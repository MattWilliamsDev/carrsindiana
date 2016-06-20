<?php
/**
 * @version $Id: field.php 184 2010-01-03 20:44:13Z  $
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

class Field extends bfModel {
	
	/**
	 * @var
	 * I do lots of stuff with direct access to tables so need to
	 * know when I'm in test mode.
	 */
	public $_mode;
	
	/*
	 * No created/modified fields...
	 */
	public $_nometa = true;
	
	/**
	 * PHP5 Constructor
	 * I set up the table name, the ORM and the search fields
	 */
	public function __construct() {
		global $mainframe;
		parent::__construct ( '#__' . $mainframe->get ( 'component_shortname' ) . '_fields' );
		
		$this->_search_fields = array ('id', 'title' );
		
		// Am I in test mode?
		$session = bfSession::getInstance ();
		$this->_mode = $session->get ( 'mode' );
	}
	
	/**
	 * I save the form configuration
	 *
	 */
	public function saveDetails() {
		
		/* save to database */
		parent::saveDetails ();
		
		/* create slug - for sef link */
		if (! $this->slug) {
			$this->slug = bfString::slug4mysql ( $this->title );
		}
		$this->store ();
	
	}
	
	/** 
	 * I delete a form
	 * 
	 */
	public function delete($id) {
		parent::delete ( $id );
	}
	
	public function copy($field_id, $form_id) {
		$this->get ( ( int ) $field_id );
		$this->id = '';
		if ($this->form_id == $form_id) {
			$this->slug = $this->slug . '_copy';
			$this->title = $this->title . ' (Copy)';
		} else {
			$this->form_id = ( int ) $form_id;
			$this->slug = $this->slug;
			$this->title = $this->title;
		}
		
		$this->ordering = '999999';
		$this->store ();
		$this->updateOrder ( 'form_id = "' . ( int ) $form_id . '"' );
		return $this;
	}
	
	/**
	 * I create a new form field record 
	 *
	 * @param int $id the field id
	 */
	public function createNewField($title, $template) {
		
		/* egt user object */
		$user = bfUser::getInstance ();
		
		/* set created by */
		$this->created_by = $user->get ( 'id' );
		$this->form_id = ( int ) $this->_session->get ( 'lastFormId', '', 'default' );
		$this->plugin = $template;
		$this->title = $title;
		$this->ordering = $this->getNextOrder ( 'form_id = ' . ( int ) $this->_session->get ( 'lastFormId', '', 'default' ) );
		
		/* save new field */
		$this->saveDetails ();
		
		$this->_checkForDBErrors ();
		$this->updateOrder ( 'form_id = ' . ( int ) $this->form_id );
		
		/* return the field id */
		return $this->id;
	}
	
	public function get($id) {
		parent::get ( $id );
	}
	
	public function getForViewing($form_id) {
		$user = bfUser::getInstance ();
		$this->getAll ( 'form_id = "' . $form_id . '" AND published = "1" AND access <= "' . $user->get ( 'aid' ) . '"', false, 'ordering ASC' );
		return $this->rows;
	}
	
	public function getFieldName($id) {
		if ($id == 'bf_status') return 'Status';
		if ($id == 'bf_user_id') return 'User Id';
		$db = bfCompat::getDBO ();
		$db->setQuery ( 'SELECT slug FROM #__form_fields WHERE id = "' . ( int ) $id . '"' );
		$name = $db->loadResult ();
		return $name ? $name : 'UNKNOWN FIELD NAME';
	}
}