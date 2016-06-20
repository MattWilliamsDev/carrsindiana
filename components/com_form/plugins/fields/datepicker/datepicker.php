<?php
/**
 * @version $Id: datepicker.php 184 2010-01-03 20:44:13Z  $
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
final class plugins_fields_datepicker extends plugins_fields_base {

	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	public $_pname = 'datepicker';

	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	public $_title = 'datepicker - A configurable date picker';

	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_attributes = array ('type' => 'text', 'id' => '', 'params' => '', 'cssfile' => '', 'lang' => '', 'name' => '', 'maxlength' => '255', 'size' => '30', 'class' => 'inputbox', 'value' => '%m/%d/%Y %I:%M %p', 'style' => '', 'onblur' => '' );

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
	public $_creation_defaults = array ('plugin' => 'datepicker', 'params' => '1', 'lang' => 'calendar-en.js', 'cssfile' => 'calendar-system.css', 'value' => '%m/%d/%Y %I:%M %p', 'published' => '1', 'access' => '0', 'allowbyemail' => '1', 'maxlength' => '255', 'size' => '30', 'class' => 'inputbox', 'form_id' => '-1', 'type' => 'text' );

	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	public $_desc = '';

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
		$qs = array ('verify_brazil_cpf', 'verify_brazil_cnpj', 'filter_strtoupper', 'filter_strtolower', 'verify_isvalidvatnumber', 'verify_isexistingusername', 'verify_isnotexistingusername', 'verify_isinteger', 'verify_isvalidurl', 'verify_isvalidcreditcardnumber', 'verify_isvalidukpostcode', 'published', 'allowsetbyget', 'allowbyemail', 'filter_a2z', 'filter_StripTags', 'filter_StringTrim', 'filter_Alnum', 'filter_Digits', 'required', 'verify_isemailaddress', 'verify_isblank', 'verify_isnotblank', 'verify_isipaddress', 'verify_isvalidukninumber', 'verify_isvalidssn', 'verify_isvaliduszip' );
		foreach ( $qs as $q ) {
			$tmp->assign ( strtoupper ( $q ), bfHTML::yesnoRadioList ( $q, '', $this->_config [$q] ) );
		}

		$OPTIONS = array (bfHTML::makeOption ( '0', 'Public' ), bfHTML::makeOption ( '1', 'Registered' ), bfHTML::makeOption ( '2', 'Special' ) );

		$access = bfHTML::selectList2 ( $OPTIONS, 'access', '', 'value', 'text', $this->_config ['access'] );
		$tmp->assign ( 'ACCESS', $access );

		$params = bfHTML::yesnoRadioList ( 'params', '', $this->_config ['params'] );
		$tmp->assign ( 'PARAMS', $params );

		$OPTIONS = array ();
		$dir = new DirectoryIterator ( bfcompat::getAbsolutePath () . '/components/com_form/plugins/fields/datepicker/jscalendar-1.0/lang' );
		foreach ( $dir as $file ) {
			if ($file->isDot ())
				continue;
				// Do something with $file
			$OPTIONS [] = bfHTML::makeOption ( $file->getFilename (), $file->getFilename () );
		}

		$LANG = bfHTML::selectList2 ( $OPTIONS, 'lang', '', 'value', 'text', $this->_config ['lang'] );
		$tmp->assign ( 'LANG', $LANG );

		$OPTIONS = array (bfHTML::makeOption ( 'calendar-blue.css', 'calendar-blue.css' ), bfHTML::makeOption ( 'calendar-blue2.css', 'calendar-blue2.css' ), bfHTML::makeOption ( 'calendar-brown.css', 'calendar-brown.css' ), bfHTML::makeOption ( 'calendar-green.css', 'calendar-green.css' ), bfHTML::makeOption ( 'calendar-system.css', 'calendar-system.css' ), bfHTML::makeOption ( 'calendar-tas.css', 'calendar-tas.css' ), bfHTML::makeOption ( 'calendar-win2k-1.css', 'calendar-win2k-1.css' ), bfHTML::makeOption ( 'calendar-win2k-2.css', 'calendar-win2k-2.css' ), bfHTML::makeOption ( 'calendar-win2k-cold-1.css', 'calendar-win2k-cold-1.css' ), bfHTML::makeOption ( 'calendar-win2k-cold-2.css', 'calendar-win2k-cold-2.css' ) );

		$CSSFILE = bfHTML::selectList2 ( $OPTIONS, 'cssfile', '', 'value', 'text', $this->_config ['cssfile'] );
		$tmp->assign ( 'CSSFILE', $CSSFILE );

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

		$this->_addJSToHead ();

		/* allowsetbyget overide */
		$val = bfRequest::getVar ( $this->_config ['slug'], null, 'GET' );
		if ($val && $this->_config ['allowsetbyget'] == '1') {
			$this->_attributes ['value'] = $this->runFilters ( $val );
		}

		if (preg_match ( '/%/', $this->_attributes ['value'] ))
			$this->_attributes ['value'] = '';

		unset ( $this->_attributes ['cssfile'] );
		unset ( $this->_attributes ['params'] );
		unset ( $this->_attributes ['lang'] );

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

		/* The selector */
		$html .= '<button id="bf_trigger_' . $this->_attributes ['name'] . '" type="reset" class="bf_button">...</button>';

		if ($this->_config ['required'] == '1') {
//			$html .= '<span class="required">*</span>';
		}

		return $html;
	}

	private function _addJSToHead() {
		$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
		if ($registry->getValue ( 'plugin.datepicker.css', 0 ) == 0) {
			$registry->setValue ( 'plugin.datepicker.css', 1 );
			$root = bfcompat::getLiveSite () . '/components/com_form/plugins/fields/datepicker/jscalendar-1.0/';
			$scripts = ' <!-- calendar stylesheet -->
			  <link rel="stylesheet" type="text/css" media="all" href="' . $root . $this->_attributes ['cssfile'] . '" title="' . $this->_attributes ['cssfile'] . '" />

			  <!-- main calendar program -->
			  <script type="text/javascript" src="' . $root . 'calendar.js"></script>

			  <!-- language for the calendar -->
			  <script type="text/javascript" src="' . $root . 'lang/' . $this->_attributes ['lang'] . '"></script>

			  <!-- the following script defines the Calendar.setup helper function, which makes
			       adding a calendar a matter of 1 or 2 lines of code. -->
			  <script type="text/javascript" src="' . $root . 'calendar-setup.js"></script>
					';

			bfDocument::addCustomHeadTag ( $scripts );
		}
		$js = 'jQuery(document).ready(function(){Calendar.setup({
				 inputField : "' . $this->_attributes ['name'] . '", // id of the input field
 				 ifFormat : "' . $this->_attributes ['value'] . '", // format of the input field
 				 showsTime : ' . ($this->_attributes ['params'] ? 'true' : 'false') . ', // will display a time selector
 				 button : "bf_trigger_' . $this->_attributes ['name'] . '", // trigger for the calendar (button ID)
 				 singleClick : false, // double-click mode
 				 step : 1, // show all years in drop-down boxes (instead of every other year as default)
 				 timeFormat : "12"
 				})
 				});';

		bfDocument::addjs ( $js );

	}

	/**
	 * postProcess gets triggered after all filters and validations are done
	 *
	 */
	public function postProcess() {
		//		$this->setSubmittedValue(strtoupper($this->getSubmittedValue()));
	}
}
?>