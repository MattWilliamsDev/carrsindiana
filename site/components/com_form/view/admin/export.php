<?php
/**
 * @version $Id: export.php 184 2010-01-03 20:44:13Z  $
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

final class JoomlaFormsExport {
	
	const BACKUPFORM = 1;
	const BACKUPFIELDS = 2;
	const BACKUPACTIONS = 3;
	const EXPORTSUBMISSIONS_XML = 4;
	const EXPORTSUBMISSIONS_CSV = 5;
	const EXPORTSUBMISSIONS_XLS = 6;
	const EXPORTSUBMISSIONS_CSV_FOREXCELONLY = 7;
	
	private $availableExports = array ('1' => 'backupCompleteForm', '2' => 'backupFields', '3' => 'backupActions', '4' => 'exportSubmissions', '7' => 'exportSubmissions' );
	
	private $_data = null;
	
	private $_output = '';
	
	public function __construct() {
	
	}
	
	public function setData(Array $data = array()) {
		
		$this->_data = $data;
	}
	
	public function generateExport($type) {
		switch ($type) {
			case self::BACKUPFORM :
				$this->_sendXMLHeaders ( 'backup.xml' );
				$this->_generate_backupCompleteForm ();
				break;
			case self::EXPORTSUBMISSIONS_XML :
				$this->_sendXMLHeaders ( 'submissions.xml' );
				$this->_generate_EXPORTSUBMISSIONS_XML ();
				break;
			case self::EXPORTSUBMISSIONS_CSV :
				$this->_sendXMLHeaders ( 'submissions.csv', 'csv' );
				$this->_generate_EXPORTSUBMISSIONS_CSV ();
				break;
			case self::EXPORTSUBMISSIONS_CSV_FOREXCELONLY :
				$this->_sendXMLHeaders ( 'submissions_EXCEL_FORMAT.csv', 'csv' );
				$this->_generate_EXPORTSUBMISSIONS_CSV ( true );
				break;
		}
	}
	
	private function _sendXMLHeaders($filename = 'export.xml', $type = 'xml') {
		
		if (! headers_sent ()) {
			if ($type === 'xml') {
				if ('JOOMLA1.5' == _BF_PLATFORM) {
					$doc = JFactory::getDocument ();
					/*@var $doc JDocument */
					$doc->setMimeEncoding ( 'text/xml' );
				
				} else {
					header ( "Content-Type: text/xml" );
				}
			} else if ($type === 'csv') {
				if ('JOOMLA1.5' == _BF_PLATFORM) {
					
					$doc = JFactory::getDocument ();
					/*@var $doc JDocument */
					$doc->setMimeEncoding ( 'text/csv' );
				
				} else {
					header ( "Content-Type: text/csv" );
				}
			}
			
			header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
			header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
			header ( 'Cache-Control: no-store, no-cache, must-revalidate' );
			header ( 'Cache-Control: post-check=0, pre-check=0', false );
			header ( 'Pragma: no-cache' );
			header ( 'Content-Disposition: attachment;filename="' . $filename . '"' );
		}
	}
	
	private function _generate_EXPORTSUBMISSIONS_XML() {
		
		$this->_output [] = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . "<submissions>";
		$submissions = $this->_data [2];
		$fields = $this->_data [1];
		foreach ( $fields as $field ) {
			$id = 'FIELD_' . $field->id;
			$value = $field->slug;
			$this->_data ['fieldmap'] [$id] = $value;
		
		}
		foreach ( $submissions as $submission ) {
			
			if ($submission->bf_status != 'Submitted') continue;
			$this->_output [] = "\t<submission id=\"" . $submission->id . "\">";
			foreach ( $submission as $k => $v ) {
				if ($k != 'id' && $k != 'bf_status'&& $k != 'bf_user_id') {
					$this->_addToXML ( $this->_data ['fieldmap'] [$k], $v, "\t\t" );
				}
			}
			$this->_output [] = "\t</submission>";
		
		}
		$this->_output [] = "</submissions>";
		echo implode ( "\n", $this->_output );
	}
	
	private function _generate_EXPORTSUBMISSIONS_CSV($usingExcel = false) {
		
		$submissions = $this->_data [2];
		$fields = $this->_data [1];
		
		$values = array ();
		$values [] = '"id"';
		
		foreach ( $fields as $field ) {
			$values [] = '"' . $field->slug . '"';
		}
		
		$this->_output [] = implode ( ',', $values );
		
		foreach ( $submissions as $submission ) {
			if ($submission->bf_status != 'Submitted') continue;
			$values = array ();
			$values [] = '"' . $submission->id . '"';
			foreach ( $fields as $field ) {

				$f = 'FIELD_' . $field->id;
				if ($usingExcel === true) {
					if ((substr ( $submission->$f, 0, 1 ) == "0" or substr ( $submission->$f, 0, 1 ) == " ") && $submission->$f != '') {
						$submission->$f = str_replace ( '"', '""', $submission->$f );
						$submission->$f = '="' . $submission->$f . '"';
						$values [] = '' . $submission->$f . '';					
					} else {
						$submission->$f = str_replace ( '"', '""', $submission->$f );
						$values [] = '"' . $submission->$f . '"';
					}
					
				
				} else {
					$submission->$f = str_replace ( '"', '""', $submission->$f );
					$values [] = '"' . $submission->$f . '"';
				}
			
			}
			$this->_output [] = implode ( ',', $values );
		}
		
		echo implode ( "\n", $this->_output );
	
	}
	
	private function _generate_backupCompleteForm() {
		
		$this->_output [] = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . "<form>";
		
		/* form header */
		$this->_output [] = "\t<config>";
		foreach ( $this->_data [0] as $k => $v ) {
			$this->_addToXML ( $k, $v, "\t\t" );
		}
		$this->_output [] = "\t</config>";
		
		$this->_output [] = "\t<form_fields>";
		foreach ( $this->_data [1] as $fields ) {
			$this->_output [] = "\t\t<field>";
			foreach ( $fields as $k => $v ) {
				
				$this->_addToXML ( $k, $v, "\t\t\t" );
			}
			$this->_output [] = "\t\t</field>";
		}
		$this->_output [] = "\t</form_fields>";
		
		$this->_output [] = "\t<form_actions>";
		foreach ( $this->_data [1] as $fields ) {
			$this->_output [] = "\t\t<action>";
			foreach ( $fields as $k => $v ) {
				
				$this->_addToXML ( $k, $v, "\t\t\t" );
			}
			$this->_output [] = "\t\t</action>";
		}
		$this->_output [] = "\t</form_actions>";
		
		$this->_output [] = "</form>";
		echo implode ( "\n", $this->_output );
	}
	
	private function _addToXML($k, $v, $tabs = '') {
		if (! is_string ( $v ))
			return;
		if (! is_string ( $k ))
			return;
		if ($v) {
			if (preg_match ( '/&/', $v ) || preg_match ( '/</', $v ) || preg_match ( '/>/', $v )) {
				$o = sprintf ( $tabs . '<%s><![CDATA[%s]]></%s>', $k, $v, $k );
				$this->_output [] = $o;
			
			} else {
				
				$o = sprintf ( $tabs . '<%s>%s</%s>', $k, $v, $k );
				$this->_output [] = $o;
			}
		} else {
			$this->_output [] = sprintf ( $tabs . '<%s />', $k );
		}
	}

}

try {
	$type = ( int ) bfRequest::getVar ( 'exportType' );
	
	if ($type > 0 && isset ( $form )) {
		
		$exporter = new JoomlaFormsExport ( );
		
		switch ($type) {
			case JoomlaFormsExport::BACKUPFORM :
				$exporter->setData ( array ($form, $field ['rows'], $action ['rows'] ) );
				break;
			
			case JoomlaFormsExport::EXPORTSUBMISSIONS_XML :
			case JoomlaFormsExport::EXPORTSUBMISSIONS_CSV :
			case JoomlaFormsExport::EXPORTSUBMISSIONS_CSV_FOREXCELONLY :
				$exporter->setData ( array ($form, $field ['rows'], $submission ['rows'] ) );
				break;
		}
		
		$exporter->generateExport ( $type );
	
	} else {
		throw new Exception ( 'Unknown export type of form not found' );
	}

} catch ( Exception $e ) {
	bfError::raiseError ( '404', $e->getMessage (), $e->getMessage () );
}