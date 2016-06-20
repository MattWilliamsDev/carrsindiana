<?php
/**
 * @version $Id: framework.config.php 204 2010-01-24 23:12:32Z  $
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

$db = bfCompat::getDBO ();
defined ( 'BF_FORMS_DEMO_MODE' ) or define ( 'BF_FORMS_DEMO_MODE', FALSE );

/* @IMPORTANT - Needs to happen before our first session call */
$registry->setValue ( 'bfFramework_form.state_defaults', array ('page' => '1', 'limit' => 10, 'filter' => '' ) );
/* Hidden fields to show */
$registry->setValue ( 'bfFramework_form.hidden_field_defaults', array ('boxchecked' => '', 'hidemainmenu' => '', 'task' => '', 'total' => '', 'view' => '', 'returnto' => '' ) );

$session = bfSession::getInstance ( 'com_form' );

/* After admin cpanel is drawn, which xAJAX view to display */
$registry->setValue ( 'bfFramework_form.defaultHomePageView', 'xwelcome' );

/* Sub-menu elements in Administrator Screen and xAJAX actions */
$registry->setValue ( 'bfFramework_form.submenus.Welcome', 'xwelcome|star|View All Forms' );
$registry->setValue ( 'bfFramework_form.submenus.Create New Form', 'xnewForm|newform|Create New Form' );
$registry->setValue ( 'bfFramework_form.submenus.Your Forms', 'xforms|forms|View All Forms' );
$registry->setValue ( 'bfFramework_form.submenus.Preferences', 'xconfiguration|preferences|Edit Preferences and customise options' );
$registry->setValue ( 'bfFramework_form.submenus.Global Layouts', 'xlayouts|layout|Edit layouts options' );
//$registry->setValue('bfFramework_form.submenus.Maintenance', 'xmaintenance|maintenance|Run Maintenance on the database');
//$registry->setValue('bfFramework_form.submenus.RSS Feeds', 	'xrsslinks|rss|View and preview the links to the RSS feeds');
$registry->setValue ( 'bfFramework_form.submenus.Addons', 'xplugins|plugins|Install and uninstall the additional mambots and modules easily' );
$registry->setValue ( 'bfFramework_form.submenus.Changelog', 'xchangelog|info|View Changelog' );
//$registry->setValue('bfFramework_form.submenus.Release Notes', 	'xreleasenotes|info|View Release Notes');
$registry->setValue ( 'bfFramework_form.submenus.HELP!', 'xhelp|info|Get Help!' );
//if (file_exists ( bfCompat::getAbsolutePath () . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'GoogleGears' . DS . 'gears-manifest.php' )) {
$registry->setValue ( 'bfFramework_form.submenus.Speed Up!', 'xturbo|turbo|Speed Up The Interface!' );
//}


$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Quick Start', 'xquickstart|star|Quick start guide on creating your form' );
$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Form Title', 'xformconfiguration|info|Basic form overview' );
$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Form Permissions', 'xformaccess|groups|Configure your form' );
$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Spam Controls', 'xspamcontrols|nospam|Configure your form' );
$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Form Layout', 'xformlayouts|layout|Configure your form layout' );

//$id = $session->get ( 'lastFormId', '', 'default' );
//if ($id > 0) {
//	$db->setQuery ( 'SELECT formtype FROM #__form_forms WHERE id = "' . ( int ) $id . '"' );
//	$type = $db->LoadResult ();
//
//	switch ($type) {
//		case "prebuilt" :
//			$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Setup Fields', 'xsetupfields|element|Setup your fields' );
//			$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Form Fields', 'xfields|element|Add and edit the form fields' );
//			break;
//		default :
//			$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Form Fields', 'xfields|element|Add and edit the form fields' );
//			break;
//	}
//
//}
$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Form Fields', 'xfields|element|Add and edit the form fields' );
$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Submit Actions', 'xactions|action|Add and edit actions (what happens after a form is submit)' );
$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Submissions', 'xsubmissions|database|View Form Submissions' );
$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Statistics', 'xstats|statistics|View Form Submissions' );

/* uploaded files manager */
$id = $session->get ( 'lastFormId', '', 'default' );

$db->setQuery ( 'SELECT count(*) FROM #__form_fields WHERE plugin = "fileupload" AND form_id = "' . ( int ) $id . '"' );
if ($db->LoadResult () > 0) {
	$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Uploaded Files', 'xuploadedfiles|files|View Uploaded Files' );
}

