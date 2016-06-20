<?php
	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	$document = &JFactory::getDocument();
	$document->addScript( 'http://www.google.com/jsapi' );
	
	require( JModuleHelper::getLayoutPath( 'mod_fxprev' ) );
?>