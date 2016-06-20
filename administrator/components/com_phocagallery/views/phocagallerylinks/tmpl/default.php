<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');

echo '<div id="phocagallery-links">'
.'<fieldset class="adminform">'
.'<legend>'.JText::_( 'COM_PHOCAGALLERY_SELECT_TYPE' ).'</legend>'
.'<ul>'
.'<li class="icon-16-edb-categories"><a href="'.$this->tmpl['COM_PHOCAGALLERY_CATEGORIES'].'">'.JText::_('COM_PHOCAGALLERY_CATEGORIES').'</a></li>'
//.'<li class="icon-16-edb-category"><a href="'.$this->tmpl['COM_PHOCAGALLERY_CATEGORY'].'">'.JText::_('COM_PHOCAGALLERY_CATEGORY').'</a></li>'
.'<li class="icon-16-edb-images"><a href="'.$this->tmpl['Images'].'">'.JText::_('COM_PHOCAGALLERY_IMAGES').'</a></li>'
.'<li class="icon-16-edb-image"><a href="'.$this->tmpl['image'].'">'.JText::_('COM_PHOCAGALLERY_IMAGE').'</a></li>'
.'<li class="icon-16-edb-switchimage"><a href="'.$this->tmpl['switchimage'].'">'.JText::_('COM_PHOCAGALLERY_SWITCH_IMAGE').'</a></li>'
.'<li class="icon-16-edb-slideshow"><a href="'.$this->tmpl['COM_PHOCAGALLERY_SLIDESHOW'].'">'.JText::_('COM_PHOCAGALLERY_SLIDESHOW').'</a></li>'
.'</ul>'
.'</div>'
.'</fieldset>'
.'</div>';
?>