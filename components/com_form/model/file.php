<?php
/**
 * @version $Id: file.php 147 2009-07-14 20:20:18Z  $
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

class File {
	
	private $files = array ();
	private $folder = '';
	
	public function __construct() {
	
	}
	
	public function getAll($form_id) {
		if (! is_int ( $form_id ))
			throw new InvalidArgumentException ( 'Form id must be an int!' );
		
		$this->_getFolder ( $form_id );
		$this->_getFiles ();
	}
	
	public function getPublicVars() {
		return array ('folder' => $this->folder, 'files' => $this->files );
	}
	
	private function _getfolder($form_id) {
		$this->folder = bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'files' . DS . substr ( md5 ( bfCompat::getSecret () . $form_id ), 0, 5 );
	}
	
	private function _getFiles() {
		
		$dir = new DirectoryIterator ( $this->folder );
		
		foreach ( $dir as $file ) {
			
			if (! $file->isDot () && ! $file->isDir () && ($file->getFilename () != 'index.php')) {
				
				$file = array ($file->getFilename (), 

				number_format ( ($file->getSize () / 1024), 2 ) . " Kb", 

				date ( "D d M Y H:i:sa", $file->getCTime () ) );
				
				$this->files [] = $file;
			}
		}
		
		return $this->files;
	
	}
	
	public function delete() {
		$session = bfSession::getInstance ( 'com_form' );
		$args = func_get_args ();
		$filename = $args [0];
		$this->_getfolder ( $session->get ( 'lastFormId', '', 'default' ) );
		$f = $this->folder . DS . $filename;
		@chmod ( $f, 0777 );
		@unlink ( $f );
	}
}
?>