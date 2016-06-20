<?php
/**
 * @version $Id: form.php 184 2010-01-03 20:44:13Z  $
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

class Form extends bfModel {

	/**
	 * @var
	 * I do lots of stuff with direct access to tables so need to
	 * know when I'm in test mode.
	 */
	public $_mode;

	public $_nometa = true;

	/**
	 * PHP5 Constructor
	 * I set up the table name, the ORM and the search fields
	 */
	public function __construct() {

		parent::__construct ( '#__form_forms' );

		$this->_search_fields = array ('id', 'form_name' );

		// Am I in test mode?
		$session = bfSession::getInstance ();
		$this->_mode = $session->get ( 'mode' );
	}

	/**
	 * I save the form configuration
	 *
	 */
	public function saveDetails() {

		/* save to database */
		parent::saveDetails ();

		/* create slug - for sef link */
		$this->slug = $this->_createSlug ();

		/* clean up the custom layout */
		if (strlen ( $this->custom_smarty ) > 10) {
			if (! preg_match ( '/FORM_OPEN_TAG/', $this->custom_smarty )) {
				$this->custom_smarty = '{$FORM_OPEN_TAG}' . "\n" . $this->custom_smarty;
			}
			if (! preg_match ( '/FORM_CLOSE_TAG/', $this->custom_smarty )) {
				$this->custom_smarty = $this->custom_smarty . "\n" . '{$FORM_CLOSE_TAG}';
			}
		}

		$this->store ();
	}

	/**
	 * I delete a form
	 *
	 */
	public function delete($id) {

		parent::delete ( $id );

		/* remove data table */
		$this->_deleteUserTable ( $id );
		$this->_deleteFormFields ( $id );
		$this->_deleteFormActions ( $id );
		$this->_deleteFormSubmissionTracking ( $id );
	}

	private function _deleteFormFields($id) {

		$this->_db->setQuery ( 'DELETE FROM #__form_fields WHERE form_id = "' . ( int ) $id . '"' );
		$this->_db->query ();

	}

	/**
	 * I delete all the form fields when a form is deleted
	 *
	 * @param int $id The form Id
	 */
	private function _deleteFormActions($id) {

		$this->_db->setQuery ( 'DELETE FROM #__form_actions WHERE form_id = "' . ( int ) $id . '"' );
		$this->_db->query ();
	}

	/** I delete all the form fields when a form is deleted
	 *
	 * @param int $id The form Id
	 */
	private function _deleteFormSubmissionTracking($id) {

		$this->_db->setQuery ( 'DELETE FROM #__form_submission_trackings WHERE form_id = "' . ( int ) $id . '"' );
		$this->_db->query ();
	}

	/**
	 * I create a new form  record
	 *
	 * @param int $id the Form id
	 */
	public function createNewForm($title, $template) {

		$needstitle = $title ? false : true;

		/* egt user object */
		$user = bfUser::getInstance ();

		/* set created by */
		$this->created_by = ( int ) $user->get ( 'id' );
		$this->touchCreatedDate ();
		$this->template = $template;
		$this->form_name = $title;
		$this->page_title = $title;

		/* check we have a title */
		if ($needstitle === false) {
			$this->form_name = $title;
			$this->page_title = $title;
		}

		/* save new field */
		$this->saveDetails ();

		/* update the form user table */
		$this->hasusertable = '#__form_submitteddata_form' . ( int ) $this->id;

		if ($needstitle === true) {
			$this->form_name = 'My New Form ' . ( int ) $this->id;
			$this->page_title = $title;
		}

		/* save again - daft! */
		$this->saveDetails ();
		$this->_checkForDBErrors ();

		/* create the submission data table */
		$this->_createUserTable ();

		$this->_checkForDBErrors ();

		$this->_assignTemplates ();
		/* return the field id */
		return $this->id;
	}

	private function _assignTemplates() {
		$path = bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'layouts' . DS . 'default' . DS;

		$css = file_get_contents ( $path . 'default.css' );
		$html = file_get_contents ( $path . 'default.tpl' );
		$js = file_get_contents ( $path . 'default.js' );

	}

	/**
	 * I create the submissions data table
	 *
	 */
	private function _createUserTable() {

		bfLoad ( 'bfDBUtils' );
		$sql = 'CREATE TABLE IF NOT EXISTS `#__form_submitteddata_form' . ( int ) $this->id . '` (`id` INT( 11 ) NOT NULL AUTO_INCREMENT, `bf_status` VARCHAR(20) NOT NULL, `bf_user_id` INT(11) NOT NULL ,PRIMARY KEY ( `id` )) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin';
		$sql = bfDBUtils::makeCompatible ( $sql );
		$this->_db->setQuery ( $sql );
		$this->_db->query ();
	}

	/**
	 * I remove the forms submissions data table
	 *
	 * @param int $id
	 */
	private function _deleteUserTable($id) {

		$sql = 'DROP TABLE `#__form_submitteddata_form' . ( int ) $id . '`';
		$this->_db->setQuery ( $sql );
		$this->_db->query ();
	} // Normal FE case


	public function get($id, $md5 = false) {

		if ($md5 === true) {
			$this->_db->setQuery ( 'SELECT * FROM #__form_forms WHERE md5(id) = "' . $id . '"' );
			$form = $this->_db->LoadObjectList ();

			foreach ( $form [0] as $k => $v ) {
				$this->$k = $v;
			}

		} else {
			parent::get ( $id );
			unset ( $this->log );
		}

		/* clean up the custom layout */
		if (strlen ( $this->custom_smarty ) > 10) {
			if (! preg_match ( '/FORM_OPEN_TAG/', $this->custom_smarty )) {
				$this->custom_smarty = '{$FORM_OPEN_TAG}' . "\n" . $this->custom_smarty;
			}
			if (! preg_match ( '/FORM_CLOSE_TAG/', $this->custom_smarty )) {
				$this->custom_smarty = $this->custom_smarty . "\n" . '{$FORM_CLOSE_TAG}';
			}
			$this->store ();
		}
	}

	public function getAll($where = '', $apply_limit = false, $orderby = null) {
		parent::getAll ( $where, $apply_limit, $orderby );

		foreach ( $this->rows as $row ) {

			$this->_db->setQuery ( 'SELECT count(*) FROM #__form_actions WHERE form_id = "' . (int)$row->id . '"' );
			$row->countactions = $this->_db->LoadResult ();
			$this->_db->setQuery ( 'SELECT count(*) FROM #__form_fields WHERE form_id = "' .(int) $row->id . '"' );
			$row->countfields = $this->_db->LoadResult ();
			$this->_db->setQuery ( 'SELECT count(*) FROM #__form_submitteddata_form' .(int) $row->id . '' );
			$row->countsubmissions = $this->_db->LoadResult ();


		}
	}

	public function getForViewing($id) {

		parent::get ( $id );
		$fields = $this->_getModel ( 'field' );
		$this->fields = $fields->getForViewing ( $id );
		if (! count ( $this->fields ))
			throw new Exception ( 'No fields in this form or form id=' . $id . ' doesnt exist!' );

	}

	public function getActionsToProcess() {
		$user = bfUser::getInstance ();
		$ac = $this->_getModel ( 'action' );
		$actions = $ac->getAllWhere ( '
          form_id = "' . ( int ) $this->id . '"
          AND access <= "' . ( int ) $user->get ( 'aid' ) . '"
          AND published = 1
          ', false, 'ordering ASC' );
		return $actions;
	}

	public function getFieldsToProcess() {
		$user = bfUser::getInstance ();
		$ac = $this->_getModel ( 'field' );
		$fields = $ac->getAllWhere ( '
          form_id = "' . ( int ) $this->id . '"
          AND access <= "' . ( int ) $user->get ( 'aid' ) . '"
          AND plugin != "html"
          AND published = 1
          ', false, 'ordering ASC' );
		return $fields;
	}

	/**
	 * I get the list of form names and id's to display on the frontpage
	 * if no form_id is specified
	 *
	 */
	function getEnabledFormsForFrontpage() {

		/* get the current user object */
		$user = bfUser::getInstance ();

		/* build the sql */
		$sql = "SELECT id, page_title FROM #__form_forms WHERE published = '1' AND access <= '" . ( int ) $user->get ( 'aid' ) . "'";

		/* set the query */
		$this->_db->setQuery ( $sql );

		/* return the result */
		$this->rows = $this->_db->loadObjectList ();
	}

	function _createSlug() {

		bfLoad ( 'bfUTF8' );
		$utf = new bfUtf8 ( );

		/**
		 *
		 *
		 */
		$unPretty = array ('/á/', '/é/', '/í/', '/ó/', '/ú/', '/Á/', '/É/', '/Í/', '/Ó/', '/Ú/', '/ñ/', '/Ñ/', '/ü/', '/Ü/', '/ / ', '/í/', '/ñ/', '/\!/', '/\?/', '/:/', '/ä/', '/ö/', '/ü/', '/Ä/', '/Ö/', '/Ü/', '/ß/', '/\s?-\s?/', '/\s?_\s?/', '/\s?\/\s?/', '/\s?\\\s?/', '/\s/', '/"/', '/\'/' );
		$pretty = array ('/a/', '/e/', '/i/', '/o/', '/u/', '/A/', '/E/', '/I/', '/O/', '/U/', '/n/', '/N/', '/u/', '/U/', '_', 'i', 'n', '', '', '', 'ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss', '_', '_', '_', '_', '_', '', '' );

		$str = $utf->utf8ToHtmlEntities ( strtolower ( preg_replace ( $unPretty, $pretty, $this->form_name ) ) );
		return str_replace ( ' ', '_', $str );
	}

	/**
	 * I update the statistics :-)
	 */
	public function recordSubmission($isSpam = false) {
		switch ($isSpam) {
			case true :
				$sql = 'UPDATE #__form_forms SET count_spamsubmissions = count_spamsubmissions+1 WHERE id = "' . ( int ) $this->id . '"';
				break;

			case false :
				$sql = 'UPDATE #__form_forms SET count_oksubmissions = count_oksubmissions+1 WHERE id = "' . ( int ) $this->id . '"';
				break;
		}

		$this->_db->setQuery ( $sql );
		$this->_db->query ();

	}
}
?>