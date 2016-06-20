<?php
/**
 * @version $Id: ipaddress.php 165 2009-08-02 20:37:23Z  $
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
final class plugins_fields_ipaddress extends plugins_fields_base {

	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	public $_pname = 'ipaddress';

	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	public $_title = 'IP Address - Display the users IP address';

	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_attributes = array ('type' => 'text', 'id' => '', 'name' => '', 'maxlength' => '255', 'size' => '30', 'class' => 'inputbox', 'value' => '', 'style' => '', 'onblur' => '' );

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
	private $_barehtml = '<input %s />';

	/**
	 * The creation defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_creation_defaults = array ('plugin' => 'ipaddress', 'verify_isipaddress' => '1', 'published' => '1', 'access' => '0', 'allowbyemail' => '1', 'maxlength' => '255', 'size' => '30', 'class' => 'inputbox', 'form_id' => '-1', 'type' => 'text' );

	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	public $_desc = 'This displays a textbox prefilled with the users IP Address';

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
		$qs = array ('verify_isvalidvatnumber', 'verify_isexistingusername', 'verify_isnotexistingusername', 'verify_isinteger', 'verify_isvalidurl', 'verify_isvalidcreditcardnumber', 'verify_isvalidukpostcode', 'published', 'allowsetbyget', 'allowbyemail', 'filter_a2z', 'filter_StripTags', 'filter_StringTrim', 'filter_Alnum', 'filter_Digits', 'required', 'verify_isemailaddress', 'verify_isblank', 'verify_isnotblank', 'verify_isipaddress', 'verify_isvalidukninumber', 'verify_isvalidssn', 'verify_isvaliduszip' );
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

		/* override */
		$this->_attributes ['id'] = $this->_config ['slug'];
		$this->_attributes ['name'] = $this->_config ['slug'];

		/* allowsetbyget overide */
		$val = bfRequest::getVar ( $this->_config ['slug'], null, 'GET' );
		if ($val && $this->_config ['allowsetbyget'] == '1') {
			$this->_attributes ['value'] = $val;
		} else {
			$this->_attributes ['value'] = isset ( $_SERVER ['REMOTE_ADDR'] ) ? $_SERVER ['REMOTE_ADDR'] : '0.0.0.0';
		}

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

		$html .= sprintf ( $this->_barehtml, $attributesSpacedHTML );

		if ($this->_config ['required'] == '1') {
//			$html .= '<span class="required">*</span>';
		}

		return $html;
	}

	/**
	 * postProcess gets triggered after all filters and validations are done
	 *
	 */
	public function postProcess() {

		/* Dont do anything if allowsetbyget is on because value could have been modified anyway! */
		if ($this->_config ['allowsetbyget'] == '1')
			return;

		/* Ignoire the users submission and reset to known value */
		$this->setSubmittedValue ( isset ( $_SERVER ['REMOTE_ADDR'] ) ? $_SERVER ['REMOTE_ADDR'] : '0.0.0.0' );
	}
}
?>