{* 
 * @version $Id: editView.tpl 172 2009-08-25 08:06:09Z  $ 
 * @package Joomla Forms 
 * @subpackage bfFramework 
 * @copyright Copyright (C) 2008 Blue Flame IT Ltd. All rights reserved. 
 * @link http://www.blueflameit.ltd.uk * @author Blue Flame IT Ltd. 
 *}


<div id="bfTabs">
	<ul>
		<li><a href="#fragment-1"><span><img src="{$LIB_IMG_URL}email_open.png" align="absmiddle" />&nbsp;{bfText}Email Header{/bfText}</span></a></li>
		<li><a href="#fragment-1a"><span><img src="{$LIB_IMG_URL}email_go.png" align="absmiddle" />&nbsp;{bfText}Addressing{/bfText}</span></a></li>
		<li><a href="#fragment-2"><span><img src="{$LIB_IMG_URL}email_edit.png" align="absmiddle" />&nbsp;{bfText}Email Content{/bfText}</span></a></li>
		<li><a href="#fragment-2b"><span><img src="{$LIB_IMG_URL}email_link.png" align="absmiddle" />&nbsp;{bfText}Attachments{/bfText}</span></a></li>
		<li><a href="#fragment-4"><span><img src="{$LIB_IMG_URL}user_green.gif" align="absmiddle" />&nbsp;{bfText}Permissions{/bfText}</span></a></li>
		<li><a href="#fragment-test"><span><img src="{$LIB_IMG_URL}server_go.png" align="absmiddle" />&nbsp;{bfText}Mail Server{/bfText}</span></a></li>
		<li><a href="#fragment-gpg"><span><img src="{$LIB_IMG_URL}gpg.png" align="absmiddle" />&nbsp;{bfText}GPG Encryption{/bfText}</span></a></li>
	</ul>
	<div id="fragment-1">
	<table class="bfadminlist">
		<tr>
			<td><b>{bfText}This Actions Friendly Name{/bfText}</b> <br />
			{bfText}This is an internal title and is never shown on the site or
			email{/bfText}</td>
			<td><input size="100" class="inputbox bfinputbox" type="text"
				value="{$TITLE}" name="title" id="title" /></td>
		</tr>
		<tr>
			<td colspan="2">
			<hr size="2" />
			</td>
		</tr>
		<tr>
			<td><b>{bfText}Email Subject Line{/bfText}</b> <br />
			{bfText}This is the subject line of the email{/bfText}</td>
			<td><input size="100" class="inputbox bfinputbox" type="text"
				value="{$EMAILSUBJECT}" name="emailsubject" id="emailsubject" /> <br />
			<b>Example: Submission Results</b></td>
		</tr>
		<tr>
			<td><b>{bfText}Email From Name{/bfText}</b> <br />
			{bfText}This is your real name (not an email address) and is used in
			forming the email's From: header.<br />
			You can also enter the name of a form field where the submitter will put their name.  For example, if your form element was called "myname" then
you should enter #MYNAME# and bfForms will replace this with the submitted value{/bfText}</td>
			<td><input size="100" class="inputbox bfinputbox" type="text"
				value="{$EMAILFROMNAME}" name="emailfromname" id="emailfromname" /> <br />
			<b>Example: Phil Taylor or #FIELDNAME#</b></td>
		</tr>
		<tr>
			<td><b>{bfText}Email From Email Address{/bfText}</b> <br />
			{bfText}This is your real email address and is used in forming the
			email's From: header<br />
			You can also enter the name of a form field where the submitter will put their email address.  For example, if your form element was called "myemail" then
