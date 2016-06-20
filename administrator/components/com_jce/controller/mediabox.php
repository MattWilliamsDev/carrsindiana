<?php
/**
 * @version		$Id: mediabox.php 107 2011-02-26 16:32:11Z happy_noodle_boy $
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
class WFControllerMediabox extends WFController
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

		$db 	=& JFactory::getDBO();
		$row 	=& JTable::getInstance('plugin');
		
		$task 	= $this->getTask();

		$query = 'SELECT id FROM #__plugins'
		. ' WHERE element = '. $db->Quote('jcemediabox')
		. ' AND folder = '. $db->Quote('system')
		. ' AND published = 1' 
		. ' LIMIT 1'
		;
		$db->setQuery($query);	
		$id = $db->loadResult();
			
		$row->load($id);
	
		if (!$row->bind(JRequest::get('post'))) {
			JError::raiseError(500, $row->getError() );
		}
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		$row->checkin();
	
		$msg = JText::sprintf( 'WF_MEDIABOX_SAVED' );		
	
		switch ( $task )
		{
			case 'apply':
				$this->setRedirect( 'index.php?option=com_jce&view=mediabox', $msg );
				break;

			case 'save':
			default:
				$this->setRedirect( 'index.php?option=com_jce&view=cpanel', $msg );
				break;
		}
	}
}
?>