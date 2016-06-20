<?php
/**
 * @version $Id: table.php 147 2009-07-14 20:20:18Z  $
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

class plugins_layouts_table extends PluginLayoutBase {

	/**
	 * The plugin name
	 *
	 * @var string
	 */
	var $_pname = 'table';

	/**
	 * PHP4 Constructor
	 *
	 */
	function plugins_layouts_table() {

		$this->__construct ();
	}

	/**
	 * PHP5 Constructor
	 *
	 */
	function __construct() {

		parent::__construct ();
	}

	function onGetFormFields() {

		$this->_paint ();
	}

	function debug($str) {

		if ($this->_debug === true)
			echo $str;
	}

	function _setHeadData() {

		/* add defaults */
		parent::_setHeadData ();

		/* set meta data */
		bfCompat::addCSS ( bfcompat::getLiveSite () . '/components/com_form/plugins/layouts/table/' . $this->_pname . '.css' );
	}

	/**
	 * The main drawing class - called to paint the form
	 *
	 */
	function onRenderForm() {

		$tmp = $this->getSmartyTemplate ();
		$tmp = $this->_onRenderForm ( $tmp );

		/* get the form fields array */
		$fields = $this->_onGetFormFieldsArray ();

		/* and let smarty deal with the layout */
		$tmp->assign ( 'fields', $fields );

		/* output to browser */
		$tmp->display ( $this->_pname . '.tpl', false );
	}
}
?>