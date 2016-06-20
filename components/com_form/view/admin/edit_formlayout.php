<?php
/**
 * @version $Id: edit_formlayout.php 147 2009-07-14 20:20:18Z  $
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

$controller->setPageTitle ( bfText::_ ( 'Edit Form Layout' ) );
$controller->setPageHeader ( bfText::_ ( 'Edit Form Layout' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'save', 'save', bfText::_ ( 'Click here to save' ) );
$toolbar->addButton ( 'apply', 'apply', bfText::_ ( 'Click here to apply' ) );
$toolbar->addButton ( 'cancel', 'cancel', bfText::_ ( 'Click here to loose changes' ) );
$toolbar->addButton ( 'help', 'help', bfText::_ ( 'Click here to get help' ) );
$toolbar->render ( true );

/** Tell the controller to display editors
 * DISABLED AS WYSIWYG corrupts the HTML
 * */
//$controller->viewHasEditor('html');
$registry->setValue ( 'usedTabs', 1 );

?>

<div id="bfTabs">
<ul>
<?php
if ($form ['layout'] != 'prebuilt') {
	?>
	<li><a href="#fragment-1"><span><img
		src="<?php
	echo _BF_FRAMEWORK_LIB_URL;
	?>/view/images/page.gif"
		align="absmiddle" /><?php
	echo bfText::_ ( 'Layout Options' );
	?></span></a></li>
		<?php
}
?>
	<li
		<?php
		echo ($form ['usecustomtemplate'] == '0') ? ' style="display:none;"' : '';
		?>
		class="custom"><a href="#fragment-2"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/page.gif"
		align="absmiddle" /><?php

		if ($form ['layout'] != 'prebuilt') {
			echo bfText::_ ( 'Custom Smarty Template' );
		} else {
			echo bfText::_ ( 'Custom HTML Form Layout' );
		}
		?></span></a></li>
	<li><a href="#fragment-3"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/page.gif"
		align="absmiddle" /><?php
		echo bfText::_ ( 'Custom CSS' );
		?></span></a></li>
	<li><a href="#fragment-4"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/page.gif"
		align="absmiddle" /><?php
		echo bfText::_ ( 'Custom JS' );
		?></span></a></li>
	<li class=""><a href="#fragment-5"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/page.gif"
		align="absmiddle" />Advanced HTML</span></a></li>
	<li class=""><a href="#fragment-6"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/bullet-wrench.gif"
		align="absmiddle" />&nbsp;EXPERTS ONLY</span></a></li>
</ul>
<?php
if ($form ['layout'] != 'prebuilt') {
	?>
<div id="fragment-1">
<table class="bfadminlist">


	<tr class="row0">
		<td class="blue"><span class="title bold">Use Custom Form Layout</span>
		<br />
		Unless you know what you are doing then leave this set to no. Leaving
		this as no will output a standard xHTML and CSS2 valid form in two
		columns</td>
		<td align="center" width="50%"><?php
	echo bfHTML::yesnoRadioList ( 'usecustomtemplate', ' onchange="jQuery(\'li.custom\').toggle();"', $form ['usecustomtemplate'] );
	?></td>
	</tr>



	<tr class="row1">
		<td class="blue"><span class="title bold">Show the form title as page
		title</span><br />
		</td>
		<td align="center" width="50%">
	<?php
	echo bfHTML::yesnoRadioList ( 'showtitle', '', $form ['showtitle'] );
	?>
</td>
	</tr>
	<?php
	if ($form ['layout'] != 'prebuilt') {
		?>
	<tr class="row0">
		<td class="blue"><span class="title bold">Show the forms reset button</span><br />
		Toggle this to no to stop the reset button showing</td>
		<td align="center" width="50%">
	<?php
		echo bfHTML::yesnoRadioList ( 'showresetbutton', '', $form ['showresetbutton'] );
		?>
</td>
	</tr>
	<tr class="row1">
		<td class="blue"><span class="title bold">Show the forms preview
		button</span><br />
		Toggle this to yes to allow users to preview their submission before
		submitting</td>
		<td align="center" width="50%">
	<?php
		echo bfHTML::yesnoRadioList ( 'showpreviewbutton', '', $form ['showpreviewbutton'] );
		?>
</td>
	</tr>
	<tr class="row0">
		<td class="blue"><span class="title bold">Show the forms submit
		button, when preview button enabled</span><br />
		Toggle this to yes to allow users a choice between preview and submit</td>
		<td align="center" width="50%">
	<?php
		echo bfHTML::yesnoRadioList ( 'showsubmitbutton', '', $form ['showsubmitbutton'] );
		?>
</td>
	</tr>
	<tr class="row1">
		<td class="blue"><span class="title bold">Submit button prompt text</span>
		<br />
		This is the translated text that shows on the forms submit button</td>
		<td align="center" width="50%"><input type="text" class="flatinputbox"
			size="" value="<?php
		echo $form ['submitbuttontext'];
		?>"
			id="submitbuttontext" name="submitbuttontext" /></td>
	</tr>
	<tr class="row0">
		<td class="blue"><span class="title bold">Submit reset prompt text</span><br />
		This is the translated text that shows on the forms reset button</td>
		<td align="center" width="50%"><input type="text" class="flatinputbox"
			size="" value="<?php
		echo $form ['resetbuttontext'];
		?>"
			id="resetbuttontext" name="resetbuttontext" /></td>
	</tr>
<?php
	}
	?>
</table>
</div>
<?php
}

