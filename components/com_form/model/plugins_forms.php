<?php
/**
 * @version $Id: plugins_forms.php 147 2009-07-14 20:20:18Z  $
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

require_once (bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'helper.php');

class Plugins_Forms {
	
	var $_pluginList = array ();
	
	/**
	 * The Absolute path to the plugins folder
	 *
	 * @var unknown_type
	 */
	var $_pluginFolder = null;
	
	/**
	 * I call the PHP5 Constructor
	 *
	 */
	function Plugins_Forms() {
		$this->__construct ();
	}
	
	function __construct() {
		$this->_pluginFolder = bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'forms' . DS;
		$this->_loadPluginGroup ();
	}
	
	/**
	 * Implement the singleton design pattern. Calling
	 * getInstance() to construct the bfSession opject causes only one instance of
	 * the state to be active. Just what you need!
	 *
	 * @return object
	 */
	function &getInstance() {
		// this implements the 'singleton' design pattern.
		

		static $instance;
		if (! isset ( $instance )) {
			$c = __CLASS__;
			$instance = new Plugins_Forms ( );
		}
		
		return $instance;
	}
	
	/**
	 * I load the group, including files as neede
	 * The files register themselves
	 *
	 */
	function _loadPluginGroup() {
		$files = form_plugin_helper::_getFiles ( 'form' );
		foreach ( $files as $file ) {
			include ($file);
			$this->register ( str_replace ( '.php', '', basename ( $file ) ) );
		}
	}
	
	/**
	 * To fool bfModel
	 */
	function getPublicVars() {
	
	}
	
	function register($name) {
		$class = 'plugins_forms_' . $name;
		$this->_pluginList [$name] = new $class ( );
	}
	
	function getOptions() {
		$options = array ();
		foreach ( $this->_pluginList as $plugin ) {
			$options [] = $plugin;
		}
		return $options;
	}
	
	/**
	 * I trigger events on observers
	 */
	function trigger($func, &$formObj) {
		return $this->_pluginList [$formObj->template]->$func ( $formObj );
	}

}

