<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined('_JEXEC') or die;
if (!JFactory::getUser()->authorise('core.manage', 'com_phocagallery')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
if (! class_exists('PhocaGalleryLoader')) {
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'libraries'.DS.'loader.php');
}

require_once( JPATH_COMPONENT.DS.'controller.php' );
phocagalleryimport('phocagallery.utils.utils');
phocagalleryimport('phocagallery.path.path');
phocagalleryimport('phocagallery.file.file');
phocagalleryimport('phocagallery.file.filethumbnail');
phocagalleryimport('phocagallery.file.fileupload');
phocagalleryimport('phocagallery.render.renderadmin');
phocagalleryimport('phocagallery.text.text');
phocagalleryimport('phocagallery.render.renderprocess');
phocagalleryimport('phocagallery.html.grid');
phocagalleryimport('phocagallery.html.category');

jimport('joomla.application.component.controller');

$controller	= JController::getInstance('PhocaGalleryCp');

$controller->execute(JRequest::getCmd('task'));

$controller->redirect();


?>