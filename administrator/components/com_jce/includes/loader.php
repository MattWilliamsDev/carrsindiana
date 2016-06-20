<?php
/**
* @version		$Id: browser.php 58 2011-02-18 12:40:41Z happy_noodle_boy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined( '_JEXEC') or die('RESTRICTED');

class WFLoader {
	/**
	 * Loads a file from specified directories.
	 *
	 * @param string $name	The class name to look for ( dot notation ).
	 * @return void
	 * @copyright Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
	 */
	function import($path) {
		
		static $paths;

		if (!isset($paths)) {
			$paths = array();
		}
		
		$parts 	= explode('.', $path);
		$key 	= array_shift($parts);
		
		$keyPath = $key ? $key . '.' . implode('.', $parts) : $path;

		if (!isset($paths[$keyPath]))
		{
			// set base as Component root
			$base 	= JPATH_COMPONENT_ADMINISTRATOR;
	
			switch ($key) {
				case 'editor':
					$base = JPATH_SITE .DS. 'components' .DS. 'com_jce' .DS. 'editor';
					break;
				case 'admin':
					$base = dirname(dirname(__FILE__));
					break;
			}
				
			$rs = require_once($base . DS . implode(DS, $parts) . '.php');	
			
			$paths[$keyPath] = $rs;
		}
		
		return $paths[$keyPath];
	}
}

function wfimport($path) {
	return WFLoader::import($path);
}