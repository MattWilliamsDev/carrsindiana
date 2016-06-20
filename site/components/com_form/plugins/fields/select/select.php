<?php
/**
 * @version $Id: select.php 184 2010-01-03 20:44:13Z  $
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
if (! class_exists ( 'plugins_fields_base' )) {
	require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'helper.php';
	require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'fields' . DS . '_baseClass.php';
}

/**
 * Class for form fields
 *
 */
final class plugins_fields_select extends plugins_fields_base {

	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	public $_pname = 'select';

	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	public $_title = 'select - A Generic Select Dropdown Box';

	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_attributes = array ('type' => 'select', 'id' => '', 'params' => '', 'name' => '', 'size' => '1', 'class' => 'inputbox', 'value' => '', 'style' => '', 'onblur' => '', 'multiple' => '' );

	/**
	 * whether to show blank attributes in html
	 *
	 * @var bool
	 */
	private $_showBlankAttributes = false;

	/**
	 * The base html
	 *
	 * @var string
	 */
	private $_barehtml = '<select %s>%s</select>';

	/**
	 * The creation defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_creation_defaults = array ('multiple' => '0', 'plugin' => 'select', 'published' => '1', 'access' => '0', 'allowbyemail' => '1', 'size' => '1', 'class' => 'inputbox', 'form_id' => '-1', 'type' => 'select', 'multiple' => '0', 'option1' => '0', 'populatebysql' => '', 'option2' => '0' );

	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	public $_desc = 'A Generic Drop Down';

	/**
	 * The sql required to extend the submitted data
	 * table to accomodate submitted data from this field
	 *
	 * @var unknown_type
	 */
	public $_extendSQL = 'ALTER TABLE `%s` ADD `%s` mediumtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;';

	/**
	 * The nuke sql to remove this element from the schema of the data table
	 *
	 * @var unknown_type
	 */
	public $_nukeSQL = 'ALTER TABLE `%s` DROP `%s`;';

	/**
	 * I set up the view template for the admin edit screen
	 *
	 */
	public function _editFieldView() {

		/* Call in Smarty to display template */
		bfLoad ( 'bfSmarty' );

		$tmp = bfSmarty::getInstance ( 'com_form' );
		$tmp->caching = false;
		$tmp->assignFromArray ( $this->_config );

		$disabled = bfHTML::yesnoRadioList ( 'disabled', '', $this->_config ['disabled'] );
		$tmp->assign ( 'DISABLED', $disabled );
		$tmp->assign ( 'CONFIG', $this->_config );

		/* Yes No Answers */
		$qs = array ('verify_iban','multiple', 'option1', 'option2', 'filter_strtoupper', 'filter_strtolower', 'verify_isvalidvatnumber', 'verify_isexistingusername', 'verify_isnotexistingusername', 'verify_isinteger', 'verify_isvalidurl', 'verify_isvalidcreditcardnumber', 'verify_isvalidukpostcode', 'published', 'allowsetbyget', 'allowbyemail', 'filter_a2z', 'filter_StripTags', 'filter_StringTrim', 'filter_Alnum', 'filter_Digits', 'required', 'verify_isemailaddress', 'verify_isblank', 'verify_isnotblank', 'verify_isipaddress', 'verify_isvalidukninumber', 'verify_isvalidssn', 'verify_isvaliduszip' );
		foreach ( $qs as $q ) {
			$tmp->assign ( strtoupper ( $q ), bfHTML::yesnoRadioList ( $q, '', $this->_config [$q] ) );
		}

		$OPTIONS = array (bfHTML::makeOption ( '0', 'Public' ), bfHTML::makeOption ( '1', 'Registered' ), bfHTML::makeOption ( '2', 'Special' ) );

		$access = bfHTML::selectList2 ( $OPTIONS, 'access', '', 'value', 'text', $this->_config ['access'] );
		$tmp->assign ( 'ACCESS', $access );

		$tmp->display ( dirname ( __FILE__ ) . DS . 'editView.tpl' );
	}

