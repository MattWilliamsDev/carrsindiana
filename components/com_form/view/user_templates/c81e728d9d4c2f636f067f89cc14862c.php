{* c81e728d9d4c2f636f067f89cc14862c.php *}


<table class="bfadminlist" width="100%">
	<tr>
		<th>Form Field</th>
		<th>Your Submission</th>
	</tr>
	{php} $i=0;{/php} {section name=i loop=$fields}
	<tr class="row{php} echo $i; {/php}">
		<td>{$fields[i].publictitle}</td>
		<td>{$fields[i].submission}</td>
	</tr>
	{php} $i = 1 - $i;{/php} {/section}

</table>

<div class="bf_form_row"><span class="bf_form_label"> </span> <span
	class="bf_form_formw">
<div id="user-box" style="float: right; display: block;">

<button id="form_submit_button" type="submit" class="button bfbutton"
	onclick="bf_form.formSubmit('{$FORM_ID}');">{if (!$SECURE_FORM)}<img width="16"
	height="16" class="icon"
	alt="{bfText}{$SUBMITBUTTONTEXT}{/bfText}{if ($SECURE_FORM)} ({bfText}Secure{/bfText}){/if}"
	src="{$LIVE_SITE}/{$PLUGIN_DIR}/system/blueflame/view/images/bullet-action.gif" />{else}<img
	width="16" height="16" class="icon"
	alt="{bfText}{$SUBMITBUTTONTEXT}{/bfText}{if ($SECURE_FORM)} ({bfText}Secure{/bfText}){/if}"
	src="{$LIVE_SITE}/{$PLUGIN_DIR}/system/blueflame/view/images/bullet-secure.gif" />{/if}{bfText}{$SUBMITBUTTONTEXT}{if
($SECURE_FORM)} ({bfText}Secure{/bfText}){/if}{/bfText}</button>

{if $SHOW_RESET_BUTTON} {bfText}or{/bfText} <a
	href="javascript:void(0);" onclick="bf_form.edit('{$FORM_ID}');">{bfText}Edit{/bfText}</a>{/if}
</div>
</span></div>
