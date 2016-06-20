 {* 
 * @version $Id: editView.tpl 147 2009-07-14 20:20:18Z  $ 
 * @package Joomla Forms 
 * @subpackage bfFramework 
 * @copyright Copyright (C) 2008 Blue Flame IT Ltd. All rights reserved. 
 * @link http://www.blueflameit.ltd.uk * @author Blue Flame IT Ltd. 
 *}

<div id="bfTabs">
	<ul>
		<li><a href="#fragment-0"><span>{bfText}How To...{/bfText}</span></a></li>
		<li><a href="#fragment-1"><span>{bfText}General{/bfText}</span></a></li>
		<li><a href="#fragment-4"><span>{bfText}Salesforce Generated Code{/bfText}</span></a></li>
		<li><a href="#fragment-5"><span>{bfText}Field Matching{/bfText}</span></a></li>
		<li><a href="#fragment-2"><span>{bfText}Options{/bfText}</span></a></li>
		<li><a href="#fragment-3"><span>{bfText}Permissions{/bfText}</span></a></li>
	</ul>
	
	<div id="fragment-0">
	<table style="margin-left: 40px; margin-top: 20px;" cellpadding="5">
	<tr>
		<td><img src="../plugins/system/blueflame/view/images/step1.png" alt="step1" /></td>
		<td>
		<h2>Login to Salesforce.com and copy the web2lead HTML generated for you</h2>
		<br />
		<p><a href="https://emea.salesforce.com/help/doc/en/setting_up_web-to-lead.htm">Click this link for full instructions</a> from salesforce.com on how to set up web2lead - note point 8 tells you to save the HTML for your "webmaster" - well thats YOU! :-) </p>
		</td>
	</tr>
	<tr>
		<td><img src="../plugins/system/blueflame/view/images/step2.png" alt="step2" /></td>
		<td>
		<h2>Take the HTML from salesforce web2lead and paste it into the box under the Salesforce Generated Code Tab above</h2>
		<br />
		<p></p>
		</td>
	</tr>
	<tr>
		<td><img src="../plugins/system/blueflame/view/images/step3.png" alt="step3" /></td>
		<td>
		<h2>Field Matching</h2>
		<br />
		<p>Go to the "Field Matching" tab above, click the button on the left hand side to pull over the fields from the salesforce generated code, you then need to match the field names from your form to the ones at salesforce so that the right information is submitted to the right fields.</p>
		</td>
	</tr>
	<tr>
		<td><img src="../plugins/system/blueflame/view/images/step4.png" alt="step4" /></td>
		<td>
		<h2>Save and test :-)</h2>
		<br />
		<p></p>
		</td>
	</tr>
	</table>
	</div>
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
		     		<td><b>{bfText}Enable Debug Mode{/bfText}</b> <br />
		     		{bfText}If you enable this, then we will raise the debug flag when posting to sales force.{/bfText}</td>
		     		<td width="150">{$CUSTOM6}</td>
		     	</tr>

	     </table>
	</div>
	
	<div id="fragment-4"><!--  Salesforce code -->
	 	<table class="bfadminlist">
		     	<tr>
		     		<td width="150" valign="top"><b>{bfText}Paste here the generated code from salesforce{/bfText}</b></td>
		     		<td><textarea name="custom5" id="custom5" class="inputbox" style="width:100%;height:600px;">{$CUSTOM5}</textarea></td>
		     	</tr>

	     </table>
	</div>
	
	<div id="fragment-5"><!--  FieldMatching code -->
	 	<table class="bfadminlist">
		     	<tr>
		     		<td width="150" valign="top"><b>{bfText}Match the salesforce fields with the field names in your form{/bfText}</b><br/>
		     		This should be in the format:<br />
		     		salesforcefieldname:ourfieldname<br />
		     		<br />
		     		Example:<br />
		     		city:mycity<br />
		     		00N20000001mf1k:customfield
		     		<br /><br />
		     		<hr/>
		     		<b>Salesforce fieldnames</b>
		     		<br />
		     		<button onclick="bf_form_admin.parseSalesForcew2lfields();return false;">Click here to Grab salesforce fields</button><br />
		     		<span id="sffieldvalues"></span>
		     		
		     		<br />
		     		<hr />
		     		<br />
		     		<b>Our Form Field Names</b>
		     		<br />
		     		{$FIELDS}
		     		</td>
		     		<td><textarea name="custom4" id="custom4" class="inputbox" style="width:100%;height:600px;">{$CUSTOM4}</textarea></td>
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