$registry->setValue ( 'bfFramework_form.submenus_formcpanel.Export Data', 'xexportoptions|export|Export Data' );

/* Index view fields */
$registry->setValue ( 'bfFramework_form.indexFields.forms', array ('id', 'id_int', 'form_name' => 'Form Name (Click Name To Edit The Form)', 'countsubmissions' => 'Submissions', 'countfields' => 'Fields', 'countactions' => 'Actions', 'preview' => 'Preview', 'onlyssl' => 'SSL', 'access', 'published' => 'Enabled' ) );
$registry->setValue ( 'bfFramework_form.indexFields.fields', array ('id', 'title' => 'Field Title', 'slug' => 'Name', 'plugin' => 'Field Type', 'required', 'access', 'published' => 'Enabled', 'ordering' ) );
$registry->setValue ( 'bfFramework_form.indexFields.actions', array ('id', 'title' => 'Action Title', 'plugin' => 'Action Type', 'access', 'published' => 'Enabled', 'ordering' ) );
$registry->setValue ( 'bfFramework_form.indexFields.layouts', array ('id', 'title' => 'Template Title', 'appliesto' => 'Pertains To' ) );
$registry->setValue ( 'bfFramework_form.indexFields.formlayouts', array ('id', 'title' => 'Template Title', 'default' => 'In Use' ) );

$ssArr = array ('id' );
$id = $session->get ( 'lastFormId', '', 'default' );
$db->setQuery ( 'SELECT title as value, publictitle as value2, slug as name FROM #__form_fields WHERE form_id = "' . ( int ) $id . '"' );
$arr = $db->LoadObjectList ();
if (isset ( $arr ) && is_array ( $arr )) {
	foreach ( $arr as $k ) {
		$vv = ($k->value2 ? $k->value2 : $k->value);
		if (strlen ( $vv ) > 20) {
			$vv = substr ( $vv, 0, 20 ) . '...';
		}
		$ssArr [$k->name] = $vv;
	}
}
$registry->setValue ( 'bfFramework_form.indexFields.submissions', $ssArr );

$registry->setValue ( 'bfFramework_form.layout.pertainsto', array ('Global' ) );

$registry->setValue ( 'bfFramework_form.Customise.Tasks', 

array (array ('xconfiguration', 'Global Preferences', bfText::_ ( 'Change your preferences to suit your website, loads of goodies in here' ), 'config' ) ) );//array('xlayouts','Set Up Your Layout Templates',bfText::_('Change the way that your frontend is shown by editing these templates - get creative!'),'customise')


$registry->setValue ( 'bfFramework_form.Maintenance.Tasks', array (array ('clearObjectCache', 'Clear Object Cache', bfText::_ ( 'This task purges all cached objects, including cached SQL Queries and Smarty Templates. <br />Run this task  as often as you want, and especially after making broad changes to any layout templates' ), 'clear' ), array ('clearContentCache', 'Clear Joomla Content Cache', bfText::_ ( 'This task purges all cached Joomla!&trade; content items.<br />Run this task as often as you like.' ), 'clear' ) ) );

$registry->setValue ( 'bfFramework_form.RSS Feeds.Links', array () );

$registry->setValue ( 'bfFramework_' . 'form' . '.addons.plugins', array ('content.form' => bfText::_ ( 'Provides Embeding Forms In Content' ) ) );
$registry->setValue ( 'bfFramework_' . 'form' . '.addons.modules', array ('mod_form' => bfText::_ ( 'Provides Embeding Forms In Modules' ) ) );
/**
 * ##############################################################################################################################################################################
 */

/* Get our final version number appended with the svn revision number (like a build number) */
$SVNRevision = '([0-9][0-9][0-9])'; //[0-9]
preg_match_all ( $SVNRevision, '$Revision: 204 $', $Revision );
$registry->setValue ( 'Component.Version', '0.2.' . $Revision [0] [0] );
$registry->setValue ( 'Component.Title', 'Blue Flame Forms For Joomla 1.5.x' );
$registry->setValue ( 'defaultLang', bfCompat::getCfg ( 'lang_site' ) );
$registry->setValue ( 'defaultEncoding', bfCompat::getCfg ( 'lang_site' ) );
$registry->setValue ( 'defaultdir', 'rtl' );

/**
 * Itemid
 */
