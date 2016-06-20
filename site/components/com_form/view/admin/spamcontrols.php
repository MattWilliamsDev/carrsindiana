<?php
/**
 * @version $Id: spamcontrols.php 147 2009-07-14 20:20:18Z  $
 * @package Blue Flame Forms (bfForms)
 * @copyright Copyright (C) 2003,2004,2005,2006,2007,2008,2009 Blue Flame IT Ltd. All rights reserved.
 * @license GNU General Public License
 * @link http://www.blueflameit.ltd.uk
 * @author Phil Taylor / Blue Flame IT Ltd.
 *
 * This file is part of the package bfForms.
 *
 * bfForms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * bfForms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this package.  If not, see http://www.gnu.org/licenses/
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/* Set the Document HTML's HEAD tag text */
$controller->setPageTitle ( bfText::_ ( 'Spam Controls' ) );

/* Set the Page Header */
$controller->setPageHeader ( bfText::_ ( 'Spam Controls' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'save', 'save', bfText::_ ( 'Save configuration' ) );
$toolbar->addButton ( 'cancel', 'overview', bfText::_ ( 'Cancel and loose changes' ) );
$toolbar->addButton ( 'help', 'xhelp', bfText::_ ( 'Click here to view Help and Support Information' ) );
$toolbar->render ( true );

$registry->setValue ( 'usedTabs', 1 );

$options = array (bfHTML::makeOption ( '', '' ) );
foreach ( $field ['rows'] as $f ) {

	$options [] = bfHTML::makeOption ( $f->slug, $f->publictitle );
}
function _buildHTML($options, $htmlfield, $form) {
	return bfHTML::selectList2 ( $options, $htmlfield, ' class="inputbox"', 'value', 'text', $form [$htmlfield] );
}
?>

<div id="bfTabs">

<ul class="ui-tabs-nav">
	<li class=""><a href="#page-info"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/bullet-info.gif"
		align="absmiddle" />&nbsp;About These Plugins</span></a></li>
	<li class=""><a href="#page-flame"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/drive_user.png"
		align="absmiddle" />&nbsp;IP Banning</span></a></li>
	<li class=""><a href="#page-words"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/drive_user.png"
		align="absmiddle" />&nbsp;Word Blacklist</span></a></li>
	<li class=""><a href="#page-hidden"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/drive_user.png"
		align="absmiddle" />&nbsp;Hidden Element</span></a></li>
	<li class=""><a href="#page-wordpress"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/wordpress.png"
		align="absmiddle" />&nbsp;Akismet Plugin</span></a></li>
	<li class=""><a href="#page-mollom"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/mollom.png"
		align="absmiddle" />&nbsp;Mollom Plugin</span></a></li>
</ul>

<div id="page-info" class="active">
<table class="bfadminlist">
	<tbody>
		<tr class="">
			<td style="padding: 10px;">
			<h1>DO NOT use these third party services if your form contains
			sensitive information</h1>
			<h2>About</h2>
			<p>These plugins are 3rd party, and apart from the integration into
			bfForms, they are unsupported by Blue Flame IT Ltd. (The
			developers of bfForms).<br />
			Please ensure you comply with the Terms Of Services for these 3rd
			Party services.</p>
			<br />
			<h2>Security</h2>
			<p>As these third party services are hosted on a different server to
			yours, bfForms will send information submitted in your forms over the
			internet to these service providers so they can provide their
			service. <b>This is done using normal http, unencrypted, and in plain
			text!</b></p>
			<br />
			<h2>Transparent Spam Controls</h2>
			<p>In addition to the options here bfForms employs some transparent,
			unconfigurable, spam controls. These include, but are not limited to
			"idiot tests", session based control and maybe even cookies :-)</p>
			<br />
			<br />
			</td>

		</tr>
	</tbody>
</table>
</div>

<div id="page-flame">
<table class="bfadminlist">
	<tbody>
		<tr class="row0">
			<td class="blue"><span class="title bold">Check Submitters IP Address
			Against Blacklist Databases</span><br />
			This option requires a linux webhost and will check the IP address of
			the submitter against 2 different major Internet spam databases ("bl.spamcop.net", "zen.spamhaus.org" ). <br /><br /> <b><?php echo bfText::_('Note: If you form submissions take a long time to submit then disable this, some servers connections to these services can be slow - not our problem but a hosting problem'); ?>.</b></td>
			<td width="50%" align="center">
					<?php
					echo bfHTML::yesnoRadioList ( 'useblacklist', ' class="inputbox"', $form ['useblacklist'] )?>
				</td>
		</tr>
		<tr class="row1">
			<td class="blue" valign="top"><span class="title bold">Manual IP
			Blacklist</span><br />
			If you have a persistant issue with one or two users from known IP's
			you can enter those IP's here, one per line, and their submissions
			will be stopped</td>
			<td width="50%" align="center"><textarea id="spam_ipblacklist"
				name="spam_ipblacklist" rows="7" cols="50" class="inputbox"><?php
				echo $form ['spam_ipblacklist'];
				?></textarea></td>
		</tr>
	</tbody>
</table>
</div>


<div id="page-words">
<table class="bfadminlist">
	<tbody>
		<tr class="row0">
			<td class="blue" valign="top"><span class="title bold">Reject
			Submissions Which Contain These Words</span><br />
			Enter a list of words, | separated. <br />
			E.g: sex|drug|rock|roll|viagra <br />
			<br />
			<b>Be careful! This plugin will match any string you enter in any
			field! - so dont use common words like "the" and "my"</td>
			<td width="50%" align="center"><textarea id="spam_wordblacklist"
				name="spam_wordblacklist" rows="7" cols="50" class="inputbox"><?php
				echo $form ['spam_wordblacklist'];
				?></textarea></td>
		</tr>
	</tbody>