?>
<div id="fragment-2">
<table class="bfadminlist">
	<tr>
		<td>
<?php
if ($form ['layout'] != 'prebuilt') {
	?>
<span class="title bold">Custom Smarty Template</span><br />
		Dont worry about the code! We will top and tail your layout below with
		xHTML Valid and CSS2 Valid markup to ensure the form actually works -
		all you need to concentrate on is creating a layout that contains the
		place holders for your form fields, titles and descriptions<br />
		Here are your available placeholders:<br />
<?php
	foreach ( $field ['rows'] as $f ) {
		echo bfString::strtoupper ( ' {$' . $f->slug . '_title}' ) . '      ' . bfString::strtoupper ( ' {$' . $f->slug . '_desc}' ) . "      " . bfString::strtoupper ( ' {$' . $f->slug . '_element}' ) . "<br />";
	}
} else {
	?>


<span class="title bold">Custom Form Layout</span><br />
		<p>Paste into the box below your prebuilt HTML from another editor,
		then press the "Parse Form" button in order to AUTOMATICALLY set up
		form fields in bfForms and then to AUTOMATICALLY replace your form
		elements with those placeholders - this wizard is fantastic (we think
		so!).</p>
		<br />
		<strong>If you edit this template at any time, or add/remove
		placeholders then click Parse Form again to reconfigure your form
		fields</strong> <br />
		<br />
		<p>You can move around placeholders at any time, and click save</p>

	<?php

	if (count ( $field ['rows'] ))
		echo bfText::_ ( 'Here are your available placeholders (if any):' ) . '<br />';
	foreach ( $field ['rows'] as $f ) {
		echo bfString::strtoupper ( ' {$' . $f->slug . '_title}' ) . '      ' . bfString::strtoupper ( ' {$' . $f->slug . '_desc}' ) . "      " . bfString::strtoupper ( ' {$' . $f->slug . '_element}' ) . "<br />";
	}
	?>



<?php
}
?>


<button style="margin-top: 20px; padding: 10px;"
			onclick="bf_form_admin.parseCustomForm();return false;"><?php
			echo bfText::_ ( 'Parse Form' );
			?></button>
		<button style="margin-top: 20px; padding: 10px;"
			onclick="bf_form_admin.createCustomForm();return false;"><?php
			echo bfText::_ ( 'Create Basic Layout (Overwrite ALL Changes)' );
			?></button>

		</td>
	</tr>
	<tr>
		<td><textarea style="width: 100%; height: 500px;" id="custom_smarty"
			name="custom_smarty"><?php
			echo $form ['custom_smarty'];
			?></textarea></td>
	</tr>
</table>
</div>
<div id="fragment-3">
<table class="bfadminlist">
	<tr>
		<td>Custom CSS - Put any CSS here you want us to add to the page</td>
	</tr>
	<tr>
		<td><textarea style="width: 100%; height: 500px;" id="custom_css"
			name="custom_css"><?php
			echo $form ['custom_css'];
			?></textarea></td>
	</tr>
</table>
</div>
<div id="fragment-4">
<table class="bfadminlist">
	<tr>
		<td>Custom JS - Put any JS here you want us to add to the page (no
		need for the &gt;script&lt; tags - we will add those!</td>
	</tr>
	<tr>
		<td><textarea style="width: 100%; height: 500px;" id="custom_js"
			name="custom_js"><?php
			echo $form ['custom_js'];
			?></textarea></td>
	</tr>
</table>
</div>
<div id="fragment-5">
<table class="bfadminlist">

	<tbody>
		<?php
		$k = 0;
		$items = $registry->getValue ( 'bfFramework_' . $mainframe->get ( 'component_shortname' ) . '.form_config_vars' );
		foreach ( $items as $configItem ) {
			if ($configItem [5] != 'Advanced HTML')
				continue;
			echo '<tr class="row' . $k . '"><td class="blue"><span class="title bold">';
			echo bfText::_ ( $configItem [1] );
			echo '</span><br />' . bfText::_ ( $configItem [6] );
			echo '</td><td width="50%" align="center">' . bfHTML::convertArrayToHTML ( $configItem, $form [$configItem [0]] ) . '</td></tr>';
			$k = 1 - $k;
		}
		?>
		</tbody>
</table>
</div>
<div id="fragment-6">
<table class="bfadminlist">

	<tbody>
		<?php
		$k = 0;
		$items = $registry->getValue ( 'bfFramework_' . $mainframe->get ( 'component_shortname' ) . '.form_config_vars' );
		foreach ( $items as $configItem ) {
			if ($configItem [5] != 'EXPERTS ONLY')
				continue;
			echo '<tr class="row' . $k . '"><td class="blue"><span class="title bold">';
			echo bfText::_ ( $configItem [1] );
			echo '</span><br />' . bfText::_ ( $configItem [6] );
			echo '</td><td width="50%" align="center">' . bfHTML::convertArrayToHTML ( $configItem, $form [$configItem [0]] ) . '</td></tr>';
			$k = 1 - $k;
		}
		?>
		</tbody>
</table>
</div>
</div>

<?php
bfHTML::addHiddenIdField ( $form );
?>




