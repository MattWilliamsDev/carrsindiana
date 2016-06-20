<?php
/**
 * @version $Id: edit_submission.php 149 2009-07-14 22:26:08Z  $
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
/* @var $controller bfController */
$controller->setPageTitle ( bfText::_ ( 'View Form Submission' ) );
$controller->setPageHeader ( bfText::_ ( 'View Form Submission' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'close', 'cancel', bfText::_ ( 'Cancel and loose changes' ) );
$toolbar->addButton ( 'help', 'help', bfText::_ ( 'Click here to get help' ) );
$toolbar->render ( true );

$fieldmap = array ();

foreach ( $field ['rows'] as $field ) {
	$id = 'FIELD_' . $field->id;
	$value = $field->publictitle;
	$fieldmap [$id] = array ('value' => $value, 'plugin' => $field->plugin );
}

?>
<table class="bfadminlist">
	<tr>
		<th>Field</th>
		<th>Value</th>
	</tr>

<?php
$ig = array ('id', 'published', 'access', 'checked_out', 'bf_status', 'bf_user_id' );
foreach ( $submission as $k => $v ) {
	if (in_array ( $k, $ig ))
		continue;
	switch ($fieldmap [$k] ['plugin']) {
		
		case 'select' :
			$str = '<tr><td>%s</td><td><input style="width:250px" class="inputbox bfinputbox" name="%s" id="%s" value="%s" /></td></tr>';
			echo sprintf ( $str, $fieldmap [$k] ['value'], $k, $k, $v );
			break;
		
		case 'textbox' :
		default :
			$str = '<tr><td>%s</td><td><input style="width:250px" class="inputbox bfinputbox" name="%s" id="%s" value="%s" /></td></tr>';
			echo sprintf ( $str, $fieldmap [$k] ['value'], $k, $k, $v );
			break;
	}

}
?>
</table>