</table>
</div>

<div id="page-hidden">
<table class="bfadminlist">
	<tbody>
		<tr class="row0">
			<td valign="top" colspan="2">Most spambots will find your form,
			determine what the form element names are, and find the URL where the
			form is posted to. The software will then post those form elements
			with modified, spam-filled values back to the form submission URL.
			Typically, the bot will populate every form element with some value
			so as to best ensure that it will succeed in being posted. So, if we
			insert a standard text input element into your form, but hide it
			visually from the user so the user cannot enter anything into this
			field, it is quite likely that the spambot will still post some value
			for this form element. If we detect that the form element is
			submitted with a value, then it's almost certainly a spambot and we
			can reject the submission.</td>
		</tr>
		<tr>
			<td class="blue" valign="top"><span class="title bold">Please enter
			the field name you want to use:</span><br />
			Unless you have used the following in your form, we recommend:
			<ul style="margin-left: 100px">
				<li>last_name</li>
				<li>first_name</li>
				<li>title</li>
			</ul>
			</td>
			<td width="50%" align="center"><input type="text"
				name="spam_hiddenfield" id="spam_hiddenfield" class="inputbox"
				value="<?php
				echo $form ['spam_hiddenfield'] ? $form ['spam_hiddenfield'] : 'my_last_name';
				?>" /></td>
		</tr>
	</tbody>
</table>
</div>

<div id="page-wordpress">
<h2 style="align: center; width: 100%;">For more information, and to
sign up for free with <a href="http://www.akismet.com">Akismet please
visit their site</a></h2>
<p>You can get a free API key by <a href="http://wordpress.com/signup/">registering
for a WordPress.com user account</a>. The API key will be emailed to you
after you register. Please note that the use of the key is covered by
the Akismet <a href="http://www.akismet.com/tos/">TOS</a> and that free
keys can only be used for personal sites. If you are a commercial entity
or if you are making more than $500 from your site, please <a
	href="http://akismet.com/commercial/">get a commercial key instead</a>.</p>
<br />
<table class="bfadminlist">
	<tbody>
		<tr class="row0">
			<td class="blue"><span class="title bold">Your Akismet Key</span><br />
			To enable this plugin please enter your Akismet Key</td>
			<td width="30%" align="center"><input type="text"
				name="spam_akismet_key" id="spam_akismet_key" class="inputbox"
				value="<?php
				echo $form ['spam_akismet_key'];
				?>" /></td>
		</tr>
		<tr class="row1">
			<td class="blue"><span class="title bold">Which Field, when
			submitted, will contain the submitters name?</td>
			<td align="center"><?php
			echo _buildHTML ( $options, 'spam_akismet_author', $form );
			?></td>
		</tr>
		<tr class="row0">
			<td class="blue"><span class="title bold">Which Field, when
			submitted, will contain the submitters EMAIL?</td>
			<td align="center"><?php
			echo _buildHTML ( $options, 'spam_akismet_email', $form );
			?></td>
		</tr>
		<tr class="row1">
			<td class="blue"><span class="title bold">Which Field, when
			submitted, will contain the submitters Website/Url?</td>
			<td align="center"><?php
			echo _buildHTML ( $options, 'spam_akismet_website', $form );
			?></td>
		</tr>
		<tr class="row0">
			<td class="blue"><span class="title bold">Which Field, when
			submitted, will contain the submitters comment, or the main area of
			text?</td>
			<td align="center"><?php
			echo _buildHTML ( $options, 'spam_akismet_body', $form );
			?></td>
		</tr>
	</tbody>
</table>

</div>

<div id="page-mollom">



<h2 style="align: center; width: 100%;">For more information, and to
sign up for free with <a href="http://mollom.com/">Mollom please visit
their site</a></h2>
<p>Mollom is a web service that helps you identify content quality and,
more importantly, helps you stop comment and contact form spam. When
moderation becomes easier, you have more time and energy to interact
with your web community. Mollom is currently in public beta.</p>

<p>For security reasons, all requests from your website to Mollom need
to contain authentication information. To control the authenticity of a
message and the integrity of the information being transmitted, both a
public and a private key are required. For each website that you wish to
protect with Mollom, you must <a
	href="http://mollom.com/key-manager/add">create a new key-pair</a>.
Remember not to share your private keys with anyone else!</p>
<br />


<table class="bfadminlist">
	<tbody>
		<tr class="row0">
			<td class="blue"><span class="title bold">Your Mollom Private Key</span><br />
			To enable this plugin please enter your Mollom Private Key</td>
			<td width="30%" align="center"><input type="text"
				name="spam_mollom_privatekey" id="spam_mollom_privatekey"
				class="inputbox"
				value="<?php
				echo $form ['spam_mollom_privatekey'];
				?>" /></td>
		</tr>
		<tr class="row1">
			<td class="blue"><span class="title bold">Your Mollom Public Key</span></td>
			<td width="30%" align="center"><input type="text"
				name="spam_mollom_publickey" id="spam_mollom_publickey"
				class="inputbox"
				value="<?php
				echo $form ['spam_mollom_publickey'];
				?>" /></td>
		</tr>

	</tbody>
</table>


</div>
<?php
bfHTML::addHiddenIdField ( $form );
?>
</div>