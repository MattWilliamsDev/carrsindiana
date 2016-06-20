<?php
/**
 * @version $Id: edit_field.php 147 2009-07-14 20:20:18Z  $
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

/* set the page titles */
$controller->setPageTitle ( bfText::_ ( 'Edit Form Field' ) . '  (' . $field ['plugin'] . ')' );
$controller->setPageHeader ( bfText::_ ( 'Edit Form Field' ) . '  (' . $field ['plugin'] . ')' );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'apply', 'apply', bfText::_ ( 'Save &amp; Reload configuration' ) );
$toolbar->addButton ( 'save', 'save', bfText::_ ( 'Save configuration' ) );
$toolbar->addButton ( 'cancel', 'cancel', bfText::_ ( 'Cancel and loose changes' ) );
$toolbar->addButton ( 'help', 'help', bfText::_ ( 'Click here to get help' ) );
$toolbar->render ( true );

/* grab a fold prefix */
$prefix = bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'fields' . DS;

/* require the fields main class */
require_once $prefix . $field ['plugin'] . DS . $field ['plugin'] . '.php';

/* calc the class name */
$class = 'plugins_fields_' . $field ['plugin'];

/* start her up! */
$plug = new $class ( );

/* pass in the current field configuration */
$plug->setConfig ( $field );

/* draw the smarty template */
$plug->_editFieldView ( $field );
?>