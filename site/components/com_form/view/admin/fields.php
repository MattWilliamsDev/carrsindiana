<?php
/**
 * @version $Id: fields.php 147 2009-07-14 20:20:18Z  $
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

$controller->setPageTitle ( bfText::_ ( 'Form Fields' ) );
$controller->setPageHeader ( bfText::_ ( 'Form Fields' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'new', 'add', bfText::_ ( 'Click here to create a new field' ) );
$toolbar->addButton ( 'edit', 'edit', bfText::_ ( 'Click here to edit selected item' ) );
$toolbar->addButton ( 'copy', 'copy', bfText::_ ( 'Click here to copy selected item' ) );
$toolbar->addButton ( 'delete', 'remove', bfText::_ ( 'Click here to delete selected items' ) );
$toolbar->addButton ( 'publish', 'publish', bfText::_ ( 'Click here to publish selected items' ) );
$toolbar->addButton ( 'unpublish', 'unpublish', bfText::_ ( 'Click here to unpublish selected items' ) );
$toolbar->addButton ( 'help', 'xhelp', bfText::_ ( 'Click here to view Help and Support Information' ) );
$toolbar->render ( true );

echo '<span style="float:right" class="info">Tip: To re order the fields, click the column header "Ordering" and then use the arrows</span>';
bfHTML::drawIndexTable ( $field, false, $controller->getView () );

?>