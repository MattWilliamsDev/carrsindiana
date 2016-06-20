<?php
/**
 * @version $Id: _baseClass.php 191 2010-01-10 20:35:02Z  $
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

class PluginLayoutBase {
	
	/**
	 * The current forms configuration Array
	 *
	 * @var array
	 */
	public $_FORM_CONFIG = array ();
	
	/**
	 * The current fields configuration Array
	 *
	 * @var array
	 */
	public $_FIELDS_CONFIG = array ();
	
	/**
	 * PHP5 Constructor
	 *
	 */
	public function __construct() {
	
	}
	
	/**
	 * I set the configuration into the object
	 *
	 * @param array $configArr
	 */
	public function onSetConfiguration($configArr) {
		
		$this->_FIELDS_CONFIG = $configArr ['fields'];
		unset ( $configArr ['fields'] );
		$this->_FORM_CONFIG = $configArr;
	
	}
	
	/** I get called by children to set defaults */
	function _onRenderForm($tmp) {
		
		/* Show Page title */
		if ($this->_FORM_CONFIG ['showtitle'] == 1) {
			$tmp->assign ( 'SHOW_PAGE_TITLE', TRUE );
		}
		
		/* Show Reset Button */
		if ($this->_FORM_CONFIG ['showresetbutton'] == 1) {
			$tmp->assign ( 'SHOW_RESET_BUTTON', TRUE );
		}
		
		$tmp->assign ( 'RESETBUTTONTEXT', $this->_FORM_CONFIG ['resetbuttontext'] );
		$tmp->assign ( 'SUBMITBUTTONTEXT', $this->_FORM_CONFIG ['submitbuttontext'] );
		
		return $tmp;
	}
	
	/**
	 * I set up the <form> tag and it attributes
	 *
	 * @param bool $output
	 * @return string The <form> tag
	 */
	function onGetFormHead($output = false) {
		
		$html = '<div id="bf_previewform_div_' . $this->_FORM_CONFIG ['id'] . '"></div>';
		//$html .= '<div id="bf_pleasewait_preview"><h2>' . bfText::_ ( 'Please wait a moment, while we validate your submission...' ) . '</h2><br/><img src="' . bfCompat::getLiveSite () . '/' . bfCompat::mambotsfoldername () . '/system/blueflame/view/images/check_throbber.gif" alt="throbber" /></div>';
		//$html .= '<div id="bf_pleasewait_submit"><h2>' . bfText::_ ( 'Please wait a moment, while we validate &amp; submit your submission...' ) . '</h2><br/><img src="' . bfCompat::getLiveSite () . '/' . bfCompat::mambotsfoldername () . '/system/blueflame/view/images/check_throbber.gif" alt="throbber" /></div>';
		$html .= "\n\n" . '<form %s>';
		
		$JMenu = JMenu::getInstance ( 'site' );
		$activeMenu = $JMenu->getActive ();
		$activeMenu === null ? $Itemid = 1 : $Itemid = $activeMenu->id;
		
		$attributes = array ();
		$attributes ['method'] = 'method="' . strtolower ( $this->_FORM_CONFIG ['method'] ) . '"';
		$attributes ['action'] = 'action="' . ($this->_FORM_CONFIG ['processorurl'] ? $this->_FORM_CONFIG ['processorurl'] : bfCompat::getLiveSite () . '/index.php?Itemid=' . ($Itemid ? $Itemid : '1')) . '"';
		$attributes ['name'] = 'name="' . 'BF_FORM_' . $this->_FORM_CONFIG ['id'] . '"';
		$attributes ['id'] = 'id="' . 'BF_FORM_' . $this->_FORM_CONFIG ['id'] . '"';
		$attributes ['enctype'] = 'enctype="' . $this->_FORM_CONFIG ['enctype'] . '"';
		$attributes ['class'] = ' class="bfform ' . $this->_FORM_CONFIG ['layout'] . 'form"';
		$attributes ['target'] = ' target="' . ($this->_FORM_CONFIG ['target'] ? $this->_FORM_CONFIG ['target'] : '_self') . '"';
		
		ksort ( $attributes );
		
		$attributes = implode ( ' ', $attributes );
		
		$html = sprintf ( $html, $attributes );
		
		switch ($output) {
			case true :
				echo $html;
				break;
			case false :
				return $html;
				break;
		}
		return true;
	}
	
	/**
	 * I create a smarty array of form elements
	 *
	 * @return array
	 */
	function _onGetFormFieldsArray() {
		
		/* Are we resuming a paused submission ??? */
		$form_id = ( int ) bfRequest::getVar ( 'form_id' );
		$submission_id = ( int ) bfRequest::getVar ( 'submission_id' );
		$user = bfUser::getInstance ();
		if ($form_id && $submission_id && $user->get ( 'id' ) > 0) {
			
			/* get submission */
			$path = _BF_JPATH_BASE . DS . 'components' . DS . 'com_form' . DS . 'model' . DS . 'submission.php';
			require_once ($path);
			$submission = new Submission ( );
			$submission->setTableName ( $form_id );
			$submission->get ( $submission_id );
			
			/* check its mine and paused */
			if ($submission->bf_status != 'Paused' || $submission->bf_user_id != $user->get ( 'id' )) {
				unset ( $submission );
			}
		
		}
		
		$rows = array ();
		
		if (count ( $this->_FIELDS_CONFIG )) {
			foreach ( $this->_FIELDS_CONFIG as $field ) {
				$fieldname = 'FIELD_' . $field->id;
				
				$vars = array ();
				foreach ( $field as $k => $v ) {
					$vars [$k] = $v;
				}
				
				/* if unpausing a submission then */
				if (isset ( $submission ) && @$submission->$fieldname != '') {
					
					switch ($field->type) {
						
						case "checkbox" :
						case "radio" :
							$field->multiple = $submission->$fieldname;
							break;
						/**
						 * Tested and Works for: 
						 * textbox 
						 * textarea
						 * select
						 * password
						 */
						default :
							$field->value = $submission->$fieldname;
							break;
					}
				}
				/* Done unpausing */
				
				Plugins_Fields::loadPlugin ( $field->plugin );
				
				switch ($field->plugin) {
					case "text" :
						$field->plugin = 'textbox';
						break;
					
					case "file" :
						$field->plugin = 'fileupload';
						break;
					
					case "UNKNOWN" :
						return;
						break;
				}
				
				$plugin = 'plugins_fields_' . $field->plugin;
				$fieldObj = new $plugin ( );
				$fieldObj->setConfig ( $field );
				
				$vars ['element'] = $fieldObj->toString ();
				$vars ['label'] = '';
				
				$rows [] = $vars;
			}
		}
		
		return $rows;
	
	}
	
	private function _getItemIdElement() {
		$Itemid = ( int ) bfRequest::getVar ( 'Itemid' );
		return "\n\t" . '<input type="hidden" name="Itemid" value="' . ($Itemid ? $Itemid : '1') . '" />' . "\n";
	}
	
	/**
	 * I set up the <form> tag and it attributes
	 *
	 * @param bool $output
	 * @return string The <form> tag
	 */
	function onGetFormFooter($output = false) {
		$html = '';
		$html .= $this->_getFormSpamControls ();
		$html .= $this->_getItemIdElement ();
		$html .= '<input type="hidden" name="bf_preview_' . $this->_FORM_CONFIG ['id'] . '" id="bf_preview_' . $this->_FORM_CONFIG ['id'] . '" value="0" />';
		
		$tmpl = bfRequest::getVar ( 'tmpl' );
		if (_BF_PLATFORM == 'JOOMLA1.5' && $tmpl == 'component') {
			$html .= '<input type="hidden" name="tmpl" id="tmpl" value="component" />';
		}
		$html .= "\n\n" . '</form>';
		
		switch ($output) {
			case true :
				echo $html;
				break;
			case false :
				return $html;
				break;
		}
		return true;
	}
	
	private function _getFormSpamControls() {
		$html = '';
		
		$attributes = array ();
		$attributes ['bf_z'] = base64_encode ( md5 ( $this->_FORM_CONFIG ['id'] ) );
		$attributes ['option'] = 'com_form';
		$attributes ['token'] = rand ( _BF_TOKEN_MIN, _BF_TOKEN_MAX );
		$attributes ['spam'] = rand ( _BF_SPAM_MIN, _BF_SPAM_MAX );
		$attributes ['bf_s'] = md5 ( base64_encode ( md5 ( bfcompat::getSecret () ) ) );
		
		$attributes [bfCompat::getToken ()] = '1';
		
		/* Pausable submissions: Is this a paused submission? If so set the submission_id as sid */
		$attributes ['sid'] = bfRequest::getVar ( 'submission_id', null, 'GET', 'int' );
		
		ksort ( $attributes );
		
		foreach ( $attributes as $k => $v ) {
			$html .= "\n\t" . '<input type="hidden" name="' . $k . '" value="' . $v . '" />' . "\n";
		}
		
		return $html;
	}
	
	function _setHeadData() {
		$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
		
		if ($registry->getValue ( 'entrypoint' ) == 'form') {
			/* set meta data */
			bfDocument::setTitle ( $this->_FORM_CONFIG ['page_title'] ? $this->_FORM_CONFIG ['page_title'] : 'Forms' );
			bfCompat::setMeta ( 'description', $this->_FORM_CONFIG ['page_title'] ? $this->_FORM_CONFIG ['page_title'] : 'Forms' );
			bfCompat::setMeta ( 'keywords', $this->_FORM_CONFIG ['page_title'] ? $this->_FORM_CONFIG ['page_title'] : 'Forms' );
			bfCompat::setMeta ( 'title', $this->_FORM_CONFIG ['page_title'] ? $this->_FORM_CONFIG ['page_title'] : 'Forms' );
		}
		/* set meta data */
		bfCompat::addCSS ( bfcompat::getLiveSite () . '/components/com_form/plugins/layouts/_baseCSS.css' );
		
		if ($this->_FORM_CONFIG ['custom_css']) {
			$hash = md5 ( $this->_FORM_CONFIG ['custom_css'] );
			if (! defined ( 'BF_' . $hash )) {
				$doc = JFactory::getDocument ();
				$doc->addStyleDeclaration ( $this->_FORM_CONFIG ['custom_css'] );
				define ( 'BF_' . $hash, 1 );
			}
		}
		
		if ($this->_FORM_CONFIG ['custom_js']) {
			$hash = md5 ( $this->_FORM_CONFIG ['custom_js'] );
			
			if (! defined ( 'BF_' . $hash )) {
				bfDocument::addScriptFromString($this->_FORM_CONFIG ['custom_js']);
				define ( 'BF_' . $hash, 1 );
			}
		}
		
		/**
		 * Enable ixedit debug screen for creating excellent jQuery effects
		 * @see http://www.ixedit.com/
		 * @see http://blog.phil-taylor.com/2009/11/22/how-to-make-form-fields-hide-and-show-with-no-coding/
		 */
		if ($this->_FORM_CONFIG ['enableixedit'] == '1') {
			bfDocument::addscript ( bfcompat::getLiveSite () . '/plugins/system/blueflame/libs/ixedit/jquery-plus-jquery-ui.js' );
			bfDocument::addscript ( bfcompat::getLiveSite () . '/plugins/system/blueflame/libs/ixedit/ixedit.packed.js' );
			bfDocument::addCSS ( bfcompat::getLiveSite () . '/plugins/system/blueflame/libs/ixedit/ixedit.css' );
		}
		
		/**
		 * Enable a wizard type multipage form layout using Janko solution 
		 * @see http://www.jankoatwarpspeed.com/examples/webform_to_wizard/#
		 * @see http://www.jankoatwarpspeed.com/post/2009/09/28/webform-wizard-jquery.aspx
		 */
		if ($this->_FORM_CONFIG ['enablejankomultipage'] == '1') {
			bfDocument::addscript ( bfcompat::getLiveSite () . '/plugins/system/blueflame/libs/jquery/jquery.wizardform.js' );
			bfDocument::addCSS ( bfcompat::getLiveSite () . '/plugins/system/blueflame/libs/jquery/jquery.wizardform.css' );
			bfDocument::addScriptFromString('jQuery(document).ready(function(){jQuery("#BF_FORM_' . $this->_FORM_CONFIG ['id'] . '").formToWizard({ submitButton: jQuery(\'#BF_FORM_' . $this->_FORM_CONFIG ['id'] . ' > input[type="submit"]\').attr(\'id\') });});</script>');
		}
	}
	
	/**
	 * I set up smarty. prefill with standard vars and then pass my object back
	 *
	 */
	function getSmartyTemplate() {
		
		/* Call in Smarty to display template */
		bfLoad ( 'bfSmarty' );
		
		/* @var $tmp bfSmarty */
		$tmp = bfSmarty::getInstance ( 'com_form' );
		$tmp->_setTemplatePath ( dirname ( __FILE__ ) . DS . strtolower ( $this->_FORM_CONFIG ['layout'] ) );
		
		/* set the head data into the Joomla JDocument or J1.0.x equivilent */
		$this->_setHeadData ();
		
		/* set form title H1 */
		if ($this->_FORM_CONFIG ['page_title'])
			$tmp->assign ( 'PAGE_TITLE', $this->_FORM_CONFIG ['page_title'] );
			
		/* get the Form tag and add to template as {FORM_OPENTAG}*/
		$tmp->assign ( 'FORM_OPEN_TAG', $this->onGetFormHead () );
		$tmp->assign ( 'FORM_CLOSE_TAG', $this->onGetFormFooter () );
		$tmp->assign ( 'FORM_ID', $this->_FORM_CONFIG ['id'] );
		
		/* failed validation */
		if (@defined ( '_BF_FAILED_VALIDATION' )) {
			$tmp->assign ( 'FAIL_VALIDATION', true );
			$messages = unserialize ( _BF_FAILED_VALIDATION_MESSAGES );
			$tmp->assign ( 'fail_messages', $messages );
		
		}
		
		if (isset ( $this->_FORM_CONFIG ['onlyssl'] ) && $this->_FORM_CONFIG ['onlyssl'] == 1) {
			$tmp->assign ( 'SECURE_FORM', '1' );
		}
		return $tmp;
	}
}
?>