{*
 * @version $Id: editView.tpl 147 2009-07-14 20:20:18Z  $
 * @package Joomla Forms
 * @subpackage bfFramework
 * @copyright Copyright (C) 2008 Blue Flame IT Ltd. All rights reserved.
 * @license see LICENSE.php
 * @link http://www.blueflameit.ltd.uk
 * @author Blue Flame IT Ltd.
*}
<div id="bfTabs">
	<ul>
		<li><a href="#fragment-1"><span>{bfText}General{/bfText}</span></a></li>
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
				<td valign="top"><b>{bfText}Free HTML - Enter your text{/bfText}</b><br />
				{bfText}You can use placeholders which will be replaced with submitted data, placeholders should be the "HTML Field Name" of the field uppercased and preceeded with a dollar sign:{/bfText}<br /><br />
				$LAST_NAME<br />
				$FIRSTNAME</td>
				<td><textarea cols="60" rows="10" class="inputbox bfinputbox"
					name="desc" id="desc">{$DESC}</textarea><br />
				</td>
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