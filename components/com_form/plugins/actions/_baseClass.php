 <?php
/**
 * @version $Id: _baseClass.php 165 2009-08-02 20:37:23Z  $
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

/**
 * Base Class for form actions
 *
 */
class plugins_actions_base {
	
	public function __construct() {
		
		$session = bfSession::getInstance ( 'com_form' );
		/* set the correct form id */
		$this->_creation_defaults ['form_id'] = $session->get ( 'lastFormId', '', 'default' );
	
	}
	
	/**
	 * I run the sql to create the form field 
	 */
	public function onAfterCreateAction(&$actionObj) {
		
		if (method_exists ( $this, 'update_creation_defaults' )) {
			$this->update_creation_defaults ();
		}
		
		/* set creation defaults */
		foreach ( $this->_creation_defaults as $k => $v ) {
			$actionObj->$k = $v;
		}
		
		/* check we have a title */
		if (! $actionObj->title) {
			$actionObj->title = 'My New Form Action ' . $actionObj->id;
		}
		
		/* set created deate */
		$actionObj->touchCreatedDate ();
		
		/* store changes */
		$actionObj->store ();
	}
	
	/**
	 * I set the configuration for this action
	 * I set the submitted values
	 *
	 * @param object $config
	 * @param object $clean [whatisyourname] => Array ( [field_id] => 12 [submission] => r )
	 */
	public function setConfig($config = null, $clean = null) {
		
		if (is_object ( $config )) {
			$arr = array ();
			foreach ( $config as $k => $v ) {
				$arr [$k] = $v;
			}
			$config = $arr;
		}
		
		if (null == ! $config)
			$this->_config = $config;
		
		if (null == ! $clean)
			$this->submittedData = $clean;
	
	}
	
	public function replacePlaceholders($data, $str) {
		
		$user = bfUser::getInstance ();
		$str = str_replace ( '$' . ('JOOMLA_USERNAME') . '', $user->get ( 'username' ), $str );
		$str = str_replace ( ':' . ('JOOMLA_USERNAME') . ':', $user->get ( 'username' ), $str );
		$str = str_replace ( '#' . ('JOOMLA_USERNAME') . '#', $user->get ( 'username' ), $str );
		$str = str_replace ( '$' . ('JOOMLA_NAME') . '', $user->get ( 'name' ), $str );
		$str = str_replace ( ':' . ('JOOMLA_NAME') . ':', $user->get ( 'name' ), $str );
		$str = str_replace ( '#' . ('JOOMLA_NAME') . '#', $user->get ( 'name' ), $str );
		$str = str_replace ( '$' . ('JOOMLA_EMAIL') . '', $user->get ( 'email' ), $str );
		$str = str_replace ( ':' . ('JOOMLA_EMAIL') . ':', $user->get ( 'email' ), $str );
		$str = str_replace ( '#' . ('JOOMLA_EMAIL') . '#', $user->get ( 'email' ), $str );
		
		foreach ( $data as $k => $v ) {
			
			if (is_string ( $k ) && is_string ( $v ['submission'] ))
				$str = str_replace ( '$' . strtoupper ( $k ) . '', $v ['submission'], $str );
			$str = str_replace ( ':' . strtoupper ( $k ) . ':', $v ['submission'], $str );
			$str = str_replace ( '#' . strtoupper ( $k ) . '#', $v ['submission'], $str );
		}
		return $str;
	}
}
?>