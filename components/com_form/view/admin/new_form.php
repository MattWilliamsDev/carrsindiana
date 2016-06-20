<?php
/**
 * @version $Id: new_form.php 147 2009-07-14 20:20:18Z  $
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

$controller->setPageTitle ( bfText::_ ( 'Create New Form' ) );
$controller->setPageHeader ( bfText::_ ( 'Create New Form' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'help', 'help', bfText::_ ( 'Click here to get help' ) );
$toolbar->render ( true );

$oplug = Plugins_Forms::getInstance ();
$templates = $oplug->getOptions ();

if (! count ( $form ['rows'] )) {
	?>
<h1 class="contentheading"><?php
	echo bfText::_ ( 'You currently have no forms!, Let\'s create your first Form' );
	?>...</h1>
<?php
}
?>

<input type="hidden" name="template" id="template" value="blank" />

<div style="text-align: left; width: 100%;">

<table style="margin-left: 40px; margin-top: 20px;" cellpadding="5">
	<tr>
		<td valign="top"><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step1.png"
			alt="step1" /></td>
		<td>
		<h2><?php
		echo bfText::_ ( 'Give your new form a title' );
		?></h2>
		<br />
		<p>
				<?php
				echo bfText::_ ( 'This is a friendly name for you to refer to this form with, it is never shown to the public and can be changed later' );
				?>
				<br />
		<br />
		<b> Form Title: <br />
		<input type="text" class="flatinputbox bfinputbox inputbox"
			name="form_title" id="form_title" /></b> <br />
		<br />
		<br />
		</p>
		</td>
	</tr>

	<!--<tr>
		<td valign="top"><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step2.png"
			alt="step1" /></td>
		<td>
		<h2><?php
		echo bfText::_ ( 'Select Quick Template (optional)' );
		?></h2>
		<br />
		<p>
				<?php
				echo bfText::_ ( 'We have designed some common form templates to get you started, these include the form fields, but you will still need to tweak them and add form actions to complete the form' );
				?>
				<br />
		<br />
		<b> Form Template: <br />
		</b>
				
				<?php
				$first = true;
				foreach ( $templates as $plugin ) {
					echo sprintf ( '<span style="padding: 20px;"><input type="radio" name="template" id="template" value="%s"%s />&nbsp;&nbsp;<b>%s</b><br /><p style="margin-left: 50px;">%s</p></span>', 

					$plugin->get ( '_pname' ), ($first === true ? ' checked="checked"' : ''), $plugin->get ( '_title' ), $plugin->get ( '_desc' ) );
					$first = false;
				}
				?>
				<br />
		<br />
		<br />
		</p>
		</td>
	</tr>

	-->
	<tr>
		<td valign="top"><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step2.png"
			alt="step2" /></td>
		<td>
		<h2><?php
		echo bfText::_ ( 'Lets get started!' );
		?></h2>
		<br />
		<p>
				<?php
				echo bfText::_ ( 'Click the create now button below to create this form and to be redirected to the form configuration page' );
				?>
				<br />
		<br />
		<input type="button" onclick="bf_form_admin.createNewForm();void(0);"
			value="<?php
			echo bfText::_ ( 'CREATE NOW!' );
			?>" /></p>
		</td>
	</tr>
</table>
</div>