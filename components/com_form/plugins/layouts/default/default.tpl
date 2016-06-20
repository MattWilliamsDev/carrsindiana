{*
  * @version $Id: default.tpl 147 2009-07-14 20:20:18Z  $
  * @package bfFramework
  * @copyright Copyright (C) 2007 Blue Flame IT Ltd. All rights reserved.
  * @license see Individual Components LICENSE.php files
  * @link http://www.blueflameit.ltd.uk
  * @author Blue Flame IT Ltd.
  *
  * This is the default basic layout with no tables
  *}


{if $SHOW_PAGE_TITLE}
	{if ($PAGE_TITLE)} 
		<h1 class="componentheading bf_form_page_title">{$PAGE_TITLE}</h1>
	{/if}
{/if}

{if ($SECURE_FORM)}
		<div class="bf_form_secureform"><span>
<img src="{$LIVE_SITE}/{$PLUGINS_DIR}/system/blueflame/view/images/confirm.png" align="left" hspace="5" alt="secure" />{bfText}This Form Is Secure{/bfText}<br /><i>{bfText}This form is submitted over SSL for your security{/bfText}</i></span></div>
{/if}

{if ($FAIL_VALIDATION)}
<div id="bf_failvalidation_messages">
<img src="{$LIVE_SITE}/{$PLUGINS_DIR}/system/blueflame/view/images/error.png" align="left" hspace="5" alt="secure" />
<h1>{bfText}There was a problem with your submission{/bfText}.</h1>
  {if count($fail_messages) }
		<p>
     	{foreach from=$fail_messages key=myId item=i}
			<b>{$i|ucwords}</b><br />
    	{/foreach}
		</p>
  {/if}
</div>
{/if}
  
<div class="bf_form_area">
     <!--  Form Open Tag -->
     {$FORM_OPEN_TAG}

     {if count($fields) }
     	{foreach from=$fields key=myId item=i}
     	
<div class="bf_form_row{$i.failvalidation}">
{if ($i.plugin == 'checkbox' || $i.plugin == 'radio' || $i.plugin == 'html')}
{* No labels needed for these kind *}
	<label>{$i.publictitle}{if $i.desc}<br/><span class="bf_field_instructions">{$i.desc}</span>{/if}</label>
{else}
	<label for="{$i.slug}">{$i.publictitle}{if $i.desc}<br/><span class="bf_field_instructions">{$i.desc}</span>{/if}</label>
{/if}
{$i.element}
</div>

         {/foreach}
     {/if}
      	<div class="bf_form_row">
           		<span class="bf_form_label">&nbsp;</span>
           		<span class="bf_form_formw">
           			<span id="user-box" style="float:right;display:block;">
		{if $SHOW_SUBMIT_BUTTON}
			<button id="form_submit_button" type="submit" class="button bfbutton" onclick="bf_form.formSubmit('{$FORM_ID}');return false;">
			{if (!$SECURE_FORM)}<img width="16" height="16" class="icon" alt="{bfText}{$SUBMITBUTTONTEXT}{/bfText}{if ($SECURE_FORM)} ({bfText}Secure{/bfText}){/if}" src="{$LIVE_SITE}/{$PLUGIN_DIR}/system/blueflame/view/images/bullet-action.gif"/>{else}<img width="16" height="16" class="icon" alt="{bfText}{$SUBMITBUTTONTEXT}{/bfText}{if ($SECURE_FORM)} ({bfText}Secure{/bfText}){/if}" src="{$LIVE_SITE}/{$PLUGIN_DIR}/system/blueflame/view/images/bullet-secure.gif"/>{/if}{bfText}{$SUBMITBUTTONTEXT}{if ($SECURE_FORM)} ({bfText}Secure{/bfText}){/if}{/bfText}</button>
  		{/if} 
		{if $SHOW_PREVIEW_BUTTON}
			<button id="form_preview_button" class="button bfbutton" onclick="bf_form.previewMode('{$FORM_ID}');return false;">
			{if (!$SECURE_FORM)}<img width="16" height="16" class="icon" alt="{bfText}Preview{/bfText}{if ($SECURE_FORM)} ({bfText}Secure{/bfText}){/if}" src="{$LIVE_SITE}/{$PLUGIN_DIR}/system/blueflame/view/images/bullet-preview.gif"/>{else}<img width="16" height="16" class="icon" alt="{bfText}Preview{/bfText}{if ($SECURE_FORM)} ({bfText}Secure{/bfText}){/if}" src="{$LIVE_SITE}/{$PLUGIN_DIR}/system/blueflame/view/images/bullet-secure.gif"/>{/if}{bfText}Preview{if ($SECURE_FORM)} ({bfText}Secure{/bfText}){/if}{/bfText}</button>
  		{/if}
  		{if $SHOW_PAUSE_BUTTON}
			<button id="form_pause_button" class="button bfbutton" onclick="bf_form.pauseMode('{$FORM_ID}');return false;">
			<img width="16" height="16" class="icon" alt="{bfText}Pause{/bfText}" src="{$LIVE_SITE}/{$PLUGIN_DIR}/system/blueflame/view/images/database_save.png"/>
			{bfText}Pause{/bfText}
			</button>
  		{/if}
		
		{if $SHOW_RESET_BUTTON} {bfText}or{/bfText} <a href="javascript:void(0);" onclick="bf_form.reset('{$FORM_ID}');">{bfText}{$RESETBUTTONTEXT}{/bfText}</a>{/if}
		</span>
	       		</span>
         	</div>
       <div class="bf_form_spacer">
       	&nbsp;
        </div>
	  {if count($hiddenfields) }
     	{foreach from=$hiddenfields key=myId item=h}
     		{$h.element}
         {/foreach}
     {/if}
	 {$FORM_SPAM_HIDDEN_FIELD}
     {$FORM_CLOSE_TAG}
</div>