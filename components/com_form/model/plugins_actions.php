<?php
/**
 * @version $Id: plugins_actions.php 147 2009-07-14 20:20:18Z  $
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

require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'helper.php';
require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'actions' . DS . '_baseClass.php';

class Plugins_Actions {
	
	public $_pluginList = array ();
	
	/**
	 * The Absolute path to the plugins folder
	 *
	 * @var unknown_type
	 */
	public $_pluginFolder = null;
	
	public function __construct() {
		
		$this->_pluginFolder = bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'actions' . DS;
	}
	
	/**
	 * Implement the singleton design pattern. Calling
	 * getInstance() to construct the bfSession opject causes only one instance of
	 * the state to be active. Just what you need!
	 *
	 * @return object
	 */
	public static function getInstance() {
		
		static $instance;
		if (! isset ( $instance )) {
			$c = __CLASS__;
			$instance = new Plugins_Actions ( );
		}
		
		return $instance;
	}
	
	/**
	 * I load the group, including files as neede
	 * The files register themselves
	 *
	 */
	private function _loadPluginGroup() {
		
		$files = form_plugin_helper::_getFiles ( 'action' );
		foreach ( $files as $file ) {
			include_once $file;
			$this->register ( str_replace ( '.php', '', basename ( $file ) ) );
		}
	}
	
	function register($name) {
		
		$class = 'plugins_actions_' . $name;
		if (class_exists ( $class )) {
			if (substr ( $class, 0, 1 ) != '_')
				$this->_pluginList [$name] = new $class ( );
		}
	}
	
	function getOptions() {
		$this->_loadPluginGroup ();
		
		$options = array ();
		foreach ( $this->_pluginList as $plugin ) {
			$options [] = $plugin;
		}
		return $options;
	}
	
	/**
	 * I trigger events on observers
	 */
	function trigger($func, $actionObj) {
		
		if (method_exists ( @$this->_pluginList [$actionObj->plugin], $func )) {
			return $this->_pluginList [$actionObj->plugin]->$func ( $actionObj );
		} else {
			$this->loadOne ( $actionObj->plugin );
			if (method_exists ( @$this->_pluginList [$actionObj->plugin], $func ))
				return $this->_pluginList [$actionObj->plugin]->$func ( $actionObj );
		
		}
	}
	
	function loadOne($plugin_name) {
		
		$class = 'plugins_actions_' . $plugin_name;
		if (! class_exists ( $class )) {
			include_once ($this->_pluginFolder . strtolower ( $plugin_name ) . DS . strtolower ( $plugin_name ) . '.php');
			$this->register ( strtolower ( $plugin_name ) );
		}
	}
}
?>