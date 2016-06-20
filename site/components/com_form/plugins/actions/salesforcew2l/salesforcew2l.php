<?php
/**
 * @version $Id: salesforcew2l.php 147 2009-07-14 20:20:18Z  $
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
class plugins_actions_salesforcew2l extends plugins_actions_base {
	
	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	private $_pname = 'salesforcew2l';
	
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
	private $_title = 'Post to SalesForce.com Web2lead Generation';
	
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
	public $_creation_defaults = array ('plugin' => 'salesforcew2l', 'published' => '1', 'access' => '0', 'form_id' => '-1', 'custom4' => '', 'custom6' => '' );
	
	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	private $_desc = "Post to SalesForce.com Web2lead Generation";
	
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
		bfLoad ( 'bfHttpspost' );
		bfload ( 'bfFormExtractor' );
		
		$dataArray = array ();
		
		$salesforceHTML = new bfFormExtractor ( $this->_config ['custom5'] );
		
		$pairs = explode ( "\n", $this->_config ['custom4'] );
		
		foreach ( $pairs as $pair ) {
			$parts = explode ( ':', $pair );
			$v = trim ( $parts [1] );
			$dataArray ['params'] [trim ( $parts [0] )] = $this->submittedData [$v] ['submission'];
		}
		
		/* debug */
		if ($this->_config ['custom6'] == '1') {
			$dataArray ['params'] ['debug'] = '1';
			$dataArray ['params'] ['debugEmail'] = $salesforceHTML->elements ['debugEmail']->value;
		}
		
		$dataArray ['params'] ['oid'] = $salesforceHTML->elements ['oid']->value;
		$dataArray ['params'] ['retURL'] = $salesforceHTML->elements ['retURL']->value;
		$dataArray ['method'] = 'POST';
		$dataArray ['target'] = $salesforceHTML->url;
		
		$httpspost = new bfHttpspost ( );
		$httpspost->initialize ( $dataArray );
		$httpspost->execute ();
		if ($httpspost->error) {
			echo '<textarea>' . $httpspost->error . '</textarea>';
		} else {
			echo '<!-- POSTED TO SALESFORCE WEB2LEAD BEHIND SCENES -->';
		}
		
		/* debug */
		if ($this->_config ['custom6'] == '1') {
			echo '<textarea>' . $httpspost->result . '</textarea>';
		}
	}
	
	public function _editActionView() {
		
		/* Call in Smarty to display template */
		bfLoad ( 'bfSmarty' );
		
		$tmp = bfSmarty::getInstance ( 'com_form' );
		$tmp->caching = false;
		$tmp->assignFromArray ( $this->_config );
		
		$tmp->assign ( 'CONFIG', $this->_config );
		
		$fieldnames = array ();
		foreach ( $this->_currentElements as $field ) {
			$fieldnames [] = $field->slug;
		}
		$tmp->assign ( 'FIELDS', implode ( '<br />', $fieldnames ) );
		
		$disabled = bfHTML::yesnoRadioList ( 'published', '', $this->_config ['published'] );
		$tmp->assign ( 'PUBLISHED', $disabled );
		
		$CUSTOM6 = bfHTML::yesnoRadioList ( 'custom6', '', $this->_config ['custom6'] );
		$tmp->assign ( 'CUSTOM6', $CUSTOM6 );
		
		$OPTIONS = array (bfHTML::makeOption ( '0', 'Public' ), bfHTML::makeOption ( '1', 'Registered' ), bfHTML::makeOption ( '2', 'Special' ) );
		
		$access = bfHTML::selectList2 ( $OPTIONS, 'access', '', 'value', 'text', $this->_config ['access'] );
		$tmp->assign ( 'ACCESS', $access );
		
		$tmp->display ( dirname ( __FILE__ ) . DS . 'editView.tpl' );
	
	}
}