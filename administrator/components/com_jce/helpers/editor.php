<?php
/**
* @version $Id: editor.php 107 2011-02-26 16:32:11Z happy_noodle_boy $
* @package JCE MediaBox
* @copyright Copyright (C) 2006-2010 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
* JCE MediaBox Plugin
*
* @package 		JCE MediaBox
* @subpackage	System
*/
class WFEditorHelper extends JPlugin
{
	function onAfterRender()
	{
		$buffer 	= JResponse::getBody();
		
		$search 	= array(
			// replace transitional doctype
			'#<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">#',
			// replace template css etc.
			'#<link href="(.*?)templates[^"]+"[^>]+>#',
			// remove body class etc.
			'#<body[^>]*>#',
			// remove extra line breaks
			'#\n{4}+#'
		);
		
		$replace 	= array(
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
			'',
			'<body>',
			''
		);
		
		$buffer 	= preg_replace(str_replace('/', '\/', $search), $replace, $buffer);
		
		JResponse::setBody($buffer);
		return true;
	}	
}
?>