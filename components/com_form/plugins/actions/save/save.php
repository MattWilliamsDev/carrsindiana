<?php
/**
 * @version $Id: save.php 152 2009-07-21 09:35:08Z  $
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
class plugins_actions_save extends plugins_actions_base {
	
	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	private $_pname = 'save';
	
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
	private $_title = 'Save submission to database';
	
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
	public $_creation_defaults = array ('plugin' => 'save', 'published' => '1', 'access' => '0', 'form_id' => '-1' );
	
	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	private $_desc = 'Save the filtered and validated form submission to the internal database table';
	
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
	
	/**
	 * I hold the form config
	 *
	 * @var Object Form
	 */
	private $_formConfig = null;
	
	/**
	 * I hold 
	 * Unsure = 9
	 * Spam = 3
	 * Paused = 2
	 * Preview = 1
	 * Submitted = 0
	 * @var int
	 */
	private $_bf_status = 0;
	
	public function __construct($bf_status = null) {
		$this->_bf_status = $bf_status;
		parent::__construct();
	}
	
	public function get($s) {
		return $this->$s;
	}
	
	public function _editActionView() {
		
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
	
	private function getSubmissionsModel() {
		if (! class_exists ( 'Submission' )) {
			$path = _BF_JPATH_BASE . DS . 'components' . DS . 'com_form' . DS . 'model' . DS . 'submission.php';
			require_once $path;
		}
		
		$model = new Submission ( );
		return $model;
	}
	
	/**
	 * Process this action
	 *
	 */
	public function run($return = false) {
		
		$storage = $this->getSubmissionsModel ();
		$storage->setTableName ( $this->_config ['form_id'] );
		
		$forBind = array ();
		foreach ( $this->submittedData as $field ) {
			$key = 'FIELD_' . $field ['field_id'];
			/* cant use the following as it screws line breaks in text areas */
			if (strpos ( $field ['submission'], "\r\n" )) {
				$forBind [$key] = $field ['submission'];
			} else {
				$forBind [$key] = $storage->_db->getEscaped ( $field ['submission'] );
			}
		
		}
		
		/* bf_status */
		switch ($this->_bf_status) {
			case "2" :
				$forBind ['bf_status'] = 'Paused';
				break;
			default :
				$forBind ['bf_status'] = 'Submitted';
				break;
		}
		
		/* Add user id */
		$user = bfUser::getInstance ();
		$forBind ['bf_user_id'] = $user->get ( 'id' );
		
		/* If paused form now being submitted */
		$submission_id = (int) bfRequest::getVar('sid');
		if ($submission_id > 0 ){
			$storage->load($submission_id);
			if ($storage->bf_user_id != $user->get('id')){
				die('Cant update record that is not yours!');
			}
		}
		
		//$forBind ['bf_status'] = 'Submitted';
		//$forBind ['bf_status'] = 'Spam';
		//$forBind ['bf_status'] = 'Unsure';
		//$forBind ['bf_status'] = 'Paused';
		

		$storage->bind ( $forBind );
		$storage->store ();
		$str = '<!-- SAVED TO DATABASE -->';
		
		if ($return === true) {
			return $str;
		} else {
			echo $str;
		}
	
	}
	
	public function phpUnitTest_getPrivate($func) {
		return $this->$func ();
	}
}