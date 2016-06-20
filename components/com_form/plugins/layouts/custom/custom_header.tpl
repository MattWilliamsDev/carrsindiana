{*
  * @version $Id: custom_header.tpl 147 2009-07-14 20:20:18Z  $
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
		
{/if}

{if ($FAIL_VALIDATION)}
<div id="bf_failvalidation_messages">
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
     <!--  CUSTOM FORM LAYOUT STARTS HERE -->