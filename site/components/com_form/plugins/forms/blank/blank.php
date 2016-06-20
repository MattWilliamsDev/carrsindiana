<?php
/**
 * @version $Id: blank.php 147 2009-07-14 20:20:18Z  $
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
 * Class for form templates
 *
 */
class plugins_forms_blank {
	
	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	private $_pname = 'blank';
	
	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	private $_title = 'A Blank form - No fields, actions or configuration ';
	
	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	private $_desc = 'Creates a blank form for you to customise';
	
	/**
	 * The creation defaults for this plugin
	 *
	 * @var array The defaults
	 */
	private $_creation_defaults = array ('published' => '1', 'access' => '0', 'method' => 'POST', 'onlyssl' => '0', 'layout' => 'default', 'showtitle' => '1', 'showresetbutton' => '1', 'submitbuttontext' => 'Submit Form', 'resetbuttontext' => 'Reset', 'formtype' => 'normal', 'accept-charset' => 'UTF-8', 'enctype' => 'multipart/form-data', 'maxsubmissions' => '0', 'maxsubmissionsperuser' => '0', 'useblacklist' => '1', 'showpreviewbutton' => '1', 'target' => '_self',  //
'allowpause' => '1', //
'allowownsubmissionedit' => '1', //  
'allowownsubmissiondelete' => '0' )//
;
	
	public function get($prop) {
		return $this->$prop;
	}
	
	/**
	 * I run the sql to create the form field
	 *
	 */
	public function onAfterCreateForm($formObj) {
		
		/* set creation defaults */
		foreach ( $this->_creation_defaults as $k => $v ) {

			$formObj->$k = $v;
		}
		
		/* mysql safe slug */
		$formObj->slug = bfString::slug4sef ( $formObj->form_name );
		
		/* modify the title if you want */
		$formObj->form_name = $formObj->form_name;
		
		/* save the form config */
		$formObj->store ();
	
	}
}

