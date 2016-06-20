<?php
/**
 * @version $Id: submission.php 152 2009-07-21 09:35:08Z  $
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

class Submission extends bfModel {
	
	private $_nometa = true;
	
	/**
	 * PHP5 Constructor
	 * I set up the table name, the ORM and the search fields
	 */
	public function __construct() {
		
		
		if ($this->_getFormId ()) {
			$this->setTableName ( $this->_getFormId () );
		} 
		$this->_search_fields = array ('id' );
	}
	
	public function setTableName($form_id, $reset=false) {
		
		if ($this->_tbl == null or $reset ===true) {
			if (! $form_id)
				$form_id = $this->_getFormId ();
			
			if (! $form_id)
				throw new Exception ( 'No form id sent to submissions model' );
			
			$db = bfCompat::getDBO ();
			$db->setQuery ( 'SELECT hasusertable FROM #__form_forms WHERE id = "' . ( int ) $form_id . '"' );
			
			$tbl2 = $db->LoadResult ();
			if (! $tbl2)
				throw new Exception ( 'Could not work out the table name for the submissions table' );
			
			parent::__construct ( $tbl2 );
		
		}
	
	}
	
	public function delete($oid = null) {
		
		if ($this->_tbl == null) {
			$this->setTableName ( $this->_getFormId () );
		}
		
		parent::delete ( $oid );
	}
	
	private function _getFormId() {
		$session = bfSession::getInstance ( 'com_form' );
		return $session->get ( 'lastFormId', '', 'default' );
	}
	
	/**
	 * I return all the tables....
	 * @return array
	 */
	private function getAllSubmissionsTables() {
		if (null==$this->_db)$this->_db = & bfCompat::getDBO ();
		$this->_db->setQuery ( "SHOW TABLES LIKE 'jos_form_submitteddata_form%'" );
		$tables = $this->_db->loadResultArray ();
		return $tables;
	}
	
	/**
	 * I return a copy of each of my submissions REGARDLESS of state.
	 * @return unknown_type
	 */
	public function getMySubmissions() {
		if (null==$this->_db)$this->_db = & bfCompat::getDBO ();
		$user = bfUser::getInstance ();
		
		$tables = $this->getAllSubmissionsTables ();
		$mine = array ();
		foreach ( $tables as $table ) {
			$this->_db->setQuery ( "select * from " . $table . " where bf_user_id = '" . ( int ) $user->get ( 'id' ) . "'" );
			$minefromthistable = $this->_db->loadObjectList ();
			foreach ( $minefromthistable as $row ) {
				$row->bf_form_id = str_replace ( 'jos_form_submitteddata_form', '', $table );
				$mine [] = $row;
			}
		}
		
		$mineRet = array ();
		$formnames = array ();
		foreach ( $mine as $row ) {
			if (! array_key_exists ( $row->bf_form_id, $formnames )) {
				$this->_db->setQuery ( "select form_name from #__form_forms where id = '" . $row->bf_form_id . "'" );
				$formnames [$row->bf_form_id] = $this->_db->loadResult ();
			}
			$row->bf_form_name = $formnames [$row->bf_form_id];
		}
		
		return $mine;
	}
}
