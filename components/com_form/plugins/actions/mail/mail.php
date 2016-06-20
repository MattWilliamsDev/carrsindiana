<?php
/**
 * @version $Id: mail.php 184 2010-01-03 20:44:13Z  $
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
if (! class_exists ( 'plugins_actions_base' )) {
	require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'helper.php';
	require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'actions' . DS . '_baseClass.php';
}
/**
 * Class for form actions
 *
 */
class plugins_actions_mail extends plugins_actions_base {
	/**
	 * The plugin name
	 *
	 * @var string
	 */
	private $_pname = 'mail';
	/**
	 * The current form_id
	 *
	 * @var int the form id
	 */
	private $_form_id = null;
	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	private $_title = 'Send an email';
	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	private $_defaults = array ('published' => '1', 'access' => '0' );
	/**
	 * The creation defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_creation_defaults = array ('plugin' => 'mail', 'published' => '1', 'access' => '0', 'form_id' => '-1' );
	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	private $_desc = 'Send an EMail containing filtered and validated form submission values to multiple email addresses';
	/**
	 * I hold this fields current config,
	 * which overrides the defaults above
	 *
	 * @var array
	 */
	public $_config = array ();
	/**
	 * I hold the incoming submitted forms clean and modified data
	 *
	 * @var array
	 */
	public $submittedData = array ();
	public function update_creation_defaults() {
		$JConfig = new JConfig ( );
		$this->_creation_defaults ['emailfrom'] = $JConfig->mailfrom;
		$this->_creation_defaults ['emailto'] = $JConfig->mailfrom;
		$this->_creation_defaults ['emailfromname'] = $JConfig->fromname;
		$this->_creation_defaults ['emailsubject'] = bfText::_ ( 'Submission Results' );
		$this->_creation_defaults ['emailplain'] = '';
		$this->_creation_defaults ['emailhtml'] = '';
		$session = bfSession::getInstance ( 'com_form' );
		$form_id = $session->get ( 'lastFormId', '', 'default' );
		if ($form_id) {
			$db = bfCompat::getDBO ();
			$db->setQuery ( 'SELECT publictitle, slug from #__form_fields WHERE form_id = ' . ( int ) $form_id . ' ORDER BY ordering' );
			$elements = $db->LoadObjectList ();
		}
		if (count ( $elements )) {
			foreach ( $elements as $field ) {
				$this->_creation_defaults ['emailplain'] .= $field->publictitle . ": #" . bfString::strtoupper ( $field->slug ) . "# \n";
				$this->_creation_defaults ['emailhtml'] .= "<b>" . $field->publictitle . ":</b> #" . bfString::strtoupper ( $field->slug ) . "#<br />\n";
			}
		}
	}
	public function get($s) {
		return $this->$s;
	}
	/**
	 * Process this action
	 *
	 */
	public function run($return = false) {
		$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
		if (@BF_FORMS_DEMO_MODE == TRUE) {
			echo '<h2 style="color:red;">Joomla Forms is running in demo mode - sending of emails is disabled, but had demo mode been turned off emails would have been sent!</h2>';
			return true;
		}
		try {
			$user = bfUser::getInstance ();
			if (! class_exists ( 'Swift' ))
				require_once _BF_FRAMEWORK_LIB_DIR . DS . 'libs' . DS . 'swift' . DS . 'Swift.php';
			if (! class_exists ( 'Zend_Validate_EmailAddress' ))
				require 'Zend/Validate/EmailAddress.php';
			if ($registry->getValue ( 'config.dnsmx' ) == "1") {
				$useDNSMX = true;
			} else {
				$useDNSMX = false;
			}
			$validator = new Zend_Validate_EmailAddress ( Zend_Validate_Hostname::ALLOW_ALL, $useDNSMX, new Zend_Validate_Hostname ( ) );
			$transport = '';
			$config = array ();
			switch (_BF_PLATFORM) {
				case 'JOOMLA1.5' :
					$JConfig = new JConfig ( );
					$config ['mailer'] = $JConfig->mailer;
					$config ['emailfrom'] = $JConfig->mailfrom;
					$config ['fromname'] = $JConfig->fromname;
					$config ['smtpauth'] = $JConfig->smtpauth;
					$config ['smtpuser'] = $JConfig->smtpuser;
					$config ['smtppass'] = $JConfig->smtppass;
					$config ['smtphost'] = $JConfig->smtphost;
					$config ['sendmail'] = $JConfig->sendmail;
					$config ['smtpsecure'] = $JConfig->smtpsecure;
					$config ['smtpport'] = $JConfig->smtpport;
					break;
				case 'JOOMLA1.0' :
					break;
			}
			
			switch ($config ['mailer']) {
				case "smtp" :
					if (! class_exists ( 'Swift_Connection_SMTP' ))
						require_once _BF_FRAMEWORK_LIB_DIR . DS . 'libs' . DS . 'swift' . DS . 'Swift' . DS . 'Connection' . DS . 'SMTP.php';
					$connection = new Swift_Connection_SMTP ( $config ['smtphost'] );
					if ($config ['smtpuser'])
						$connection->setUsername ( $config ['smtpuser'] );
					if ($config ['smtppass'])
						$connection->setpassword ( $config ['smtppass'] );
					if ($config ['smtpport'])
						$connection->setPort ( $config ['smtpport'] );
					if ($config ['smtpsecure']) {
						switch ($config ['smtpsecure']) {
							case "ssl" :
								$connection->setEncryption ( Swift_Connection_SMTP::ENC_SSL );
								break;
							case "tls" :
								$connection->setEncryption ( Swift_Connection_SMTP::ENC_TLS );
								break;
							default :
								$connection->setEncryption ( Swift_Connection_SMTP::ENC_OFF );
								break;
						}
					}
					break;
				
				case "sendmail" :
					if (! class_exists ( 'Swift_Connection_Sendmail' ))
						require_once _BF_FRAMEWORK_LIB_DIR . DS . 'libs' . DS . 'swift' . DS . 'Swift' . DS . 'Connection' . DS . 'Sendmail.php';
					$connection = new Swift_Connection_Sendmail ( ($config ['sendmail'] . ' -bs ') );
					break;
				default :
				case "mail" :
					if (! class_exists ( 'Swift_Connection_NativeMail' ))
						require_once _BF_FRAMEWORK_LIB_DIR . DS . 'libs' . DS . 'swift' . DS . 'Swift' . DS . 'Connection' . DS . 'NativeMail.php';
					$connection = new Swift_Connection_NativeMail ( );
					break;
			}
			$swift = new Swift ( $connection );
			/**
			 * use disk cache
			 * @link http://www.swiftmailer.org/wikidocs/v3/tips/memory
			 */
			if (is_writable ( _BF_CACHE_DIR )) {
				Swift_CacheFactory::setClassName ( "Swift_Cache_Disk" );
				Swift_Cache_Disk::setSavePath ( _BF_CACHE_DIR );
			}
			$recipients = new Swift_RecipientList ( );
			/**
			 * Replace all the #PLACEHOLDERS#
			 */
			foreach ( $this->submittedData as $key => $field ) {
				/* remove sensitive information */
				if (! preg_match ( '/PGP/', $this->_config ['gpgpublickey'] ) && $this->submittedData [$key] ['allowbyemail'] == '0') {
					$field ['submission'] = '[**********]';
				}
				$key = "#" . strtoupper ( $key ) . "#";
				$this->_config ['emailto'] = str_replace ( $key, $field ['submission'], $this->_config ['emailto'] );
				$this->_config ['emailcc'] = str_replace ( $key, $field ['submission'], $this->_config ['emailcc'] );
				$this->_config ['emailbcc'] = str_replace ( $key, $field ['submission'], $this->_config ['emailbcc'] );
				$this->_config ['emailplain'] = str_replace ( $key, $field ['submission'], $this->_config ['emailplain'] );
				$this->_config ['emailhtml'] = str_replace ( $key, $this->newlinetobr ( $field ['submission'] ), $this->_config ['emailhtml'] );
				$this->_config ['emailsubject'] = str_replace ( $key, $field ['submission'], $this->_config ['emailsubject'] );
				/* If I am logged in */
				if ($user->get ( 'id' ) > 0) {
					/* replace #MYID# with logged in users ID */
					/*
					 * JUSER_MYID
					 * JUSER_MYUSERNAME
					 * JUSER_MYFULLNAME
					 * JUSER_MYEMAIL
					 */
					$this->_config ['emailplain'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ($user->get ( 'id' ), $user->get ( 'username' ), $user->get ( 'name' ), $user->get ( 'email' ) ), $this->_config ['emailplain'] );
					$this->_config ['emailhtml'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ($user->get ( 'id' ), $user->get ( 'username' ), $user->get ( 'name' ), $user->get ( 'email' ) ), $this->_config ['emailhtml'] );
					$this->_config ['emailsubject'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ($user->get ( 'id' ), $user->get ( 'username' ), $user->get ( 'name' ), $user->get ( 'email' ) ), $this->_config ['emailsubject'] );
					$this->_config ['emailto'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ($user->get ( 'id' ), $user->get ( 'username' ), $user->get ( 'name' ), $user->get ( 'email' ) ), $this->_config ['emailto'] );
					$this->_config ['emailcc'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ($user->get ( 'id' ), $user->get ( 'username' ), $user->get ( 'name' ), $user->get ( 'email' ) ), $this->_config ['emailcc'] );
					$this->_config ['emailbcc'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ($user->get ( 'id' ), $user->get ( 'username' ), $user->get ( 'name' ), $user->get ( 'email' ) ), $this->_config ['emailbcc'] );
				} else {
					/* remove placeholders */
					$this->_config ['emailplain'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ('', '', '', '' ), $this->_config ['emailplain'] );
					$this->_config ['emailhtml'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ('', '', '', '' ), $this->_config ['emailhtml'] );
					$this->_config ['emailsubject'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ('', '', '', '' ), $this->_config ['emailsubject'] );
					$this->_config ['emailto'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ('', '', '', '' ), $this->_config ['emailto'] );
					$this->_config ['emailcc'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', '#JUSER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ('', '', '', '' ), $this->_config ['emailcc'] );
					$this->_config ['emailbcc'] = str_replace ( array ('#JUSER_MYID#', '#JUSER_MYUSERNAME#', 'J#USER_MYFULLNAME#', '#JUSER_MYEMAIL#' ), array ('', '', '', '' ), $this->_config ['emailbcc'] );
				}
				/* Joomla Vars */
				$this->_config ['emailplain'] = str_replace ( array ('#J_LIVESITE#', '#J_SITENAME#' ), array (bfCompat::getLiveSite (), bfCompat::getSiteName () ), $this->_config ['emailplain'] );
				$this->_config ['emailhtml'] = str_replace ( array ('#J_LIVESITE#', '#J_SITENAME#' ), array (bfCompat::getLiveSite (), bfCompat::getSiteName () ), $this->_config ['emailhtml'] );
				$this->_config ['emailsubject'] = str_replace ( array ('#J_LIVESITE#', '#J_SITENAME#' ), array (bfCompat::getLiveSite (), bfCompat::getSiteName () ), $this->_config ['emailsubject'] );
				if (preg_match ( '/'.$key.'/i', $this->_config ['emailto'] )) {
					if ($validator->isValid ( $field ['submission'] )) {
						$this->_config ['emailto'] = str_replace ( $key, $field ['submission'], $this->_config ['emailto'] );
					} else {
						throw new Exception ( 'You did not provide a valid email address!' );
					}
				}
				if (preg_match ( '/'.$key.'/i', $this->_config ['emailcc'] )) {
					if ($validator->isValid ( $field ['submission'] )) {
						$this->_config ['emailcc'] = str_replace ( $key, $field ['submission'], $this->_config ['emailcc'] );
					} else {
						throw new Exception ( 'You did not provide a valid email address!' );
					}
				}
				if (preg_match ( '/'.$key.'/i', $this->_config ['emailbcc'] )) {
					if ($validator->isValid ( $field ['submission'] )) {
						$this->_config ['emailbcc'] = str_replace ( $key, $field ['submission'], $this->_config ['emailbcc'] );
					} else {
						throw new Exception ( 'You did not provide a valid email address!' );
					}
				}
				if (preg_match ( '/'.$key.'/i', $this->_config ['emailfromname'] )) {
					/* could be unclean - clean it again to make sure! */
					$this->_config ['emailfromname'] = str_replace ( $key, $field ['submission'], $this->_config ['emailfromname'] );
				}
				if (preg_match ( '/'.$key.'/i', $this->_config ['emailfrom'] )) {
					if ($validator->isValid ( $field ['submission'] )) {
						$this->_config ['emailfrom'] = str_replace ( $key, $field ['submission'], $this->_config ['emailfrom'] );
					} else {
						throw new Exception ( 'You did not provide a valid email address!' );
					}
				}
			}
			/* To: */
			$emailtos = explode ( "\n", $this->_config ['emailto'] );
			if (count ( $emailtos )) {
				foreach ( $emailtos as $email ) {
					$email = trim ( $email );
					if ($validator->isValid ( $email ))
						$recipients->addTo ( $email );
				}
			}
			/* cc: */
			$emailccs = explode ( "\n", $this->_config ['emailcc'] );
			if (count ( $emailccs )) {
				foreach ( $emailccs as $email ) {
					if ($validator->isValid ( $email ))
						$recipients->addCc ( $email );
				}
			}
			/* bcc: */
			$emailbccs = explode ( "\n", $this->_config ['emailbcc'] );
			if (count ( $emailbccs )) {
				foreach ( $emailbccs as $email ) {
					if ($validator->isValid ( $email ))
						$recipients->addBcc ( $email );
				}
			}
			//Create the message
			$message = new Swift_Message ( );
			/* a little spam control abuse */
			$message->headers->set ( "X-JF-Joomla_Forms", "This Email Was Sent By bfForms. See www.phil-taylor.com for full details" );
			$message->headers->set ( "X-JF-Tracking", bfCompat::getLiveSite () );
			$message->headers->set ( "X-JF-FormID", $this->_config ['form_id'] );
			$message->headers->set ( "X-JF-SubmittersIP", @$_SERVER ['REMOTE_ADDR'] );
			/* body */
			/* Encrypt ? */
			if (preg_match ( '/PGP/', $this->_config ['gpgpublickey'] )) {
				$this->_config ['emailplain'] = $this->_gpg_encrypt ( $this->_config ['gpgpublickey'], $this->_config ['emailplain'] );
				$message->attach ( new Swift_Message_Part ( (stripslashes ( stripslashes ( $this->_config ['emailplain'] ) )) ) );
			} else {
				/* No Encryption */
				if ($this->_config ['emailplain'])
					$message->attach ( new Swift_Message_Part ( (stripslashes ( stripslashes ( $this->_config ['emailplain'] ) )) ) );
				if ($this->_config ['emailhtml'])
					$message->attach ( new Swift_Message_Part ( stripslashes ( stripslashes ( $this->_config ['emailhtml'] ) ), "text/html" ) );
			}
			/* Set Subject */
			if ($this->_config ['emailsubject'])
				$message->setSubject ( stripslashes ( stripslashes ( $this->_config ['emailsubject'] ) ) );
				/* Attachments */
			if ($this->_config ['senduploadedfiles'] == '1') {
				$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );
				$files = $registry->getValue ( 'bf.form.uploadedfiles', array () );
				if (count ( $files )) {
					foreach ( $files as $file ) {
						//Use the Swift_File class
						$message->attach ( new Swift_Message_Attachment ( new Swift_File ( $file ), basename ( $file ) ) );
					}
				}
			}
			if ($this->_config ['attachments']) {
				$files = explode ( "\n", $this->_config ['attachments'] );
				if (count ( $files )) {
					foreach ( $files as $file ) {
						if (file_exists ( $file ))
							$message->attach ( new Swift_Message_Attachment ( new Swift_File ( $file ), basename ( $file ) ) );
					}
				}
			}
			/* From: */
			if (! $validator->isValid ( $this->_config ['emailfrom'] ))
				throw new Exception ( 'Your FROM EMAIL ADDRESS is invalid! - Contact the webmaster and ask him to reconfigure the form actions options' );
			$from = new Swift_Address ( $this->_config ['emailfrom'], $this->_config ['emailfromname'] );
			if ($swift->send ( $message, $recipients, $from )) {
				echo "<!-- EMAIL ACCEPTED FOR DELIVERY BY SERVER -->";
			} else {
				echo "<!-- EMAIL ***NOT*** ACCEPTED FOR DELIVERY BY SERVER -->";
			}
		} catch ( Swift_Connection_Exception $e ) {
			bfError::raiseError ( 'SWIFT MAILER SAID: ', $e->getMessage (), $e->getMessage () );
			return false;
		} catch ( Swift_Exception $e ) {
			bfError::raiseError ( 'SWIFT MAILER SAID: ', $e->getMessage (), $e->getMessage () );
			return false;
		} catch ( Exception $e ) {
			bfError::raiseError ( 'BFERROR: ', $e->getMessage (), $e->getMessage () );
			return false;
		}
	}
	private function _gpg_encrypt($public_key, $data) {
		bfLoad ( 'bfGpg' );
		$options = array ('debug' => 0, 'homedir' => _BF_FRAMEWORK_LIB_DIR . DS . 'cache' );
		$gpg = new Crypt_GPG ( $options );
		$gpg->importKey ( $public_key );
		$keys = $gpg->getKeys ();
		/* @var $keyid Crypt_GPG_Key */
		$keyid = $keys [0];
		$pri = $keyid->getPrimaryKey ();
		$gpg->addEncryptKey ( $keyid );
		$buffer = $gpg->encrypt ( $data, true );
		$gpg->deletePublicKey ( $pri->getId () );
		@unlink ( _BF_FRAMEWORK_LIB_DIR . DS . 'cache' . DS . 'pubring.gpg' );
		@unlink ( _BF_FRAMEWORK_LIB_DIR . DS . 'cache' . DS . 'random_seed' );
		@unlink ( _BF_FRAMEWORK_LIB_DIR . DS . 'cache' . DS . 'secring.gpg' );
		@unlink ( _BF_FRAMEWORK_LIB_DIR . DS . 'cache' . DS . 'trustdb.gpg' );
		return $buffer;
	}
	public function _editActionView() {
		/* Call in Smarty to display template */
		bfLoad ( 'bfSmarty' );
		$tmp = bfSmarty::getInstance ( 'com_form' );
		$tmp->caching = false;
		$tmp->assignFromArray ( $this->_config );
		$tmp->assign ( 'CONFIG', $this->_config );
		$disabled = bfHTML::yesnoRadioList ( 'published', '', $this->_config ['published'] );
		$tmp->assign ( 'PUBLISHED', $disabled );
		$SENDUPLOADEDFILES = bfHTML::yesnoRadioList ( 'senduploadedfiles', '', $this->_config ['senduploadedfiles'] );
		$tmp->assign ( 'SENDUPLOADEDFILES', $SENDUPLOADEDFILES );
		$OPTIONS = array (bfHTML::makeOption ( '0', 'Public' ), bfHTML::makeOption ( '1', 'Registered' ), bfHTML::makeOption ( '2', 'Special' ) );
		$access = bfHTML::selectList2 ( $OPTIONS, 'access', '', 'value', 'text', $this->_config ['access'] );
		$tmp->assign ( 'ACCESS', $access );
		/* Element placeholders HTML */
		$placeholders = '';
		if (count ( $this->_currentElements )) {
			foreach ( $this->_currentElements as $el ) {
				$placeholders .= '<li>#' . bfString::strtoupper ( $el->slug ) . '#</li>';
			}
		}
		$tmp->assign ( 'PLACEHOLDERS', $placeholders . '<br />' );
		$tmp->display ( dirname ( __FILE__ ) . DS . 'editView.tpl' );
	}
	private function newlinetobr($str) {
		return str_replace ( "\n", "<br />", $str );
	}
}
