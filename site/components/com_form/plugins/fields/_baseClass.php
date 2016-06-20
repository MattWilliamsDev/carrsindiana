<?php
/**
 * @version $Id: _baseClass.php 201 2010-01-24 23:11:10Z  $
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

interface plugins_fields_base_abstract {
}

/**
 * Base Class for form fields
 *
 */
class plugins_fields_base implements plugins_fields_base_abstract {
	
	/**
	 * The current form_id 
	 *
	 * @var int the form id
	 */
	public $_form_id = null;
	
	/**
	 * I hold the text of the validation errors
	 */
	public $_validationErrors = array ();
	
	/**
	 * I hold the text of the filter errors
	 */
	public $_filterErrors = array ();
	
	/**
	 * I hold the submitted value so that validation rules can be processed on me.
	 */
	public $_submittedValue = '';
	
	/**
	 * I hold this fields current config, 
	 * which overrides the defaults above
	 *
	 * @var array
	 */
	public $_config = array ();
	
	public function __construct() {
		
		/* get session to get last form */
		$this->_session = bfSession::getInstance ( 'com_form' );
		
		/* set the correct form id */
		$this->_creation_defaults ['form_id'] = $this->_session->get ( 'lastFormId', '', 'default' );
	}
	
	/**
	 * I extend the schema of the data table
	 *
	 * @param object $fieldObj The field object
	 */
	public function onAfterCreateField_ExtendDataTable(&$fieldObj, $formid = null) {
		
		/* if no sql - like a submit button */
		if (! $this->_extendSQL)
			return;
			
		/* load utils for mysql 4.0 conversions */
		bfLoad ( 'bfDBUtils' );
		
		/* get db object */
		$db = bfCompat::getDBO ();
		
		/* get data tbl */
		$fid = $formid ? $formid : $fieldObj->form_id;
		$tblName = $this->_getUserTable ( $fid );
		
		/* get field slug - this is the column name */
		$slug = 'FIELD_' . $fieldObj->id;
		
		/* generate sql */
		$sql = sprintf ( $this->_extendSQL, $tblName, $slug );
		
		/* make it compatible */
		$sql = bfDBUtils::makeCompatible ( $sql );
		
		/* set it */
		$db->setQuery ( $sql );
		
		/* exceute it */
		$db->query ();
	
	}
	
	public function onAfterCopyField($fieldObj, $form) {
		
		$this->onAfterCreateField_ExtendDataTable ( $fieldObj, $form );
	}
	
	/**
	 * I run the sql to create the form field 
	 *
	 */
	public function onAfterCreateField(&$fieldObj) {
		
		/* get session to get last form */
		$this->_session = bfSession::getInstance ( 'com_form' );
		
		/* set the correct form id */
		$this->_creation_defaults ['form_id'] = $this->_session->get ( 'lastFormId', '', 'default' );
		
		/* set creation defaults */
		foreach ( $this->_creation_defaults as $k => $v ) {
			if ($fieldObj->$k == '') {
				$fieldObj->$k = $v;
			}
		}
		
		/* check we have a title */
		if (! $fieldObj->title) {
			$fieldObj->title = 'My New Form Field ' . $fieldObj->id;
		}
		
		/* mysql safe slug */
		$fieldObj->slug = bfString::slug4mysql ( $fieldObj->title );
		
		/* modify the title */
		$fieldObj->publictitle = $fieldObj->title;
		$fieldObj->title = $fieldObj->title . ' (From ' . $this->_pname . ' Field Template)';
		
		/* set created deate */
		$fieldObj->touchCreatedDate ();
		
		/* store changes */
		$fieldObj->store ();
	}
	
	public function onDeleteField(&$fieldObj) {
		
		/* load utils for mysql 4.0 conversions */
		bfLoad ( 'bfDBUtils' );
		
		/* get db object */
		$db = bfCompat::getDBO ();
		
		/* get data tbl */
		$tblName = $this->_getUserTable ( $fieldObj->form_id );
		
		/* generate sql */
		$sql = sprintf ( $this->_nukeSQL, $tblName, 'FIELD_' . $fieldObj->id );
		
		/* make it compatible */
		$sql = bfDBUtils::makeCompatible ( $sql );
		
		/* set it */
		$db->setQuery ( $sql );
		
		/* exceute it */
		$db->query ();
	
	}
	
