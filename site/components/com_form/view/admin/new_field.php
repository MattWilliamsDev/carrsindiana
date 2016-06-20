<?php
/**
 * @version $Id: new_field.php 160 2009-07-21 10:49:54Z  $
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

$controller->setPageTitle ( bfText::_ ( 'Create New Form Field' ) );
$controller->setPageHeader ( bfText::_ ( 'Create New Form Field' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'help', 'help', bfText::_ ( 'Click here to get help' ) );
$toolbar->render ( true );

$oplug = Plugins_Fields::getInstance ();
$templates = $oplug->getOptions ();
$registry->setValue ( 'usedTabs', 1 );
if (! count ( $field ['rows'] )) {
	?>
<h1 class="contentheading"><?php
	echo bfText::_ ( 'You currently have no form fields!, Let\'s create your first form field' );
	?>...</h1>
<?php
}
?>
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
		echo bfText::_ ( 'Give your new field a title' );
		?></h2>
		<br />
		<p>
				<?php
				echo bfText::_ ( 'This is the prompt that will be next to the field when the form is displayed, E.g. Please enter your name' );
				?>
				<br />
		<br />
		<b> Form Field Title: <br />
		<input type="text" class="flatinputbox bfinputbox inputbox"
			name="title" id="title" /></b> <br />
		<br />
		<br />
		</p>
		</td>
	</tr>
	<tr>
		<td valign="top"><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step2.png"
			alt="step1" /></td>
		<td>
		<h2><?php
		echo bfText::_ ( 'Select A Field Template' );
		?></h2>
		<br />
		<p>
				<?php
				echo bfText::_ ( 'We have designed some common form fields to get you started, these include all the commonly used form fields, but you will still need to tweak them and add validations in order to build up your form' );
				?>
				<br />
				<br />
				</p>

		<!--  New Tabs Interface  -->

		<div id="bfTabs">
		<ul>
			<li><a href="#fragment-1"><span><?php
			echo bfText::_ ( 'Basic Fields' );
			?></span></a></li>
			<li><a href="#fragment-2"><span><?php
			echo bfText::_ ( 'Prefilled Dropdowns' );
			?></span></a></li>
			<li><a href="#fragment-3"><span><?php
			echo bfText::_ ( 'Joomla Specific' );
			?></span></a></li>
			<li><a href="#fragment-4"><span><?php
			echo bfText::_ ( 'Hidden Fields' );
			?></span></a></li>
			<li><a href="#fragment-5"><span><?php
			echo bfText::_ ( 'Special Fields' );
			?></span></a></li>
				<li><a href="#fragment-6"><span><?php
			echo bfText::_ ( 'Buttons' );
			?></span></a></li>
		</ul>
		<div id="fragment-1">
		<table class="bfadminlist">
			<thead>
				<tr>
					<th></th>
					<th>Element Title</th>
					<th>Descripton</th>
				</tr>
			</thead>
			<tbody>
				<tr class="row0">
					<td><input type="radio" value="textbox" id="template"
						name="template" /></td>
					<td>Textbox</td>
					<td>The most basic form field, the textbox, can be used for many
					things</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="textarea" id="template"
						name="template" /></td>
					<td>Textarea</td>
					<td>The humble textarea, can be used for many things (No WYSIWYG)</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="password" id="template"
						name="template" /></td>
					<td>Password</td>
					<td>A textbox with a password mask, with optional visual password
					strength indicator</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="select" id="template"
						name="template" /></td>
					<td>Select List</td>
					<td>A blank dropdown for your own options</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="checkbox" id="template"
						name="template" /></td>
					<td>Checkboxes</td>
					<td>Single or multiple checkboxes, horizontal and vertical</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="radio" id="template" name="template" /></td>
					<td>Radio Boxes</td>
					<td>Single or multiple Radio Boxes, horizontal and vertical</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="fileupload" id="template"
						name="template" /></td>
					<td>File Upload</td>
					<td>Allow visitors to upload files using this standard file upload
					field</td>
				</tr>
				
			</tbody>
		</table>
		</div>
		<div id="fragment-2">
		<table class="bfadminlist">
			<thead>
				<tr>
					<th></th>
					<th>Element Title</th>
					<th>Descripton</th>
				</tr>
			</thead>
			<tbody>
				<tr class="row0">
					<td><input type="radio" value="selectaustralianstates"
						id="template" name="template" /></td>
					<td>Australian States</td>
					<td>A Select Box pre-populated with all Austrialian states</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="selectcanadianprovince"
						id="template" name="template" /></td>
					<td>Canadian Provinces</td>
					<td>A Select Box pre-populated with all Canadian provinces</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="selectcountries" id="template"
						name="template" /></td>
					<td>All Countries</td>
					<td>A Select Box pre-populated with all known countries</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="selectcurrency" id="template"
						name="template" /></td>
					<td>All Known World Currencies</td>
					<td>A Select Box pre-populated with all known world currencies</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="selectonetohundred" id="template"
						name="template" /></td>
					<td>1 - 100</td>
					<td>A Select Box pre-populated with numbers 1 - 100 (Useful for Age
					fields)</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="selectrating" id="template"
						name="template" /></td>
					<td>Rating</td>
					<td>A Select Box pre-populated with Excellent -> Very Poor for use
					as a rating</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="selecttruefalse" id="template"
						name="template" /></td>
					<td>True/False</td>
					<td>A Select Box pre-populated with True and False options</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="selectusastates" id="template"
						name="template" /></td>
					<td>USA States</td>
					<td>A Select Box pre-populated with all the USA states</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="selectyear" id="template"
						name="template" /></td>
					<td>Years 1900 - 2049</td>
					<td>A Select Box pre-populated with numbers between 1900 - 2049
					(Useful as a Year)</td>
				</tr>
			</tbody>
		</table>
		</div>
		<div id="fragment-3">
		<table class="bfadminlist">
			<thead>
				<tr>
					<th></th>
					<th>Element Title</th>
					<th>Descripton</th>
				</tr>
			</thead>
			<tbody>
				<tr class="row0">
					<td><input type="radio" value="username" id="template"
						name="template" /></td>
					<td>User Name</td>
					<td>Pre-populated with the Logged In Joomla Users name, or NOT
					LOGGED IN if not logged in</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="userid" id="template"
						name="template" /></td>
					<td>User ID</td>
					<td>Pre-populated with the Logged In Joomla Users Id (from #__users
					table), or "0" if not logged in</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="useremailaddress" id="template"
						name="template" /></td>
					<td>User Email Address</td>
					<td>Pre-populated with the Logged In Joomla Users Email Address, or
					blank if not logged in</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="userfullname" id="template"
						name="template" /></td>
					<td>User's Full Name</td>
					<td>Pre-populated with the Logged In Joomla Users Full Name, or
					blank if not logged in</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="ipaddress" id="template"
						name="template" /></td>
					<td>Form Submitters IP Address</td>
					<td>Pre-populated with the IP Address of the visitor</td>
				</tr>

			</tbody>
		</table>
		</div>
		<div id="fragment-4">
		<table class="bfadminlist">
			<thead>
				<tr>
					<th></th>
					<th>Element Title</th>
					<th>Descripton</th>
				</tr>
			</thead>
			<tbody>
				<tr class="row1">
					<td><input type="radio" value="hidden" id="template"
						name="template" /></td>
					<td>[Hidden Field] - Generic Hidden Field</td>
					<td>A generic hidden field for you to populate yourself</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="usernamehidden" id="template"
						name="template" /></td>
					<td>[Hidden Field] - User Name</td>
					<td>A hidden field pre-populated with the Logged In Joomla Users
					name, or NOT LOGGED IN if not logged in</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="useridhidden" id="template"
						name="template" /></td>
					<td>[Hidden Field] - User ID</td>
					<td>A hidden field pre-populated with the Logged In Joomla Users Id
					(from #__users table), or "0" if not logged in</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="useremailaddresshidden"
						id="template" name="template" /></td>
					<td>[Hidden Field] - User Email Address</td>
					<td>A hidden field pre-populated with the Logged In Joomla Users
					Email Address, or blank if not logged in</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="userfullnamehidden" id="template"
						name="template" /></td>
					<td>[Hidden Field] - User's Full Name</td>
					<td>A hidden field pre-populated with the Logged In Joomla Users
					Full Name, or blank if not logged in</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="ipaddresshidden" id="template"
						name="template" /></td>
					<td>[Hidden Field] - Form Submitters IP Address</td>
					<td>A hidden field pre-populated with the IP Address of the visitor</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="referer" id="template"
						name="template" /></td>
					<td>[Hidden Field] - Refering URL or Page Title</td>
					<td>A hidden field pre-populated the refering page's URL or Page Title</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="timestamp" id="template"
						name="template" /></td>
					<td>[Hidden Field] - Submitted Time Stamp</td>
					<td>A hidden field pre-populated with the date/time of submission</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="randomnumber" id="template"
						name="template" /></td>
					<td>[Hidden Field] - Random Number Generated On Submission</td>
					<td>A hidden field pre-populated a random number</td>
				</tr>
				<tr class="row0">
					<td><input type="radio" value="embeddedpagetitle" id="template"
						name="template" /></td>
					<td>[Hidden Field] - Embedded Page Title</td>
					<td>A hidden field pre-populated with the title of the page when a form is embedded in a content item</td>
				</tr>
			</tbody>
		</table>
		</div>
		<div id="fragment-5">
		<table class="bfadminlist">
			<thead>
				<tr>
					<th></th>
					<th>Element Title</th>
					<th>Descripton</th>
				</tr>
			</thead>
			<tbody>
				<tr class="row0">
					<td><input type="radio" value="datepicker" id="template"
						name="template" /></td>
					<td>Date Picker</td>
					<td>A configurable calendar that allows you to pick dates</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="html" id="template" name="template" /></td>
					<td>HTML</td>
					<td>This is not really a form field, but allows you to type any
					html to be displayed</td>
				</tr>
			</tbody>
		</table>
		</div>
		<div id="fragment-6">
		<table class="bfadminlist">
			<thead>
				<tr>
					<th></th>
					<th>Element Title</th>
					<th>Descripton</th>
				</tr>
			</thead>
			<tbody>
			<tr class="row0">
					<td><input type="radio" value="submit" id="template"
						name="template" /></td>
					<td>Submit Button</td>
					<td>A simple, but very needed submit button (Only needed if you are
					using a custom layout)</td>
				</tr>
				<tr class="row1">
					<td><input type="radio" value="pause" id="template"
						name="template" /></td>
					<td>Pause Button</td>
					<td>A pause button to be used in custom layouts</td>
				</tr>
				
			</tbody>
		</table>
		</div>
		</div>

		<!--  /New Tabs Interface  --></td>
	</tr>
	<tr>
		<td valign="top"><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step3.png"
			alt="step1" /></td>
		<td>
		<h2><?php
		echo bfText::_ ( 'Lets Add This!' );
		?></h2>
		<br />
		<p>
				<?php
				echo bfText::_ ( 'Click the create now button below to create this form field and to be redirected to the form fields list' );
				?>
				<br />
		<br />
		<input type="button" onclick="bf_form_admin.createNewField();void(0);"
			value="<?php
			echo bfText::_ ( 'CREATE NOW!');
			?>" /></p>
		</td>
	</tr>
</table>
</div>
