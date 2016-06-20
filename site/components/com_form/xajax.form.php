<?php
/**
 * @version $Id: xajax.form.php 184 2010-01-03 20:44:13Z  $
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
		define ( 'JPATH_SITE', $GLOBALS ['mosConfig_absolute_path'] );
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

if (_BF_PLATFORM == 'JOOMLA1.5') {
	global $mainframe;
	if ($mainframe->isAdmin ()) {
		/* Register our functions so the xAJAX plugin knows about us */
		$xajaxFunctions [] = 'bf_com_bfform_AdminHandler';
	} else {
		/* Register our functions so the xAJAX plugin knows about us */
		$xajaxFunctions [] = 'bf_com_form_Handler';
	
	}
} else {
	global $mainframe;
	if ($mainframe->isAdmin ()) {
		/* Register our functions so the xAJAX plugin knows about us */
		$xajaxFunctions [] = 'bf_com_bfform_AdminHandler';
	} else {
		/* Register our functions so the xAJAX plugin knows about us */
		$xajaxFunctions [] = 'bf_com_form_Handler';
	
	}
}
/**
 * This handles passing the incoming request to superXMVC and returning XML
 *
 * @return XML
 */
function bf_com_form_Handler() {
	global $mainframe;
	
	define ( '_IS_XAJAX_CALL', '1' );
	define ( 'JPATH_COMPONENT', dirname ( __FILE__ ) );
	
	/* Start object for returning */
	$objResponse = new xajaxResponse ( );
	
	/* define our components names */
	$mainframe->set ( 'component', 'com_form' );
	$mainframe->set ( 'component_shortname', 'form' );
	
	/* Setup our framework */
	include_once (_BF_JPATH_BASE . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'bfFramework.php');
	
	/* Get our arguments */
	$args = @func_get_args ();
	
	$registry->setValue ( 'args', $args );
	
	/* let superXMVC handle our xAJAX controlling */
	require_once (_BF_JPATH_BASE . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'superXMVC.php');
	
	/* Return XML to xAJAX */
	return $objResponse;
}

/**
 * This handles passing the incoming request to superXMVC and returning XML
 *
 * @return XML
 */
function bf_com_bfform_AdminHandler() {
	ini_set ( 'session.bug_compat_42', 0 );
	define ( 'JPATH_COMPONENT', dirname ( __FILE__ ) );
	define ( '_IS_XAJAX_CALL', '1' );
	define ( '_XAJAX_ADMIN', '1' );
	
	$objResponse = new XajaxResponse ( );
	
	global $mainframe;
	
	/* define our components names */
	$mainframe->set ( 'component', 'com_form' );
	$mainframe->set ( 'component_shortname', 'form' );
	
	/**
	 * As this is an admin controller we need to make sure we are logged in
	 * before we allow any xAJAX to take place
	 */
	if (_BF_PLATFORM == 'JOOMLA1.5') {
		/* get the user object */
		$user = JFactory::getUser ();
		/* get the user id =0 if not logged in */
		$userid = $user->get ( 'id' );
	} elseif (_BF_PLATFORM == 'JOOMLA1.0') {
		/* get the userid fm the session */
		global $my;
		$userid = $my->id;
	}
	
	/* We have no session, session expired, or logged out */
	if (! $userid) {
		$objResponse->alert ( 'Your sesion has expired, Please login again. (Err 132)' );
		$objResponse->redirect ( 'index.php?option=logout' );
		/* Return XML to xAJAX - dont go any further */
		return $objResponse;
	}
	
	/* Setup our framework */
	include_once (_BF_JPATH_BASE . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'bfFramework.php');
	
	/* Get our arguments */
	$args = @func_get_args ();
	
	$registry->setValue ( 'args', $args );
	
	/* let superXMVC handle our xAJAX controlling */
	require_once (_BF_JPATH_BASE . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'superXMVC.php');
	
	/* Return XML to xAJAX */
	return $objResponse;
}