if (! bfCompat::isAdmin ()) {
	$itemid = bfUtils::findItemid ();
	$registry->setValue ( 'Itemid', $itemid );
}
/* Set minimum access levels */
/**
 * Gids:
 * 25 Super Administrator
 * 18 Registered
 * 19 Author
 * 20 Editor
 * 21 Publisher
 * 23 Manager
 * 24 Administrator
 * 25 Super Administrator
 * 0  Not Logged in
 */
/* Access control: View front console */
$registry->setValue ( 'Security.Front', '0' );

/* Access control: View admin console */
$registry->setValue ( 'Security.AdminConsole', '25' );

/* Access control: View or edit configuration pages */
$registry->setValue ( 'Security.Admin.viewDebug', '25' );

/* Specific task function calls in the controller can be ACL'ed , must have x prefix*/

/* Access control: Ability to load the admin control panel */
$registry->setValue ( 'Security.AdminController.xcpanel', '25' );

/* Front end normal functions - must NOT have x prefix*/
/* Access control: Ability to View list of all forms */
$registry->setValue ( 'Security.FrontController.viewforms', '0' );

/**
 * set the default xajax bfHandler's name - must be unique else many bf components will fall over each other
 * You also need to manually change this is js.js as we cant set it in JS files
 */
$registry->setValue ( 'bfFramework_form.bfHandler', 'bfHandler' );

/* Set our default controller file and path */
$registry->setValue ( 'bfFramework_form.controller.admin', bfCompat::getAbsolutePath () . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'controller' . DS . 'admin' . '.php' );
$registry->setValue ( 'bfFramework_form.controller.front', bfCompat::getAbsolutePath () . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'controller' . DS . 'front' . '.php' );

/**
 * Set the defaults for bfModel
 */
$registry->setValue ( 'bfFramework_form.bfModel.defaults.published', '0' );
$registry->setValue ( 'bfFramework_form.bfModel.defaults.access', '0' );
$registry->setValue ( 'bfFramework_form.bfModel.defaults.checked_out', '0' );
$registry->setValue ( 'bfFramework_form.bfModel.defaults.layout', 'table' );

/**
 * Configure the names of the tabs in Configuration Screen
 */
$registry->setValue ( 'bfFramework_form.form_config_tabs.General', 'General' );
$registry->setValue ( 'bfFramework_form.form_config_tabs.Access', 'Access' );
$registry->setValue ( 'bfFramework_form.form_config_tabs.Layout', 'Layout' );
$registry->setValue ( 'bfFramework_form.form_config_tabs.Security', 'Security' );
$registry->setValue ( 'bfFramework_form.form_config_tabs.Advanced HTML', 'Advanced HTML' );
//$registry->setValue('bfFramework_form.form_config_tabs.Submissions', 	'Submissions' );
$registry->setValue ( 'bfFramework_form.form_config_tabs.EXPERTS ONLY', 'EXPERTS ONLY' );

/**
 * Configuraton Vars - used in building configuration pages
 * Also these set the defaults
 * And tell the configuration view which tab to place the items on
 * Items are rendered in the order they are here!
 */
$config_vars = array ();

$config_vars ['layout'] = array ('layout', // ID
bfText::_ ( 'Choose the layout plugin to render/paint the form with' ), // Text Label
'string', // Input Type
'selectbox', // Form Field Type
'basic', // Default Value
'Layout', // Tab
bfText::_ ( '' ), array ('basic' => bfText::_ ( 'Basic  - xHTML Valid using div and span tags' ), 'default' => bfText::_ ( 'default - using default tags ' ), 'cmx' => bfText::_ ( 'cmx' ) ) ); // Tip


