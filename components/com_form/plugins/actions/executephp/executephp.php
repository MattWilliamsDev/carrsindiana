<?php
/**
 * @version $Id: executephp.php 179 2009-12-27 17:04:24Z  $
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

/* Needed on Apply */
if (! class_exists ( 'plugins_actions_base' )) {
	require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'helper.php';
	require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'actions' . DS . '_baseClass.php';
}

/**
 * Class for form actions
 *
 */
class plugins_actions_executephp extends plugins_actions_base {
	
	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	private $_pname = 'executephp';
	
	/**
	 * The current form_id
	 *
	 * @var int the form id
	 */
	private $_form_id = null;
	
	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	private $_title = 'Execute PHP Code';
	
	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	private $_defaults = array ('published' => '1', 'access' => '0' );
	
	/**
	 * The creation defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_creation_defaults = array ('plugin' => 'executephp', 'published' => '1', 'access' => '0', 'form_id' => '-1' );
	
	/**
	 * The plugin description
	 *
	 * @var text The code that gets executed
	 */
	private $_desc = 'You can interact with an API, POST data to another file, or anything else you want';
	
	/**
	 * I hold this fields current config,
	 * which overrides the defaults above
	 *
	 * @var array
	 */
	public $_config = array ();
	
	/**
	 * I hold the incoming submitted forms clean and modified data
	 *
	 * @var array
	 */
	public $submittedData = array ();
	
	public function get($s) {
		return $this->$s;
	}
	/**
	 * Process this action
	 *
	 */
	public function run($return = false) {
		$str = $this->replacePlaceholders ( $this->submittedData, $this->_config ['desc'] );
		
		ob_start ();
		eval ( $str );
		$output = ob_get_contents ();
		ob_end_clean ();
		
		if ($return === true) {
			return $str;
		} else {
			echo $output;
		}
	}
	
	public function _editActionView() {
		
		$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
		
		/* Call in Smarty to display template */
		bfLoad ( 'bfSmarty' );
		
		$tmp = bfSmarty::getInstance ( 'com_form' );
		$tmp->caching = false;
		$tmp->assignFromArray ( $this->_config );
		
		$tmp->assign ( 'CONFIG', $this->_config );
		
		$disabled = bfHTML::yesnoRadioList ( 'published', '', $this->_config ['published'] );
		$tmp->assign ( 'PUBLISHED', $disabled );
		
		$OPTIONS = array (bfHTML::makeOption ( '0', 'Public' ), bfHTML::makeOption ( '1', 'Registered' ), bfHTML::makeOption ( '2', 'Special' ) );
		
		$access = bfHTML::selectList2 ( $OPTIONS, 'access', '', 'value', 'text', $this->_config ['access'] );
		$tmp->assign ( 'ACCESS', $access );
		
		$tmp->display ( dirname ( __FILE__ ) . DS . 'editView.tpl' );
	
	}
}

?>