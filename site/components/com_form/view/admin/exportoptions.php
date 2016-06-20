<?php
/**
 * @version $Id: exportoptions.php 147 2009-07-14 20:20:18Z  $
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

$controller->setPageTitle ( bfText::_ ( 'Export Options' ) );
$controller->setPageHeader ( bfText::_ ( 'Export Options' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'help', 'xhelp', bfText::_ ( 'Click here to view Help and Support Information' ) );
$toolbar->render ( true );

$session = bfSession::getInstance ( 'com_form' );
$form = ( int ) $session->get ( 'lastFormId', '', 'default' );
?>

<ul class="export-options">
	<li><a target="_new"
		href="index2.php?option=com_form&form_id=<?php
		echo $form;
		?>&task=export&tmpl=component&no_html=1&exportType=1"><?php
		echo bfText::_ ( 'Backup/Export Form, Fields and Actions Configuration to XML' );
		?></a>
	<br />
	<small>
	<?php
	echo bfText::_ ( 'Note that this cannot be imported or restored, it is purely for reference purposes at the moment' );
	?>
	</small></li>
	<li><a target="_new"
		href="index2.php?option=com_form&form_id=<?php
		echo $form;
		?>&task=export&tmpl=component&no_html=1&exportType=4"><?php
		echo bfText::_ ( 'Export Form Submissions to XML' );
		?></a></li>
	<li><a target="_new"
		href="index2.php?option=com_form&form_id=<?php
		echo $form;
		?>&task=export&tmpl=component&no_html=1&exportType=5"><?php
		echo bfText::_ ( 'Export Form Submissions to CSV' );
		?></a></li>
	<li><a target="_new"
		href="index2.php?option=com_form&form_id=<?php
		echo $form;
		?>&task=export&tmpl=component&no_html=1&exportType=7"><?php
		echo bfText::_ ( 'Export Form Submissions to CSV (Microsoft Excel Specific Encoding)' );
		?></a></li>
</ul>