	/**
	 * I return a form element
	 *
	 * @return string
	 */
	public function toString() {
		$html = '';
		if ($this->_config ['published'] == '0') {
			return;
		}

		$options = array ();

		$params = explode ( "\n", $this->_attributes ['params'] );

		/* allowsetbyget overide */
		$val = bfRequest::getVar ( $this->_config ['slug'], null, 'GET' );
		if ($val && $this->_config ['allowsetbyget'] == '1') {
			$this->_attributes ['value'] = $this->runFilters ( $val );
		}

		/* if coming from validation rules then prepopulate again */
		if ($this->_attributes ['value'])
			$this->_config ['value'] = $this->_attributes ['value'];

		/*
	     * Oh my - how on earth do we handle multiples?
		 */
		if ($this->_config ['multiple'] == '1') {
			if ($this->_attributes ['value']) {
				//print_R ( $this->_attributes ['value'] );
			}
		}

		if (is_array ( $params ) && count ( $params ) > 1) {
			foreach ( $params as $v ) {
				$selected = '';
				if (preg_match ( '/\|/', $v )) {
					$parts = explode ( '|', $v );
					if (isset ( $this->_config ['value'] )) {
						$parts [0] == $this->_config ['value'] ? $selected = ' selected="selected"' : $selected = '';
					}
					$options [] = '<option' . $selected . ' value="' . stripslashes ( bfString::trim ( ($parts [0] ? $parts [0] : '') ) ) . '">' . stripslashes ( bfString::trim ( $parts [1] ) ) . '</option>';
				} else {
					if (isset ( $this->_config ['value'] )) {
						$v == $this->_config ['value'] ? $selected = ' selected="selected"' : $selected = '';
					}
					$options [] = '<option' . $selected . ' value="' . stripslashes ( bfString::trim ( $v ) ) . '">' . stripslashes ( bfString::trim ( $v ) ) . '</option>';
				}
			}
		} elseif ($this->_config ['option2'] == '1' && $this->_config ['populatebysql']) {
			$db = bfCompat::getDBO ();
			$db->setQuery ( $this->_config ['populatebysql'] );
			$results = $db->LoadObjectList ();
			foreach ( $results as $row ) {
				$v = $row->value . '|' . $row->text;
				$selected = '';
				if (preg_match ( '/\|/', $v )) {
					$parts = explode ( '|', $v );
					if (isset ( $this->_config ['value'] )) {
						$parts [0] == $this->_config ['value'] ? $selected = ' selected="selected"' : $selected = '';
					}
					$options [] = '<option' . $selected . ' value="' . stripslashes ( bfString::trim ( ($parts [0] ? $parts [0] : $parts [1]) ) ) . '">' . stripslashes ( bfString::trim ( $parts [1] ) ) . '</option>';
				} else {
					if (isset ( $this->_config ['value'] )) {
						$parts [0] == $this->_config ['value'] ? $selected = ' selected="selected"' : $selected = '';
					}
					$options [] = '<option' . $selected . ' value="' . stripslashes ( bfString::trim ( $v ) ) . '">' . stripslashes ( bfString::trim ( $v ) ) . '</option>';
				}
			}
		} else {

		}

		/* override */
		$this->_attributes ['id'] = $this->_config ['slug'];
		$this->_attributes ['name'] = $this->_config ['slug'];

		if ($this->_config ['multiple'] == '1') {
			$this->_attributes ['multiple'] = "multiple";
			$this->_attributes ['name'] = $this->_attributes ['name'] . "[]";
			if ($this->_attributes ['size'] < '2')
				$this->_attributes ['size'] = '5';

			if ($this->_config ['option1'] == '1') {
				$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
				if ($registry->getValue ( 'plugins.select.option1', 0 ) == '0') {
					bfDocument::addscript ( bfCompat::getLiveSite () . '/plugins/system/blueflame/libs/jquery/jquery.asmselect.js' );
					bfDocument::addCSS ( bfCompat::getLiveSite () . '/plugins/system/blueflame/libs/jquery/jquery.asmselect.css' );
					$registry->setValue ( 'plugins.select.option1', 1 );
				}
				bfDocument::addScriptFromString ( "
						jQuery(document).ready(function() {
								jQuery(\"select#" . $this->_config ['slug'] . "\").asmSelect({
									addItemTarget: 'bottom',
									animate: true,
									highlight: true,
									sortable: false
								});
							 }
						  );" );
			}
		} else {
			unset ( $this->_attributes ['multiple'] );
		}

		/* unset unrequired attributes */
		unset ( $this->_attributes ['params'] );
		unset ( $this->_attributes ['value'] );
		unset ( $this->_attributes ['type'] );

		$attributesHTML = array ();

		foreach ( $this->_attributes as $k => $v ) {
			if ($v == "" && $this->_showBlankAttributes === true) {
				$attributesHTML [$k] = strtolower ( $k ) . '="' . $v . '"';
			} else if ($v != "") {
				$attributesHTML [$k] = strtolower ( $k ) . '="' . $v . '"';
			}
		}

		ksort ( $attributesHTML );

		$attributesSpacedHTML = implode ( ' ', $attributesHTML );

		$html .= sprintf ( $this->_barehtml, $attributesSpacedHTML, implode ( "\n", $options ) );

		if ($this->_config ['required'] == '1') {
//			$html .= '<span class="required">*</span>';
		}

		return $html;
	}

	/*
 	 * postProcess gets triggered after all filters and validations are done
	 */
	public function postProcess() {
		$str = $this->getSubmittedValue ();

		if (is_array ( $str ))
			$str = implode ( ', ', $this->getSubmittedValue () );
		$this->setSubmittedValue ( is_string ( $str ) ? $str : null );
	}
}
?>