<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
jimport('joomla.application.component.controllerform');

class PhocaGalleryCpControllerPhocaGalleryImg extends JControllerForm
{
	protected	$option 		= 'com_phocagallery';
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	
	
	protected function allowAdd($data = array())
	{
		// Initialise variables.
		$user		= JFactory::getUser();
		$categoryId	= JArrayHelper::getValue($data, 'catid', JRequest::getInt('filter_category_id'), 'int');
		
		$allow		= null;

		if ($categoryId)
		{
			// If the category has been passed in the URL check it.
			$allow	= $user->authorise('core.create', 'com_phocagallery.phocagalleryimg.'.$categoryId);
		}
		if ($allow === null)
		{
			// In the absense of better information, revert to the component permissions.
			return parent::allowAdd($data);
		}
		else {
			return $allow;
		}
	}


	protected function allowEdit($data = array(), $key = 'id')
	{
		// Initialise variables.
		$categoryId	= (int) isset($data['catid']) ? $data['catid'] : 0;
		$user		= JFactory::getUser();
		if ($categoryId)
		{
			// The category has been set. Check the category permissions.
			return $user->authorise('core.edit', 'com_phocagallery.phocagalleryimg.'.$categoryId);
		}
		else
		{
			// Since there is no asset tracking, revert to the component permissions.
			return parent::allowEdit($data, $key);
		}
	}
	
	/*
	function deletethumbs()
	{
		$cid	= JRequest::getVar( 'cid', array(0), 'get', 'array' );
		
		$model	= &$this->getModel( 'phocagallery' );
		if ($model->deletethumbs($cid[0])) {
			$msg = JText::_( 'COM_PHOCAGALLERY_SUCCESS_THUMBNAIL_DELETE' );
		} else {
			$msg = JText::_( 'COM_PHOCAGALLERY_ERROR_THUMBNAIL_DELETE' );
		}
		
		
		$link = 'index.php?option=com_phocagallery&view=phocagalleryimgs';
		$this->setRedirect($link, $msg);
	}
	*/
	function rotate() {
		$id		= JRequest::getVar( 'id', 0, 'get', 'int' );
		$angle	= JRequest::getVar( 'angle', 90, 'get', 'int' );
		$model	= $this->getModel( 'phocagalleryimg' );
		
		$message 		= '';
		$rotateReturn 	= $model->rotate($id, $angle, $message);
		
		if (!$rotateReturn) {
			$message = PhocaGalleryUtils::setMessage($message, JText::_( 'COM_PHOCAGALLERY_ERROR_IMAGE_ROTATE' ));
		} else {
			$message = JText::_( 'COM_PHOCAGALLERY_SUCCESS_IMAGE_ROTATE' );
		}
		
		$link = 'index.php?option=com_phocagallery&view=phocagalleryimgs';
		$this->setRedirect($link, $message);
	}

	
	/*
	 *if thumbnails are created - show message after creating thumbnails - show that files was saved in database
	 */
	function thumbs() {
		$msg = JText::_( 'COM_PHOCAGALLERY_SUCCESS_SAVE_MULTIPLE' );
		
		$countcat		= JRequest::getVar( 'countcat', 0, 'get', 'int' );
		$countimg		= JRequest::getVar( 'countimg', 0, 'get', 'int' );
		//$imagesid		= JRequest::getVar( 'imagesid', 0, 'get', 'int' );
		
		$link = 'index.php?option=com_phocagallery&view=phocagalleryimgs&countcat='.$countcat.'&countimg='.$countimg.'&imagesid='.md5(time());	
		//$link = 'index.php?option=com_phocagallery&view=phocagalleryimgs';
		$this->setRedirect($link, $msg);
	}
	
	function disablethumbs() {
		$model	= $this->getModel( 'phocagalleryimg' );
		if ($model->disableThumbs()) {
			$msg = JText::_('COM_PHOCAGALLERY_SUCCESS_DISABLE_THUMBS');
		} else {
			$msg = JText::_('COM_PHOCAGALLERY_ERROR_DISABLE_THUMBS');
		}
		$link = 'index.php?option=com_phocagallery&view=phocagalleryimgs';
		$this->setRedirect($link, $msg);
	}
	
	

	function recreate() {
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'COM_PHOCAGALLERY_SELECT_ITEM_RECREATE' ) );
		}
		$message = '';
		$model = $this->getModel( 'phocagalleryimg' );
		if(!$model->recreate($cid, $message)) {
			$message = PhocaGalleryUtils::setMessage($message, JText::_( 'COM_PHOCAGALLERY_ERROR_THUMBS_REGENERATING' ));
		} else {
			$message = JText::_( 'COM_PHOCAGALLERY_SUCCESS_THUMBS_REGENERATING' );
		}

		$this->setRedirect( 'index.php?option=com_phocagallery&view=phocagalleryimgs', $message );
	}

}
?>
