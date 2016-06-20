<?php
/**
 * @version $Id: textarea.php 199 2010-01-24 23:10:49Z  $
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
final class plugins_fields_textarea extends plugins_fields_base {

	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	public $_pname = 'textarea';

	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	public $_title = 'textarea - A Simple Text Area';

	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_attributes = array ('id' => '', 'name' => '', 'cols' => '40', 'rows' => '10', 'class' => 'inputbox', 'style' => '', 'onblur' => '', 'option1' => '0', 'option2' => '0' );

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
	private $_barehtml = '<textarea %s>%s</textarea>';

	/**
	 * The creation defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_creation_defaults = array ('plugin' => 'textarea', 'published' => '1', 'access' => '0', 'allowbyemail' => '1', 'size' => '50', 'class' => 'inputbox', 'cols' => '40', 'rows' => '10', 'form_id' => '-1', 'type' => 'textarea', 'option1' => '0', 'option2' => '0' );

	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	public $_desc = 'The humble textarea, can be used for many things';

	/**
	 * The sql required to extend the submitted data
	 * table to accomodate submitted data from this field
	 *
	 * @var unknown_type
	 */
	public $_extendSQL = 'ALTER TABLE `%s` ADD `%s` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;';

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
		$qs = array ('option1', 'option2', 'filter_strtoupper', 'filter_strtolower','filter_ucwords', 'verify_isvalidvatnumber', 'verify_isexistingusername', 'verify_isnotexistingusername', 'verify_isinteger', 'verify_isvalidurl', 'verify_isvalidcreditcardnumber', 'verify_isvalidukpostcode', 'published', 'allowsetbyget', 'allowbyemail', 'filter_a2z', 'filter_StripTags', 'filter_StringTrim', 'filter_Alnum', 'filter_Digits', 'required', 'verify_isemailaddress', 'verify_isblank', 'verify_isnotblank', 'verify_isipaddress', 'verify_isvalidukninumber', 'verify_isvalidssn', 'verify_isvaliduszip' );
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

		if ($this->_config ['published'] == '0') {
			return;
		}

		if (@$this->_config ['option1'] == '1') {
			$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
			if ($registry->getValue ( 'plugins.textarea.option1', 0 ) == '0') {
				bfDocument::addscript ( bfCompat::getLiveSite () . '/plugins/system/blueflame/libs/jquery/jquery.textarearesizer.compressed.js' );
				$registry->setValue ( 'plugins.textarea.option1', 1 );
			}

			$script = "";

			$css = "
			div.grippie {
				background: url(" . bfCompat::getLiveSite () . "/plugins/system/blueflame/view/images/grippie.png) no-repeat scroll center 2px;
				border-color:#DDDDDD;
				border-style:solid;
				border-width:0pt 1px 1px;
				cursor:s-resize;
				height:9px;
				overflow:hidden;
			}
			.resizable-textarea textarea {
				display:block;
				margin-bottom:0pt;
				width:95%;
				height: 20%;
			}
			";
			bfDocument::addCssFromString ( $css );

			bfDocument::addScriptFromString ( "
			jQuery(document).ready(function() {
			jQuery('textarea#" . $this->_config ['slug'] . "').TextAreaResizer();
			 }
			  );
			  " );
		}

		/**
		 * Disable Auto grow as IE8 incompatibility
		 */
		/*
		if (@$this->_config ['option2'] == '1') {
			$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
			if ($registry->getValue ( 'plugins.textarea.option2', 0 ) == '0') {
				bfDocument::addscript ( bfCompat::getLiveSite () . '/plugins/system/blueflame/libs/jquery/jquery.autogrow.js' );
				$registry->setValue ( 'plugins.textarea.option2', 1 );
			}
			bfDocument::addScriptFromString ( "
			jQuery(document).ready(function() {
			jQuery('textarea#" . $this->_config ['slug'] . "').autogrow();
			 }
			  );
			  " );
		}
		*/

		$value = '';

		/* override */
		$this->_attributes ['id'] = $this->_config ['slug'];
		$this->_attributes ['name'] = $this->_config ['slug'];

		/* allowsetbyget overide */
		$val = bfRequest::getVar ( $this->_config ['slug'], null, 'GET' );
		if ($val && $this->_config ['allowsetbyget'] == '1') {
			$this->_attributes ['value'] = $this->runFilters ( $val );
		}

		if (! isset ( $this->_attributes ['value'] ) && isset ( $this->_config ['value'] )) {
			$value = $this->_config ['value'];
		} else {
			if (isset ( $this->_attributes ['value'] ))
				$value = $this->_attributes ['value'];
		}
		unset ( $this->_attributes ['value'] );
		unset ( $this->_attributes ['type'] );
		unset ( $this->_attributes ['option1'] );
		unset ( $this->_attributes ['option2'] );

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

		$html = sprintf ( $this->_barehtml, $attributesSpacedHTML, $value );

//		if ($this->_config ['required'] == '1') {
//			$html = $html . '<span class="required">*</span>';
//		}

		return $html;
	}
	
	public function postProcess() {
		$str = $this->getSubmittedValue ();
		$str = stripslashes(stripslashes(stripslashes($str)));
		$this->setSubmittedValue ( $str  );
	}
}