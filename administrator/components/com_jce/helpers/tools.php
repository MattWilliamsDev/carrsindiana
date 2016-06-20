<?php
/**
 * @version		$Id: tools.php 131 2011-04-01 16:26:21Z happy_noodle_boy $
 * @package		JCE
 * @copyright	Copyright (C) 2009 Ryan Demmer. All rights reserved.
 * @license		GNU/GPL
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class WFToolsHelper {
	
	function getTemplate()
	{
		$db =& JFactory::getDBO();
		
		// Joomla! 1.5
		if (WF_JOOMLA15) {		
			$query = 'SELECT template'
			. ' FROM #__templates_menu'
			. ' WHERE client_id = 0'
			;
		// Joomla! 1.6+
		} else {
			$query = 'SELECT template'
			. ' FROM #__template_styles'
			. ' WHERE client_id = 0'
			. ' AND home = 1'
			;
		}

		$db->setQuery($query);	
		return $db->loadResult();
	}
	
	function parseColors($file)
	{
		$data = JFile::read(realpath($file));
		
		if (preg_match_all('/@import url\(([^\)]+)\)/', $data, $matches)) {
			$template = self::getTemplate();
			
			foreach ($matches[1] as $match) {
				$file = JPATH_SITE.DS.'templates'.DS.$template.DS.'css'.DS.$match;
				self::parseColors($file);
			}
		}	
		preg_match_all('/#[0-9a-f]{3,6}/i', $data, $matches);
		return $matches[0];
	}
	
	function getTemplateColors() 
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		$colors 	= array();
		
		$template 	= self::getTemplate();
		$path 		= JPATH_SITE.DS.'templates'.DS.$template.DS.'css';
		
		$files 		= JFolder::files($path, '\.css$', false, true);
		
		foreach ($files as $file) {
			$colors = array_merge($colors, WFToolsHelper::parseColors($file));
		}
		
		return implode(",", array_unique($colors));
	}
	function getOptions($params)
	{
		$options = array(
			'editableselects' 	=>	array('label' => WFText::_('WF_TOOLS_EDITABLESELECT_LABEL')),
			'extensions'		=>	array(
				'labels' 		=> array(
					'title'	=> WFText::_('WF_EXTENSION_MAPPER'),
					'ok'	=> WFText::_('WF_LABEL_OK')
				)
			),
			'colorpicker'	=> array(
				'template_colors' 	=> self::getTemplateColors(),
				'custom_colors' 	=> $params->get('editor.custom_colors'),
				'labels' => array(					
					'title'		=> WFText::_('WF_COLORPICKER_TITLE'),
					'picker'	=> WFText::_('WF_COLORPICKER_PICKER'),
					'palette'	=> WFText::_('WF_COLORPICKER_PALETTE'),
					'named'		=> WFText::_('WF_COLORPICKER_NAMED'),
					'template'	=> WFText::_('WF_COLORPICKER_TEMPLATE'),
					'custom'	=> WFText::_('WF_COLORPICKER_CUSTOM'),
					'color'		=> WFText::_('WF_COLORPICKER_COLOR'),
					'apply'		=> WFText::_('WF_COLORPICKER_APPLY'),
					'name'		=> WFText::_('WF_COLORPICKER_NAME')
				)
			)
		);

		return $options;
	}
}
?>