	private function _getUserTable($form_id) {
		
		/* get table name */
		$db = bfCompat::getDBO ();
		$db->setQuery ( 'SELECT hasusertable FROM #__form_forms WHERE id = "' . ( int ) $form_id . '"' );
		return $db->loadResult ();
	}
	
	public function setConfig($config, $controller = null) {
		
		if (null !== $controller)
			$this->controller = $controller;
		
		if (is_object ( $config )) {
			$arr = array ();
			
			foreach ( $config as $k => $v ) {
				$arr [$k] = $v;
			}
			$config = $arr;
		}
		
		$this->_config = $config;
		
		$this->_setAttributes ();
	}
	
	private function _setAttributes() {
		
		foreach ( $this->_config as $k => $v ) {
			if (array_key_exists ( $k, $this->_attributes )) {
				if ($v != '')
					$this->_attributes [$k] = $v;
			}
		}
		
		/* after failing validation re-populate the form with submitted values */
		$this->_setValueBySubmission ();
		
		/* disabled? */
		$this->setDisabled ();
	
	}
	
	public function setSubmittedValue($value) {
		
		$this->_submittedValue = $value;
		bfRequest::setVar ( $this->_config ['slug'], $value );
	}
	
	public function getSubmittedValue() {
		
		return $this->_submittedValue;
	}
	
	/**
	 * Allows the value of a field to be set by the get var
	 * @deprecated 
	 */
	public function setValueByGet() {
		throw new Exception ( '@depreciated - called in each element instead' );
	}
	
	public function setDisabled() {
		
		/* Disabled */
		if (@$this->_config ['disabled']) {
			$this->_attributes ['disabled'] = 'disabled';
		}
	}
	
	public function getValidationErrorMessages() {
		
		return $this->_validationErrors;
	}
	
	public function getFilterErrorMessages() {
		
		return $this->_filterErrors;
	}
	
	private function _setValueBySubmission() {
		
		if (defined ( '_BF_FAILED_VALIDATION' )) {
			if (bfRequest::getVar ( $this->_config ['slug'] )) {
				$this->_attributes ['value'] = bfRequest::getVar ( $this->_config ['slug'] );
			}
		}
	}
	
	private function _flagFailedValidation() {
		
		$this->_config ['FAILVALIDATION'] = true;
	}
	
	private function _addValidationError($msg) {
		
		$this->_validationErrors [] = $this->_config ['publictitle'] . ' ' . bfText::_ ( $msg );
	}
	
