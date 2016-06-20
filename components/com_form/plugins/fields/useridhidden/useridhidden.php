<?php
/**
 * @version $Id: useridhidden.php 147 2009-07-14 20:20:18Z  $
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
class plugins_fields_useridhidden extends plugins_fields_base {

	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	public $_pname = 'useridhidden';

	/**
	 * The current form_id
	 *
	 * @var int the form id
	 */
	public $_form_id = null;

	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	public $_title = 'Pre-Filled With Logged In Users ID - Hidden Field';

	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_attributes = array ('type' => 'hidden', 'id' => '', 'name' => '', 'value' => '' );

	/**
	 * whether to show blank attributes in html
	 *
	 * @var bool
	 */
	public $_showBlankAttributes = false;

	/**
	 * The base html
	 *
	 * @var string
	 */
	public $_barehtml = '<input %s />';

	/**
	 * I hold this fields current config,
	 * which overrides the defaults above
	 *
	 * @var array
	 */
	public $_config = array ();

	/**
	 * The creation defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_creation_defaults = array ('plugin' => 'useridhidden', 'verify_isinteger' => '1', 'filter_alnum' => '1', 'published' => '1', 'access' => '0', 'allowbyemail' => '1', 'maxlength' => '255', 'type' => 'hidden', 'form_id' => '-1' );

	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	public $_desc = 'A hidden field prefilled with the logged in user\'s id number, cannot be changed by the user';

	/**
	 * The sql required to extend the submitted data
	 * table to accomodate submitted data from this field
	 *
	 * @var unknown_type
	 */
	public $_extendSQL = 'ALTER TABLE `%s` ADD `%s` INT( 11 ) NOT NULL ;';

	/**
	 * The nuke sql to remove this element from the schema of the data table
	 *
	 * @var unknown_type
	 */
	public $_nukeSQL = 'ALTER TABLE `%s` DROP `%s`;';

	/**
	 * PHP5 Constructor
	 *
	 */
	public function __construct() {

		/* get session to get last form */
		$session = bfSession::getInstance ( 'com_form' );

		/* set the correct form id */
		$this->_creation_defaults ['form_id'] = $session->get ( 'lastFormId', '', 'default' );
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
		$qs = array ('verify_isvalidvatnumber', 'verify_isexistingusername', 'verify_isnotexistingusername', 'verify_isinteger', 'verify_isvalidurl', 'verify_isvalidcreditcardnumber', 'verify_isvalidukpostcode', 'published', 'allowsetbyget', 'allowbyemail', 'filter_a2z', 'filter_StripTags', 'filter_StringTrim', 'filter_Alnum', 'filter_Digits', 'required', 'verify_isemailaddress', 'verify_isblank', 'verify_isnotblank', 'verify_isipaddress', 'verify_isvalidukninumber', 'verify_isvalidssn', 'verify_isvaliduszip' );
		foreach ( $qs as $q ) {
			$tmp->assign ( strtoupper ( $q ), bfHTML::yesnoRadioList ( $q, '', $this->_config [$q] ) );
		}

		$OPTIONS = array (bfHTML::makeOption ( '0', 'Public' ), bfHTML::makeOption ( '1', 'Registered' ), bfHTML::makeOption ( '2', 'Special' ) );

		$access = bfHTML::selectList2 ( $OPTIONS, 'access', '', 'value', 'text', $this->_config ['access'] );
		$tmp->assign ( 'ACCESS', $access );

		$tmp->display ( dirname ( __FILE__ ) . DS . 'editView.tpl' );
	}

	public function toString() {

		if ($this->_config ['published'] == '0') {
			return;
		}

		/* override */
		$this->_attributes ['id'] = $this->_config ['slug'];
		$this->_attributes ['name'] = $this->_config ['slug'];

		/* add username */
		$user = bfUser::getInstance ();

		/* allowsetbyget overide */
		$val = bfRequest::getVar ( $this->_config ['slug'], null, 'GET' );
		if ($val && $this->_config ['allowsetbyget'] == '1') {
			$this->_attributes ['value'] = $val;
		} else {
			$this->_attributes ['value'] = $user->get ( 'id' ) ? $user->get ( 'id' ) : '0';
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

		$html = sprintf ( $this->_barehtml, $attributesSpacedHTML );

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

		/* add username */
		$user = bfUser::getInstance ();

		/* Ignoire the users submission and reset to known value */
		$this->setSubmittedValue ( $user->get ( 'id' ) );
	}
}
?>