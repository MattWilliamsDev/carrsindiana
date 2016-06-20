<?php
/**
 * @version $Id: front.php 185 2010-01-10 17:56:01Z  $
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

final class com_formControllerFront extends bfController {
	
	/**
	 * I hold the validation and filter errors
	 */
	private $_messages = array ();
	
	/**
	 * PHP5 constructor
	 * I also set the registry object into the controller
	 *
	 */
	public function __construct() {
		/** set the registry object into the controller */
		$this->_registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
		$this->_registry->setValue ( 'entrypoint', 'form' );
		parent::__construct ();
	}
	
	/**
	 * I'm the entry point for a mambot loaded form
	 */
	public function mambot($form_id) {
		/* @var $this->_registry bfRegistry */
		$this->_registry->setValue ( 'entrypoint', 'mambot' );
		$this->frontpage ( $form_id );
	
	}
	
	/**
	 * I'm the entry point for a module loaded form
	 */
	public function module($form_id) {
		$this->_registry->setValue ( 'entrypoint', 'module' );
		$this->frontpage ( $form_id );
	}
	
	public function myforms() {
		/* @var $submissions Submission */
		$submissions = $this->getModel ( 'submission', true );
		$this->mysubmissions = $submissions->getMySubmissions ();
		
		$form = $this->getModel ( 'form', true );
		$form->getAll ();
		$this->forms = $form->rows;
	}
	
	/**
	 * I control in first entry point to the component
	 *
	 * @param $arg Could be anything!
	 */
	public function frontpage($arg = null) {
		$mainframe = JFactory::getApplication ();
		$params = $mainframe->getParams ( 'com_form' );
		
		/* Am I looking for the My Forms page? - check the params! */
		if ($params->get ( 'myforms' ) == 'Yes') {
			$this->_redirect ( 'myforms' );
			return;
		}
	
		$form_id = '';
		
		/* form posted from com_form */
		if (is_array ( $arg ) && array_key_exists ( 'form_id', $arg )) {
			$form_id = $arg ['form_id'];
		}
		
		if (! is_array ( $form_id )) { // Might come from mambot/module and therefore passed in a form_id
			$form_id = $arg; //bfRequest::getVar ( 'form_id', null, 'GET', 'INT' );
		}
		
		/* If no form id in the url check the params of the menu item J1.5 only */
		if (is_array ( $arg )) {
			if (! array_key_exists ( 'form_id', $arg ) && _BF_PLATFORM == 'JOOMLA1.5' && ! count ( $_POST )) {
				
				$form_id = $params->get ( 'form_id', null );
			}
		}
		
		/* viewing a single form */
		if (! is_int ( $arg )) {
			
			if (array_key_exists ( 'form_id', $arg )) {
				$form_id = ( int ) $arg ['form_id'];
			}
		}
		

		/**
		 * if still no form id
		 * The second part, bfRequest::getVar ( 'bf_s' ), is here because if we dont have it and the form
		 * is set as the homepage then the form never gets processed
		 */
		if ($form_id && ! bfRequest::getVar ( 'bf_s' )) {
			/* Preserve the referer */
			/* @var $session bfSession */
			$session = bfSession::getInstance ( 'com_form' );
			$referer = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : '';
			$session->set ( 'current_referer', $referer, 'default' );
			
			/* we have a form id!! Yippee! Lets fire up the form! */
			if ($this->_displayForm ( $form_id ) === false) {
				$this->setView ( 'BF_ERROR' );
				return false;
			}
		
		} else {
		
			/* am I submitted form? Check for the tokens! */
			if (bfRequest::getVar ( 'bf_s' ) == md5 ( base64_encode ( md5 ( bfcompat::getSecret () ) ) )) {
				$this->_processForm ();
				return;
			}
			
			/* no form id specified - shall we show all forms? */
			if ($this->_registry->getValue ( 'config.show_list' ) == 1) {
				
				/* & is important for PHP4 */
				/* Load Model */
				$forms = $this->getModel ( 'form' );
				
				/* Get Forms data */
				$forms->getEnabledFormsForFrontpage ();
				
				$this->setView ( 'form_list' );
			} else {
				bfError::raiseError ( '403', bfText::_ ( 'No form Id Specified! Err76' ) );
			}
		}
	}
	
	/**
	 * I check that the form is ready to be used
	 *
	 * @param Form $form
	 * @param bool $submitted
	 * @return bool True if the form is valid
	 */
	public function _checkForm($form, $submitted = false) {
		
		/* check form is created - else its a fake id! */
		if ($form->id < 1)
			throw new Exception ( 'Access Denied - No Such Form id' );
			
		/* check form is created - else its a fake id! */
		if (@! $form->created)
			throw new Exception ( 'Access Denied - No Such Form' );
			
		/* check user access level */
		$user = bfUser::getInstance ();
		if ($user->get ( 'aid' ) < $form->access)
			throw new Exception ( bfText::_ ( 'Access Denied To This Form - Access Level Above yours, are you logged in?' ) );
			
		/* check form is published */
		if ($form->published != 1)
			throw new Exception ( bfText::_ ( 'Access Denied To This Form - The form is not published' ) );
		
		if ($submitted === false) {
			
			/* check form has fields */
			
			if (count ( $form->fields ) == 0) {
				throw new Exception ( bfText::_ ( 'This form has no form fields - please create some (or change the published state/access level of fields)' ) );
			}
		
		}
		
		if (defined ( '_BF_TEST_MODE' ) && _BF_TEST_MODE != true) {
			/* @var $tracking Submission_tracking */
			$tracking = $this->getModel ( 'submission_tracking', true );
			$msg1 = bfText::_ ( 'This form has reached its submissions limit' );
			$msg2 = bfText::_ ( 'You have personally reached this forms submissions limit per user' );
			
			if ($form->maxsubmissions > 0 && $tracking->howManySubmissionsForThisForm ( $form->id ) >= $form->maxsubmissions){
				throw new Exception ( $msg1 );
			}
			
			if ($form->maxsubmissionsperuser > 0 && ($tracking->howManySubmissionsFromThisUser ( $form->id ) >= $form->maxsubmissionsperuser)){
				throw new Exception ( $msg2 );
			}
		}
		return true;
	
	}
	
	/**
	 * I am the nightmare that is the function that displays a form!
	 *
	 * @param int $form_id The form id required
	 */
	private function _displayForm($form_id) {
		try {
			
			/* & is important for PHP4 */
			/* Load Model */
			$form = $this->getModel ( 'form' );
			
			$form->getForViewing ( ( int ) $form_id );
			
			$this->_checkForm ( $form );
			
			/* stupid place to put this!! */
			if ($form->spam_hiddenfield) {
				$this->session->set ( '_bf_spamField_' . $form_id, '<input type="text" style="display:none" name="' . $form->spam_hiddenfield . '" id="' . $form->spam_hiddenfield . '" value="" />' );
			}
			
			/* check if we need ssl enabled */
			if (isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on') {
				$runningSSL = true;
			} else {
				$runningSSL = false;
			}
			
			if ($runningSSL === false && $form->onlyssl == 1) {
				$url = bfCompat::sefRelToAbs ( 'index.php?option=com_form&form_id=' . $form_id );
				$url = str_replace ( 'https', 'http', $url );
				$url = str_replace ( 'http', 'https', $url );
				$url = str_replace ( '&amp;', '&', $url );
				
				/* Attempt to redirect to a secure form */
				bfCompat::redirect ( $url );
				return;
			}
			
			/* spoof check */
			$this->session->set ( 'lastViewedForm', $form_id, 'default' );
			
			$this->loadPluginModel ( 'fields' );
			
			bfDocument::addPathway ( $form->page_title, 'index.php?option=com_form&form_id=' . $form_id );
			
			/* set the form view - This will call the right plugin for layout */
			$this->setView ( 'form' );
			
		//			$this->lastscript = 'if (typeof(cmxform)!="undefined") cmxform();';
		} catch ( OverSubmitLimitException $e ) {
			bfError::raiseError ( '', bfText::_ ( 'This form has reached its submissions limit' ) );
		} catch ( UserOverSubmitLimitException $e ) {
			bfError::raiseError ( '', bfText::_ ( 'You have personally reached this forms submissions limit per user' ) );
		} catch ( Exception $e ) {
			bfError::raiseError ( '', $e->getMessage () );
			return false;
		}
	}
	
	/**
	 * Our own built in spammer checks
	 *
	 * @return bool isSpammer
	 */
	public function _isSpammer() {
		$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
		/**
		 * Check I have actually viewed this form in this session
		 */
		//$form_id = $this->session->get ( 'lastViewedForm', null, 'default' );
		

		/* is there any form set in the session */
		//		if (! $form_id) {
		//			throw new Exception ( 'Failed Spammer Checks - Err#101 !' );
		//		}
		

		/* is this the last form viewed */
		$md5FormId = base64_decode ( bfRequest::getVar ( 'bf_z' ) );
		
		/* check the form sent us an encrypted form id */
		if (! $md5FormId) {
			throw new Exception ( 'Failed Spammer Checks - Err#102 !' );
		}
		
		//		if ($md5FormId != md5 ( $form_id )) {
		//			throw new Exception ( 'Failed Spammer Checks - Err#103 !' );
		//}
		

		/**
		 * Check fooled hidden field token
		 */
		if ($registry->getValue ( 'config.global_spam_104' ) == '0') {
			$token = bfRequest::getVar ( 'token' );
			if ($token < _BF_TOKEN_MIN || $token > _BF_TOKEN_MAX) {
				throw new Exception ( 'Failed Spammer Checks - Err#104 !' );
			}
		}
		/**
		 * Check fooled hidden field spam
		 * This is a stupidity check
		 */
		if ($registry->getValue ( 'config.global_spam_105' ) == '0') {
			$spam = bfRequest::getVar ( 'spam' );
			if ($spam < _BF_SPAM_MIN || $spam > _BF_SPAM_MAX) {
				throw new Exception ( 'Failed Spammer Checks - Err#105 !' );
			}
		}
		
		/* Joomla built in spoof checking */
		if ($registry->getValue ( 'config.global_spam_106' ) == '0') {
			if (_BF_PLATFORM == 'JOOMLA1.5') {
				$token = bfCompat::getToken ();
				
				if (! JRequest::getVar ( $token, '', null )) {
					throw new Exception ( 'Failed Spammer Checks - Err#106 !' );
				} else {
					return false;
				}
			} else {
				//			$r = 1 - josSpoofCheck ();
			//			if ($r != 1) {
			//				throw new Exception ( 'Failed Spammer Checks - Err#107 !' );
			//			} else {
			//				return false;
			//			}
			}
		}
	
	}
	
	public function xpublic_preview() {
		$this->_processForm ( true );
	}
	
	/**
	 * I run the validation routines...
	 *
	 * @return bool
	 */
	private function _passesValidation() {
		
		if (count ( $this->_messages )) {
			define ( '_BF_FAILED_VALIDATION_MESSAGES', serialize ( $this->_messages ) );
			define ( '_BF_FAILED_VALIDATION', true );
			return false;
		} else {
			return true;
		}
	
	}
	
	private function _processForm($preview = false) {
		
		try {
		
			/* find a form ID */
			$md5FormId = base64_decode ( bfRequest::getVar ( 'bf_z' ) );
			if (! $md5FormId) {
				$md5FormId = base64_decode ( $this->getArgument ( 'bf_z' ) );
				if (! $md5FormId)
					throw new Exception ( 'No form id specified 313' );
			}
			
			/* lets get our form config */
			$this->_form = $this->getModel ( 'form' );
			$this->_form->get ( $md5FormId, true );
			
			/* spammer checks */
			if ($preview === false) {
				if ($this->_isSpammer () === true) {
					throw new Exception ( 'Failed Spammer Checks!' );
				}
			} else {
				/* in preview mode - need to set vars */
				$args = $this->getAllArguments ();
				foreach ( $args as $k => $v ) {
					bfRequest::setVar ( $k, $v, 'default' );
				}
			}
			
			/* Check Spam Plugins - Can only be done here as we need form id for form config */
			if ($preview === false)
				$this->_checkSpamPlugins ( $this->_form, $preview );
			
			$this->session->set ( 'lastFormId', $this->_form->id, 'default' );
			
			/* Are we in Pause mode? */
			$bf_preview = bfRequest::getVar ( 'bf_preview_' . $this->_form->id );
			$bf_preview == "2" ? $pause = true : $pause = false;
			
			/* ok we got this far - so its not a spam so count it for our statistics */
			if ($preview == false && $pause == false)
				$this->_form->recordSubmission ( false );
				
			/* check form is published, access level etc... */
			$this->_checkForm ( $this->_form, true );
		
			/* set page title */
			bfCompat::setPageTitle ( $this->_form->page_title );
			
			/* We use the RAW $_POST or $_GET because we are going to clean it through filters */
			switch (strtoupper ( $this->_form->method )) {
				case "GET" :
					$rawsubmission = $_GET;
					break;
				case "POST" :
					$rawsubmission = $_POST;
					break;
				default :
					throw new Exception ( 'Invalid Form Submit Method' );
					break;
			}
			
			/* scrub scrub scrub */
			
			/* @todo - Do we need additional cleaning - dont think so :)

            /* after cleaning rename */
			$cleansubmission = $rawsubmission;
			
			/* load plugins model */
			$this->loadPluginModel ( 'fields' );
			
			/* get the fields for this form - nuke any submitted data we dont need */
			$this->_fieldsToProcess = $this->_form->getFieldsToProcess ();
			
			if (count ( $this->_fieldsToProcess ) == 0 || ! is_array ( $this->_fieldsToProcess ))
				throw new Exception ( 'Something went wrong, as I have no fields to process' );
				
			/* remove all submitted values apart from the fields we want */
			$this->_submission = array ();
			$JS = array ();
			foreach ( $this->_fieldsToProcess as $field ) {
				Plugins_Fields::loadPlugin ( $field->plugin );
				
				$plugin = 'plugins_fields_' . $field->plugin;
				
				if (! class_exists ( $plugin ))
					throw new Exception ( "I'm sorry but I dont know about a plugin element called " . $plugin );
				
				$fieldObj = new $plugin ( );
				$fieldObj->setConfig ( $field );
				if (isset ( $cleansubmission [$field->slug] ))
					$fieldObj->setSubmittedValue ( $cleansubmission [$field->slug] );
					
				/* Run PreProcess */
				if (method_exists ( $fieldObj, 'preProcess' )) {
					$fieldObj->preProcess ();
				}
				
				/* Run Filters */
				if ($fieldObj->runFilters () == false) {
					foreach ( $fieldObj->getFilterErrorMessages () as $msg ) {
						//						$this->_messages [$field->slug] = $msg;
					}
				}
				/* _submittedValue now if filtered */
				
				/* Run Validations */
				if ($fieldObj->passesValidation () == false) {
					foreach ( $fieldObj->getValidationErrorMessages () as $msg ) {
						$this->_messages [$field->slug] = $msg;
						$JS [] = "jQuery('#" . $field->slug . "').attr('class',jQuery('#" . $field->slug . "').attr('class') + ' bf_fail_validation');";
					}
				
				} else {
					if ($field->type != 'submit') {
						$JS [] = "jQuery('#" . $field->slug . "').attr('class',jQuery('#" . $field->slug . "').attr('class') + ' bf_pass_validation');";
					}
				}
				
				/* Run PostProcess */
				if (method_exists ( $fieldObj, 'postProcess' ) && ! count ( $this->_messages )) {
					$fieldObj->postProcess ();
				}
				
				$this->_submission [$field->slug] = array ('field_id' => $field->id, 'submission' => $fieldObj->getSubmittedValue (), 'publictitle' => $field->publictitle, 'allowbyemail' => $field->allowbyemail, 'type' => $field->type );
			}
			
			/**
			 * If I dont pass falidation then show the form again
			 * With hints on why I never passed
			 */
			
			if ($this->_passesValidation () == false) {
				if ($preview === false) {
					if (count ( $JS )) {
						$scr = "\n" . 'jQuery(document).ready(function() {' . "\n\t\t" . implode ( "\n\t\t", $JS ) . "\n " . ' } );' . "\n";
					}
					
					bfDocument::addScriptFromString ( $scr );
					
					$this->_displayForm ( $this->_form->id );
				} else {
					
					/* in xajax preview and validate mode */
					
					if (count ( $JS )) {
						$scr = "\n" . 'jQuery(document).ready(function() {' . "\n\t\t" . implode ( "\n\t\t", $JS ) . "\n jQuery('#bf_failvalidation_messages').show();" . ' } );' . "\n";
					}
					
					$this->setLayout ( 'none' );
					$this->xajax->script ( $scr );
				}
				return;
			}
			
			if (count ( $this->_submission ) == 0)
				throw new Exception ( 'Something went wrong, as I have no submission to pass to the actions' );
				
			/* ok we are past our checks - lets start processing actions */
			if ($preview === false && $pause === false) {
				
				$this->_processActions ();
			} else {
				if ($pause === true) {
					/* Do Save */
					require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'helper.php';
					require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'actions' . DS . '_baseClass.php';
					require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'actions' . DS . 'save' . DS . 'save.php';
					$save = new plugins_actions_save ( 2 );
					$save->setConfig ( array ('form_id' => $this->_form->id ), $this->_submission );
					$save->run ();
					/* redirect to view my forms page */
					bfRedirect ( bfCompat::getLiveSite () . '/index.php?option=com_form&task=myforms' );
					return;
				} else {
					/* in preview mode */
					/* Render a preview layout */
					$this->setXajaxTarget ( 'bf_previewform_div_' . $this->_form->id );
					$this->setView ( 'preview_submission' );
					$this->xajax->script ( 'bf_form.displayPreview(' . $this->_form->id . ');' );
				}
			}
		
		} catch ( Exception $e ) {
			if (preg_match ( '/Failed Spammer/', $e->getMessage () )) {
				$this->_form->count_spamsubmissions ++;
				$this->_form->store ();
			}
			if (defined ( '_IS_XAJAX_CALL' )) {
				$this->xajax->alert ( $e->getMessage () );
			} else {
				echo bfError::raiseError ( '', $e->getMessage () );
			}
		}
	}
	
	private function _processActions() {
		
		/* get our plugin model */
		$this->loadPluginModel ( 'actions' );
		
		/* start it up */
		$actionPlugins = Plugins_Actions::getInstance ();
		
		/* get the actions this form wants us to process */
		$actionsToProcess = $this->_form->getActionsToProcess ();
		
		if (! count ( $actionsToProcess ))
			throw new Exception ( 'You have not defined any actions for this form' );
			
		/* process each action in turn */
		foreach ( $actionsToProcess as $action ) {
			
			/* include the plugin and register it */
			$actionPlugins->loadOne ( $action->plugin );
			
			/* start a new action trigger */
			$class = 'plugins_actions_' . $action->plugin;
			
			if (! class_exists ( $class ))
				throw new Exception ( "I'm sorry but I dont know about a plugin action called " . $class );
			
			$worker = new $class ( );
			
			/* pass it the config for this action id */
			$worker->setConfig ( $action, $this->_submission );
			
			/* do what the action does */
			$worker->run ();
		
		}
		
		$tracking = $this->getModel ( 'submission_tracking' );
		$tracking->logSubmission ();
	
	}
	
	private function _checkSpamPlugins($formObj, $preview) {
		
		/* We use the RAW $_POST or $_GET because we are going to clean it through filters */
		switch (strtoupper ( $this->_form->method )) {
			case "GET" :
				$rawsubmission = $_GET;
				break;
			case "POST" :
				$rawsubmission = $_POST;
				break;
			default :
				throw new Exception ( 'Invalid Form Submit Method' );
				break;
		}
		
		if ($this->_registry->getValue ( 'config.global_spam_106' ) == '0') {
			if ($formObj->spam_hiddenfield) {
				if (isset ( $rawsubmission [$formObj->spam_hiddenfield] ) && $rawsubmission [$formObj->spam_hiddenfield] != '')
					throw new Exception ( 'Failed Spammer Checks Err#483' );
			}
		}
		
		/* Check BlackLists */
		bfLoad ( 'bfVerify' );
		if (isset ( $_SERVER ['REMOTE_ADDR'] )) {
			if ($this->_form->useblacklist == "1" && bfVerify::isblacklisted ( $_SERVER ['REMOTE_ADDR'] ) === true) {
				throw new Exception ( 'Form Submitters IP Address is Blacklisted!' );
			}
		}
		
		/* Akismet */
		if ($formObj->spam_akismet_key != '') {
			bfLoad ( 'bfAkismet' );
			
			//			$comment = array (
			//			'author' => 'viagra-test-123',
			//			 'email' => 'test@example.com',
			//			 'website' => 'http://www.example.com/',
			//			 'body' => 'This is a test comment',
			//			 'permalink' => 'http://yourdomain.com/yourblogpost.url' );
			

			$comment = array ('author' => $rawsubmission [$this->_form->spam_akismet_author], 'email' => $rawsubmission [$this->_form->spam_akismet_email], 'website' => $rawsubmission [$this->_form->spam_akismet_website], 'body' => $rawsubmission [$this->_form->spam_akismet_body], 'permalink' => bfCompat::getLiveSite () );
			
			$akismet = new bfAkismet ( bfCompat::getLiveSite (), $formObj->spam_akismet_key, $comment );
			
			if ($akismet->isError ()) {
				throw new Exception ( "Couldn't connect to Akismet Spam Server!" );
			} else {
				if ($akismet->isSpam ()) {
					throw new Exception ( "Akismet Spam Plugin Thinks Your Submission is Spam!" );
				}
			}
		}
		
		/* Mollom */
		
		if ($formObj->spam_mollom_privatekey != '' && $formObj->spam_mollom_publickey != '') {
			bfLoad ( 'bfMollom' );
			
			/* set keys */
			
			bfMollom::setPublicKey ( $formObj->spam_mollom_publickey );
			bfMollom::setPrivateKey ( $formObj->spam_mollom_privatekey );
			
			/* populate serverlist (get them from your db, or file, or ... */
			$servers = array();
			
			bfMollom::setServerList ( json_decode('["http:\/\/174.37.205.152","http:\/\/88.151.243.81","http:\/\/88.151.243.145","http:\/\/174.37.205.152","http:\/\/88.151.243.81","http:\/\/88.151.243.145","http:\/\/174.37.205.152","http:\/\/88.151.243.81","http:\/\/88.151.243.145"]'));
		
			$feedback = bfMollom::checkContent ( null, null, implode ( "\n", $rawsubmission ) );
				
				
			// process feedback
			if ($feedback ['spam'] == 'unknow') {
				//throw new Exception ( 'Mollom Spam Service Thinks Your Submission Is unknow!' );
			} else if ($feedback ['spam'] == 'unsure') {
				//throw new Exception ( 'Mollom Spam Service Thinks Your Submission Is unsure!' );
			} else if ($feedback ['spam'] == 'ham') {
				//throw new Exception ( 'Mollom Spam Service Thinks Your Submission Is ham!' );
			} else if ($feedback ['spam'] == 'spam') {
				throw new Exception ( 'Mollom Spam Service Thinks Your Submission Is Spam!' );
			}
		}
		
		/* IP Black list */
		if ($formObj->spam_ipblacklist != '') {
			$ips = explode ( "\n", $formObj->spam_ipblacklist );
			if (in_array ( $_SERVER ['REMOTE_ADDR'], $ips )) {
				throw new Exception ( 'Your IP Address has been banned' );
			}
		}
		
		/* common things */
		foreach ( $rawsubmission as $k => $v ) {
			if ($this->_registry->getValue ( 'config.global_spam_108' ) == '0') {
				if (is_string ( $k ) && is_string ( $v )) {
					if (preg_match ( "/bcc:|cc:|multipart|\[url|Content-Type:/i", $k . $v )) {
						throw new Exception ( 'Failed Spammer Checks - Err#108 !' );
					}
				}
			}
			
			if ($this->_registry->getValue ( 'config.global_spam_109' ) == '0') {
				if (preg_match_all ( "/<a|http:/i", $k . $v, $out ) > 3) {
					throw new Exception ( 'Failed Spammer Checks - Err #109!' );
				}
			}
			
			if ($formObj->spam_wordblacklist) {
				$spamwords = "/" . bfString::trim ( $formObj->spam_wordblacklist ) . "/i";
				ob_start ();
				
				print_R ( $rawsubmission );
				
				$contents = ob_get_contents ();
				ob_end_clean ();
				
				if (preg_match ( $spamwords, $contents )) {
					throw new Exception ( 'Submission contains banned words!- Err#110 !' );
				}
			}
		
		}
	
	}
	
	/**
	 * index.php?option=com_form&form_id=150&submission_id=10&task=edit
	 * @return unknown_type
	 */
	public function edit() {
		
		$form_id = ( int ) bfRequest::getVar ( 'form_id' );
		$submission_id = ( int ) bfRequest::getVar ( 'submission_id' );
		$data = array ('form_id' => $form_id, 'submission_id' => $submission_id );
		/* @var $registry bfRegistry */
		$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
		$registry->setValue ( 'resumingsubmission', $data );
		$this->frontpage ( $data );
	}
	/**
	 * index.php?option=com_form&form_id=150&submission_id=10&task=delete
	 * @return unknown_type
	 */
	public function delete() {
		try {
			$user = bfUser::getInstance ();
			if ($user->get ( 'id' ) == '0')
				throw new exception ( bfText::_ ( 'You need to be logged in to delete submissions' ) );
			$form_id = ( int ) bfRequest::getVar ( 'form_id' );
			$submission_id = ( int ) bfRequest::getVar ( 'submission_id' );
			
			if ($form_id == "0" || $submission_id == "0")
				throw new Exception ( 'Error #739!' );
			
			$forms = $this->getModel ( 'form', true );
			$forms->get ( $form_id );
			
			if ($forms->allowownsubmissiondelete == "0")
				throw new Exception ( 'Submissions of this form cannot be deleted' );
			
			$submissions = $this->getModel ( 'submission', true );
			/* @var $submissions Submission */
			$submissions->setTableName ( $form_id, true );
			$submissions->get ( $submission_id );
			
			if ($submissions->bf_user_id != $user->get ( 'id' )) {
				throw new exception ( bfText::_ ( 'You cannot delete some one elses submission' ) );
			}
			
			/*check config allows this form submission to be deleted. */
			$submissions->bf_status = 'Deleted';
			$submissions->store ();
			
			bfRedirect ( 'index.php?option=com_form&task=myforms', bfText::_ ( 'Deleted!' ) );
		
		} catch ( Exception $e ) {
			die ( $e->getMessage () );
		}
	
	}
	
	public function getSubmission() {
		return $this->_submission;
	}
}

class OverSubmitLimitException extends Exception {
}
class UserOverSubmitLimitException extends Exception {
}