{*
 * @version $Id: editView.tpl 147 2009-07-14 20:20:18Z  $
 * @package Joomla Forms
 * @subpackage bfFramework
 * @copyright Copyright (C) 2008 Blue Flame IT Ltd. All rights reserved.
 * @license see LICENSE.php
 * @link http://www.blueflameit.ltd.uk
 * @author Blue Flame IT Ltd.
*}

<h2 style="color:red;">This action must be placed after all other actions as the process of redirection will prevent any actions after this from fireing</h2>
<div id="bfTabs">
	<ul>
		<li><a href="#fragment-1"><span>{bfText}General{/bfText}</span></a></li>
		<li><a href="#fragment-2"><span>{bfText}Options{/bfText}</span></a></li>
		<li><a href="#fragment-3"><span>{bfText}Permissions{/bfText}</span></a></li>
	</ul>
	<div id="fragment-1">
		<table class="bfadminlist">
			<tr>
				<td><b>{bfText}Friendly Title{/bfText}</b> <br />
				{bfText}This is an internal title and is never shown on the site{/bfText}
				</td>
				<td><input size="100" class="inputbox bfinputbox" type="text"
					value="{$TITLE}" name="title" id="title" /></td>
			</tr>
			
			<tr>
				<td><b>{bfText}Destination URL{/bfText}</b> <br />
				{bfText}This is the url that you wish the user to be redirected to{/bfText}
				</td>
				<td><input size="100" class="inputbox bfinputbox" type="text"
					value="{$DESC}" name="desc" id="desc" /></td>
			</tr>
		 
		</table>
	</div>
	
	<div id="fragment-2"><!--  Options -->
	 	<table class="bfadminlist">
		     	<tr>
		     		<td><b>{bfText}Send submitted details in the redirection{/bfText}</b> <br />
		     		{bfText}If you enable this, then after the form is submited, the fields will be validated, the actions ordered before this one will trigger, and then the system will send all submitted values to the Destination URL (On the general tab) using the method specified below.{/bfText}</td>
		     		<td width="150">{$CUSTOM6}</td>
		     	</tr>
		     	<tr>
		     		<td><b>{bfText}Redirect Method{/bfText}</b> <br />
		     		{bfText}If you select POST, and select yes in the option above, then the redirection will POST all values to the Destination URL.  You can also choose GET if that is required.{/bfText}</td>
		     		<td>{$CUSTOM4}</td>
		     	</tr>
	     </table>
	</div>
	 
	<div id="fragment-3"><!--  Access -->
		<table class="bfadminlist">
		     	<tr>
		     		<td><b>{bfText}Joomla Access Level{/bfText}</b> <br />
		     		{bfText}A visitor needs to be this level or below to trigger this action{/bfText}</td>
		     		<td>{$ACCESS}</td>
		     	</tr>
		     	<tr>
		     		<td><b>{bfText}Publish this action{/bfText}</b> <br />
		     		{bfText}Toggle this action published/unpublished{/bfText}</td>
		     		<td>{$PUBLISHED}</td>
		     	</tr>
	     </table>
	</div>
</div>
 
<input type="hidden" value="{$ID}" name="id" id="id" />
<input type="hidden" value="{$ORDERING}" name="ordering" id="ordering" />