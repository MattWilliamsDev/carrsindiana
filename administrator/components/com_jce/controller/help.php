<?php
/**
 * @version		$Id: help.php 107 2011-02-26 16:32:11Z happy_noodle_boy $
 * @package		JCE
 * @copyright	Copyright (C) 2009 Ryan Demmer. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

wfimport('admin.controller');

/**
 * Plugins Component Controller
 *
 * @package		Joomla
 * @subpackage	Plugins
 * @since 1.5
 */
class WFControllerHelp extends WFController
{
	/**
	 * Custom Constructor
	 */
	function __construct( $config = array())
	{		
		parent::__construct($config);
	}
	
	function display()
	{
		parent::display();
	}
}
?>