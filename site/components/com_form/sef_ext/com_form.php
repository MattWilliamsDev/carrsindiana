<?php
/**
 * @version $Id: com_form.php 147 2009-07-14 20:20:18Z  $
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
 * THIS IS THE PLUGIN FOR sh404sef
 */

global $sh_LANG, $sefConfig;
$shLangName = '';
$shLangIso = '';
$title = array ();
$shItemidString = '';
$dosef = shInitializePlugin ( $lang, $shLangName, $shLangIso, $option );
if ($dosef == false)
	return;
	
// remove common URL from GET vars list, so that they don't show up as query string in the URL
shRemoveFromGETVarsList ( 'option' );
shRemoveFromGETVarsList ( 'lang' );
if (! empty ( $Itemid ))
	shRemoveFromGETVarsList ( 'Itemid' );

$title [] = 'forms';

/* If a form ID is set then we need the name of the form */
if (isset ( $form_id )) {
	
	/* Get the name of the form */
	$database->setQuery ( 'SELECT page_title FROM #__form_forms WHERE id = "' . ( int ) $form_id . '"' );
	$title [] = $database->loadResult ();
	shRemoveFromGETVarsList ( 'form_id' );

} else {
	$title [] = 'all';
}

if ($dosef) {
	$string = shFinalizePlugin ( $string, $title, $shAppendString, $shItemidString, (isset ( $limit ) ? @$limit : null), (isset ( $limitstart ) ? @$limitstart : null), (isset ( $shLangName ) ? @$shLangName : null) );
}
?>