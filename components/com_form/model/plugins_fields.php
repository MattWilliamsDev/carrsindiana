<?php
/**
 * @version $Id: plugins_fields.php 147 2009-07-14 20:20:18Z  $
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
require_once (bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'fields' . DS . '_baseClass.php');

class Plugins_Fields {
	
	public $_pluginList = array ();
	
	/**
	 * The Absolute path to the plugins folder
	 *
	 * @var unknown_type
	 */
	public $_pluginFolder = null;
	
	public function __construct() {
		
		$this->_pluginFolder = bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'fields' . DS;
		$this->_loadPluginGroup ();
	}
	
	/**
	 * Implement the singleton design pattern. Calling
	 * getInstance() to construct the bfSession opject causes only one instance of
	 * the state to be active. Just what you need!
	 *
	 * @return object
	 */
	public static function getInstance() {
		
		// this implements the 'singleton' design pattern.
		

		static $instance;
		if (! isset ( $instance )) {
			$c = __CLASS__;
			$instance = new Plugins_Fields ( );
		}
		
		return $instance;
	}
	
	/**
	 * I load the group, including files as neede
	 * The files register themselves
	 *
	 */
	function _loadPluginGroup() {
		
		$files = form_plugin_helper::_getFiles ( 'field' );
		foreach ( $files as $file ) {
			$class = 'plugins_fields_' . str_replace ( '.php', '', basename ( $file ) );
			
			if (! class_exists ( 'plugins_fields_' . str_replace ( '.php', '', basename ( $file ) ) ))
				include_once ($file);
			$this->register ( str_replace ( '.php', '', basename ( $file ) ) );
		}
	}
	
	/**
	 * I load the group, including files as neede
	 * The files register themselves
	 *
	 */
	function loadPlugin($plugin) {
		
		$plug = Plugins_Fields::getInstance ();
		
		switch ($plugin) {
			case "text" :
				$plugin = 'textbox';
				break;
			
			case "file" :
				$plugin = 'fileupload';
				break;
			case "UNKNOWN" :
				return;
				break;
		}
		
		$file = $plug->_pluginFolder . $plugin . '.php';
		
		$class = 'plugins_fields_' . $plugin;
		if (! class_exists ( $class )) {
			if (! file_exists ( $file )) {
				die ( 'Plugin File not found for the class "' . $class . '"' );
			}
		}
	}
	
	/**
	 * To fool bfModel
	 */
	function getPublicVars() {
	
	}
	
	/**
	 * I'm the wrapper for the edit field screen in admin
	 *
	 * @param object $config The field's row from the database
	 */
	//function _editField($controller) {
	

	//          $class = 'plugins_fields_' . $config->plugin;
	//          $f = new $class();
	//          $f->setConfig($config, $controller);
	//          $f->_admin_editController();
	//          $f->_admin_editView();
	//  $controller->setView('edit_field');
	//  }
	

	/**
	 * Register the plugin
	 *
	 * @param string $name the plugin name
	 */
	function register($name) {
		
		$class = 'plugins_fields_' . $name;
		if (class_exists ( $class )) {
			if (substr ( $class, 0, 1 ) != '_')
				$this->_pluginList [$name] = new $class ( );
		}
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
	function trigger($func, $fieldObj, $ext = array()) {
		switch ($fieldObj->plugin) {
			case "text" :
				$fieldObj->plugin = 'textbox';
				break;
			
			case "file" :
				$fieldObj->plugin = 'fileupload';
				break;
			case "UNKNOWN" :
				return;
				break;
		}
		if (method_exists ( $this->_pluginList [$fieldObj->plugin], $func ))
			return $this->_pluginList [$fieldObj->plugin]->$func ( $fieldObj, $ext );
	}
}
?>