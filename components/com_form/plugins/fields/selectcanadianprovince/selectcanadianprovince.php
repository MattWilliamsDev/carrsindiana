<?php
/**
 * @version $Id: selectcanadianprovince.php 184 2010-01-03 20:44:13Z  $
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
final class plugins_fields_selectcanadianprovince extends plugins_fields_base {

	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	public $_pname = 'selectcanadianprovince';

	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	public $_title = 'Drop Down List: Prepopulated with Canadian Province Territory';

	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_attributes = array ('type' => 'select', 'id' => '', 'params' => '', 'name' => '', 'size' => '1', 'class' => 'inputbox', 'value' => '', 'style' => '', 'onblur' => '' );

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
	public $_creation_defaults = array ('plugin' => 'selectaustralianstates', 'published' => '1', 'access' => '0', 'allowbyemail' => '1', 'size' => '1', 'class' => 'inputbox', 'form_id' => '-1', 'type' => 'select', 'verify_isinarray' => '' );

	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	public $_desc = 'A Drop Down With Canadian Province Territories as Options';

	/**
	 * The sql required to extend the submitted data
	 * table to accomodate submitted data from this field
	 *
	 * @var unknown_type
	 */
	public $_extendSQL = 'ALTER TABLE `%s` ADD `%s` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;';

	/**
	 * The nuke sql to remove this element from the schema of the data table
	 *
	 * @var unknown_type
	 */
	public $_nukeSQL = 'ALTER TABLE `%s` DROP `%s`;';

	public function __construct() {

		$states = array ("AB" => "Alberta", "BC" => "British Columbia", "MB" => "Manitoba", "NB" => "New Brunswick", "NL" => "Newfoundland and Labrador", "NT" => "Northwest Territories", "NS" => "Nova Scotia", "NU" => "Nunavut", "ON" => "Ontario", "PE" => "Prince Edward Island", "QC" => "Quebec", "SK" => "Saskatchewan", "YT" => "Yukon" );

		$params = array ('' => bfText::_ ( 'Please Select' ) );

		$verify = array ();

		foreach ( $states as $short => $long ) {
			$params [] = $short . '|' . $long;
			$verify [] = $short;
		}

		$params = implode ( "\n", $params );
		$this->_creation_defaults ['params'] = $params;
		$this->_creation_defaults ['verify_isinarray'] = implode ( ',', $verify );
		$this->_creation_defaults ['required'] = '1';

	}

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
		$qs = array ('filter_strtoupper', 'filter_strtolower', 'verify_isvalidvatnumber', 'verify_isexistingusername', 'verify_isnotexistingusername', 'verify_isinteger', 'verify_isvalidurl', 'verify_isvalidcreditcardnumber', 'verify_isvalidukpostcode', 'published', 'allowsetbyget', 'allowbyemail', 'filter_a2z', 'filter_StripTags', 'filter_StringTrim', 'filter_Alnum', 'filter_Digits', 'required', 'verify_isemailaddress', 'verify_isblank', 'verify_isnotblank', 'verify_isipaddress', 'verify_isvalidukninumber', 'verify_isvalidssn', 'verify_isvaliduszip' );
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

		foreach ( $params as $v ) {
			$selected = '';
			if (preg_match ( '/\|/', $v )) {
				$parts = explode ( '|', $v );
				if (isset ( $this->_config ['value'] ))
					($parts [0] == $this->_config ['value']) ? $selected = ' selected="selected"' : $selected = '';
				$options [] = '<option' . $selected . ' value="' . addslashes ( bfString::trim ( ($parts [0] ? $parts [0] : $parts [1]) ) ) . '">' . addslashes ( bfString::trim ( $parts [1] ) ) . '</option>';
			} else {
				if (isset ( $this->_config ['value'] ))
					($v == $this->_config ['value']) ? $selected = ' selected="selected"' : $selected = '';
				$options [] = '<option' . $selected . ' value="' . addslashes ( bfString::trim ( $v ) ) . '">' . addslashes ( bfString::trim ( $v ) ) . '</option>';
			}
		}

		/* override */
		$this->_attributes ['id'] = $this->_config ['slug'];
		$this->_attributes ['name'] = $this->_config ['slug'];

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

	public function postProcess() {
		$this->setSubmittedValue ( $this->getSubmittedValue () );
	}
}
?>