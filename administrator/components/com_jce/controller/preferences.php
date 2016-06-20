<?php
/**
 * @version		$Id: preferences.php 108 2011-02-26 16:40:33Z happy_noodle_boy $
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

/**
 * Plugins Component Controller
 *
 * @package		Joomla
 * @subpackage	Plugins
 * @since 1.5
 */
class WFControllerPreferences extends WFController
{
	/**
	 * Custom Constructor
	 */
	function __construct( $default = array())
	{		
		parent::__construct();
		
		$this->registerTask( 'apply', 'save' );
	}
	
	function display()
	{
		parent::display();
	}

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or die( 'RESTRICTED' );
		
		wfimport('admin.helpers.component');

		$db =& JFactory::getDBO();	
		
		// get params
		$component 	=& WFComponentHelper::getComponent();
		// create params object from json string
		$params 	= json_decode($component->params);

		$registry = new JRegistry();
		$registry->loadArray(JRequest::getVar('params', '', 'POST', 'ARRAY'));
		// set preference object
		$params->preferences = $registry->toObject();		
		// get component table
		$row =& WFComponentHelper::getTable();
		// set params as JSON string
		$row->params = json_encode($params);

		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		$row->checkin();

		$this->setRedirect('index.php?option=com_jce&view=preferences&tmpl=component&saved=1', WFText::_('WF_PREFERENCES_SAVED'));
	}
}
?>