<?php
/**
 * @version $Id: customise.php 147 2009-07-14 20:20:18Z  $
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

$controller->setPageTitle ( bfText::_ ( 'Customise' ) );
$controller->setPageHeader ( bfText::_ ( 'Customise' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'help', 'help', bfText::_ ( 'Click here to get help' ) );
$toolbar->render ( true );

/* read the addons out of the framework config file */
$tasks = $registry->getValue ( 'bfFramework_form.Customise.Tasks' );

bfLoad ( 'bfButtons' );

$buttons = new bfButtons ( );

?>
<table class="bfadminlist">
	<thead>
		<tr>
			<th><?php
			echo bfText::_ ( 'Customise Task' );
			?></th>
			<th width="120">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$row = 0;
	foreach ( $tasks as $task ) {
		$buttons = new bfButtons ( 'left', false );
		$buttons->addButton ( 'ok', '\'' . $task [0] . '\', \'' . $task [0] . '\'', 'Go', $task [1] );
		
		/* display the row */
		echo sprintf ( '<tr class="row%s">
		<td><span class="bullet-%s biggerblue indent"><span class="bold">%s</span><br /><small>%s</small></span></td>
		<td valign="top" id="toggle-%s">%s</td>
		</tr>', $row, $task [3], $task [1], $task [2], $task [0], $buttons->display ( true ) );
		
		/* row zebra colors */
		$row = 1 - $row;
	}
	?>
	</tbody>
</table>