	/*
	* I run the validations
	* Add new ones in here...
	*/
	public function passesValidation() {
		bfLoad ( 'bfVerify' );
		
		/* If pausing then forego the validation checks - slight security risk? Maybe, but the user is logged in...*/
		$bf_preview = bfRequest::getVar ( 'bf_preview_' . $this->_config ['form_id'] );
		if ($bf_preview == "2")
			return true;
		
		if ($this->_config ['required'] == '1' && $this->_submittedValue == '') {
			
			if ($this->_pname == 'fileupload' && array_key_exists ( $this->_config ['slug'], $_FILES )) {
				if ($_FILES [$this->_config ['slug']] ['error'] == '4') {
					$this->_addValidationError ( ' - ' . bfText::_ ( 'you did not select a file to upload' ) );
					$this->_flagFailedValidation ();
				}
			} else {
				$this->_addValidationError ( bfText::_ ( 'is a required field' ) );
				$this->_flagFailedValidation ();
			}
			return false;
		}
		
		/* VERIFY_ISEMAILADDRESS */
		if ($this->_config ['verify_isemailaddress'] == '1') {
			if (bfVerify::isemailaddress ( $this->_submittedValue )) {
				/* not */
				if (! bfVerify::isemailaddressbydns ( $this->_submittedValue )) {
					/* yes basic not dns */
					$this->_addValidationError ( bfText::_ ( 'is not a valid email address, failed DNS Checks' ) );
					$this->_flagFailedValidation ();
					return false;
				} else if (! bfVerify::isValidHostname ( $this->_submittedValue )) {
					$this->_addValidationError ( bfText::_ ( 'is not a valid email address, failed Hostname/Domain Checks' ) );
					$this->_flagFailedValidation ();
					return false;
				} else {
					/* yes basic AND yes dns AND yes hostname */
					return true;
				}
			} else {
				/* not basic */
				$this->_addValidationError ( bfText::_ ( 'is not a valid email address, failed basic Checks' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		
		}
		
		/* VERIFY_ISBLANK */
		if ($this->_config ['verify_isblank'] == '1') {
			if (! bfVerify::isblank ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'must be left empty' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* VERIFY_ISNOTBLANK */
		if ($this->_config ['verify_isnotblank'] == '1') {
			if (! bfVerify::isnotblank ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'must not be left empty' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* VERIFY_ISIPADDRESS */
		if ($this->_config ['verify_isipaddress'] == '1') {
			if (! bfVerify::isipaddress ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not a valid IP Address' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* VERIFY_ISVALIDUKNINUMBER */
		if ($this->_config ['verify_isvalidukninumber'] == '1') {
			if (! bfVerify::isvalidukninumber ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not a valid UK NI Number' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* VERIFY_ISVALIDSSN */
		if ($this->_config ['verify_isvalidssn'] == '1') {
			if (! bfVerify::isValidSSN ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not a valid US SS Number' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_isvaliduszip */
		if ($this->_config ['verify_isvaliduszip'] == '1') {
			if (! bfVerify::isValidUSZip ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not a valid US Zip Code' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_isvalidukpostcode */
		if ($this->_config ['verify_isvalidukpostcode'] == '1') {
			if (! bfVerify::isValidUKPostCode ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not a valid UK Post Code' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_isexistingusername */
		if ($this->_config ['verify_isexistingusername'] == '1') {
			if (! bfVerify::isExistingUsername ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not a valid and existing Joomla Username' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_isnotexistingusername */
		if ($this->_config ['verify_isnotexistingusername'] == '1') {
			if (! bfVerify::isNotExistingUsername ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is a username already taken' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_isvalidcreditcardnumber */
		if ($this->_config ['verify_isvalidcreditcardnumber'] == '1') {
			if (! bfVerify::isValidCreditCardNumber ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not a valid credit card number' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_isvalidurl */
		if ($this->_config ['verify_isvalidurl'] == '1') {
			if (! bfVerify::isValidURL ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not a valid URL' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_isvalidvatnumber */
		if ($this->_config ['verify_isvalidvatnumber'] == '1') {
			if (! bfVerify::isValidVATNumber ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not a valid UK VAT Number' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_isinteger */
		if ($this->_config ['verify_isinteger'] == '1') {
			if (! bfVerify::isinteger ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not an integer' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_stringlengthgreaterthan */
		if ($this->_config ['verify_stringlengthgreaterthan'] > 0) {
			if (! bfVerify::stringlengthgreaterthan ( $this->_submittedValue, $this->_config ['verify_stringlengthgreaterthan'] )) {
				$this->_addValidationError ( bfText::_ ( 'must be at least' ) . ' ' . $this->_config ['verify_stringlengthgreaterthan'] . ' ' . bfText::_ ( ' chars long' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_stringlengthlessthan */
		if ($this->_config ['verify_stringlengthlessthan'] > 0) {
			if (! bfVerify::stringlengthlessthan ( $this->_submittedValue, $this->_config ['verify_stringlengthlessthan'] )) {
				$this->_addValidationError ( bfText::_ ( 'must be less than' ) . ' ' . $this->_config ['verify_stringlengthlessthan'] . ' ' . bfText::_ ( ' chars long' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_stringlengthequals */
		if ($this->_config ['verify_stringlengthequals'] > 0) {
			if (! bfVerify::stringlengthequals ( $this->_submittedValue, $this->_config ['verify_stringlengthequals'] )) {
				$this->_addValidationError ( bfText::_ ( 'must be exactly' ) . ' ' . $this->_config ['verify_stringlengthequals'] . ' ' . bfText::_ ( ' chars long' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_numbergreaterthan */
		if ($this->_config ['verify_numbergreaterthan']) {
			if (! bfVerify::numbergreaterthan ( $this->_submittedValue, $this->_config ['verify_numbergreaterthan'] )) {
				$this->_addValidationError ( bfText::_ ( 'must be greater than ' ) . ' ' . $this->_config ['verify_numbergreaterthan'] );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_numberlessthan */
		if ($this->_config ['verify_numberlessthan']) {
			if (! bfVerify::numberlessthan ( $this->_submittedValue, $this->_config ['verify_numberlessthan'] )) {
				$this->_addValidationError ( bfText::_ ( 'must be less than ' ) . ' ' . $this->_config ['verify_numberlessthan'] );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_numberequals */
		if ($this->_config ['verify_numberequals']) {
			if (! bfVerify::numberequals ( $this->_submittedValue, $this->_config ['verify_numberequals'] )) {
				$this->_addValidationError ( bfText::_ ( 'must be equal to ' ) . ' ' . $this->_config ['verify_numberequals'] );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_regex */
		if ($this->_config ['verify_regex']) {
			if (! bfVerify::regex ( $this->_config ['verify_regex'], $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'must match regex: ' ) . ' ' . $this->_config ['verify_regex'] );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_numberlessthan */
		if ($this->_config ['verify_equalto']) {
			if (! bfVerify::equalto ( $this->_submittedValue, $this->_config ['verify_equalto'] )) {
				$this->_addValidationError ( bfText::_ ( 'must be equal to ' ) . ' ' . $this->_config ['verify_equalto'] );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_isinarray */
		if ($this->_config ['verify_isinarray']) {
			if (! bfVerify::isInArray ( $this->_submittedValue, $this->_config ['verify_isinarray'] )) {
				$this->_addValidationError ( bfText::_ ( 'must be one of these' ) . ': ' . $this->_config ['verify_isinarray'] );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_brazil_cpf */
		if ($this->_config ['verify_brazil_cpf']) {
			if (! bfVerify::isValid_brazil_cpf ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not valid' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_brazil_cnpj */
		if ($this->_config ['verify_brazil_cnpj']) {
			if (! bfVerify::isValid_brazil_cnpj ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not valid' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* verify_iban Zend_Validate_Iban */
		if ($this->_config ['verify_iban']) {
			if (! bfVerify::isValid_iban ( $this->_submittedValue )) {
				$this->_addValidationError ( bfText::_ ( 'is not a valid bank IBAN Number' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* domains */
		/* VERIFY_ISALLOWEDDOMAIN */
		if ($this->_config ['verify_isalloweddomain'] != '') {
			if (! bfVerify::isalloweddomain ( $this->_config ['verify_isalloweddomain'], $this->_submittedValue )) {
				$this->_addValidationError ( $domain . ' ' . bfText::_ ( 'is not an allowed or whitelisted email domain for this form submission' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* VERIFY_ISDENIEDDOMAIN */
		if ($this->_config ['verify_isdenieddomain'] != '') {
			
			if (! bfVerify::isdenieddomain ( $this->_config ['verify_isdenieddomain'], $this->_submittedValue )) {
				$this->_addValidationError ( $domain . ' ' . bfText::_ ( 'is a denied email domain for this form submission' ) );
				$this->_flagFailedValidation ();
				return false;
			}
		}
		
		/* File Uploads */
		/* Filter and Validate at the same time :-) */
		if (isset ( $_FILES )) {
			if (is_array ( $_FILES )) {
				
				if (array_key_exists ( $this->_config ['slug'], $_FILES )) {
					$file = $_FILES [$this->_config ['slug']];
					
					$file ['name'] = $this->_Zendfilter ( 'StripTags', $file ['name'] );
					$file ['type'] = $this->_Zendfilter ( 'StripTags', $file ['type'] );
					$file ['tmp_name'] = $this->_Zendfilter ( 'StripTags', $file ['tmp_name'] );
					$file ['size'] = $this->_Zendfilter ( 'Digits', $file ['size'] );
					$file ['error'] = $this->_Zendfilter ( 'Digits', $file ['error'] );
					$_FILES [$this->_config ['slug']] = $file;
					
					/* ok we are clean now */
					if ($file ['name']) {
						$ext = substr ( $file ['name'], strrpos ( $file ['name'], '.' ) + 1 );
						if (! preg_match ( '~' . $ext . '~', $this->_config ['verify_fileupload_extensions'] )) {
							$this->_addValidationError ( bfText::_ ( 'has an unacceptable extension' ) );
							$this->_flagFailedValidation ();
							return false;
						}
					}
					$AcceptSize = $this->_config ['verify_fileupload_maxsize'] * 1024 * 1024;
					if ($file ['size'] > $AcceptSize) {
						$this->_addValidationError ( bfText::_ ( 'is bigger than the allowed upload size' ) );
						$this->_flagFailedValidation ();
						return false;
					}
				}
			
			}
		}
		
		return true;
	}
	
	private function _Zendfilter($filter, $filtered) {
		
		$class = 'Zend_Filter_' . $filter;
		if (! class_exists ( $class ))
			require_once 'Zend/Filter/' . $filter . '.php';
		
		switch ($filter) {
			case "Alpha" :
				$filter = new $class ( true );
				break;
			default :
				$filter = new $class ();
				break;
		}
		
		return $filter->filter ( $filtered );
	}
	
	public function runFilters($unclean = null) {
		if (! array_key_exists ( 'plugin', $this->_config ))
			$this->_config ['plugin'] = '';
		
		if ($this->_config ['plugin'] == 'fileupload') {
			return $unclean ? $unclean : '';
		}
		
		if ($unclean !== null) {
			$before = $unclean;
			$filtered = $unclean;
		} else {
			$before = $this->_submittedValue;
			$filtered = $this->_submittedValue;
		}
		
		/* clean xHTML and XSS */
		$filtered = str_replace ( '">', '', $filtered );
		$filtered = str_replace ( '<"', '', $filtered );
		$filtered = str_replace ( "'>", '', $filtered );
		$filtered = str_replace ( "<'", '', $filtered );
		
		/* clean up for testing */
		if (! array_key_exists ( 'filter_StringTrim', $this->_config ))
			$this->_config ['filter_StringTrim'] = '0';
		if (! array_key_exists ( 'filter_Alnum', $this->_config ))
			$this->_config ['filter_Alnum'] = '0';
		if (! array_key_exists ( 'filter_Digits', $this->_config ))
			$this->_config ['filter_Digits'] = '0';
		if (! array_key_exists ( 'filter_StripTags', $this->_config ))
			$this->_config ['filter_StripTags'] = '0';
		if (! array_key_exists ( 'filter_a2z', $this->_config ))
			$this->_config ['filter_a2z'] = '0';
			
		/* Run Filters */
		if ($this->_config ['filter_StringTrim'] == '1' && $filtered != '' && is_string ( $filtered ))
			$filtered = $this->_Zendfilter ( 'StringTrim', $filtered );
		
		if ($this->_config ['filter_Alnum'] == '1' && $filtered != '' && is_string ( $filtered ))
			$filtered = $this->_Zendfilter ( 'Alnum', $filtered );
		
		if ($this->_config ['filter_Digits'] == '1' && $filtered != '' && is_string ( $filtered ))
			$filtered = $this->_Zendfilter ( 'Digits', $filtered );
		
		if ($this->_config ['filter_StripTags'] == '1' && $filtered != '' && is_string ( $filtered ))
			$filtered = $this->_Zendfilter ( 'StripTags', $filtered );
		
		if ($this->_config ['filter_a2z'] == '1' && $filtered != '' && is_string ( $filtered ))
			$filtered = $this->_Zendfilter ( 'Alpha', $filtered );
		
		if ($this->_config ['filter_strtoupper'] == '1' && $filtered != '' && is_string ( $filtered ))
			$filtered = bfString::strtoupper ( $filtered );
		
		if ($this->_config ['filter_ucwords'] == '1' && $filtered != '' && is_string ( $filtered ))
			$filtered = bfString::ucwords ( $filtered );
		
		if ($this->_config ['filter_strtolower'] == '1' && $filtered != '' && is_string ( $filtered ))
			$filtered = bfString::strtolower ( $filtered );
		
		if ($before !== $filtered && $unclean === null) {
			$this->setSubmittedValue ( $filtered );
			//			$this->_filterErrors [] = $this->_config ['slug'] . ' ' . bfText::_ ( 'was filtered' );
			return $filtered;
		} else {
			return $filtered;
		}
	}
}

?>
