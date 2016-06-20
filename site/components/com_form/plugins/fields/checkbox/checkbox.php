<?php
/**
 * @version $Id: checkbox.php 152 2009-07-21 09:35:08Z  $
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
final class plugins_fields_checkbox extends plugins_fields_base {

	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	public $_pname = 'checkbox';

	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	public $_title = 'checkbox - A Simple Check Box';

	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_attributes = array ('type' => 'text', 'id' => '', 'name' => '', 'maxlength' => '255', 'size' => '30', 'class' => 'inputbox', 'value' => '', 'style' => '', 'onblur' => '', 'multiple' => '' );

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
	public $_creation_defaults = array ('plugin' => 'checkbox', 'value' => "yes|Click for YES\nno|Click For No", 'published' => '1', 'access' => '0', 'allowbyemail' => '1', 'maxlength' => '255', 'size' => '30', 'rows' => '3', 'class' => 'inputbox', 'form_id' => '-1', 'type' => 'checkbox' );

	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	public $_desc = 'Single or multiple checkboxes, horizontal and vertical';

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
		$qs = array ('filter_strtoupper', 'filter_strtolower', 'verify_isvalidvatnumber', 'verify_isexistingusername', 'verify_isnotexistingusername', 'verify_isinteger', 'verify_isvalidurl', 'verify_isvalidcreditcardnumber', 'verify_isvalidukpostcode', 'published', 'allowsetbyget', 'allowbyemail', 'filter_a2z', 'filter_StripTags', 'filter_StringTrim', 'filter_Alnum', 'filter_Digits', 'required', 'verify_isemailaddress', 'verify_isblank', 'verify_isnotblank', 'verify_isipaddress', 'verify_isvalidukninumber', 'verify_isvalidssn', 'verify_isvaliduszip' );
		foreach ( $qs as $q ) {
			$tmp->assign ( strtoupper ( $q ), bfHTML::yesnoRadioList ( $q, '', $this->_config [$q] ) );
		}

		$OPTIONS = array (bfHTML::makeOption ( '0', 'Public' ), bfHTML::makeOption ( '1', 'Registered' ), bfHTML::makeOption ( '2', 'Special' ) );

		$access = bfHTML::selectList2 ( $OPTIONS, 'access', '', 'value', 'text', $this->_config ['access'] );
		$tmp->assign ( 'ACCESS', $access );

		$OPTIONS = array (bfHTML::makeOption ( '0', 'Vertical' ), bfHTML::makeOption ( '1', 'Horizontal' ) );

		$layoutoption = bfHTML::selectList2 ( $OPTIONS, 'layoutoption', '', 'value', 'text', $this->_config ['layoutoption'] );
		$tmp->assign ( 'LAYOUTOPTION', $layoutoption );

		$tmp->display ( dirname ( __FILE__ ) . DS . 'editView.tpl' );
	}

	/**
	 * I return a form element
	 *
	 * @return string
	 */
	public function toString() {
		$html = '';

		if ($this->_config ['layoutoption'] == '1') {
			$htmlArr = array ('<br /><span class="bf_layout_checkbox_horizontal">' );
		} else {
			$htmlArr = array ('<br /><fieldset>' );
		}
		if ($this->_config ['published'] == '0') {
			return;
		}

		$values = explode ( "\n", trim ( $this->_config ['value'] ) );
		$i = 0;
		$perrowsofar = 1;
		foreach ( $values as $value ) {
			$value = explode ( '|', $value );
			$this->_attributes ['value'] = $value [0];
			/* override */
			$this->_attributes ['id'] = $this->_config ['slug'] . $i;
			$this->_attributes ['name'] = $this->_config ['slug'] . '[]';

			/* allowsetbyget overide */
			$val = bfRequest::getVar ( $this->_config ['slug'], null, 'GET' );
			if ($val && $this->_config ['allowsetbyget'] == '1') {
				$this->_attributes ['value'] = $this->runFilters ( $val );
			}

			$attributesHTML = array ();

			foreach ( $this->_attributes as $k => $v ) {
				if ($k == 'multiple')
					continue;
				if ($v == "" && $this->_showBlankAttributes === true) {
					$attributesHTML [$k] = strtolower ( $k ) . '="' . $v . '"';
				} else if ($v != "") {

					$attributesHTML [$k] = strtolower ( $k ) . '="' . $v . '"';
				}
			}

			/* check by default */
			if ($this->_attributes ['multiple']) {
				$checked = explode ( ',', strtolower ( $this->_attributes ['multiple'] ) );
				$checked = array_map('trim',$checked);
				
				if (in_array ( strtolower ( $this->_attributes ['value'] ), $checked)) {
					$attributesHTML ['checked'] = strtolower ( 'checked' ) . '="checked"';
				}
			}

			ksort ( $attributesHTML );

			$attributesSpacedHTML = implode ( ' ', $attributesHTML );

			$htmlArr [] = '<label class="bf_layout_checkbox">' . sprintf ( $this->_barehtml, $attributesSpacedHTML ) . (@$value [1] ? $value [1] : $value [0]) . '</label>';
			if ($this->_config ['layoutoption'] == '1') {
				if ($perrowsofar == $this->_config ['rows']) {
					$htmlArr [] = '<span class="bf_layout_checkbox_newline">&nbsp;</span>';
					$perrowsofar = 0;
				}
			}
			$i ++;
			$perrowsofar ++;
		}

		if ($this->_config ['layoutoption'] == '1') {
			$htmlArr [] = '</span>';
		} else {
			$htmlArr [] = '</fieldset>';
		}

		return implode ( '', $htmlArr );
	}

	/**
	 * postProcess gets triggered after all filters and validations are done
	 */
	public function postProcess() {
		$str = $this->getSubmittedValue ();
		//		print_R($_POST);
		if (is_array ( $str ))
			$str = implode ( ', ', $this->getSubmittedValue () );
		$this->setSubmittedValue ( $str ? $str : 'Nothing Selected' );
	}
}
?>