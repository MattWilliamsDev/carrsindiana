<?php

// no direct access
defined('_JEXEC') or die;

class modMenuHelper3
{
 
	static function getList($menutype)
	{
		// Initialise variables.
		$list		= array();
		$db			= JFactory::getDbo();
		$user		= JFactory::getUser();
		$app		= JFactory::getApplication();
		$menu		= $app->getMenu();

		// If no active menu, use default
		$active = ($menu->getActive()) ? $menu->getActive() : $menu->getDefault();

		$path		= $active->tree;
		$start		= 1;
		$end		= 10;
		$showAll	=1;
		$maxdepth	= 10;
		$items 		= $menu->getItems('menutype',$menutype);

		$lastitem	= 0;

		if ($items) {
			foreach($items as $i => $item)
			{
				if (($start && $start > $item->level)
					|| ($end && $item->level > $end)
					|| (!$showAll && $item->level > 1 && !in_array($item->parent_id, $path))
					|| ($maxdepth && $item->level > $maxdepth)
				) {
					unset($items[$i]);
					continue;
				}

				$item->deeper = false;
				$item->shallower = false;
				$item->level_diff = 0;

				if (isset($items[$lastitem])) {
					$items[$lastitem]->deeper		= ($item->level > $items[$lastitem]->level);
					$items[$lastitem]->shallower	= ($item->level < $items[$lastitem]->level);
					$items[$lastitem]->level_diff	= ($items[$lastitem]->level - $item->level);
					
					 
				}

				$lastitem			= $i;
				$item->active		= false;
				$item->flink = $item->link;

				switch ($item->type)
				{
					case 'separator':
						// No further action needed.
						continue;

					case 'url':
						if ((strpos($item->link, 'index.php?') === 0) && (strpos($item->link, 'Itemid=') === false)) {
							// If this is an internal Joomla link, ensure the Itemid is set.
							$item->flink = $item->link.'&Itemid='.$item->id;
						}
						break;

					case 'alias':
						// If this is an alias use the item id stored in the parameters to make the link.
						$item->flink = 'index.php?Itemid='.$item->params->get('aliasoptions');
						break;

					default:
						$router = JSite::getRouter();
						if ($router->getMode() == JROUTER_MODE_SEF) {
							$item->flink = 'index.php?Itemid='.$item->id;
						}
						else {
							$item->flink .= '&Itemid='.$item->id;
						}
						break;
				}

				if (strcasecmp(substr($item->flink, 0, 4), 'http') && (strpos($item->flink, 'index.php?') !== false)) {
					$item->flink = JRoute::_($item->flink, true, $item->params->get('secure'));
				}
				else {
					$item->flink = JRoute::_($item->flink);
				}
			}

			if (isset($items[$lastitem])) {
				$items[$lastitem]->deeper		= (($start?$start:1) > $items[$lastitem]->level);
				$items[$lastitem]->shallower	= (($start?$start:1) < $items[$lastitem]->level);
				$items[$lastitem]->level_diff	= ($items[$lastitem]->level - ($start?$start:1));
			}
		}

		return $items;
	}
}
function mosShowListMenu($moduletype){

	$list	= modMenuHelper3::getList($moduletype);
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$active	= $menu->getActive();
	$active_id = isset($active) ? $active->id : $menu->getDefault()->id;
	$path	= isset($active) ? $active->tree : array();
	
	?>
	<ul onmouseover="check_id()">
	<?php
	foreach ($list as $i => &$item) :
		$class = '';
		if ($item->id == $active_id) {
		//	$class .= 'current ';
		}
	
		if (in_array($item->id, $path)) {
			$class .= 'active ';
		}
	
		if ($item->deeper) {
		//	$class .= 'parent ';
		}
		if ($item->level==1 && $item->deeper) {
			$class .= 's5_level_one_parent ';
		}
		
		if ($item->level==2 ) {
			$class .= 'noback ';
		}
		
		if (!empty($class)) {
			$class = ' class="'.trim($class) .'"';
		} 
	
		echo '<li id="item-'.$item->id.'"'.$class.'>';
		if ($item->level==1) {
			echo '<span class="s5_outer_active">';
		}
		// Render the menu item.
		switch ($item->type) :
			case 'separator':
				default_separator($item);
				break;
			case 'url':
				default_url($item);
				break;
			case 'component':
				//require JModuleHelper::getLayoutPath('mod_s5_accordion_menu', 'default_'.$item->type);
				default_component($item);
				break;
	
			default:
				default_url($item);
				//require JModuleHelper::getLayoutPath('mod_s5_accordion_menu', 'default_url');
				break;
		endswitch;
		if ($item->level==1) {
			 echo '</span>';
		 }
		// The next item is deeper.
		if ($item->deeper) {
			echo '<ul style="visibility: hidden; display: block;"> <li class="s5_top_menu_spacer"></li>';
		}
		// The next item is shallower.
		else if ($item->shallower) {
			echo '</li>';
			echo str_repeat('<li class="s5_bottom_menu_spacer"></li></ul></li>', $item->level_diff);
		}
		// The next item is on the same level.
		else {
			echo '</li>';
		}
	endforeach;
	?></ul>
	<?php
}

