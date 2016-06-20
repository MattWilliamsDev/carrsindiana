{* * This is displayed when the component is called from the front * end
without a form id @id 1 * $Id: c4ca4238a0b923820dcc509a6f75849b.php 2
2009-01-03 00:16:32Z $ *} {if $HASFORMS}


<h1 class="component ">{bfText}List Of All Active Forms{/bfText}</h1>
<p>{bfText}The following are a list of active forms on this website,
please select a form to view it{/bfText}</p>
<ul class="bfsubmenu">
	{foreach from=$forms key=myId item=i}
	<li class="bullet-form nobullet"><a href="{$i.url}">{$i.form_name}</a>
	{/foreach}

</ul>


{else}


<h1>{bfText}I'm sorry - this site has no active forms{/bfText}</h1>

<p>{bfText}If you think this is a mistake, please contact the site's
webmaster{/bfText}</p>


{/if}


<div
	style="color: #000; background-color: #ccc; height: 1px; font-size: 1px; margin-top: 50px;"></div>
<div style="text-align: center; color: #ccc; margin-bottom: 100px;">
<center><small>{bfText}Powered by{/bfText} <a class="taglineblue"
	href="http://www.forms-for-joomla.com/">{bfText}Blue Forms
Forms{/bfText}</a></small></center>
</div>
