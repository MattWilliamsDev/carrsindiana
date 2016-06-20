<?php
/**
 * @version $Id: submissions.php 149 2009-07-14 22:26:08Z  $
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

error_reporting ( 0 );
$controller->setPageTitle ( bfText::_ ( 'Submissions Manager' ) );
$controller->setPageHeader ( bfText::_ ( 'Submissions Manager' ) );

if (count ( $submission ['rows'] )) {
	/* Create a toolbar, or use a deafult index type toolbar */
	$toolbar = bfToolbar::getInstance ( $controller );
	$toolbar->addButton ( 'edit', 'edit', bfText::_ ( 'Click here to edit selected item' ) );
	$toolbar->addButton ( 'delete', 'remove', bfText::_ ( 'Click here to delete selected items' ) );
	$toolbar->addButton ( 'help', 'xhelp', bfText::_ ( 'Click here to view Help and Support Information' ) );
	$toolbar->render ( true );
	
	$session = bfSession::getInstance ( 'com_form' );
	
	$ifInSession = $session->get ( 'SubmissionIndexFields', array (), 'default' );
	
	$if = array ();
	
	if (! count ( $ifInSession )) {
			$if ['bf_status'] = 'Status';
		$if ['bf_user_id'] = 'User Id';
				$count = 0;
		foreach ( $submission ['rows'] [0] as $k => $v ) {
			if ($k == 'id')
				continue;
			if ($count >= 5)
				continue;
			require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'model' . DS . 'field.php';
			$if [$k] = Field::getFieldName ( str_replace ( 'FIELD_', '', $k ) );
			++ $count;
		}
	
	} else {
		
		foreach ( $ifInSession as $k ) {
			if ($k == 'id')
				continue;
			require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'model' . DS . 'field.php';
			$if [$k] = Field::getFieldName ( str_replace ( 'FIELD_', '', $k ) );
		}
	}
	
	array_unshift ( $if, 'id' );
	?>
<table class="bfadminlist" width="100%">
	<tbody>
		<tr>
			<th colspan="2">
			<h3
				onclick="jQuery('#bftoolbar').toggle();jQuery('#bf_optionsbox').toggle();jQuery('#bf_pagenav_table').toggle();jQuery('#indexTableHTML').toggle();"><?php
	echo bfText::_ ( 'Click Here To Select Columns To Display In This View (Limited to 5 columns)' );
	?>:</h3>
			</th>
		</tr>
	</tbody>
</table>

<table class="bfadminlist" width="100%" style="display: none;"
	id="bf_optionsbox">
	<tbody>
		<?php
	foreach ( $submission ['rows'] [0] as $k => $v ) {
		$selected = '';
		if ($k == 'id')
			continue;
		if (in_array ( $k, $ifInSession ))
			$selected = ' CHECKED';
		
		echo '<tr><td width="10"><input id="' . $k . '" name="' . $k . '" type="checkbox"' . $selected . ' /></td><td>' . Field::getFieldName ( str_replace ( 'FIELD_', '', $k ) ) . '</td><tr>';
		
		
		
	}
	echo '<tr><td width="10"></td><td><input type="button" value="Apply Filter" onclick="bf_form_admin.applyFilterSubmission()" /> or <input type="button" value="Close" onclick="jQuery(\'#bftoolbar\').toggle();jQuery(\'#bf_optionsbox\').toggle();jQuery(\'#bf_pagenav_table\').toggle();jQuery(\'#indexTableHTML\').toggle();" /></td><tr>';
	?>
</tbody>
</table>
<br />
<?php

// Remove Internal values  
//$submissions = array();
//foreach ($submission ['rows'] as $row){
//	if ($row->bf_status != 'Submitted ') continue;
//	unset($row->bf_status);
//	unset($if['bf_status']);
//	unset($row->bf_user_id);
//	unset($if['bf_user_id']);
//	$submissions[] = $row;
//}

	bfHTML::drawIndexTable ( $submission, false, $controller->getView (), $if );
} else {
	echo '<h1>' . bfText::_ ( 'No Submissions - Have you added the SAVE action, and are you sure you have had any submissions?' ) . '</h1>';
}
?>