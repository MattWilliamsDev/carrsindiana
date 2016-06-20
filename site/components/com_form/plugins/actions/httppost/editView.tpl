 {* 
 * @version $Id: editView.tpl 195 2010-01-12 21:28:21Z  $ 
 * @package Joomla Forms 
 * @subpackage bfFramework 
 * @copyright Copyright (C) 2008 Blue Flame IT Ltd. All rights reserved. 
 * @link http://www.blueflameit.ltd.uk * @author Blue Flame IT Ltd. 
 *}

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
				{bfText}This is the url that you wish to ping with the forms submitted values{/bfText}
				</td>
				<td><input size="100" class="inputbox bfinputbox" type="text"
					value="{$DESC}" name="desc" id="desc" /></td>
			</tr>
		 
		</table>
	</div>
	
	<div id="fragment-2"><!--  Options -->
	 	<table class="bfadminlist">
		     	<tr>
		     		<td><b>{bfText}Send submitted details in the post{/bfText}</b> <br />
		     		{bfText}If you enable this, then after the form is submited, the fields will be validated, and then the system will send all submitted values to the Destination URL (On the general tab) using a HTTP POST behind the scenes.{/bfText}</td>
		     		<td width="150">{$CUSTOM6}</td>
		     	</tr>
		     	<tr>
		     		<td><b>{bfText}Enable Debug Mode{/bfText}</b> <br />
		     		{bfText}If you enable this, then after the form is submited, the results of the post to the API will be shown in a textarea.{/bfText}</td>
		     		<td width="150">{$CUSTOM9}</td>
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