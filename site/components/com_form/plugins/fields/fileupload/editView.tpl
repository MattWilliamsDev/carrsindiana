<div id="bfTabs">
<ul>
	<li><a href="#fragment-1"><span><img src="{$LIB_IMG_URL}bullet-info.gif" align="absmiddle" />&nbsp;{bfText}General{/bfText}</span></a></li>
	<li><a href="#fragment-2"><span><img src="{$LIB_IMG_URL}bullet-wrench.gif" align="absmiddle" />&nbsp;{bfText}Options{/bfText}</span></a></li>
	<li><a href="#fragment-2a"><span><img src="{$LIB_IMG_URL}tick.gif" align="absmiddle" />&nbsp;{bfText}Validation{/bfText}</span></a></li>
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
	<tr>
		<td valign="top"><b>{bfText}Description/Instructions{/bfText}</b> <br />

		{bfText}This is used to convey instructions to the visitor{/bfText}</td>
		<td><textarea cols="60" rows="10" class="inputbox bfinputbox"
			name="desc" id="desc">{$DESC}</textarea><br />
		</td>
	</tr>
</table>
</div>
<div id="fragment-2">
<table class="bfadminlist">
	<tr>
		<td colspan="2"><b>{bfText}Uploaded Files Destination Directory{/bfText}</b> <br />
		{bfText}Set this to the folder you wish to save your uploaded files	in{/bfText}<br />
		<span id="iswritable" style="color:red;"></span>
		<input onblur="bf_form_admin.checkFileUploadWritable();" type="text" value="{$FILEUPLOAD_DESTDIR}"
			id="fileupload_destdir" name="fileupload_destdir" style="width:100%;" /></td>
	</tr>
	<tr>
		<td><b>{bfText}What to do with duplicate filenames{/bfText}</b> <br />
		{bfText}Select what you would like to do with duplicate file names{/bfText}</td>
		<td>{$VERIFY_FILEUPLOAD_OVERWRITEMODE}</td>
	</tr>
	<tr>
		<td><b>{bfText}Filename Structure{/bfText}</b> <br />

		{bfText}Specify the filename structure. {/bfText}<br />
		{bfText}When you upload a file, the file name will be changed to this structure.<br />
		You can use the following placeholders which will be replaced.<br />
		::DATE::  ::TIME::  ::USERID:: ::FORMID:: ::ORIGINALFILENAME:: {/bfText}
		<strong>Note: You cannot use ::TIME:: on windows servers as windows doesnt allow : in a filename!</strong></td>
		<td><input size="100" class="inputbox bfinputbox" type="text" value="{$FILEUPLOAD_FILENAMEMASK}" name="fileupload_filenamemask"
			id="fileupload_filenamemask" />
		</td>
	</tr>
	<tr>
		<td><b>{bfText}Set field submission value to:{/bfText}</b> <br />
		{bfText}After the file is uploaded, what would you like the form fields value to be set to (set this so that you receive the right value in emails and saved in the database){/bfText}</td>
		<td>{$FILEUPLOAD_SETVALUETO}</td>
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
		<td style="width: 180px;">{$REQUIRED}</td>
	</tr>
</table>
</fieldset>

<fieldset><legend>File Upload Validation Rules</legend>

<table class="bfadminlist">
	<tr>
		<td><b>{bfText}Filename must have this extension{/bfText}</b> <br />
		{bfText}Set this is a comma separated list of values of extensions
		allowed{/bfText}</td>
		<td><input type="text" value="{$VERIFY_FILEUPLOAD_EXTENSIONS}"
			id="verify_fileupload_extensions" name="verify_fileupload_extensions" /></td>
	</tr>
	<tr>
		<td><b>{bfText}File must be smaller than X{/bfText}</b> <br />
		{bfText}Set this to a Mb value that the file cannot exceed{/bfText}</td>
		<td><input type="text" value="{$VERIFY_FILEUPLOAD_MAXSIZE}"
			id="verify_fileupload_maxsize" name="verify_fileupload_maxsize" /></td>
	</tr>
</table>
</fieldset>
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
	
</table>
</div>
</div>

<input type="hidden" value="{$ID}" name="id" id="id" />
<input type="hidden" value="{$ORDERING}" name="ordering" id="ordering" />

