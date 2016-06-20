<?php
/**
 * @version $Id: action.php 147 2009-07-14 20:20:18Z  $
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

class Action extends bfModel {
	
	/**
	 * @var
	 * I do lots of stuff with direct access to tables so need to
	 * know when I'm in test mode.
	 */
	public $_mode;
	public $_nometa = true;
	
	/**
	 * PHP5 Constructor
	 * I set up the table name, the ORM and the search fields
	 */
	function __construct() {
		global $mainframe;
		parent::__construct ( '#__' . $mainframe->get ( 'component_shortname' ) . '_actions' );
		
		$this->_search_fields = array ('id', 'title' );
		
		// Am I in test mode?
		$session = bfSession::getInstance ();
		$this->_mode = $session->get ( 'mode' );
	}
	
	public function copy($action_id, $form_id) {
		$this->get ( ( int ) $action_id );
		$this->id = '';
		$this->form_id = ( int ) $form_id;
		$this->title = $this->title . ' (Copy)';
		$this->ordering = '999999';
		$this->store ();
		$this->updateOrder ( 'form_id = "' . ( int ) $form_id . '"' );
		return $this;
	}
	
	/**
	 * I save the form configuration
	 *
	 */
	function saveDetails() {
		
		/* save to database */
		parent::saveDetails ();
	
	}
	
	/** 
	 * I delete a form
	 * 
	 */
	function delete($id) {
		parent::delete ( $id );
	}
	
	/**
	 * I create a new form field record 
	 *
	 * @param int $id the field id
	 */
	function createNewAction($title, $template) {
		
		/* egt user object */
		$user = bfUser::getInstance ();
		
		/* set created by */
		$this->created_by = $user->get ( 'id' );
		$this->plugin = $template;
		$this->title = $title;
		
		/* save new field */
		$this->saveDetails ();
		$this->updateOrder ();
		
		/* return the field id */
		return $this->id;
	}
	
	/**
	 * Load single action
	 *
	 * @param int $id
	 */
	function get($id) {
		parent::get ( $id );
	}
}
?>