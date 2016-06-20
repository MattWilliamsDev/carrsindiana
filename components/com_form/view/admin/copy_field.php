<?php
/**
 * @version $Id: copy_field.php 147 2009-07-14 20:20:18Z  $
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
$controller->setPageTitle ( bfText::_ ( 'Copy Form Fields' ) );
$controller->setPageHeader ( bfText::_ ( 'Copy Form Fields' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'copy', 'copy', bfText::_ ( 'Process Copy Action' ) );
$toolbar->addButton ( 'cancel', 'cancel', bfText::_ ( 'Cancel and loose changes' ) );
$toolbar->addButton ( 'help', 'help', bfText::_ ( 'Click here to get help' ) );
$toolbar->render ( true );

echo '<h1>' . bfText::_ ( 'Fields to Copy' ) . ' </h1>';

echo '<ul style="margin-left:100px;">';
foreach ( $field ['fieldnames'] as $name ) {
	echo '<li>' . $name . '</li>';
}
echo '</ul>';

echo '<h1>' . bfText::_ ( 'Form to copy fields to' ) . ' </h1>';

echo '<select id="form" name="form">';
foreach ( $form ['rows'] as $form ) {
	echo '<option value="' . $form->id . '">' . $form->form_name . '</option>';
}

echo '</select>';

echo '<input type="hidden" name="fields" id="fields" value="' . base64_encode ( $field ['idstocopy'] ) . '" />';
?>