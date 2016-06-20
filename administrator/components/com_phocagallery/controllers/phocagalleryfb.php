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
jimport('joomla.application.component.controllerform');

class PhocaGalleryCpControllerPhocaGalleryFb extends JControllerForm
{
	protected	$option 		= 'com_phocagallery';

	protected function allowEdit($data = array(), $key = 'id')
	{
		// Initialise variables.
		$catId	= (int) isset($data['catid']) ? $data['catid'] : 0;
		$user		= JFactory::getUser();
		if ($catId)
		{
			// The category has been set. Check the category permissions.
			return $user->authorise('core.edit', 'com_phocagallery.phocagalleryfb');
		}
		else
		{
			// Since there is no asset tracking, revert to the component permissions.
			return parent::allowEdit($data, $key);
		}
	}
}
?>
