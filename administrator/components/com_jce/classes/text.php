<?php
/**
 * @version		$Id: plugins.php 97 2011-02-25 18:37:25Z happy_noodle_boy $
 * @package		JCE
 * @copyright	Copyright (C) 2009 Ryan Demmer. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class WFText
{
	/**
	 * Transalate a language string.
	 * @param $string 	Language string
	 * @param $default 	Default
	 */
	public static function _($string, $default = '')
	{
		// replace legacy JCE_ prefix
		$string 	= str_replace('JCE_', 'WF_', $string);		
		$translated = JText::_($string);
		
		if ($translated == $string) {
			if ($default) {
				return $default;
			}
			// remove prefix
			$translated = preg_replace(array('#^(WF_)#', '#(LABEL|OPTION)_#', '#_(DESC|TITLE)#'), '', $string);
			
			$translated = ucwords(strtolower(str_replace('_', ' ', $translated)));
		}
		
		return $translated;
	}
	
	public static function sprintf($string)
	{
		return JText::sprintf($string);
	}
}