<div id="bfTabs">
<ul>
	<li><a href="#fragment-1"><span><img src="{$LIB_IMG_URL}bullet-info.gif" align="absmiddle" />&nbsp;{bfText}General{/bfText}</span></a></li>
	<li><a href="#fragment-2"><span><img src="{$LIB_IMG_URL}bullet-wrench.gif" align="absmiddle" />&nbsp;{bfText}Options{/bfText}</span></a></li>
	<li><a href="#fragment-3"><span><img src="{$LIB_IMG_URL}bullet-secure.gif" align="absmiddle" />&nbsp;{bfText}Permissions{/bfText}</span></a></li>
	<li><a href="#fragment-4"><span><img src="{$LIB_IMG_URL}style.png" align="absmiddle" />&nbsp;{bfText}Style{/bfText}</span></a></li>
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
		<td><b>{bfText}Text for the submit button to show{/bfText}</b> <br />
		{bfText}This value will be the text on the submit button{/bfText}</td>
		<td><input size="100" class="inputbox bfinputbox" type="text"
			value="{$VALUE}" name="value" id="value" /></td>
	</tr>

	<tr>
		<td><b>{bfText}Show Field As Disabled{/bfText}</b> <br />
		{bfText}Disable this field, disabled fields are not submitted{/bfText}</td>
		<td>{$DISABLED}</td>
	</tr>
	<tr>
		<td valign="top"><b>{bfText}Javascript onBlur Statement{/bfText}</b> <br />
		{bfText}Enter the Javascript onBlur statement here, the application
		will insert this in the onBlur="" attribute{/bfText}</td>
		<td><textarea id="onblur" name="onblur" class="inputbox bfinputbox"
			style="width: 400px; height: 100px;">{$ONBLUR}</textarea></td>
	</tr>
</table>

</div>
<div id="fragment-3"><!--  Access -->
<table class="bfadminlist">

	<tr>
		<td><b>{bfText}Publish this field{/bfText}</b> <br />
		{bfText}Toggle this field published/unpublished{/bfText}</td>
		<td>{$PUBLISHED} <br />
		<b>{bfText}Default: Yes{/bfText}<b></td>
	</tr>


</table>

</div>
<div id="fragment-4"><!--  Style -->
<table class="bfadminlist">
	<tr>
		<td><b>{bfText}CSS Class{/bfText}</b> <br />
		{bfText}This css class attribute is applied to the HTML tag{/bfText}</td>
		<td><input size="100" class="inputbox bfinputbox" type="text"
			value="{$CLASS}" name="class" id="class" /></td>
	</tr>
	<tr>
		<td><b>{bfText}CSS Style{/bfText}</b> <br />
		{bfText}If you put css in the text box to the right, this will be put
		in a style="" attribute in the HTML tag{/bfText}</td>
		<td><input size="100" class="inputbox bfinputbox" type="text"
			value="{$STYLE}" name="style" id="style" /></td>
	</tr>
	<tr>
		<td><b>{bfText}Field Size{/bfText}</b> <br />
		{bfText}The size attribute of the field's input element, should be an
		integer. Default: 50{/bfText}</td>
		<td><input size="4" class="inputbox bfinputbox" type="text"
			value="{$SIZE}" name="size" id="size" /></td>
	</tr>
	<tr>
		<td><b>{bfText}Input Maxlength{/bfText}</b> <br />
		{bfText}The maxlength attribute of the field's input element, should
		be an integer. Default: 255{/bfText}</td>
		<td><input size="4" class="inputbox bfinputbox" type="text"
			value="{$MAXLENGTH}" name="maxlength" id="maxlength" /></td>
	</tr>
</table>
</div>
</div>

<input type="hidden" value="{$ID}" name="id" id="id" />
<input type="hidden" value="{$ORDERING}" name="ordering" id="ordering" />

