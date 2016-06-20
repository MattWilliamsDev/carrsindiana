<?php
/**
 * @version $Id: uploadedfiles.php 147 2009-07-14 20:20:18Z  $
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

$controller->setPageTitle ( bfText::_ ( 'Uploaded Files Manager' ) );
$controller->setPageHeader ( bfText::_ ( 'Uploaded Files Manager' ) );

if (BF_FORMS_DEMO_MODE == TRUE) {
	echo '<h2 style="color:red;">File Uploads disabled in demo mode!</h2>';
}

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );

$toolbar->addButton ( 'delete', 'xdelete', bfText::_ ( 'Click here to delete selected files' ) );
$toolbar->addButton ( 'help', 'xhelp', bfText::_ ( 'Click here to view Help and Support Information' ) );
$toolbar->render ( true );

echo sprintf ( '<h2>%s', bfText::_ ( 'All files are uploaded to the following folder:' ) );
echo '<br />';
echo sprintf ( '<strong>%s</strong></h2>', $file ['folder'] );

echo '<table class="bfadminlist">';

echo "<tr><th width=\"10\">#</th><th>" . bfText::_ ( 'Filename' ) . "</th><th>" . bfText::_ ( 'Size' ) . "</th><th>" . bfText::_ ( 'Date Uploaded' ) . "</th>";
if (count ( $file ['files'] )) {
	foreach ( $file ['files'] as $f ) {
		echo '<tr>';
		
		echo "<td><input type=\"checkbox\" id=\"cid[]\" name=\"cid[]\" onclick=\"isChecked(this.checked);\" value=\"{$f[0]}\" /></td><td>{$f[0]}</td><td>{$f[1]}</td><td>{$f[2]}</td>";
		
		echo '</tr>';
	}
} else {
	echo '<tr>';
	
	echo "<td colspan=\"4\">" . bfText::_ ( 'No Files Uploaded Yet' ) . "</td>";
	
	echo '</tr>';

}
echo '</table>';
?>