<div id="bfTabs">
<ul>
	<li><a href="#fragment-1"><span><img src="{$LIB_IMG_URL}bullet-info.gif" align="absmiddle" />&nbsp;{bfText}General{/bfText}</span></a></li>
	<li><a href="#fragment-2"><span><img src="{$LIB_IMG_URL}bullet-wrench.gif" align="absmiddle" />&nbsp;{bfText}Options{/bfText}</span></a></li>
	<li><a href="#fragment-2a"><span><img src="{$LIB_IMG_URL}tick.gif" align="absmiddle" />&nbsp;{bfText}Validation{/bfText}</span></a></li>
	<li><a href="#fragment-2b"><span><img src="{$LIB_IMG_URL}arrow_divide.png" align="absmiddle" />&nbsp;{bfText}Filters{/bfText}</span></a></li>
	<li><a href="#fragment-3"><span><img src="{$LIB_IMG_URL}bullet-secure.gif" align="absmiddle" />&nbsp;{bfText}Permissions{/bfText}</span></a></li>
</ul>
<div id="fragment-1">
<table class="bfadminlist">
	<tr>
		<td><b>{bfText}Friendly Title{/bfText}</b> <br />
		{bfText}This is an internal title and is never shown on the
		site{/bfText}</td>
		<td><input size="100" class="inputbox bfinputbox" type="text"
			value="{$TITLE}" name="title" id="title" /></td>
	</tr>
	<tr>
		<td><b>{bfText}Public Field Title{/bfText}</b> <br />
		{bfText}This is the public title and IS SHOWN on the site{/bfText}</td>
		<td><input size="100" class="inputbox bfinputbox" type="text"
			value="{$PUBLICTITLE}" name="publictitle" id="publictitle" /></td>
	</tr>
	<tr>
		<td><b>{bfText}HTML Field Name{/bfText}</b> <br />

		{bfText}This is the id/name value of the actual HTML element.{/bfText}<br />
		<b>{bfText}MUST NOT start with a number!{/bfText}</b></td>
		<td><input onblur="bf_form_admin.validateFieldSlug();" size="100"
			class="inputbox bfinputbox" type="text" value="{$SLUG}" name="slug"
			id="slug" /><br />
		<b>{bfText}This must be unique in this form, this means you cannot
		have two elements with the same system name!!!<br />
		You should also keep this quite short, for example:
		"lastname"{/bfText}</b></td>
	</tr>
	
</table>
</div>
<div id="fragment-2">
<table class="bfadminlist">
	<tr>
		<td><b>{bfText}Allow default value to be overridden by var in the
		GET{/bfText}</b> <br />
		{bfText}If this is set to YES, then calling a form with a url
		containing &FIELDNAME=myvalue would set the default value to
		myvalue{/bfText}</td>
		<td>{$ALLOWSETBYGET}</td>
	</tr>
	
</table>

</div>
<div id="fragment-2a">

<fieldset><legend>Basic Rules</legend>
<table class="bfadminlist">
	<tr>
		<td><b>{bfText}Required{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to be a required
		field{/bfText}</td>
		<td style="width:180px;">{$REQUIRED}</td>
	</tr>
</table>
</fieldset>


</div>
<div id="fragment-2b">
We validate that the refering page is a valid URL, thats it!
</div>
<div id="fragment-3"><!--  Access -->
<table class="bfadminlist">
	<tr>
		<td><b>{bfText}Joomla Access Level{/bfText}</b> <br />
		{bfText}A visitor needs to be this level or below to see this
		field{/bfText}</td>
		<td>{$ACCESS} <br />
		<b>{bfText}Default: Public{/bfText}<b></td>
	</tr>
	<tr>
		<td><b>{bfText}Publish this field{/bfText}</b> <br />
		{bfText}Toggle this field published/unpublished{/bfText}</td>
		<td>{$PUBLISHED} <br />
		<b>{bfText}Default: Yes{/bfText}<b></td>
	</tr>
	<tr>
		<td><b>{bfText}Allow submitted value to be sent by email{/bfText}</b>
		<br />
		{bfText}If this field contains confidential text and you never want
		this to be sent by email then choose No, and we will only send *****'s
		by email instead{/bfText}</td>
		<td>{$ALLOWBYEMAIL} <br />
		<b>{bfText}Default: Yes{/bfText}<b></td>
	</tr>

</table>

</div>
</div>

<input type="hidden" value="{$ID}" name="id" id="id" />
<input type="hidden" value="{$ORDERING}" name="ordering" id="ordering" />

