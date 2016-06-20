<?php
/**
 * @version $Id: preview_submission.php 147 2009-07-14 20:20:18Z  $
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

$registry = bfRegistry::getInstance ( 'com_form', 'com_form' );

/* Call in Smarty to display template */
bfLoad ( 'bfSmarty' );

/* set up smarty vars */
$tmp = bfSmarty::getInstance ( 'com_form' );

/* set the unique compile id */
$tmp->compile_id = 'com_form_form_submission';

/* pass our forms array in */
$f = $controller->getSubmission ();
$items = array ();

foreach ( $f as $item ) {
	if ($item ['type'] == 'hidden')
		continue;
	$items [] = $item;
}

$tmp->assign ( 'fields', $items );
$tmp->assign ( 'FORM_ID', $form['id'] );

$tmp->assign ( 'SUBMITBUTTONTEXT', $form ['submitbuttontext'] );
$tmp->assign ( 'RESETBUTTONTEXT', $form ['resetbuttontext'] );
$tmp->assign ( 'SHOW_RESET_BUTTON', $form ['showresetbutton'] );

/* c4ca4238a0b923820dcc509a6f75849b.php */
$tmp->display ( md5 ( 2 ) . '.php', true );
?>