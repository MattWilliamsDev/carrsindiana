<?php
/**
 * @version $Id: admin.php 184 2010-01-03 20:44:13Z  $
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

final class com_formController extends bfController {
	
	public function __construct() {
		
		parent::__construct ();
	}
	
	private function _getFormId() {
		
		return ( int ) $this->session->get ( 'lastFormId', '', 'default' );
	}
	
	public function xhelp() {
		$this->setView ( 'help' );
	}
	
	public function xwelcome() {
		
		$form_id = $this->_getFormId ();
		if ($form_id) {
			
			/* Load Model */
			$forms = $this->getModel ( 'form' );
			
			/* Get all rows */
			$forms->get ( ( int ) $form_id );
			
			/* set the view file (optional) */
			$this->setView ( 'quickstart' );
			$this->xajax->script ( "jQuery('#showjoomla').append('&nbsp;&nbsp;&nbsp;<a target=\"_blank\" href=\"../index.php?option=com_form&form_id=" . ( int ) $form_id . "\"><img src=\"../" . bfCompat::mambotsfoldername () . "/system/blueflame/view/images/bullet-preview.gif\" align=\"absmiddle\" />&nbsp;" . bfText::_ ( 'Preview Form' ) . "</a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:bfFramework.menuClick(\'Loading...\',\'xforms\');\"><img src=\"../" . bfCompat::mambotsfoldername () . "/system/blueflame/view/images/arrow_switch.png\" align=\"absmiddle\" />&nbsp;" . bfText::_ ( 'Choose Another Form' ) . "</a>&nbsp;&nbsp;&nbsp;<img src=\"../" . bfCompat::mambotsfoldername () . "/system/blueflame/view/images/base.gif\" align=\"absmiddle\" />&nbsp;Current Form - " . $forms->form_name . "');" );
		} else {
			/* set the view file (optional) */
			$scripts = array ();
			$file = bfCompat::getAbsolutePath () . DS . 'plugins' . DS . 'content' . DS . 'contentform.php';
			if (! file_exists ( $file )) {
				$msg = 'In order to embed forms into content items or modules you need to install the free addons, use the Addons Menu item on the left to do this...';
				$scripts [] = 'jQuery.jGrowl("' . $msg . '", { theme: \'red\' ,sticky: true });';
			}
			
			if ($this->_registry->getValue ( 'config.enable' ) == '0') {
				$msg = 'This extension is currently disabled, you need to ENABLE it in the Preferences, use the menu item on the left to do this';
				$scripts [] = 'jQuery.jGrowl("' . $msg . '", { theme: \'red\' ,sticky: true });';
			}
			$this->xajax->script ( implode ( '; ', $scripts ) );
			$this->setView ( 'welcome' );
		}
	}
	
	public function xkeepalive() {
		
		$this->log->log ( 'Keeping alive connection through xajax ...' );
		$this->setLayout ( 'none' );
		$html = "setTimeout('bfHandler(\'xkeepalive\');', 60000);";
		$this->xajax->addscript ( $html );
	}
	
	public function xsaveformconfig() {
		
		$args = $this->getAllArguments ();
		
		/* Load Model */
		$forms = $this->getModel ( 'form' );
		
		/* Get all rows */
		$forms->save ( $args );
		
		if (defined ( '_BF_APPLY' )) {
			$this->_redirect ( 'xformconfiguration' );
		} else {
			$this->_redirect ( 'xoverview' );
		}
	}
	
	public function xsaveformlayout() {
		
		$args = $this->getAllArguments ();
		
		/* Load Model */
		$forms = $this->getModel ( 'form' );
		
		/* Get all rows */
		$forms->save ( $args );
		
		if (defined ( '_BF_APPLY' )) {
			$this->_redirect ( 'xformlayouts' );
		} else {
			$this->_redirect ( 'xoverview' );
		}
	}
	
	public function xsetupfields() {
		
		$form_id = $this->_getFormId ();
		
		/* Load Model */
		$forms = $this->getModel ( 'form' );
		
		/* Get all rows */
		$forms->get ( ( int ) $form_id );
	}
	
	/**
	 * I display the list of currently configured fields
	 *1
	 */
	public function xfields() {
		
		/* Load Model */
		$fields = $this->getModel ( 'field' );
		
		/* Get all rows */
		$fields->getAll ( 'form_id = "' . $this->_getFormId () . '"' );
		
		if (! count ( $fields->rows )) {
			$this->_redirect ( '_newField' );
			return;
		}
		/* set the view file (optional) */
		$this->setView ( 'fields' );
		
		/* set last view into session */
		$this->session->returnto ( $this->getView () );
	}
	
	/**
	 * I display the list of uploaded files
	 *1
	 */
	public function xuploadedfiles() {
		
		/* Load Model */
		$files = $this->getModel ( 'file' );
		
		/* Get all rows */
		$files->getAll ( $this->_getFormId () );
		
		/* set the view file (optional) */
		$this->setView ( 'uploadedfiles' );
		
		/* set last view into session */
		$this->session->returnto ( $this->getView () );
	}
	
	/**
	 * I display the list of submissions
	 *1
	 */
	public function xsubmissions() {
		
		/* Load Model */
		$submissions = $this->getModel ( 'submission' );
		
		$submissions->setTableName ( $this->_getFormId () );
		
		/* Get all rows */
		$submissions->getAll ();
		
		/* set the view file (optional) */
		$this->setView ( 'submissions' );
		
		/* set last view into session */
		$this->session->returnto ( $this->getView () );
	}
	
	/**
	 * I display the list of currently configured actions
	 *1
	 */
	public function xactions() {
		
		/* Load Model */
		$actions = $this->getModel ( 'action' );
		
		/* Get all rows */
		$actions->getAll ( 'form_id = "' . $this->_getFormId () . '"' );
		
		if (! count ( $actions->rows )) {
			$this->_redirect ( '_newAction' );
			return;
		}
		/* set the view file (optional) */
		$this->setView ( 'actions' );
		
		/* set last view into session */
		$this->session->returnto ( $this->getView () );
	}
	
	/**
	 * Display index view of layout templates
	 *
	 */
	public function xlayouts() {
		$templates = $this->getModel ( 'layout' );
		$templates->getAll ( 'appliesto = "Global"' );
		/* set last view into session */
		$this->session->returnto ( $this->getView () );
		
		$this->setView ( 'layouts' );
	}
	
	/**
	 * Display index view of layout templates
	 *
	 */
	public function xformlayouts() {
		$forms = $this->getModel ( 'form' );
		$forms->get ( $this->_getFormId () );
		
		$fields = $this->getModel ( 'field', true );
		$fields->getAll ( 'form_id = ' . $this->_getFormId (), FALSE );
		
		$this->setView ( 'edit_formlayout' );
		$this->session->returnto ( 'overview' );
	}
	
	/**
	 * I display the list of currently configured forms
	 *
	 */
	public function xforms() {
		
		/* Load Model */
		$forms = $this->getModel ( 'form' );
		
		/* Get all rows */
		$forms->getAll ();
		
		if (! count ( $forms->rows )) {
			$this->_redirect ( '_newForm' );
			return;
		}
		/* set the view file (optional) */
		$this->setView ( 'forms' );
		
		/* set last view into session */
		$this->session->returnto ( $this->getView () );
	
	}
	
	public function xstats() {
		
		/* Load Model */
		$forms = $this->getModel ( 'form' );
		
		/* Get all rows */
		$forms->get ( $this->_getFormId () );
		
		/* set the view file (optional) */
		$this->setView ( 'stats' );
	
	}
	
	/**
	 * I create a form and redirect to the view for that form
	 */
	public function xadmin_createform() {
		
		$args = $this->getAllArguments ();
		
		/* get the form field title */
		$form_title = $args [1];
		$form_type = @$args [2] ? $args [2] : 'blank';
		
		/* Load Model */
		$form = $this->getModel ( 'form' );
		$this->session->returnto ( 'forms' );
		
		/* create the form */
		$form->createNewForm ( $form_title, $form_type );
		
		$this->loadPluginModel ( 'forms' );
		$plug = Plugins_Forms::getInstance ();
		
		$plug->_pluginList [$form_type]->onAfterCreateForm ( $form );
		
		/* set the view file (optional) */
		$this->_redirect ( 'xforms' );
	
	}
	
	/**
	 * I create a form and redirect to the view for that form field
	 */
	public function xadmin_createfield() {
		
		$args = $this->getAllArguments ();
		
		/* get the form field title */
		$field_title = $args [1];
		$field_type = $args [2];
		
		/* Load Model */
		$field = $this->getModel ( 'field' );
		$this->session->returnto ( 'fields' );
		
		/* create the form */
		$field->createNewField ( $field_title, $field_type );
		
		$this->loadPluginModel ( 'fields' );
		$plug = Plugins_Fields::getInstance ();
		
		/* allow changes to be made by plugin */
		$plug->trigger ( 'onAfterCreateField', $field );
		
		/* allow changes to be made by plugin - extend schema of data table */
		$plug->trigger ( 'onAfterCreateField_ExtendDataTable', $field );
		
		$plug->trigger ( 'onAfterSaveNewField', $field );
		
		$this->setArguments ( array ($field->id ) );
		
		$this->_registry->setValue ( 'usedTabs', 1 );
		/* set the view file (optional) */
		$this->_redirect ( '_editField' );
	}
	
	/**
	 * I create a form and redirect to the view for that form field
	 */
	public function xadmin_createaction() {
		
		$args = $this->getAllArguments ();
		
		/* get the form field title */
		$action_title = $args [1];
		$action_type = $args [2];
		
		/* Load Model */
		$action = $this->getModel ( 'action' );
		$this->session->returnto ( 'actions' );
		
		/* create the form */
		$action->createNewAction ( $action_title, $action_type );
		
		$this->loadPluginModel ( 'actions' );
		$plug = Plugins_Actions::getInstance ();
		
		/* allow changes to be made by plugin */
		$plug->trigger ( 'onAfterCreateAction', $action );
		
		/* allow changes to be made by plugin - extend schema of data table */
		$plug->trigger ( 'onAfterCreateAction_ExtendDataTable', $action );
		
		/* set argument for the edit view */
		$this->setArguments ( array ($action->id ) );
		
		$this->_registry->setValue ( 'usedTabs', 1 );
		
		/* quiet redirect */
		$this->_redirect ( '_editAction' );
	}
	
	public function xadmin_checkfileuploadfolder() {
		
		$folder = $this->getArgument ( 1 );
		if (! file_exists ( $folder )) {
			mkdir ( $folder, 0777 );
		}
		@chmod ( $folder, 0777 );
		if (! is_writable ( $folder )) {
			$s = "jQuery('span#iswritable').html('FOLDER IS NOT WRITEABLE!!!!!!');";
			$this->xajax->script ( $s );
		} else {
			if (! file_exists ( $folder . DS . 'index.php' )) {
				touch ( $folder . DS . 'index.php' );
			}
		}
		
		$this->setLayout ( 'none' );
	
	}
	
	public function xformconfiguration() {
		
		/* Load Model */
		$forms = $this->getModel ( 'form' );
		
		/* Get Form data */
		$forms->get ( $this->_getFormId () );
		
		/* set last view into session */
		$this->session->returnto ( 'overview' );
	
	}
	
	public function xformaccess() {
		
		/* Load Model */
		$forms = $this->getModel ( 'form' );
		
		/* Get Form data */
		$forms->get ( $this->_getFormId () );
		
		/* set last view into session */
		$this->session->returnto ( 'overview' );
	
	}
	
	public function xspamcontrols() {
		
		/* Load Model */
		$forms = $this->getModel ( 'form' );
		
		/* Get Form data */
		$forms->get ( $this->_getFormId () );
		
		$fields = $this->getModel ( 'field', true );
		$fields->getall ( 'form_id = ' . ( int ) $this->_getFormId (), false );
		
		/* set last view into session */
		$this->session->returnto ( 'overview' );
	}
	
	/**
	 * Badly named function, we never edit forms as forms hve a submenu all of their own
	 * This is actually a redirect to the add new form view
	 *
	 */
	public function xadd() {
		$args = $this->getAllArguments ();
		if ($args ['view'] == 'forms') {
			$this->_redirect ( '_newForm' );
		} elseif ($args ['view'] == 'fields') {
			$this->_redirect ( '_newField' );
		} elseif ($args ['view'] == 'actions') {
			$this->_redirect ( '_newAction' );
		} else {
			parent::xadd ();
		}
	}
	
	public function xcopy() {
		$args = $this->getAllArguments ();
		switch ($args ['view']) {
			case 'forms' :
				$this->_redirect ( '_copyForm' );
				break;
			case 'fields' :
				$this->_redirect ( '_copyField' );
				break;
			case 'copy_field' :
				$this->_redirect ( '_copyFieldProcess' );
				break;
			case 'copy_action' :
				$this->_redirect ( '_copyActionProcess' );
				break;
			case 'actions' :
				$this->_redirect ( '_copyAction' );
				break;
			default :
				parent::xadd ();
				break;
		}
	}
	
	public function _copyFieldProcess() {
		$args = $this->getAllArguments ();
		$args ['fields'] = unserialize ( base64_decode ( $args ['fields'] ) );
		$this->loadPluginModel ( 'fields' );
		
		foreach ( $args ['fields'] as $field ) {
			$f = $this->getModel ( 'field' );
			$field = $f->copy ( $field, $args ['form'] );
			
			$plug = Plugins_Fields::getInstance ();
			
			/* allow changes to be made by plugin */
			$plug->trigger ( 'onAfterCopyField', $field, $args ['form'] );
		}
		
		$this->_redirect ( 'xfields' );
	}
	
	public function _copyActionProcess() {
		$args = $this->getAllArguments ();
		$args ['actions'] = unserialize ( base64_decode ( $args ['actions'] ) );
		foreach ( $args ['actions'] as $action ) {
			$this->getModel ( 'action' )->copy ( $action, $args ['form'] );
		}
		$this->_redirect ( 'xactions' );
	}
	
	/**
	 * Badly named function, we never edit forms as forms hve a submenu all of their own
	 * This is actually a redirect to the add new form view
	 *
	 */
	public function xapply() {
		//
		define ( '_BF_APPLY', true );
		
		$args = $this->getAllArguments ();
		if ($args ['view'] == 'formconfiguration') {
			$this->_redirect ( 'xsaveformconfig' );
		} elseif ($args ['view'] == 'fields') {
			parent::xapply ( $args );
		} elseif ($args ['view'] == 'actions') {
			parent::xapply ( $args );
		} elseif ($args ['view'] == 'edit_formlayout') {
			$this->_redirect ( 'xsaveformlayout' );
		} else {
			parent::xapply ( $args );
		}
		$this->registry->setValue ( 'usedTabs', 1 );
	
	}
	
	public function xedit() {
		$args = $this->getAllArguments ();
		
		$view = $this->session->get ( 'returnto', '', 'default' );
		
		if ($view == 'fields') {
			//			$this->viewHasEditor ( 'desc' );
			$this->registry->setValue ( 'usedTabs', 1 );
			/* set last view into session */
			$this->session->returnto ( 'fields' );
			$this->_redirect ( '_editField' );
		
		}
		if ($view == 'forms') {
			$this->xajax->redirect ( 'index2.php?option=com_form&form_id=' . $args ['cid'] [0] );
			return;
		}
		if ($view == 'formlayouts') {
			//			$this->viewHasEditor ( 'desc' );
			$this->registry->setValue ( 'usedTabs', 1 );
			/* set last view into session */
			$this->session->returnto ( 'formlayouts' );
			$this->_redirect ( '_editFormLayout' );
		
		} elseif ($view == 'actions') {
			$this->registry->setValue ( 'usedTabs', 1 );
			$fields = $this->getModel ( 'field', true );
			$fields->getAllWhere ( 'form_id = "' . ( int ) $this->_getFormId () . '"', false );
			
			/* set last view into session */
			$this->session->returnto ( 'actions' );
			$this->_redirect ( '_editAction' );
		} elseif ($view == 'submissions') {
			$fields = $this->getModel ( 'field', true );
			$fields->getAllWhere ( 'form_id = "' . ( int ) $this->_getFormId () . '"', false );
			$sub = $this->getModel ( 'submission' );
			
			/* when edit button used instead of clicking the row */
			if (array_key_exists ( 'cid', $args )) {
				$args [1] = $args ['cid'] [0];
			}
			
			$sub->get ( ( int ) $args [1] );
			
			/* set last view into session */
			$this->session->returnto ( 'submissions' );
			$this->setView ( 'edit_submission' );
		} else {
			parent::xedit ();
		}
	
	}
	
	public function export() {
		$args = $this->getAllArguments ();
		$form_id = ( int ) $args ['form_id'];
		
		switch ($args ['exportType']) {
			case 1 : //backup whole form
				$forms = $this->getModel ( 'form', true );
				$form = $forms->get ( ( int ) $form_id );
				$fields = $this->getModel ( 'field', true );
				$fields->getAllWhere ( 'form_id = "' . ( int ) $form_id . '"', false );
				$actions = $this->getModel ( 'action', true );
				$actions->getAllWhere ( 'form_id = "' . ( int ) $form_id . '"', false );
				
				break;
			case 5 : //backup submissions xml
			case 4 : //backup submissions xml
			case 7 : //backup submissions xml with excel
				$forms = $this->getModel ( 'form', true );
				$form = $forms->get ( ( int ) $form_id );
				$submissions = $this->getModel ( 'submission', true );
				$submission = $submissions->getAll ( '', false );
				$fields = $this->getModel ( 'field', true );
				/* @var $fields bfModel */
				$fields->getAllWhere ( 'form_id = "' . ( int ) $form_id . '"', false, 'ordering asc' );
				break;
		}
	}
	
	public function xexportoptions() {
	
	}
	
	/**
	 * Wrapper method for editing form fields
	 *
	 */
	public function _editField() {
		
		$args = $this->getAllArguments ();
		
		if (array_key_exists ( 'cid', $args )) {
			$field_id = $args ['cid'] [0];
		} else {
			$field_id = @$args [3] ? @$args [3] : $args [1];
		}
		
		$field = $this->getModel ( 'field' );
		$field->get ( ( int ) $field_id );
		
		$this->loadPluginModel ( 'fields' );
		
		$this->setView ( 'edit_field' );
	
	}
	
	public function _editFormLayout() {
		
		$this->setView ( 'edit_formlayout' );
	}
	
	/**
	 * Wrapper method for editing form fields
	 *
	 */
	public function _editAction() {
		
		$args = $this->getAllArguments ();
		
		if (array_key_exists ( 'cid', $args )) {
			$action_id = $args ['cid'] [0];
		} else {
			$action_id = @$args [3] ? @$args [3] : $args [1];
		}
		
		$field = $this->getModel ( 'field' );
		$field->getAllWhere ( 'form_id = "' . ( int ) $this->_getFormId () . '"' );
		
		$action = $this->getModel ( 'action' );
		$action->get ( ( int ) $action_id );
		
		$this->loadPluginModel ( 'actions' );
		
		$this->setView ( 'edit_action' );
	
	}
	
	/**
	 * remove items
	 *
	 */
	public function xremove() {
		
		$args = $this->getAllArguments ();
		
		if ($args ['view'] == 'fields') {
			
			$row = $this->getModel ( 'field' );
			$cids = $args ['cid'];
			/* for each we want to delete */
			if (! is_array ( $cids )) {
				$cids = array ($cids );
			}
			foreach ( $cids as $id ) {
				$row->load ( $id );
				
				$this->loadPluginModel ( 'fields' );
				$plug = Plugins_Fields::getInstance ();
				
				/* allow changes to be made by plugin */
				$plug->trigger ( 'onDeleteField', $row );
			
			}
			parent::xremove ( $args );
		} elseif ($args ['view'] == 'forms') {
			$row = $this->getModel ( 'form' );
			$cids = $args ['cid'];
			/* for each we want to delete */
			if (! is_array ( $cids )) {
				$cids = array ($cids );
			}
			foreach ( $cids as $id ) {
				$row->delete ( $id );
			}
			
			/* display new form options */
			$this->setView ( 'forms' );
		
		} else {
			parent::xremove ( $args );
		}
	}
	
	public function xnewForm() {
		$this->_redirect ( '_newForm' );
	}
	
	public function _newForm() {
		
		/* Load Model */
		$forms = $this->getModel ( 'form' );
		
		/* Get all rows - import to know if this is the first form */
		$forms->getAll ();
		
		$this->loadPluginModel ( 'forms' );
		$plug = Plugins_Forms::getInstance ();
		
		/* display new form options */
		$this->setView ( 'new_form' );
	}
	
	public function _newField() {
		
		/* Load Model */
		$fields = $this->getModel ( 'field' );
		
		/* Get all rows - import to know if this is the first form */
		$fields->getAll ();
		
		$this->loadPluginModel ( 'fields' );
		$plug = Plugins_Fields::getInstance ();
		
		/* display new form options */
		$this->setView ( 'new_field' );
	}
	
	public function _newAction() {
		
		/* Load Model */
		$actions = $this->getModel ( 'action' );
		
		/* Get all rows - import to know if this is the first form */
		$actions->getAll ();
		
		$this->loadPluginModel ( 'actions' );
		$plug = Plugins_Actions::getInstance ();
		
		/* display new form options */
		$this->setView ( 'new_action' );
	}
	
	public function _copyField() {
		$args = $this->getArgument ( 'cid' );
		
		foreach ( $args as $arg ) {
			$fieldModel = $this->getModel ( 'field' );
			$fieldModel->get ( $arg );
			$fieldModel->fieldnames [] = $fieldModel->slug;
		}
		
		$fieldModel->idstocopy = serialize ( $args );
		
		$formsModel = $this->getModel ( 'form' );
		$forms = $formsModel->getAll ( '', FALSE );
		
		$this->setView ( 'copy_field' );
	
	}
	
	public function _copyAction() {
		$args = $this->getArgument ( 'cid' );
		
		foreach ( $args as $arg ) {
			$actionModel = $this->getModel ( 'action' );
			$actionModel->get ( $arg );
			$actionModel->actionnames [] = $actionModel->title;
		}
		
		$actionModel->idstocopy = serialize ( $args );
		
		$formsModel = $this->getModel ( 'form' );
		$forms = $formsModel->getAll ( '', FALSE );
		
		$this->setView ( 'copy_action' );
	
	}
	
	private function _consoleLogArray($str) {
		ob_start ();
		
		print_R ( $str );
		
		$contents = ob_get_contents ();
		ob_end_clean ();
		
		$contents = implode ( ' ', explode ( "\n", $contents ) );
		$this->xajax->script ( 'console.log("' . $contents . '");' );
	}
	public function xoverview() {
		$this->_redirect ( 'xquickstart' );
	}
	
	public function xquickstart() {
	
	}
	
	public function xadmin_validatefieldslug() {
		
		$args = $this->getAllArguments ();
		
		$field = $this->getModel ( 'field' );
		
		$this->xajax->assign ( 'slug', 'value', bfString::slug4mysql ( $args [1] ) );
		
		$this->setLayout ( 'none' );
	
	}
	
	public function xadmin_generateEmailContents() {
		global $mainframe;
		$fields = $this->getModel ( 'field', true );
		$fields->getall ( 'form_id = ' . ( int ) $this->_getFormId (), false, 'ordering ASC' );
		
		$plain = '';
		$style = '<style>table{ border: 1px solid #ccc; }table th { background-color: #ccc; }</style>';
		$heading = "\n<h2>" . bfText::_ ( 'This is a form submission from' ) . " <a href=\"#J_LIVESITE#\">#J_SITENAME#</a></h2>\n";
		$html = $style . "\n" . $heading . "\n<table cellpadding=\"5\">\n\t<tr>\n\t\t<th>" . bfText::_ ( 'Field' ) . '</th><th>' . bfText::_ ( 'Submitted Value' ) . "</th>\n\t</tr>\n";
		if (count ( $fields->rows )) {
			foreach ( $fields->rows as $element ) {
				$plain .= $element->publictitle . ' #' . bfString::strtoupper ( $element->slug ) . "# \n";
				$html .= "\t<tr>\n\t\t<td><b>" . $element->publictitle . "</b></td>\t<td> #" . bfString::strtoupper ( $element->slug ) . "#</td>\n\t</tr>\n";
			}
		}
		$this->xajax->assign ( 'emailplain', 'value', $plain );
		$this->xajax->assign ( 'emailhtml', 'value', $html . '</table>' );
		$this->setLayout ( 'none' );
	}
	
	public function xadmin_parseCustomForm() {
		
		$form = $this->getModel ( 'form' );
		$form->get ( $this->_getFormId () );
		
		/**
		 *     [name] =>
    [id] => commentform
    [method] => POST
    [url] => http://www.thisisjersey.com/wp-comments-post.php
    [enctype] => application/x-www-form-urlencoded
    [class] =>
    [autocomplete] =>
		 */
		
		$args = $this->getAllArguments ();
		$html = base64_decode ( $args [1] );
		
		bfload ( 'bfFormExtractor' );
		$extractor = new bfFormExtractor ( $html );
		
		$html = str_replace ( ($extractor->formOpenTagOriginalHTML), '{$FORM_OPEN_TAG}', $html );
		$html = str_replace ( ($extractor->formCloseTagOriginalHTML), '{$FORM_CLOSE_TAG}', $html );
		
		/* Do Form Header */
		$form->form_name = $extractor->name ? $extractor->name : $form->form_name;
		$form->method = $extractor->method ? $extractor->method : $form->method;
		$form->processorurl = $extractor->url ? $extractor->url : $form->processorurl;
		$form->enctype = $extractor->enctype ? $extractor->enctype : $form->enctype;
		$form->store ();
		
		/* do form elements */
		if (count ( $extractor->elements ) >= 1) {
			foreach ( $extractor->elements as $newelement ) {
				$field = $this->getModel ( 'field', true );
				foreach ( $newelement as $k => $v ) {
					if (is_string ( $v ))
						$field->$k = $v;
				}
				/* Some transforms */
				$field->slug = bfString::slug4mysql ( $field->name );
				$field->publictitle = $field->desc ? $field->desc : $field->name;
				$field->title = $field->name;
				$field->ordering = $field->tabindex;
				$field->id = '';
				
				switch ($field->type) {
					case "text" :
						$field->plugin = 'textbox';
						break;
					
					case "file" :
						$field->plugin = 'fileupload';
						break;
					case "UNKNOWN" :
						continue;
						break;
					default :
						$field->plugin = $field->type;
						break;
				}
				
				if (isset ( $field->options )) {
					switch ($field->type) {
						case 'select' :
							$field->params = ($field->options);
							break;
						case 'checkbox' :
							$field->params = bfString::trim ( $field->options );
							break;
						
						default :
							$field->params = $field->options;
							break;
					}
					
					unset ( $field->options );
				}
				
				/* defaults */
				$field->published = 1;
				$field->access = 0;
				
				unset ( $field->name );
				unset ( $field->tabindex );
				unset ( $field->originalHTML );
				unset ( $field->autocomplete );
				unset ( $field->onClick );
				unset ( $field->onclick );
				$field->form_id = $this->_getFormId ();
				$field->store ();
				
				$plugin = $this->getModel ( 'plugins_fields' );
				$plugin->loadPlugin ( $field->plugin );
				$plugin->trigger ( 'onAfterCreateField', $field );
				$plugin->trigger ( 'onAfterCreateField_ExtendDataTable', $field );
				
				// hack as our regex consumes the final > for select boxes
				$suffix = '';
				if ($field->type == 'select')
					$suffix = '>';
				$html = str_replace ( $newelement->originalHTML . $suffix, '{$' . bfString::strtoupper ( $field->slug ) . '_ELEMENT}', $html );
			}
			
			$field->updateOrder ();
		}
		
		$this->xajax->assign ( 'custom_smarty', 'value', $html );
		if ('UNKNOWN' != $form->processorurl)
			$this->xajax->script ( "jQuery('input#processorurl').val('" . $form->processorurl . "');" );
		$this->xajax->script ( "submitToXAJAX('apply');" );
		$this->setLayout ( 'none' );
	}
	
	public function xadmin_parseCustomSalesForceForm() {
		$this->setLayout ( 'none' );
		$args = $this->getAllArguments ();
		$html = base64_decode ( $args [1] );
		
		bfload ( 'bfFormExtractor' );
		$extractor = new bfFormExtractor ( $html );
		
		$elements = array ();
		unset ( $extractor->elements ['submit'] );
		unset ( $extractor->elements ['debug'] );
		unset ( $extractor->elements ['debugEmail'] );
		unset ( $extractor->elements ['oid'] );
		unset ( $extractor->elements ['retURL'] );
		foreach ( $extractor->elements as $e => $v ) {
			$elements [] = $e;
		}
		
		$this->xajax->assign ( 'sffieldvalues', 'innerHTML', implode ( '<br />' . "\n", $elements ) );
	}
	
	public function xadmin_generatebasicformlayout() {
		
		$fields = $this->getModel ( 'field', true );
		$fields->getAllWhere ( 'form_id = ' . ( int ) $this->_getFormId (), false, 'ordering asc' );
		
		$html = '{$FORM_OPEN_TAG}' . "\n";
		
		foreach ( $fields->rows as $field ) {
			ob_start ();
			
			$s = bfString::strtoupper ( $field->slug );
			
			echo "\t" . '<div class="bf_form_row"><label for="' . $field->slug . '">{$' . $s . '_TITLE}</label>{$' . $s . '_ELEMENT}</div>' . "\n";
			
			$contents = ob_get_contents ();
			ob_end_clean ();
			
			$html .= $contents;
		}
		$html .= '{$FORM_CLOSE_TAG}';
		$this->xajax->assign ( 'custom_smarty', 'value', $html );
		$this->setLayout ( 'none' );
	}
	
	public function xadmin_setsubmissionfilter() {
		$args = $this->getAllArguments ();
		
		$indexFields = array ();
		$count = 0;
		foreach ( $args as $k => $v ) {
			if (preg_match ( '/FIELD/', $k ) || $k == 'bf_status' || $k == 'bf_user_id') {
				if ($count == 5)
					continue;
				$indexFields [] = $k;
				++ $count;
			}
		}
		
		if (count ( $indexFields )) {
			$session = bfSession::getInstance ( 'com_form' );
			$session->set ( 'SubmissionIndexFields', $indexFields, 'default' );
		}
		$this->_redirect ( 'xsubmissions' );
	}
	
	public function gpg_encrypt($public_key, $data) {
		
		bfLoad ( 'bfGpg' );
		
		$options = array ('debug' => 0, 'homedir' => _BF_FRAMEWORK_LIB_DIR . DS . 'cache', 'debug' => 0 );
		//$gpg = Crypt_GPG::factory ( 'php', $options );
		$gpg = new Crypt_GPG ( $options );
		
		$gpg->importKey ( $public_key );
		
		$keys = $gpg->getKeys ();
		
		$gpg->addEncryptKey ( $keys [0] );
		
		$buffer = $gpg->encrypt ( $data, true );
		
		@unlink ( _BF_FRAMEWORK_LIB_DIR . DS . 'cache' . DS . 'pubring.gpg' );
		@unlink ( _BF_FRAMEWORK_LIB_DIR . DS . 'cache' . DS . 'pubring.gpg~' );
		@unlink ( _BF_FRAMEWORK_LIB_DIR . DS . 'cache' . DS . 'random_seed' );
		@unlink ( _BF_FRAMEWORK_LIB_DIR . DS . 'cache' . DS . 'secring.gpg' );
		@unlink ( _BF_FRAMEWORK_LIB_DIR . DS . 'cache' . DS . 'trustdb.gpg' );
		return $buffer;
	}
}