function default_component($item){
	$class = $item->params->get('menu-anchor_css', '') ? 'class="'.$item->params->get('menu-anchor_css', '').'" ' : '';
	$title = $item->params->get('menu-anchor_title', '') ? 'title="'.$item->params->get('menu-anchor_title', '').'" ' : '';
	if ($item->params->get('menu_image', '')) {
			$item->params->get('menu_text', 1 ) ? 
			$linktype = '<img src="'.$item->params->get('menu_image', '').'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
			$linktype = '<img src="'.$item->params->get('menu_image', '').'" alt="'.$item->title.'" />';
	} 
	else { $linktype = $item->title;
	}  
	//$linktype = $item->params->get('menu_image', '') && $item->params->get('menu_text', 1 ) ? '<img src="'.$item->params->get('menu_image', '').'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' : $item->title;
	if($item->level==1) $class = ' class="active" '; else $class =' class="sub" ';
	if($item->deeper && $item->level!=1)  $class=' class="parent" ';
	
	if(!$item->deeper && $item->level!=1) {
	  echo '<span>';
	 }
	 if($item->deeper && $item->level!=1) {
	  echo '<span><span>';
	  } else {
		 echo '<span class="s5_rs">';
	 }
	switch ($item->browserNav) :
		default:
		case 0:
	?><a <?php echo $class; ?>href="<?php echo $item->flink; ?>" <?php echo $title; ?>><?php echo $linktype; ?><?php if($item->level==1){?><span class="s5_bottom_text"></span><?php }?></a><?php
			break;
		case 1:
			// _blank
	?><a <?php echo $class; ?>href="<?php echo $item->flink; ?>" target="_blank" <?php echo $title; ?>><?php echo $linktype; ?><?php if($item->level==1){?><span class="s5_bottom_text"></span><?php }?></a><?php
			break;
		case 2:
			// window.open
	?><a <?php echo $class; ?>href="<?php echo $item->flink.'&amp;tmpl=component'; ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');return false;" <?php echo $title; ?>><?php echo $linktype; ?><?php if($item->level==1){?><span class="s5_bottom_text"></span><?php }?></a>
	<?php
			break;
	endswitch;
	if(!$item->deeper && $item->level!=1) {
	  echo '</span>';
	 }
	if($item->deeper && $item->level!=1) {
	echo '</span></span>'; 
	 } else {
	echo '</span>';
	
	}
}
function default_url($item){
$class = $item->params->get('menu-anchor_css', '') ? 'class="'.$item->params->get('menu-anchor_css', '').'" ' : '';
$title = $item->params->get('menu-anchor_title', '') ? 'title="'.$item->params->get('menu-anchor_title', '').'" ' : '';
if ($item->params->get('menu_image', '')) {
		$item->params->get('menu_text', 1 ) ? 
		$linktype = '<img src="'.$item->params->get('menu_image', '').'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
		$linktype = '<img src="'.$item->params->get('menu_image', '').'" alt="'.$item->title.'" />';
} 
else { $linktype = $item->title;
}
 
if($item->level==1) $class = ' class="active" '; else $class =' class="sub" ';
if($item->deeper && $item->level!=1)  $class=' class="parent" ';

 if(!$item->deeper && $item->level!=1) {
  echo '<span>';
 }
  if($item->deeper && $item->level!=1) {
  echo '<span><span>';
  } else {
	 echo '<span class="s5_rs">';
 }
switch ($item->browserNav) :
	default:
	case 0:
?><a <?php echo $class; ?>href="<?php echo $item->flink; ?>" <?php echo $title; ?>><?php echo $linktype; ?><?php if(($item->level==1 && $item->deeper)|| ($item->level==1)){?><span class="s5_bottom_text"></span><?php }?></a><?php
		break;
	case 1:
		// _blank
?><a <?php echo $class; ?>href="<?php echo $item->flink; ?>" target="_blank" <?php echo $title; ?>><?php echo $linktype; ?><?php if(($item->level==1 && $item->deeper)|| ($item->level==1)){?><span class="s5_bottom_text"></span><?php }?></a><?php
		break;
	case 2:
		// window.open
		$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,'.$item->params->get('window_open');
?><a <?php echo $class; ?>href="<?php echo $item->flink.'&tmpl=component'; ?>" onclick="window.open(this.href,'targetWindow','<?php echo $attribs;?>');return false;" <?php echo $title; ?>><?php echo $linktype; ?><?php if(($item->level==1 && $item->deeper)|| ($item->level==1)){?><span class="s5_bottom_text"></span><?php }?></a><?php
		break;
endswitch;
if(!$item->deeper && $item->level!=1) {
  echo '</span>';
 }
 if($item->deeper && $item->level!=1) {
echo '</span></span>'; 
 } else {
echo '</span>';

}
}
function  default_separator($item){
$title = $item->params->get('menu-anchor_title', '') ? 'title="'.$item->params->get('menu-anchor_title', '').'" ' : '';
if ($item->params->get('menu_image', '')) {
		$item->params->get('menu_text', 1 ) ? 
		$linktype = '<img src="'.$item->params->get('menu_image', '').'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
		$linktype = '<img src="'.$item->params->get('menu_image', '').'" alt="'.$item->title.'" />';
} 
else { $linktype = $item->title;
}
if($item->level==1) $class = ' class="active" '; else $class =' class="sub" ';
if($item->deeper && $item->level!=1)  $class=' class="parent" ';
if(!$item->deeper && $item->level!=1) {
  echo '<span>';
 }
  if($item->deeper && $item->level!=1) {
  echo '<span><span>';
  } else {
	 echo '<span class="s5_rs">';
 }
?><a <?php echo $class; ?> href="javascript:;"><?php echo $title; ?><?php echo $linktype; ?></a>

<?php 
if(!$item->deeper && $item->level!=1) {
  echo '</span>';
 }
if($item->deeper && $item->level!=1) {
echo '</span></span>'; 
 } else {
echo '</span>';

}
}