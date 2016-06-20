<?php
/**
 * @version $Id: formconfiguration.php 147 2009-07-14 20:20:18Z  $
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

/* Set the Document HTML's HEAD tag text */
$controller->setPageTitle ( bfText::_ ( 'Edit Form & Page Titles' ) );

/* Set the Page Header */
$controller->setPageHeader ( bfText::_ ( 'Edit Form & Page Titles' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'refresh', 'formconfiguration', bfText::_ ( 'Reload configuration' ) );
$toolbar->addButton ( 'apply', 'apply', bfText::_ ( 'Save &amp; Reload configuration' ) );
$toolbar->addButton ( 'save', 'save', bfText::_ ( 'Save configuration' ) );
$toolbar->addButton ( 'cancel', 'overview', bfText::_ ( 'Cancel and loose changes' ) );
$toolbar->render ( true );

$registry->setValue ( 'usedTabs', 1 );
$tabs = $registry->getValue ( 'bfFramework_' . $mainframe->get ( 'component_shortname' ) . '.form_config_tabs' );
unset ( $tabs->Security );
?>


<div id="bfTabs">


<ul class="ui-tabs-nav">
	<li class=""><a href="#page-general"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/bullet-info.gif"
		align="absmiddle" />&nbsp;General</span></a></li>


</ul>

<?php
$first = '0';
foreach ( $tabs as $tab ) {
	if ($first === '0') {
		$style = 'block';
		$class = ' class="active"';
	} else {
		$style = 'none';
		$class = '';
	}
	?>
	<div
	id="page-<?php
	echo strtolower ( str_replace ( ' ', '', $tab ) );
	?>">
<table class="bfadminlist">

	<tbody>
		<?php
	$k = 0;
	$items = $registry->getValue ( 'bfFramework_' . $mainframe->get ( 'component_shortname' ) . '.form_config_vars' );
	foreach ( $items as $configItem ) {
		if ($configItem [5] == 'Permissions')
			continue;
		if ($configItem [5] == 'Access')
			continue;
		if ($configItem [5] == 'Layout')
			continue;
		if ($configItem [5] == 'Advanced HTML')
			continue;
		if ($configItem [5] == 'EXPERTS ONLY')
			continue;
		if (strtolower ( $configItem [5] ) == strtolower ( $tab )) {
			echo '<tr class="row' . $k . '"><td class="blue"><span class="title bold">';
			echo bfText::_ ( $configItem [1] ) . '</span>';
			echo '<br />' . bfText::_ ( $configItem [6] );
			echo '</td>';
			
			echo '<td width="50%" align="center">' . bfHTML::convertArrayToHTML ( $configItem, $form [$configItem [0]] ) . '</td>';
			echo '</tr>';
			$k = 1 - $k;
		}
	}
	?>
		</tbody>
</table>
</div>
<?php
	$first ++;
}
bfHTML::addHiddenIdField ( $form );
?>
</div>