$config_vars ['showtitle'] = array ('showtitle', // ID
bfText::_ ( 'Show the form title as page title' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'Layout', // Tab
bfText::_ ( '' ) );

$config_vars ['showresetbutton'] = array ('showresetbutton', // ID
bfText::_ ( 'Show the forms reset button' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'Layout', // Tab
bfText::_ ( 'Toggle this to no to stop the reset button showing' ) );

$config_vars ['showpreviewbutton'] = array ('showpreviewbutton', // ID
bfText::_ ( 'Show the forms preview button' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'Layout', // Tab
bfText::_ ( 'Toggle this to yes to allow users to preview their submission before submitting' ) );

$config_vars ['showsubmitbutton'] = array ('showsubmitbutton', // ID
bfText::_ ( 'Show the forms submit button, when preview button enabled' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'Layout', // Tab
bfText::_ ( 'Toggle this to yes to allow users a choice between preview and submit' ) );

$config_vars ['submitbuttontext'] = array ('submitbuttontext', // ID
bfText::_ ( 'Submit button prompt text' ), // Text Label
'string', // Input Type
'textbox', // Form Field Type
'Submit Form', // Default Value
'Layout', // Tab
bfText::_ ( 'This is the translated text that shows on the forms submit button' ) ); // Tip


$config_vars ['resetbuttontext'] = array ('resetbuttontext', // ID
bfText::_ ( 'Submit reset prompt text' ), // Text Label
'string', // Input Type
'textbox', // Form Field Type
'Reset', // Default Value
'Layout', // Tab
bfText::_ ( 'This is the translated text that shows on the forms reset button' ) ); // Tip


$config_vars ['processorurl'] = array ('processorurl', // ID
bfText::_ ( 'Alternative Processing Script' ), // Text Label
'string', // Input Type
'textbox', // Form Field Type
'', // Default Value
'EXPERTS ONLY', // Tab
bfText::_ ( 'If you set this to a URL then the FORM tags ACTION attribute will be set to this url, NOTE: bfForms will NOT be able to process this form in this case!<br /><br /><strong>If you have imported your own HTML as a prebuilt form and then parsed the form to remove the place holders, AND you still want bfForms to process this form then you MUST REMOVE THIS URL ABOVE AND LET bfForms DECIDE ITS OWN PROCESSOR URL</STRONG>' ) ); // Tip


$config_vars ['hasusertable'] = array ('hasusertable', // ID
bfText::_ ( 'Storage table for submitted data' ), // Text Label
'string', // Input Type
'textbox', // Form Field Type
'', // Default Value
'EXPERTS ONLY', // Tab
bfText::_ ( 'Automatically Generated :: The dynamically created table in which all submitted data is stored, DO NOT CHANGE unless you know what you are doing' ) ); // Tip


$config_vars ['enableixedit'] = array ('enableixedit', // ID
bfText::_ ( 'Enable ixEdit Interface' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'EXPERTS ONLY', // Tab
bfText::_ ( 'see <a href="http://blog.phil-taylor.com/2009/11/22/how-to-make-form-fields-hide-and-show-with-no-coding/">http://blog.phil-taylor.com/2009/11/22/how-to-make-form-fields-hide-and-show-with-no-coding/</a> for more details' ) ); // Tip

$config_vars ['enablejankomultipage'] = array ('enablejankomultipage', // ID
bfText::_ ( 'Enable Janko Multi Page Fieldset Solution' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'EXPERTS ONLY', // Tab
bfText::_ ( 'see <a href="http://www.jankoatwarpspeed.com/examples/webform_to_wizard/#">http://www.jankoatwarpspeed.com/examples/webform_to_wizard/#</a> for more details on form format' ) ); // Tip


$config_vars ['form_name'] = array ('form_name', // ID
bfText::_ ( 'This forms friendly name' ), // Text Label
'string', // Input Type
'textbox', // Form Field Type
'', // Default Value
'General', // Tab
bfText::_ ( 'This is never shown on your sites visitors' ) ); // Tip


$config_vars ['page_title'] = array ('page_title', // ID
bfText::_ ( 'What would you like the page title to say' ), // Text Label
'string', // Input Type
'textbox', // Form Field Type
'myForm', // Default Value
'General', // Tab
bfText::_ ( 'This is the title that will be in the &lt;title&gt; tags of the &lt;head&gt; of the html document' ) ); // Tip


$config_vars ['published'] = array ('published', // ID
bfText::_ ( 'Is this form enabled/published' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'Access', // Tab
bfText::_ ( 'Use this to stop anyone viewing/submitting this form' ) ); // Tip


$config_vars ['access'] = array ('access', // ID
bfText::_ ( 'Minimum Access Level To View And Submit Form' ), // Text Label
'int', // Input Type
'selectbox', // Form Field Type
'0', // Default Value
'Access', // Tab
bfText::_ ( 'Users in this group and below will be able to view and submit this form' ), array ('0' => bfText::_ ( 'Public' ), '1' => bfText::_ ( 'Registered' ), '2' => bfText::_ ( 'Special' ) ) ); // Tip


$config_vars ['onlyssl'] = array ('onlyssl', // ID
bfText::_ ( 'Only Allow This Form To Be Viewed And Submitted Over Secure https/ssl' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'Access', // Tab
bfText::_ ( 'This requires that you have a SSL certficate set up for this site and that joomla can run from https. Enable for maximum security.' ) );

$config_vars ['maxsubmissionsperuser'] = array ('maxsubmissionsperuser', // ID
bfText::_ ( 'Number of times a visitor/user can submit this form successfully' ), // Text Label
'int', // Input Type
'textbox', // Form Field Type
'0', // Default Value
'Access', // Tab
bfText::_ ( 'Setting this to a number greater than Zero will cause bfForms to track the number of submissions per visitor.  If the visitor is not logged into Joomla then this will be tracked by IP Address and if the user is logged in we will track by Joomla User ID' ) ); // Tip


$config_vars ['maxsubmissions'] = array ('maxsubmissions', // ID
bfText::_ ( 'Maximum number of sucessful submissions this form will except' ), // Text Label
'int', // Input Type
'textbox', // Form Field Type
'10', // Default Value
'Access', // Tab
bfText::_ ( 'Setting this to a number greater than Zero will cause bfForms to track the number of successful submissions and once the limit is reached will display a warning message stating the maximum number of submissions has been received' ) ); // Tip


/* new features for pausing forms and reediting them */
$config_vars ['allowpause'] = array ('allowpause', // ID
bfText::_ ( 'Allow logged in users to pause a form submission and return to it later' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'Access', // Tab
bfText::_ ( 'This requires that the user is logged in and that you have enabled the feature, non-loggedin visitors will not see this feature.' ) );

$config_vars ['allowownsubmissionedit'] = array ('allowownsubmissionedit', // ID
bfText::_ ( 'Allow logged in users to edit their own previous form submissions' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'Access', // Tab
bfText::_ ( 'This requires that the user is logged in and that you have enabled the feature, non-loggedin visitors will not see this feature.' ) );

$config_vars ['allowownsubmissiondelete'] = array ('allowownsubmissiondelete', // ID
bfText::_ ( 'Allow logged in users to delete their own previous form submissions' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'Access', // Tab
bfText::_ ( 'This requires that the user is logged in and that you have enabled the feature, non-loggedin visitors will not see this feature.' ) );

$config_vars ['method'] = array ('method', // ID
bfText::_ ( 'The Form Post Method' ), // Text Label
'string', // Input Type
'selectbox', // Form Field Type
'POST', // Default Value
'Advanced HTML', // Tab
bfText::_ ( 'Normally forms on the internet are submitted by POST, however you can use this to override to GET' ), array ('POST' => bfText::_ ( 'POST   ' ), 'GET' => bfText::_ ( 'GET   ' ) ) ); // Tip


$config_vars ['enctype'] = array ('enctype', // ID
bfText::_ ( 'The Form tags enctype attribute' ), // Text Label
'string', // Input Type
'textbox', // Form Field Type
'application/x-www-form-urlencoded', // Default Value
'Advanced HTML', // Tab
bfText::_ ( 'This attribute specifies the content type used to submit the form to the server (when the value of method is "post")' ) );

$config_vars ['accept-charset'] = array ('accept-charset', // ID
bfText::_ ( 'The Form tags accept-charset attribute' ), // Text Label
'string', // Input Type
'textbox', // Form Field Type
'UTF-8', // Default Value
'Advanced HTML', // Tab
bfText::_ ( 'This attribute specifies the list of character encodings for input data that is accepted by the server processing this form' ) );

$config_vars ['target'] = array ('target', // ID
bfText::_ ( 'Specify the target for the form submission' ), // Text Label
'string', // Input Type
'selectbox', // Form Field Type
'_self', // Default Value
'Advanced HTML', // Tab
bfText::_ ( 'This attribute specifies the "target" of the form tag - normally this is _self but can be _blank for a popup of a new page' ), array ('_blank' => 'Blank', '_self' => 'Self', '_parent' => 'Parent', '_top' => 'Top' ) );

$config_vars ['useblacklist'] = array ('useblacklist', // ID
bfText::_ ( 'Check Submitters IP Address Against Blacklist Databases' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'Security', // Tab
bfText::_ ( 'This option requires a linux webhost and will check the IP address of the submitter against 3 different spam databases ("bl.spamcop.net", "list.dsbl.org", "sbl.spamhaus.org").' ) );

$registry->setValue ( 'bfFramework_form.form_config_vars', $config_vars );

/**
 * GLOBAL CONFIG
 */

/**
 * Configure the names of the tabs in Configuration Screen
 */
$registry->setValue ( 'bfFramework_form.config_tabs.General', 'General' );
$registry->setValue ( 'bfFramework_form.config_tabs.Spam Controls', 'Spam Controls' );
$registry->setValue ( 'bfFramework_form.config_tabs.Misc Tweaks', 'Misc Tweaks' );
$config_vars = array ();

$config_vars ['dnsmx'] = array ('dnsmx', // ID
bfText::_ ( 'Set this to NO if MX checking not available on this system' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'Misc Tweaks', // Tab
bfText::_ ( 'If you get error -MX checking not available on this system- when submitting a form then set this to false' ) ); // Tip


$config_vars ['enable'] = array ('enable', // ID
bfText::_ ( 'Enable This Component' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'General', // Tab
bfText::_ ( 'If you set this to No then none of the forms created with this component will be useable on this site' ) ); // Tip


$config_vars ['bf_js_options_useblanket'] = array ('bf_js_options_useblanket', // ID
bfText::_ ( 'Use a "One Moment Please" Splashscreen/loading screen when submit button pressed' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'General', // Tab
bfText::_ ( 'if set to yes, upon submission of a form a spashscreen will show' ) ); // Tip


$config_vars ['show_list'] = array ('show_list', // ID
bfText::_ ( 'Show links to all published forms, if no form selected' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'1', // Default Value
'General', // Tab
bfText::_ ( 'if set to yes then going to the component index.php?option=com_form will display a list of forms, and if no will give an error message' ) ); // Tip


$config_vars ['global_spam_104'] = array ('global_spam_104', // ID
bfText::_ ( '!!NOT RECOMMENDED!! Disable the spam checks of internal check #104' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'Spam Controls', // Tab
bfText::_ ( '!!NOT RECOMMENDED!! if set to yes our internal checks for #104 will be disabled, this could lead to more spam on your site, enable this if you get false readings' ) ); // Tip


$config_vars ['global_spam_105'] = array ('global_spam_105', // ID
bfText::_ ( '!!NOT RECOMMENDED!! Disable the spam checks of internal check #105' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'Spam Controls', // Tab
bfText::_ ( '!!NOT RECOMMENDED!! if set to yes our internal check #105 will be disabled, this could lead to more spam on your site, enable this if you get false readings' ) ); // Tip


$config_vars ['global_spam_106'] = array ('global_spam_106', // ID
bfText::_ ( '!!NOT RECOMMENDED!! Disable the spam checks of internal check #106' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'Spam Controls', // Tab
bfText::_ ( '!!NOT RECOMMENDED!! if set to yes our internal check #106 will be disabled, this could lead to more spam on your site, enable this if you get false readings' ) ); // Tip


$config_vars ['global_spam_108'] = array ('global_spam_108', // ID
bfText::_ ( '!!NOT RECOMMENDED!! Disable the spam checks of internal check #108' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'Spam Controls', // Tab
bfText::_ ( '!!NOT RECOMMENDED!! if set to yes our internal check #108 will be disabled, this could lead to more spam on your site, enable this if you get false readings' ) ); // Tip


$config_vars ['global_spam_109'] = array ('global_spam_109', // ID
bfText::_ ( '!!NOT RECOMMENDED!! Disable the spam checks of internal check #109' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'Spam Controls', // Tab
bfText::_ ( '!!NOT RECOMMENDED!! if set to yes our internal check #109 will be disabled, this could lead to more spam on your site, enable this if you get false readings' ) ); // Tip


$config_vars ['global_spam_483'] = array ('global_spam_483', // ID
bfText::_ ( '!!NOT RECOMMENDED!! Disable the spam checks of internal check #483' ), // Text Label
'int', // Input Type
'yesnoradiolist', // Form Field Type
'0', // Default Value
'Spam Controls', // Tab
bfText::_ ( '!!NOT RECOMMENDED!! if set to yes our internal check #483 will be disabled, this could lead to more spam on your site, enable this if you get false readings' ) ); // Tip


$registry->setValue ( 'bfFramework_form.config_vars', $config_vars );