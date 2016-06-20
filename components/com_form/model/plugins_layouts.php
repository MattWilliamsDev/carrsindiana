<?php
/**
 * @version $Id: plugins_layouts.php 147 2009-07-14 20:20:18Z  $
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

class Plugins_Layouts {

	public $_pluginList = array ();

	/**
	 * The Absolute path to the plugins folder
	 *
	 * @var unknown_type
	 */
	public $_pluginFolder = null;

	/**
	 * The name of a single layout if loaded
	 *
	 * @var string
	 */
	public $_loadedOneLayout = null;

	public $_form_id = null;

	public function __construct($form_id = null) {
		$this->_form_id = ( int ) $form_id;
		$this->_pluginFolder = bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'layouts' . DS;
	}

	function loadAll() {
		$this->_loadPluginGroup ();
	}

	function loadOne($layout_name) {
		include_once ($this->_pluginFolder . strtolower ( $layout_name ) . DS . strtolower ( $layout_name ) . '.php');
		$this->_loadedOneLayout = strtolower ( $layout_name );
		$this->register ( strtolower ( $layout_name ) );
	}

	/**
	 * Implement the singleton design pattern. Calling
	 * getInstance() to construct the bfSession opject causes only one instance of
	 * the state to be active. Just what you need!
	 *
	 * @return object
	 */
	public static function getInstance($form_id = null) {
		// this implements the 'singleton' design pattern.


		static $instance;
		if (! isset ( $instance )) {
			$c = __CLASS__;
			$instance = new Plugins_Layouts ( $form_id );
		}

		return $instance;
	}

	public function getAll() {

	}

	/**
	 * I load the group, including files as neede
	 * The files register themselves
	 *
	 */
	function _loadPluginGroup() {
		$files = form_plugin_helper::_getFiles ( $this->_pluginFolder );
		foreach ( $files as $file ) {
			include ($file);
		}

		/* self register */
		$layout_name = basename ( $file );
		$this->register ( strtolower ( $layout_name ) );
	}

	/**
	 * To fool bfModel
	 */
	function getPublicVars() {

	}

	function register($name) {
		$class = 'plugins_layouts_' . $name;
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
	function trigger($func, $fieldArr = null) {

		if ($fieldArr) {
			$fieldArr ['usecustomtemplate'] ? $fieldArr ['layout'] = 'custom' : $fieldArr ['layout'] = 'default';
			return $this->_pluginList [$fieldArr ['layout']]->$func ( $fieldArr );
		} else {
			if (method_exists ( $this->_pluginList [$this->_loadedOneLayout], $func )) {
				return $this->_pluginList [$this->_loadedOneLayout]->$func ( $fieldArr );
			} else {
				return false;
			}
		}
	}
}
?>