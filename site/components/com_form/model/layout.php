<?php
/**
 * @version $Id: layout.php 147 2009-07-14 20:20:18Z  $
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

class Layout extends bfModel {
	
	/**
	 * @var
	 * I do lots of stuff with direct access to tables so need to
	 * know when I'm in test mode.
	 */
	var $_mode;
	var $_nometa = true;
	
	/**
	 * PHP5 Constructor
	 * I set up the table name, the ORM and the search fields
	 */
	function __construct() {
		global $mainframe;
		parent::__construct ( '#__' . $mainframe->get ( 'component_shortname' ) . '_layouts' );
		
		$this->_search_fields = array ('id', 'title', 'html' );
		
		// Am I in test mode?
		$session = bfSession::getInstance ();
		$this->_mode = $session->get ( 'mode' );
	}
	
	function get($id) {
		if (! $id)
			die ( 'No layout id specified' );
		parent::get ( $id );
		global $mainframe;
		$filename = bfCompat::getAbsolutePath () . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'view' . DS . 'user_templates' . DS . md5 ( $id ) . '.php';
		$this->filename = $filename;
		if (file_exists ( $filename )) {
			$this->html = file_get_contents ( $filename );
		} else {
			$this->html = 'Could not locate: ' . $filename;
		}
	}
	
	function saveDetails() {
		global $mainframe;
		
		/* save to database */
		parent::saveDetails ();
		
		/* get raw html from args */
		$registry = bfRegistry::getInstance ( $mainframe->get ( 'component' ) );
		$args = $registry->getValue ( 'args' );
		$this->html = $args [1] ['html'];
		
		/* save to file */
		$temp_file = bfCompat::getAbsolutePath () . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'view' . DS . 'user_templates' . DS . md5 ( $this->id ) . '.php';
		
		/* check file exists */
		if (! file_exists ( $temp_file )) {
			if (@ ! touch ( $temp_file )) {
				bfError::raiseError ( '500', 'Could not create file ' . $temp_file );
				return;
			}
		}
		
		/* write template file */
		$fd = fopen ( $temp_file, 'w' );
		if (false === $fd) {
			bfError::raiseError ( '500', 'Could not save ' . $temp_file );
			return;
		}
		fputs ( $fd, $this->html );
		fclose ( $fd );
		@ chmod ( $temp_file, 0644 );
	
	}
	
	function delete($id) {
		global $mainframe;
		parent::delete ( $id );
		
		/* delete file */
		$temp_file = bfCompat::getAbsolutePath () . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'view' . DS . 'user_templates' . DS . md5 ( $this->id ) . '.php';
		
		/* check file exists */
		if (file_exists ( $temp_file )) {
			if (! unlink ( $temp_file )) {
				bfError::raiseError ( '500', 'Could not delete file ' . $temp_file );
				return;
			}
		}
	}
	
	function getAll($where = '', $apply_limit = true, $orderby = null) {
		parent::getAll ( $where, $apply_limit, $orderby );
	}
}
?>