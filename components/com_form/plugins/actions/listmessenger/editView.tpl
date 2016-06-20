 {* 
 * @version $Id: editView.tpl 147 2009-07-14 20:20:18Z  $ 
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
		</table>
	</div>
	
	<div id="fragment-2"><!--  Options -->
	 	<table class="bfadminlist">
		     	<tr>
		     		<td valign="top"><b>{bfText}Groups To Subscribe To{/bfText}</b> <br />
		     		{bfText}Select the group you want the submitter to be signed up to.{/bfText}</td>
		     		<td width="50%">{$CUSTOM5}</td>
		     	</tr>
		     	<tr>
		     		<td><b>{bfText}Subscribe/Unsubscribe Action{/bfText}</b> <br />
		     		{bfText}Which action do you want to perform.{/bfText}</td>
		     		<td>{$CUSTOM6}</td>
		     	</tr>
				<tr>
		     		<td><b>{bfText}Which field contains the persons FIRSTNAME?{/bfText}</b></td>
		     		<td>{$EMAILFROM}</td>
		     	</tr>
		     	<tr>
		     		<td><b>{bfText}Which field contains the persons LASTNAME?{/bfText}</b></td>
		     		<td>{$EMAILFROMNAME}</td>
		     	</tr>
		     	<tr>
		     		<td><b>{bfText}Which field contains the persons EMAILADDRESS?{/bfText}</b></td>
		     		<td>{$EMAILTO}</td>
		     	</tr>
		     	
	     </table>

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