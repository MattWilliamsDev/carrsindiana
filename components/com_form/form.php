<?php
/**
 * @version $Id: form.php 184 2010-01-03 20:44:13Z  $
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
if (defined ( '_VALID_MOS' ) or defined ( '_JEXEC' )) {
	/* ok we are in Joomla 1.0.x or Joomla 1.5+ */
	if (! defined ( '_VALID_MOS' )) {
		/* We are in Joomla 1.5 */
		if (! defined ( '_VALID_MOS' ))
			define ( '_VALID_MOS', '1' );
		if (! defined ( '_PLUGIN_DIR_NAME' ))
			define ( '_PLUGIN_DIR_NAME', 'plugins' );
		define ( '_BF_PLATFORM', 'JOOMLA1.5' );
	} else if (! defined ( '_JEXEC' )) {
		/* we are in Joomla 1.0 */
		if (! defined ( '_JEXEC' ))
			define ( '_JEXEC', '1' );
		if (! defined ( '_PLUGIN_DIR_NAME' ))
			define ( '_PLUGIN_DIR_NAME', 'mambots' );
		if (! defined ( '_BF_PLATFORM' ))
			define ( '_BF_PLATFORM', 'JOOMLA1.0' );
		if (! defined ( 'JPATH_ROOT' ))
			define ( 'JPATH_ROOT', $GLOBALS ['mosConfig_absolute_path'] );
		if (! defined ( 'DS' ))
			define ( 'DS', DIRECTORY_SEPARATOR );
	} else {
		if (defined ( '_VALID_MOS' ) or defined ( '_JEXEC' )) {
			/* Joomla 1.5 with legacy mode enabled*/
			/* We are in Joomla 1.5 */
			if (! defined ( '_VALID_MOS' ))
				define ( '_VALID_MOS', '1' );
			if (! defined ( '_PLUGIN_DIR_NAME' ))
				define ( '_PLUGIN_DIR_NAME', 'plugins' );
			if (! defined ( '_BF_PLATFORM' ))
				define ( '_BF_PLATFORM', 'JOOMLA1.5' );
		} else {
			die ( 'Unknown Platform- Contact Support' );
		}
	}
	if (! defined ( 'JPATH_SITE' ))
		define ( 'JPATH_SITE', $mosConfig_absolute_path );
	if (! defined ( 'DS' ))
		define ( 'DS', DIRECTORY_SEPARATOR );
	if (! defined ( '_JEXEC' ))
		define ( '_JEXEC', '1' );
	if (! defined ( 'BF_PLATFORM' ))
		define ( 'BF_PLATFORM', 'STANDALONE' );
	if (! defined ( 'JPATH_BASE' ))
		define ( 'JPATH_BASE', $GLOBALS ['mosConfig_absolute_path'] );
	if (! defined ( '_BF_JPATH_BASE' ))
		define ( '_BF_JPATH_BASE', $GLOBALS ['mosConfig_absolute_path'] );
} else {
	header ( 'HTTP/1.1 403 Forbidden' );
	die ( 'Direct access not allowed' );
}

if(function_exists("date_default_timezone_set") and function_exists("date_default_timezone_get"))
@date_default_timezone_set(@date_default_timezone_get());

/* checks */
$cachePath = _BF_JPATH_BASE . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'libs' . DS . 'smarty' . DS . 'templates_c' . DS . 'com_form';
if (! is_writeable ( $cachePath )) {
	@chmod ( $cachePath, 0755 );
}
if (! is_writeable ( $cachePath )) {
	@chmod ( $cachePath, 0775 );
}
if (! is_writeable ( $cachePath )) {
	@chmod ( $cachePath, 0777 );
}
if (! is_writeable ( $cachePath )) {
	echo '<h1>Sorry...</h1>';
	echo '<p>The following folder needs to be writable so that we can enable caching and compiling of the layout templates:<br />';
	echo DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'libs' . DS . 'smarty' . DS . 'templates_c' . DS . 'com_form';
	die ();
}

/* define our components names */
$mainframe->set ( 'component', 'com_form' );
$mainframe->set ( 'component_shortname', 'form' );
$mainframe->set ( 'no_acronyms', 1 );

/* Pull in the bfFramework */
require (_BF_JPATH_BASE . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'bfFramework.php');

/** check the global enable switch **/
if ($registry->getValue ( 'config.enable' ) != 1 && ! bfCompat::isAdmin ()) {
	bfError::raiseError ( '403', 'This component is disabled by config' );
	return;
}

/* Use Google CDN to load jQuery */
//bfDocument::addScript ( 'http://www.google.com/jsapi' );
//$r = <<<JJJJ
//  google.load("jquery", "1");
//  google.load("jqueryui", "1");
//JJJJ;
//bfDocument::addScriptFromString ( $r );


/* Load this components stylesheet */
if (@! defined ( '_BF_FORM_HEAD_SCRIPTS' )) {
	bfDocument::addScriptFromString ( 'var bf_live_site = "' . bfCompat::getLiveSite () . '";' );
	bfDocument::addScriptFromString ( 'var bf_js_options_useblanket = "' . $registry->getValue ( 'config.bf_js_options_useblanket' ) . '";' );
	bfDocument::addscript ( bfCompat::getLiveSite () . '/' . bfCompat::mambotsfoldername () . '/system/blueflame/bfCombine.php?type=js&c=' . $mainframe->get ( 'component_shortname' ) . '&f=mootools' );
	bfDocument::addscript ( bfCompat::getLiveSite () . '/' . bfCompat::mambotsfoldername () . '/system/blueflame/bfCombine.php?type=js&c=' . $mainframe->get ( 'component_shortname' ) . '&f=jquery,bffront_js,front_js' );
	bfDocument::addCSS ( bfCompat::getLiveSite () . '/' . bfCompat::mambotsfoldername () . '/system/blueflame/bfCombine.php?type=css&c=' . $mainframe->get ( 'component_shortname' ) . '&f=bffront_css,front_css' );
	define ( '_BF_FORM_HEAD_SCRIPTS', true );
}

/**
 * Pull in and set up the controller
 * then exec the task for this URI
 */
require $registry->getValue ( 'bfFramework_form.controller.front' );

$controller = new com_formControllerFront ( );
$controller->setArguments ( bfRequest::get ( 'REQUEST' ), false );

/* If the execute cannot find xfoo in the controller it sets view as foo */
$task = bfRequest::getVar ( 'task', 'frontpage' );

/* fix for some corruption in the global vars caused by other extensions */
if ($task == 'view'
	|| $task=='category' // DArn k2 puts task=category in the _SESSION no less!
	)
	$task = 'frontpage';
	
	
$controller->execute ( $task );

/* Deal with the layout/view or just return some xajax actions*/
switch ($controller->getLayout ()) {
	
	case 'xajax' :
	case 'none' :
	case 'text' :
		break;
	
	case "html" :
	case 'view' :
		echo '<div id="com_form"><div id="tag-message" style="display:none;"></div>';
		
		/* we need to echo it as the default is to just return the html */
		if ($controller->getView () != 'BF_ERROR')
			echo $controller->renderView ();
		
		echo '</div>';
		break;
}