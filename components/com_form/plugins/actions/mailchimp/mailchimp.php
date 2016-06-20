<?php
/**
 * @version $Id: mailchimp.php 181 2009-12-27 17:04:45Z  $
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
class plugins_actions_mailchimp extends plugins_actions_base {
	
	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	private $_pname = 'mailchimp';
	
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
	private $_title = 'AutoSubscribe/unsubscribe Submitters To Mailchimp.com Mailing Lists';
	
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
	public $_creation_defaults = array ('plugin' => 'mailchimp', 'published' => '1', 'access' => '0', 'form_id' => '-1', 'custom4' => 'POST', 'custom6' => '1', 'custom5' => '' );
	
	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	private $_desc = "AutoSubscribe/unsubscribe to Mailchimp.com Mailing Lists";
	
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
		require_once 'httppost.class.php';
		
		$dataArray = array ();
		
		/*emailfrom*/
		$dataArray ['firstname'] = $this->submittedData [$this->_config ['emailfrom']] ['submission'];
		
		/*emailfromname*/
		$dataArray ['lastname'] = $this->submittedData [$this->_config ['emailfromname']] ['submission'];
		
		/*emailto*/
		$dataArray ['email_address'] = $this->submittedData [$this->_config ['emailto']] ['submission'];
		
		$merge_vars = array ('FNAME' => $dataArray ['firstname'], 'LNAME' => $dataArray ['lastname'], 'INTERESTS' => '' );
		
		$api = new MCAPI ( $this->_config ['custom4'] );
		
		// By default this sends a confirmation email - you will not see new members
		// until the link contained in it is clicked!
		if ($this->_config ['custom6'] == '1') {

			$retval = $api->listSubscribe ( $this->_config ['custom5'], $dataArray ['email_address'], $merge_vars );
		} else {

			$retval = $api->listUnsubscribe ( $this->_config ['custom5'], $dataArray ['email_address'] );
		}
		
		if ($api->errorCode) {
			echo "Unable to complete mailchimp plugin()!\n";
			echo "\tCode=" . $api->errorCode . "\n";
			echo "\tMsg=" . $api->errorMessage . "\n";
		} else {
			echo '<!-- Successfully trippered mailchimp -->';
		}
	}
	
	public function _editActionView() {
		
		/* Call in Smarty to display template */
		bfLoad ( 'bfSmarty' );
		$db = bfCompat::getDBO ();
		$session = bfSession::getInstance ( 'com_form', 'com_form' );
		$form_id = $session->get ( 'lastFormId', '', 'default' );
		
		$db->setQuery ( "SELECT group_name as text, groups_id as value from #__mailinglist_groups" );
		$groups = $db->LoadObjectList ();
		
		$db->setQuery ( "SELECT slug as text, slug as value from #__form_fields where form_id = '" . $form_id . "' ORDER BY slug ASC" );
		$fields = $db->LoadObjectList ();
		
		$tmp = bfSmarty::getInstance ( 'com_form' );
		$tmp->caching = false;
		$tmp->assignFromArray ( $this->_config );
		
		$tmp->assign ( 'CONFIG', $this->_config );
		
		$disabled = bfHTML::yesnoRadioList ( 'published', '', $this->_config ['published'] );
		$tmp->assign ( 'PUBLISHED', $disabled );
		
		$OPTIONS = array (bfHTML::makeOption ( '1', 'Subscribe' ), bfHTML::makeOption ( '0', 'Unsubscribe' ) );
		
		$custom6 = bfHTML::selectList2 ( $OPTIONS, 'custom6', 'class="inputbox bfinputbox"', 'value', 'text', $this->_config ['custom6'] );
		$tmp->assign ( 'CUSTOM6', $custom6 );
		
		$OPTIONS = array (bfHTML::makeOption ( '0', 'Public' ), bfHTML::makeOption ( '1', 'Registered' ), bfHTML::makeOption ( '2', 'Special' ) );
		
		$access = bfHTML::selectList2 ( $OPTIONS, 'access', '', 'value', 'text', $this->_config ['access'] );
		$tmp->assign ( 'ACCESS', $access );
		
		// API Key
		$tmp->assign ( 'CUSTOM4', $this->_config ['custom4'] );
		
		if ($this->_config ['custom4']) {
			require_once 'httppost.class.php';
			$api = new MCAPI ( $this->_config ['custom4'] );
			$lists = $api->lists ();
			$options = array ();
			foreach ( $lists as $list ) {
				$options [] = bfHTML::makeOption ( $list ['id'], $list ['name'] );
			}
		}
		
		$custom5 = bfHTML::selectList2 ( $options, 'custom5', 'class="inputbox bfinputbox"', 'value', 'text', $this->_config ['custom5'] );
		$tmp->assign ( 'CUSTOM5', $custom5 );
		
		$EMAILTO = bfHTML::selectList2 ( $fields, 'emailto', 'class="inputbox bfinputbox"', 'value', 'text', $this->_config ['emailto'] );
		$tmp->assign ( 'EMAILTO', $EMAILTO );
		
		$EMAILFROM = bfHTML::selectList2 ( $fields, 'emailfrom', 'class="inputbox bfinputbox"', 'value', 'text', $this->_config ['emailfrom'] );
		$tmp->assign ( 'EMAILFROM', $EMAILFROM );
		
		$EMAILFROMNAME = bfHTML::selectList2 ( $fields, 'emailfromname', 'class="inputbox bfinputbox"', 'value', 'text', $this->_config ['emailfromname'] );
		$tmp->assign ( 'EMAILFROMNAME', $EMAILFROMNAME );
		
		$tmp->display ( dirname ( __FILE__ ) . DS . 'editView.tpl' );
	}
}


