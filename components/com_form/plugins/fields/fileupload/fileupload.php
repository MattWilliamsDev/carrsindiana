<?php
/**
 * @version $Id: fileupload.php 184 2010-01-03 20:44:13Z  $
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
final class plugins_fields_fileupload extends plugins_fields_base {

	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	public $_pname = 'fileupload';

	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	public $_title = 'fileupload - A File Upload Brows Button';

	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_attributes = array ('type' => 'file', 'id' => '', 'name' => '', 'maxlength' => '255', 'size' => '30', 'class' => 'inputbox', 'value' => '', 'style' => '', 'onblur' => '' );

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
	public $_creation_defaults = array ('fileupload_setvalueto' => '2', 'verify_fileupload_overwritemode' => '2', 'fileupload_filenamemask' => '::DATE::_::TIME::_::USERID::____::ORIGINALFILENAME::', 'plugin' => 'fileupload', 'published' => '1', 'access' => '0', 'allowbyemail' => '1', 'maxlength' => '255', 'size' => '30', 'class' => 'inputbox', 'form_id' => '-1', 'type' => 'file', 'verify_fileupload_extensions' => 'jpg,jpeg,png,doc,txt,gif,rtf,pdf,xls,rar,tar,zip,tgz,gz', 'verify_fileupload_maxsize' => '2.0', 'fileupload_destdir' => '' );

	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	public $_desc = 'An element to upload a file';

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

	public function __construct() {
		$session = bfSession::getInstance ( 'com_form' );
		$this->_creation_defaults ['fileupload_destdir'] = bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'files' . DS . substr ( md5 ( bfCompat::getSecret () . $session->get ( 'lastFormId', '', 'default' ) ), 0, 5 );
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

		// user uploads 'foo.gif', but that file already exists in the upload directory:
		//    1 = (overwrite) overwrite existing file with uploaded foo.gif
		//    2 = (rename) keep original foo.gif, upload new file but call it 'foo_copy1.gif'
		//    3 = (do nothing) keep original foo.gif, do nothing with uploaded file, raise error
		$options = array ();
		$options [] = bfHTML::makeOption ( '1', bfText::_ ( 'Overwrite Existing File With Uploaded File' ) );
		$options [] = bfHTML::makeOption ( '2', bfText::_ ( "Keep original foo.gif, upload new file but call it 'foo_copy1.gif'" ) );
		$verify_fileupload_overwritemode = bfHTML::selectList2 ( $options, 'verify_fileupload_overwritemode', ' class="inputbox"', 'value', 'text', $this->_config ['verify_fileupload_overwritemode'] );
		$tmp->assign ( strtoupper ( 'verify_fileupload_overwritemode' ), $verify_fileupload_overwritemode );
		$options = array ();
		$options [] = bfHTML::makeOption ( '1', bfText::_ ( 'Full absolute path to file' ) );
		$options [] = bfHTML::makeOption ( '2', bfText::_ ( "Full URL to the file, if destination folder is in web space, else just filename" ) );
		$options [] = bfHTML::makeOption ( '3', bfText::_ ( "Just the filename" ) );
		$fileupload_setvalueto = bfHTML::selectList2 ( $options, 'fileupload_setvalueto', ' class="inputbox"', 'value', 'text', $this->_config ['fileupload_setvalueto'] );

		$tmp->assign ( strtoupper ( 'fileupload_setvalueto' ), $fileupload_setvalueto );

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

		/* allowsetbyget overide */
		$val = bfRequest::getVar ( $this->_config ['slug'], null, 'GET' );
		if ($val && $this->_config ['allowsetbyget'] == '1') {
			$this->_attributes ['value'] = $this->runFilters ( $val );
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

		$html .= sprintf ( $this->_barehtml, $attributesSpacedHTML );

		if ($this->_config ['required'] == '1') {
//			$html .= '<span class="required">*</span>';
		}

		return $html;
	}

	/**
	 * postProcess gets triggered after all filters and validations are done
	 *
	 */
	public function postProcess() {
		/* Handle File Uploads FIRST - Hack to change Ordering :-)  */

		if (BF_FORMS_DEMO_MODE == TRUE) {
			echo '<h2 style="color:red;">File Uploads disabled in demo mode!</h2>';
			return;
		}

		if (! isset ( $_FILES ))
			return;

		if (isset ( $_FILES [$this->_config ['slug']] )) {
			$file = $_FILES [$this->_config ['slug']];
		} else {
			return;
		}

		bfload ( 'bfFileUpload' );

		define('_BF_FORM_ID', $this->_config['form_id']);
		/**
		 * Error codes are here:
		 * @link http://uk2.php.net/manual/en/features.file-upload.errors.php
		 */
		if ($file ['error'] == 4) {
			$this->setSubmittedValue ( bfText::_ ( 'No File Selected For Upload' ) );
		}

		/* clean */

		$upload = new bfFileUpload ( );
		$upload->filemask = $this->_config ['fileupload_filenamemask'];

		// restrict filesize to 1500 bytes (1.5kb) or smaller
		//		$upload->set_max_filesize ( 15000 );
		$upload->setMaxFilesize ( $this->_config ['verify_fileupload_maxsize'] * 1024 * 1024 );

		// limit types of files based on MIME type
		// 'image' - accept any MIME type containing 'image' (.gif, .jpg, .png, .tif, etc...)
		// 'image/gif' - only accept gif images
		// 'image/gif, image/png' - only accept gif and png images
		// 'image/gif, text' - accept gif images and any MIME type containing 'text'
		//		$upload->set_acceptable_types ( 'image' ); // comma separated string, or array


		// reject files, even if they are an acceptable MIME type
		//
		// the following will accept all image file not ending with '.jpg'
		//    $upload->set_acceptable_types('image');
		//    $upload->set_reject_extension('.jpg');
		//		$upload->set_reject_extension ( '.jpg' ); // comma separated string, or array


		// reject image files larger than these pixels dimensions (only affects image uploads)
		//		$upload->set_max_image_size ( 400, 400 ); // width, height


		// Set mode to manage identically named files
		//
		// user uploads 'foo.gif', but that file already exists in the upload directory:
		//    1 = (overwrite) overwrite existing file with uploaded foo.gif
		//    2 = (rename) keep original foo.gif, upload new file but call it 'foo_copy1.gif'
		//    3 = (do nothing) keep original foo.gif, do nothing with uploaded file, raise error
		$upload->setOverwriteMode ( $this->_config ['verify_fileupload_overwritemode'] );

		$filename = $upload->upload ( $this->_config ['slug'], $this->_config ['fileupload_destdir'] );

		if ($filename) {
			/* @var $registry bfRegistry */
			$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );

			$abs = $this->_config ['fileupload_destdir'] . DS . $filename;

			if ($this->_config ['allowbyemail'] == '1') {
				$files = $registry->getValue ( 'bf.form.uploadedfiles', array () );
				$files = array_merge ( $files, array ($abs ) );
				$registry->setValue ( 'bf.form.uploadedfiles', $files );
			}
			switch ($this->_config ['fileupload_setvalueto']) {
				case '1' :
					$this->setSubmittedValue ( str_replace ( "\\", "/", $abs ) );
					break;

				case '2' :
					if (preg_match ( '~'.bfCompat::getAbsolutePath ().'~', $this->_config ['fileupload_destdir'] )) {
						$url = str_replace ( bfCompat::getAbsolutePath (), bfCompat::getLiveSite (), $abs );

						$this->setSubmittedValue ( str_replace ( "\\", "/", $url ) );
					} else {
						$this->setSubmittedValue ( str_replace ( "\\", "/", $filename ) );
					}
					break;

				case '3' :
				default :
					$this->setSubmittedValue ( str_replace ( "\\", "/", $filename ) );
					break;
			}

		} else {
			$this->setSubmittedValue ( $upload->getError () );
		}

	}

	public function onAfterSaveNewField() {
		$folder = $this->_creation_defaults ['fileupload_destdir'];
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
	}
}
?>