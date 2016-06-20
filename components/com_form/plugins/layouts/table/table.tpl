{*
  * @version $Id: table.tpl 147 2009-07-14 20:20:18Z  $
  * @package bfFramework
  * @copyright Copyright (C) 2007 Blue Flame IT Ltd. All rights reserved.
  * @license see Individual Components LICENSE.php files
  * @link http://www.blueflameit.ltd.uk
  * @author Blue Flame IT Ltd.
  *
  * This is the default basic layout with tables for layout
  *}


{if $SHOW_PAGE_TITLE}
	{if ($PAGE_TITLE)} 
		<h1 class="componentheading bf_form_page_title">{$PAGE_TITLE}</h1>
	{/if}
{/if}

{if ($SECURE_FORM)}
		<div class="bf_form_secureform"><span>
<img src="{$LIVE_SITE}/plugins/system/blueflame/view/images/confirm.png" align="left" hspace="5" alt="secure" />{bfText}This Form Is Secure{/bfText}<br /><i>{bfText}This form is submitted over SSL for your security{/bfText}</i></span></div>
{/if}
  
<div class="bf_form_area">
     <!--  Form Open Tag -->
     {$FORM_OPEN_TAG}
     {if count($fields) }
	<table class="bf_form_table">
     	{foreach from=$fields key=myId item=i}
         	<tr><td>{$i.title}:</td><td>{$i.element}</td></tr>
         {/foreach}
	
     {/if}
           	<tr>
           		<td colspan="2" style="text-align: right;">
           			<input type="submit" value="{$RESETBUTTONTEXT}{if ($SECURE_FORM)} ({bfText}Secure{/bfText}){/if}" class="button bfbutton" />{if $SHOW_RESET_BUTTON} {bfText}or{/bfText} <a href="javascript:void(0);" onclick="jQuery('form#BF_FORM_{$FORM_ID}').reset();">{bfText}{$RESETBUTTONTEXT}{/bfText}</a> {/if}
           		</td>
           	</tr>
    </table>
       <div class="bf_form_spacer">
       	&nbsp;
        </div>
     {$FORM_CLOSE_TAG}
</div>