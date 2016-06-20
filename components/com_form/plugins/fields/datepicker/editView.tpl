<div id="bfTabs">
<ul>
	<li><a href="#fragment-1"><span><img src="{$LIB_IMG_URL}bullet-info.gif" align="absmiddle" />&nbsp;{bfText}General{/bfText}</span></a></li>
	<li><a href="#fragment-2"><span><img src="{$LIB_IMG_URL}bullet-wrench.gif" align="absmiddle" />&nbsp;{bfText}Options{/bfText}</span></a></li>
	<li><a href="#fragment-2a"><span><img src="{$LIB_IMG_URL}tick.gif" align="absmiddle" />&nbsp;{bfText}Validation{/bfText}</span></a></li>
	<li><a href="#fragment-2b"><span><img src="{$LIB_IMG_URL}arrow_divide.png" align="absmiddle" />&nbsp;{bfText}Filters{/bfText}</span></a></li>
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
		<td><b>{bfText}Date Input Mask{/bfText}</b> <br />
		{bfText}This value will be parsed by the calendar and is the final format of the string{/bfText}</td>
		<td><input size="100" class="inputbox bfinputbox" type="text"
			value="{$VALUE}" name="value" id="value" /></td>
	</tr>
	<tr>
		<td><b>{bfText}Show Time Selector{/bfText}</b> <br />
		{bfText}Toggle this to show the time selector in the calendar as well, if you turn this off then you need to remove the time elements from the value above{/bfText}</td>
		<td>{$PARAMS}</td>
	</tr>
	<tr>
		<td><b>{bfText}Calendar Language File{/bfText}</b> <br />
		{bfText}Select the appropriate language file{/bfText}</td>
		<td>{$LANG}</td>
	</tr>
	<tr>
		<td><b>{bfText}Allow default value to be overridden by var in the
		GET{/bfText}</b> <br />
		{bfText}If this is set to YES, then calling a form with a url
		containing &FIELDNAME=myvalue would set the default value to
		myvalue{/bfText}</td>
		<td>{$ALLOWSETBYGET}</td>
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
<div id="fragment-2a">
<h1>{bfText}Warning: Pay attention to the options here, setting all to
yes will make it impossible for this field to pass validation, some
rules will conflict with other rules! (i.e. input cannot be expected to
be an IP Address AND an email address!!!{/bfText}</h1>


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

<fieldset><legend>Joomla Specific Rules</legend>
<table class="bfadminlist">
	<tr>
		<td><b>{bfText}Input MUST be a valid &amp; already existing Joomla
		Username{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid and already existing Joomla Usernames{/bfText}</td>
		<td style="width:180px;">{$VERIFY_ISEXISTINGUSERNAME}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST NOT be an already taken Joomla
		Username{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid and NOT ALREADY existing Joomla Usernames{/bfText}</td>
		<td>{$VERIFY_ISNOTEXISTINGUSERNAME}</td>
	</tr>
</table>
</fieldset>

<fieldset><legend>Blank/Non Blank Rules</legend>
<table class="bfadminlist">
	<tr>
		<td><b>{bfText}Input MUST be left blank{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		blank values{/bfText}</td>
		<td style="width:180px;">{$VERIFY_ISBLANK}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST NOT be left blank{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		input{/bfText}</td>
		<td>{$VERIFY_ISNOTBLANK}</td>
	</tr>
</table>
</fieldset>
<fieldset><legend>Specific Value Rules</legend>
<table class="bfadminlist">
	<tr>
		<td><b>{bfText}Input MUST be a valid email address{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid email addresses{/bfText}</td>
		<td style="width:180px;">{$VERIFY_ISEMAILADDRESS}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST be a valid IP Address {/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid ip addresses{/bfText}</td>
		<td>{$VERIFY_ISIPADDRESS}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST be a valid UK National Insurance
		Number{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid UK NI Numbers{/bfText}</td>
		<td>{$VERIFY_ISVALIDUKNINUMBER}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST be a valid US Social Security
		Number{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid US SS Numbers{/bfText}</td>
		<td>{$VERIFY_ISVALIDSSN}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST be a valid US Zipcode{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid US Zip Codes{/bfText}</td>
		<td>{$VERIFY_ISVALIDUSZIP}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST be a valid UK PostCode{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid UK PostCodes{/bfText}</td>
		<td>{$VERIFY_ISVALIDUKPOSTCODE}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST be a valid Credit Card Number{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid Credit Card Number{/bfText}</td>
		<td>{$VERIFY_ISVALIDCREDITCARDNUMBER}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST be a valid URL (web Address){/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid URL (Web Address){/bfText}</td>
		<td>{$VERIFY_ISVALIDURL}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST be a valid UK VAT Number{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid <a
			href="http://www.direct.gov.uk/en/MoneyTaxAndBenefits/Taxes/BeginnersGuideToTax/DG_4015895">UK
		VAT numbers</a>{/bfText}</td>
		<td>{$VERIFY_ISVALIDVATNUMBER}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST be a valid Brazil CPF Number
		Number{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid Brazil CPF Numbers{/bfText}</td>
		<td>{$VERIFY_BRAZIL_CPF}</td>
	</tr>
	<tr>
		<td><b>{bfText}Input MUST be a valid Brazil CNPJ Number
		Number{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to only accept
		valid Brazil CNPJ Numbers{/bfText}</td>
		<td>{$VERIFY_BRAZIL_CNPJ}</td>
	</tr>
	</table>
	</fieldset>
<fieldset><legend>More Rules</legend>

	<table class="bfadminlist">
		<tr>
			<td><b>{bfText}Input MUST be an valid Integer{/bfText}</b> <br />
			{bfText}Setting this to "Yes" will force this field to only accept
			valid <a
				href="http://uk3.php.net/manual/en/language.types.integer.php">Integers</a>{/bfText}</td>
			<td style="width:180px;">{$VERIFY_ISINTEGER}</td>
		</tr>
		<tr>
			<td><b>{bfText}Input MUST be a string greater than or equal to X
			chars{/bfText}</b> <br />
			{bfText}Setting this to a number will force this field to only accept
			valid input longer or equal to the number of chars you
			specify{/bfText}</td>
			<td><input type="text" value="{$VERIFY_STRINGLENGTHGREATERTHAN}"
				id="verify_stringlengthgreaterthan"
				name="verify_stringlengthgreaterthan" /></td>
		</tr>
		<tr>
			<td><b>{bfText}Input MUST be a string less than or equal to X
			chars{/bfText}</b> <br />
			{bfText}Setting this to a number will force this field to only accept
			valid input less than or equal to the number of chars you
			specify{/bfText}</td>
			<td><input type="text" value="{$VERIFY_STRINGLENGTHLESSTHAN}"
				id="verify_stringlengthlessthan" name="verify_stringlengthlessthan" /></td>
		</tr>
		<tr>
			<td><b>{bfText}Input MUST be a string EXACTLY equal to X
			chars{/bfText}</b> <br />
			{bfText}Setting this to a number will force this field to only accept
			valid input of EXACTLY the number of chars you specify{/bfText}</td>
			<td><input type="text" value="{$VERIFY_STRINGLENGTHEQUALS}"
				id="verify_stringlengthequals" name="verify_stringlengthequals" /></td>
		</tr>
		<tr>
			<td><b>{bfText}Input MUST be a number greater than the number you
			specify here{/bfText}</b> <br />
			{bfText}Setting this to a number will force this field to only accept
			valid input of a number greater than the number you specify{/bfText}</td>
			<td><input type="text" value="{$VERIFY_NUMBERGREATERTHAN}"
				id="verify_numbergreaterthan" name="verify_numbergreaterthan" /></td>
		</tr>
		<tr>
			<td><b>{bfText}Input MUST be a number less than the number you
			specify here{/bfText}</b> <br />
			{bfText}Setting this to a number will force this field to only accept
			valid input of a number less than the number you specify{/bfText}</td>
			<td><input type="text" value="{$VERIFY_NUMBERLESSTHAN}"
				id="verify_numberlessthan" name="verify_numberlessthan" /></td>
		</tr>
		<tr>
			<td><b>{bfText}Input MUST be a number equal to the number you specify
			here{/bfText}</b> <br />
			{bfText}Setting this to a number will force this field to only accept
			valid input of a number equal to the number you specify{/bfText}</td>
			<td><input type="text" value="{$VERIFY_NUMBEREQUALS}"
				id="verify_numberequals" name="verify_numberequals" /></td>
		</tr>
		<tr>
			<td><b>{bfText}Input MUST be a string that matches this <a
				href="http://uk.php.net/manual/en/function.preg-match.php">regex</a>{/bfText}</b>
			<br />
			{bfText}Setting this with a <a
				href="http://uk.php.net/manual/en/function.preg-match.php">regex</a>
			string will force this field to only accept valid input that matches
			the regex{/bfText}</td>
			<td><input type="text" value="{$VERIFY_REGEX}" id="verify_regex"
				name="verify_regex" /></td>
		</tr>
		<tr>
			<td><b>{bfText}Input MUST be equal to ... {/bfText}</b> <br />
			{bfText}Setting this with a string will force this field to only
			accept valid input that matches the string you specify{/bfText}</td>
			<td><input type="text" value="{$VERIFY_EQUALTO}" id="verify_equalto"
				name="verify_equalto" /></td>
		</tr>
		<tr>
			<td><b>{bfText}Input MUST be equal one of these... {/bfText}</b> <br />
			{bfText}Setting this with a string of comma separated values will
			force this field to only accept valid input that matches one of the
			strings you provide. E.g: if you enter "one,two,three" in this box
			and then user submits "three" then it would pass validation, if they
			entered "four" it would fail {/bfText}</td>
			<td><input type="text" value="{$VERIFY_ISINARRAY}"
				id="verify_isinarray" name="verify_isinarray" /></td>
		</tr>

	</table>
</fieldset>
</div>
<div id="fragment-2b">
<table class="bfadminlist">
	<tr>
		<td><b>{bfText}Filter To Only A-Z{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to be a filtered
		to only a-z or A-Z chars{/bfText}</td>
		<td style="width:180px;">{$FILTER_A2Z} <br />
		<b>{bfText}Default: No{/bfText}<b></td>
	</tr>
	<tr>
		<td><b>{bfText}StripTags Filter{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will force this field to be a filtered
		removing all HTML Tags{/bfText}</td>
		<td>{$FILTER_STRIPTAGS} <br />
		<b>{bfText}Default: Yes{/bfText}<b></td>
	</tr>
	<tr>
		<td><b>{bfText}Trim Input{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will trim the preceeding and trailing
		whitespace from the submitted value{/bfText}
		
		
		<td>{$FILTER_STRINGTRIM} <br />
		<b>{bfText}Default: Yes{/bfText}<b></td>
	</tr>
	<tr>
		<td><b>{bfText}Alnum Filter{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will returns the value, removing all but
		alphabetic and digit characters.{/bfText}
		
		
		<td>{$FILTER_ALNUM} <br />
		<b>{bfText}Default: No{/bfText}<b></td>
	</tr>
	<tr>
		<td><b>{bfText}Digits Only{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will returns the value, removing all but
		digit characters.{/bfText}
		
		
		<td>{$FILTER_DIGITS} <br />
		<b>{bfText}Default: No{/bfText}<b></td>
	</tr>
	
	<tr>
		<td><b>{bfText}Force submitted value to UPPERCASE{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will return the value after it has been made uppercase{/bfText}
		<td>{$FILTER_STRTOUPPER} <br />
		<b>{bfText}Default: No{/bfText}<b></td>
	</tr>
	
	<tr>
		<td><b>{bfText}Force submitted value to lowercase{/bfText}</b> <br />
		{bfText}Setting this to "Yes" will return the value after it has been made lowercase{/bfText}
		<td>{$FILTER_STRTOLOWER} <br />
		<b>{bfText}Default: No{/bfText}<b></td>
	</tr>

</table>

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
		<td><b>{bfText}Calendar CSS Style File{/bfText}</b> <br />
		{bfText}Please choose which stlye you would like{/bfText}</td>
		<td>{$CSSFILE}</td>
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