you should enter #MYEMAIL# and bfForms will replace this with the submitted value{/bfText}</td>
			<td><input size="100" class="inputbox bfinputbox" type="text"
				value="{$EMAILFROM}" name="emailfrom" id="emailfrom" /> <br />
			<b>Example: phil@phil-taylor.com or #FIELDNAME#</b></td>
		</tr>
	</table>
	</div>
	<div id="fragment-1a">
	
	
	<table class="bfadminlist">
		<tr>
			<td valign="top" colspan="2"><b>{bfText}How to send emails to the form
			submitter{/bfText}</b> <br />
			{bfText}You might want to send an email to an email address the form
			submitter has entered. To do this simply go back to your form
			elements, and write down the "Name" (HTML Field Name) of the element,
			then enter it in one of these boxes, in uppercase, and surrounded by #
			signs{/bfText} <br />
			<b>Example: <br />
			#EMAILADDRESS# <br />
			or<br />
			#ENTERYOUREMAILHERE# <br />
			or<br />
			#PART_OF_EMAIL_ADDRESS#@yourowndomain.com  (Think out of the box!) 
			</td>
		</tr>
	
		<tr>
			<td valign="top"><b>{bfText}To: A List of Email Addresses{/bfText}</b>
			<br />
			{bfText}These are the email addesses this email will be sent to, using
			the To: part of the email. Note that if you enter more than one email
			in this box they must be one per line, and also each person will see
			the other persons email addresses. To Avoid this use BCC
			instead.{/bfText} <br />
			<b>Example: <br />
			phil@phil-taylor.com <br />
			bill@microsoft.com <br />
			testing@dev.com</b></td>
	
			<td><textarea cols="60" rows="7" class="inputbox bfinputbox"
				name="emailto" id="emailto">{$EMAILTO}</textarea></td>
		</tr>
		<tr>
			<td valign="top"><b>{bfText}CC: A List of Email Addresses{/bfText}</b>
			<br />
			{bfText}These are the email addesses this email will be sent to, using
			the CC: part of the email. Note that if you enter more than one email
			in this box they must be one per line, and also each person will see
			the other persons email addresses. To Avoid this use BCC
			instead.{/bfText} <br />
			<b>Example: <br />
			phil@phil-taylor.com <br />
			bill@microsoft.com <br />
			testing@dev.com</b></td>
	
			<td><textarea cols="60" rows="7" class="inputbox bfinputbox"
				name="emailcc" id="emailcc">{$EMAILCC}</textarea></td>
		</tr>
		<tr>
			<td valign="top"><b>{bfText}BCC: A List of Email Addresses{/bfText}</b>
			<br />
			{bfText}These are the email addesses this email will be sent to, using
			the BCC: part of the email.{/bfText} <br />
			<b>{bfText}Example{/bfText}: <br />
			phil@phil-taylor.com <br />
			bill@microsoft.com <br />
			testing@dev.com</b></td>
	
			<td><textarea cols="60" rows="7" class="inputbox bfinputbox"
				name="emailbcc" id="emailbcc">{$EMAILBCC}</textarea></td>
		</tr>
	
	
	</table>
	</div>
	<div id="fragment-2">
	<table class="bfadminlist">
		<tr>
			<td colspan="2">
			<h2>{bfText}Instructions{/bfText} <small><small><a href="#" onclick="jQuery('#instructions').toggle('slow');">[Hide/Show]</a></small></small></h2>
			<div id="instructions" style="display:none;">
				<p>{bfText}The body of the emails will be parsed by the action to replace
				placeholders with the values the visitor has just submitted{/bfText}.</p>
				<p>{bfText}These placeholders are the HTML Field Name (Name) of the element,
				in uppercase, surrounded by #'s{/bfText}</p>
				<p><br />
				<b>{bfText}Example: Dear #NAME#, Thanks for sending me your address, you
				entered #ADDRESS1#, #ADDRESS2#{/bfText}</b></p>
				<br />
				<h2>{bfText}Current Form Placeholders{/bfText}:</h2>
				<p>
				<ul style="margin-left: 30px;">
					{$PLACEHOLDERS}
				</ul>	
				</p>
				<h2>{bfText}Magic Joomla Vars{/bfText}</h2><p>{bfText}If the user is logged in then you can use the following place holders to 
				access information about the current Joomla User{/bfText}: <br />
				<ul style="margin-left: 30px;">
					<li>#JUSER_MYID#</li>
					<li>#JUSER_MYUSERNAME#</li>
					<li>#JUSER_MYFULLNAME#</li>
					<li>#JUSER_MYEMAIL#</li>
				</ul>
				Other Joomla Vars:<br/>
				<ul style="margin-left: 30px;">
					<li>#J_LIVESITE#   =   {$LIVESITE}</li>
					<li>#J_SITENAME#   =   {$SITENAME}</li>
				</ul>
				<br />
				<h2>{bfText}Magic Generation{/bfText}</h2>
				<p>{bfText}To generate the email content automatically click this button (WARNING: The content in the boxes below will be replaced!) - You will need to do this after adding or removing other form elements{/bfText}
				<br />
				<button onclick="bf_form_admin.generateEmailContents();return false;">{bfText}Generate Email Contents{/bfText}...</button>
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<hr />
			</td>
		</tr>
		<tr>
			<td valign="top"><b>{bfText}Plain Text Email Body{/bfText}</b> <br />
			{bfText}If you would like to send a plain text portion of the email
			please add it here.{/bfText}</td>
			<td><textarea cols="100" rows="7" class="inputbox bfinputbox"
				name="emailplain" id="emailplain">{$EMAILPLAIN}</textarea></td>
		</tr>
	
		<tr>
			<td valign="top"><b>{bfText}HTML Email Body{/bfText}</b><br />
			{bfText}If you would like to send a HTML text portion of the email
			please add it here.(Remember this should include any HTML
			Markup!!){/bfText} <br>
			<p><b>Example:<br />
			&lt;h1&gt;Thankyou!&lt;/h1&gt;&lt;p&gt;Your details have been
			received&lt;/p&gt;</b></p>
			</td>
	
			<td><textarea cols="100" rows="15" class="inputbox bfinputbox"
				name="emailhtml" id="emailhtml">{$EMAILHTML}</textarea></td>
		</tr>
	</table>
	</div>
	<div id="fragment-2b">
	<table class="bfadminlist">
	<tr>
			<td valign="top"><b>{bfText}Send submitted files, which have been uploaded, as attachements to this email{/bfText}</b><br />
			{bfText}This relies on the file upload field having the permission to "send by email" set to yes{/bfText} <br>
			</td>
	
			<td>{$SENDUPLOADEDFILES}</td>
		</tr>
			<tr>
			<td colspan="2" valign="top"><b>{bfText}Attach these files always{/bfText}</b>
			<br />
			{bfText}Specify in this box a list of files you wish to attach every time.  They should be with the full path and file name. E.g. <b>/home/phil/public_html/myreport.pdf</b>.<br /> Enter ONE filename per line.{/bfText} <br />
			</td>
		</tr><tr>
			<td colspan="2"><textarea cols="60" rows="7" class="inputbox bfinputbox"
				style="width:100%;" name="attachments" id="attachments">{$ATTACHMENTS}</textarea></td>
		</tr>
	</table>
	</div>
	<div id="fragment-4"><!--  Access -->
	<table class="bfadminlist">
		<tr>
			<td><b>{bfText}Joomla Access Level{/bfText}</b> <br />
			{bfText}A visitor needs to be this level or below to trigger this
			action{/bfText}</td>
			<td>{$ACCESS}</td>
		</tr>
		<tr>
			<td><b>{bfText}Publish this action{/bfText}</b> <br />
			{bfText}Toggle this action published/unpublished{/bfText}</td>
			<td>{$PUBLISHED}</td>
		</tr>
	
	
	</table>
	
	</div>
	
	<div id="fragment-test"><!--  Access -->
	<table class="bfadminlist">
		<tr>
			<td><b>{bfText}Configuration for outgoing mail{/bfText}</b> <br />
			{bfText}In Joomla, all outgoing email is controlled by the
			configuration options set in your <a
				href="index2.php?option=com_config">Joomla Global Configuration</a>{/bfText}
			<br />
			{bfText}If the configuration you have set in Joomla Global
			Configuration is not compatible with your server then we will never be
			able to send form submissions, Please check with your web host for the
			correct settings{/bfText} <br />
			<b>We highly recommend SMTP with Authentication, as the most reliable
			and secure email transport - ask your web host if this is available to
			you...</b></td>
			<td></td>
		</tr>
	</table>
	
	</div>
	
	<div id="fragment-gpg"><!--  Access -->
	
	<table class="bfadminlist">
		<tr>	
			<td colspan="2">
			<p>
	GnuPG is the GNU project's complete and free implementation of the OpenPGP standard as 
	defined by RFC4880 . GnuPG allows to encrypt and sign your data and communication, 
	features a versatile key managment system with public key directories. GnuPG is also known as GPG. If you want your emails to be encrypted - and very secure - then you might want to <a href="http://www.gnupg.org/">learn more about GPG</a>
	</p>
	<h2>This feature requires PHP version 5.2.1 or greater.</h2>
			</td>
		</tr>
		<tr>
			<td valign="top"><b>{bfText}Public Key To Encrypt To{/bfText}</b>
			<br />If you specify a public key here, and leave the html message blank, opting instead for a plain text message, bfForms will encrypt mail sent with this action to the supplied public key before sending <br />
			
			
			<td><textarea cols="100" rows="100" class="inputbox bfinputbox"
				name="gpgpublickey" id="gpgpublickey">{$GPGPUBLICKEY}</textarea></td>
		</tr>
	</table>
	</div>
</div>

<input type="hidden" value="{$ID}" name="id" id="id" />
<input type="hidden" value="{$ORDERING}" name="ordering" id="ordering" />