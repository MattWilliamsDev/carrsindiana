<?php
/**
 * @version   $Id: xml.php 43 2011-01-21 08:16:25Z happy_noodle_boy $
 * @package   JCE
 * @copyright Copyright (C) 2009 Ryan Demmer. All rights reserved.
 * @license   GNU/GPL
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

/**
 * Joomla! 1.5 / 1.6 bridging functions
 * @author ryandemmer
 */
class WFVersionHelper
{
	/*
	 * Get a component by id
	 * @params $id Component id
	 * @return Component object
	 */
	function getComponent($id) 
	{
		$db	=& JFactory::getDBO();
		// Joomla! 1.5
		if (WF_JOOMLA15) {
			$query = 'SELECT * FROM #__components'
			. ' WHERE id = '.(int) $id
			;
			$db->setQuery($query);
			return $db->loadObject();
			// Joomla! 1.6
		} else {
			$query = 'SELECT * FROM #__extensions'
			. ' WHERE extension_id = '.(int) $id
			. ' AND type = '. $db->Quote('component')
			;
			$db->setQuery($query);
			
			$component = $db->loadObject();
			$component->option = $component->element;
			
			return $component;
		}
	}
}