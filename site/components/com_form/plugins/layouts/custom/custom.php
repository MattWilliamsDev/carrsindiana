<?php
/**
 * @version $Id: custom.php 184 2010-01-03 20:44:13Z  $
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

final class plugins_layouts_custom extends PluginLayoutBase {

	/**
	 * The plugin name
	 *
	 * @var string
	 */
	private $_pname = 'custom';

	public function __construct() {

		parent::__construct ();
	}

	public function onGetFormFields() {

		$this->_paint ();
	}

	public function _setHeadData() {

		/* add defaults */
		parent::_setHeadData ();

		/* set meta data */
		bfCompat::addCSS ( bfcompat::getLiveSite () . '/components/com_form/plugins/layouts/custom/custom.css' );
	}

	/**
	 * The main drawing class - called to paint the form
	 *
	 */
	public function onRenderForm() {

		//		/* get smarty prefilled object */
		$tmp = $this->getSmartyTemplate ();

		$tmp = $this->_onRenderForm ( $tmp );
		$ok = file_put_contents ( bfcompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'layouts' . DS . 'custom' . DS . 'custom_' . $this->_FORM_CONFIG ['id'] . '.tpl', $this->_FORM_CONFIG ['custom_smarty'] );

		/* get the form fields array */
		$fields = $this->_onGetFormFieldsArray ();

		$hiddenFields = array ();
		$visfields = array ();
		foreach ( $fields as $field ) {
			$tmp->assign ( strtoupper ( '' . $field ['slug'] . '_element' ), $field ['element'] );
			$tmp->assign ( strtoupper ( '' . $field ['slug'] . '_desc' ), $field ['desc'] );
			$tmp->assign ( strtoupper ( '' . $field ['slug'] . '_title' ), $field ['publictitle'] );

			if (preg_match ( '/type="hidden"/i', $field ['element'] )) {
				$hiddenFields [] = $field;
			} else {
				$visfields [] = $field;
			}
		}

		$session = bfSession::getInstance('com_form');
		$tmp->assign ( 'FORM_SPAM_HIDDEN_FIELD', $session->get ( '_bf_spamField_' . $this->_FORM_CONFIG ['id'] ) );
		
		/* and let smarty deal with the layout */
		$tmp->assign ( 'fields', $visfields );
		$tmp->assign ( 'hiddenfields', $hiddenFields );

		$tmp->assign ( 'SHOW_SUBMIT_BUTTON', 1 );

		if ($this->_FORM_CONFIG ['showsubmitbutton'] == "0" && $this->_FORM_CONFIG ['showpreviewbutton'] == "1")
			$tmp->assign ( 'SHOW_SUBMIT_BUTTON', null );

		if ($this->_FORM_CONFIG ['showpreviewbutton'] == "1")
			$tmp->assign ( 'SHOW_PREVIEW_BUTTON', 1 );

		/* output to browser */
		$tmp->display ( 'custom_header.tpl', false );
		$tmp->display ( 'custom_' . $this->_FORM_CONFIG ['id'] . '.tpl', false );
		$tmp->display ( 'custom_footer.tpl', false );
	}
}
?>