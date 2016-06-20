<?php
/**
 * @version $Id: admin.form.php 148 2009-07-14 20:20:31Z  $
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

if (defined ( '_VALID_MOS' ) or defined ( '_JEXEC' )) {
	/* ok we are in Joomla 1.0.x or Joomla 1.5+ */
	if (! defined ( '_VALID_MOS' )) {
		/* We are in Joomla 1.5 */
		if (! defined ( '_VALID_MOS' ))
			define ( '_VALID_MOS', '1' );
		if (! defined ( '_PLUGIN_DIR_NAME' ))
			define ( '_PLUGIN_DIR_NAME', 'plugins' );
		define ( '_BF_PLATFORM', 'JOOMLA1.5' );
	} else if (! defined ( '_JEXEC' )) {
		/* we are in Joomla 1.0 */
		if (! defined ( '_JEXEC' ))
			define ( '_JEXEC', '1' );
		if (! defined ( '_PLUGIN_DIR_NAME' ))
			define ( '_PLUGIN_DIR_NAME', 'mambots' );
		if (! defined ( '_BF_PLATFORM' ))
			define ( '_BF_PLATFORM', 'JOOMLA1.0' );
		if (! defined ( 'JPATH_ROOT' ))
			define ( 'JPATH_ROOT', $GLOBALS ['mosConfig_absolute_path'] );
		if (! defined ( 'DS' ))
			define ( 'DS', DIRECTORY_SEPARATOR );
	} else {
		if (defined ( '_VALID_MOS' ) or defined ( '_JEXEC' )) {
			/* Joomla 1.5 with legacy mode enabled*/
			/* We are in Joomla 1.5 */
			if (! defined ( '_VALID_MOS' ))
				define ( '_VALID_MOS', '1' );
			if (! defined ( '_PLUGIN_DIR_NAME' ))
				define ( '_PLUGIN_DIR_NAME', 'plugins' );
			if (! defined ( '_BF_PLATFORM' ))
				define ( '_BF_PLATFORM', 'JOOMLA1.5' );
		} else {
			die ( 'Unknown Platform- Contact Support' );
		}
	}
	if (! defined ( 'JPATH_SITE' ))
		define ( 'JPATH_SITE', $GLOBALS ['mosConfig_absolute_path'] );
	if (! defined ( 'DS' ))
		define ( 'DS', DIRECTORY_SEPARATOR );
	if (! defined ( '_JEXEC' ))
		define ( '_JEXEC', '1' );
	if (! defined ( 'BF_PLATFORM' ))
		define ( 'BF_PLATFORM', 'STANDALONE' );
	if (! defined ( 'JPATH_BASE' ))
		define ( 'JPATH_BASE', $GLOBALS ['mosConfig_absolute_path'] );
	if (! defined ( '_BF_JPATH_BASE' ))
		define ( '_BF_JPATH_BASE', @$GLOBALS ['mosConfig_absolute_path'] );
} else {
	header ( 'HTTP/1.1 403 Forbidden' );
	die ( 'Direct access not allowed' );
}

/* PHP version Check */
if (phpversion () < '5.0.0')
	die ( 'This Extension Requires PHP 5 or Greater - <a href="http://www.joomla-forms.com/faq/article/system_requirements">We did warn you before purchase</a>! :-) ' );

$nohtml = false;

if (_BF_PLATFORM == 'JOOMLA1.5') {
	$tmpl = JRequest::getVar ( 'no_html' );
	if ($tmpl == '1') {
		$nohtml = true;
	}
} else {
	$tmpl = mosGetParam ( $_REQUEST, 'no_html', 0 );
	if ($tmpl == '1') {
		$nohtml = true;
	}
}
//
//if (file_exists ( JPATH_ROOT . '/components/com_joomfish/joomfish.php' )) {
//	require_once (JPATH_ROOT . '/administrator/components/com_joomfish/mldatabase.class.php');
//	require_once (JPATH_ROOT . '/administrator/components/com_joomfish/joomfish.class.php');
//}

/* turn on error reporting */
if ($_SERVER ['HTTP_HOST'] == '127.0.0.1' || $_SERVER ['HTTP_HOST'] == 'localhost') {
	error_reporting ( E_ALL );
}

/* set component names */
$mainframe->set ( 'component', 'com_form' );
$mainframe->set ( 'component_shortname', 'form' );

include_once (JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'bfXML.php');

/* get entry task */
if (_BF_PLATFORM == 'JOOMLA1.0') {
	$entry_task = mosGetParam ( $_REQUEST, 'entry_task', null );
} else {
	$entry_task = JRequest::getVar ( 'entry_task' );
	// @todo
//	die('Not yet compatible with Joomla 1.5 - sorry!');
//	die(__FILE__ . ' line 51 ');
}

if ($entry_task === null) {

	$nofiles = file_exists ( JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'bfVersion.php' );
	if (! $nofiles) {
		$entry_task = 'noframework';
	} else {
		/* cehck that the framework mambot is published */
		/* check framework version */
		$bfVer = file_get_contents ( $ae = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'bfVersion.php' );
		$parts = explode ( "\n", $bfVer );
		$frameworkVersion = $parts [2];

		/* check my component version */
		$xml = new bfXml ( );

		$xmlFile = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'versions.txt';
		$arr = $xml->parse ( $xmlFile );

		$componentRequiresVersion = $arr ['requiresMinimumFrameworkVersion'];

		/* compare */
		if ($componentRequiresVersion > $frameworkVersion) {
			$entry_task = 'upgradeFramework';
		}

		_checkXAJAXVersions ();

		/* check xajax */
		if (_BF_PLATFORM == 'JOOMLA1.0') {
			$checkFile = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'xajax.system.php';
		} else {
			$checkFile = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'xajax.php';
		}
		if (file_exists ( $checkFile )) {
			/* xajax installed - make sure its published ! */
			if (_BF_PLATFORM == 'JOOMLA1.0') {
				global $database;
				$database->setQuery ( 'UPDATE #__mambots SET published=\'1\' WHERE element = \'xajax.system\'' );
				$database->query ();
			} else {
				$db = & JFactory::getDBO ();
				$db->setQuery ( 'UPDATE #__plugins SET published=\'1\' WHERE element = \'xajax.system\'' );
				$db->query ();

			}
		} else {
			$entry_task = 'needXajax';
		}
	}
}

function _checkXAJAXVersions() {
	if (file_exists ( JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'xajax_0.2.4' )) {
		@rename ( JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'xajax_0.2.4', JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'PLEASEDELETEME_xajax_0.2.4' );
		@unlink ( JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'xajax.system.php' );
		@unlink ( JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'xajax.system.xml' );
		die ( 'Removed old xajax files - please hit refresh' );
	}
}

switch ($entry_task) {

	case "upload_file" :

		if (_BF_PLATFORM == 'JOOMLA1.5' && ! function_exists ( 'mosPathName' )) {
			function mosPathName($p_path, $p_addtrailingslash = true) {
				jimport ( 'joomla.filesystem.path' );
				$path = JPath::clean ( $p_path );
				if ($p_addtrailingslash) {
					$path = rtrim ( $path, DS ) . DS;
				}
				return $path;
			}
		}

		$path = mosPathName ( $_POST ['filepath'], true );
		if ($_FILES ['uploaded_file'] ['tmp_name']) {
			if (! file_exists ( mosPathName ( $path . $_FILES ['uploaded_file'] ['name'] ) )) {
				if (copy ( $_FILES ['uploaded_file'] ['tmp_name'], mosPathName ( $path . $_FILES ['uploaded_file'] ['name'], false ) )) {
					@unlink ( $_FILES ['uploaded_file'] ['tmp_name'] );
					?><script>parent.jQuery('#filename').val('<?php
					echo $_FILES ['uploaded_file'] ['name'];
					?>');parent.submitToXAJAX('save');</script><?php
				}
			} else {
				?><script>alert('File already exists!');</script><?php
			}
		} else {
			?><script>alert('No file selected!');</script><?php
		}

		die ();
		break;
	default:
		/* Pull in the bfFramework - or install framework! */
		$ae = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'bfAdminEntry.php';
		if (file_exists ( $ae )) {
			require ($ae);
		} else {
			die ( 'No framework!' );
		}
		break;

	case "doupgradeframework":
		/* check framework version */
		$bfVer = file_get_contents ( JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . DS . 'bfVersion.php' );
		$parts = explode ( "\n", $bfVer );
		$frameworkVersion = $parts [2];

		bfInstallFramework ( true, $frameworkVersion );
		break;

	case "installframework" :
		bfInstallFramework ();
		break;

	case "installxajax" :
		bfinstallxajax ();
		break;

	case "needXajax" :
		bfneedXajax ();
		break;

	case "jpromoter" :
		bfpatchjpromoter ();
		break;

	case "smfbridge" :
		patchsmfbridge ();
		break;

	case "upgradeFramework" :
		?>
<div
	style="text-align: left; width: 500px; border: 1px solid #ccc; padding: 20px; margin-bottom: 0pt; margin-left: auto; margin-right: auto; margin-top: 0pt;">

<h1>One moment please, your framework needs upgrading...</h1>

<p>We have detected that you currently have the bfFramework installed.
This framework is required for the correct operation of the current
component.</p>

<p>We need to upgrade this for you - its a simple one click proceedure
:-) just make sure the following folder is writeable and then click the
install button</p>

				<?php
		$folder = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system';
		@chmod ( $folder, 0777 );
		echo '<b>' . $folder . '</b><br />';
		echo 'This folder is currently: <b>';
		echo (file_exists ( $folder ) && is_writeable ( $folder )) ? '<span style="color: green;">Writeable</span>' : '<span style="color: red;">NOT WRITEABLE</span>';
		echo '</b>';
		if (! file_exists ( $folder ) or ! is_writeable ( $folder )) {
			echo '<br/><br/><b>The path doesnt exist or is not writeable - fix this and then refresh this page</b>';
			return;
		}
		?>
				<br />
<br />
				<?php

		$xml = new bfXml ( );
		$xmlFile = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'versions.txt';
		$arr = $xml->parse ( $xmlFile );

		printf ( 'This version of this component provides <b>version %s</b> of the bfFramework<br />', $arr ['providesFrameworkVersion'] );
		printf ( 'This version of this component REQUIRES minimum <b>version %s</b> of the bfFramework<br />', $arr ['requiresMinimumFrameworkVersion'] );
		printf ( 'This version of your current Bfframework is <b>version %s</b>, This will be upgraded to <b>version %s</b><br />', $frameworkVersion, $arr ['providesFrameworkVersion'] );
		?>
				<br />
<br />
<center><a
	href="index<?php
		echo (_BF_PLATFORM == 'JOOMLA1.0') ? '2' : '';
		?>.php?option=com_form&entry_task=doupgradeframework">Upgrade
the bfFramework </a></center>

</div>

<?php
		break;

	case "noframework" :
		?>
<div
	style="text-align: left; width: 500px; border: 1px solid #ccc; padding: 20px; margin-bottom: 0pt; margin-left: auto; margin-right: auto; margin-top: 0pt;">
<h1>One moment please...</h1>

<p>We have detected that you currently do not have the bfFramework
installed. This framework is required for the correct operation of the
current component.</p>

<p>We can install this for you - its a simple one click procedure :-)
just make sure the following folder is writeable and then click the
install button</p>

				<?php
		$folder = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system';
		@chmod ( $folder, 0777 );
		echo '<b>' . $folder . '</b><br />';
		echo 'This folder is currently: <b>';
		echo (file_exists ( $folder ) && is_writeable ( $folder )) ? '<span style="color: green;">Writeable</span>' : '<span style="color: red;">NOT WRITEABLE</span>';
		echo '</b>';
		if (! file_exists ( $folder ) or ! is_writeable ( $folder )) {
			echo '<br/><br/><b>The path doesnt exist or is not writeable - fix this and then refresh this page</b>';
			return;
		}
		?>
				<br />
<br />
				<?php

		$xml = new bfXml ( );
		$xmlFile = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'versions.txt';
		$arr = $xml->parse ( $xmlFile );

		printf ( 'This version of this component can provide <b>version %s</b> of the bfFramework<br />', $arr ['providesFrameworkVersion'] );
		printf ( 'This version of this component REQUIRES minimum <b>version %s</b of the bfFramework<br />', $arr ['requiresMinimumFrameworkVersion'] );
		?>
				<br />
<br />
<center><a
	href="index<?php
		echo (_BF_PLATFORM == 'JOOMLA1.0') ? '2' : '';
		?>.php?option=com_form&entry_task=installframework">Install
the bfFramework </a></center>
</div>

<?php
		break;
}

/**
 * Damage control of JPromoter
 */
function bfpatchjpromoter() {
	global $mainframe;

	$patchFile = JPATH_ROOT . DS . 'mambots' . DS . 'system' . DS . 'jpromoter.metaedit.php';
	$contents = file_get_contents ( $patchFile );
	if (ereg ( 'session_name', $contents )) {
		echo '<h1>' . ('Already Patched') . '</h1>';
		echo '<a href="index2.php?option=' . $mainframe->get ( 'component' ) . '">' . ('Click here to continue') . '...</a>';
		return;
	}
	$patchText = '@session_name( md5( $mosConfig_live_site ) );';
	$contents = str_replace ( "session_start();", $patchText . "\n\n" . "@session_start();" . "\n", $contents );
	if ($fp = fopen ( $patchFile, 'wb' )) {
		fwrite ( $fp, $contents );
		fclose ( $fp );
	}

	echo '<h1>' . ('Success') . '</h1>';
	echo '<a href="index2.php?option=' . $mainframe->get ( 'component' ) . '">' . ('Click here to continue') . '...</a>';
}

/**
 * Damage control of SMF Bridge
 */
function patchsmfbridge() {
	global $mainframe;
	$patchFile = JPATH_ROOT . DS . 'mambots' . DS . 'system' . DS . 'SMF_header_include.php';
	$contents = file_get_contents ( $patchFile );
	if (ereg ( '_IS_XAJAX_CALL', $contents )) {
		echo '<h1>' . ('Already Patched') . '</h1>';
		echo '<a href="index2.php?option=' . $mainframe->get ( 'component' ) . '">' . ('Click here to continue') . '...</a>';
		return;
	}
	$patchText = 'if (@_IS_XAJAX_CALL) return;';
	$contents = str_replace ( "function SMF_header_include( ) {", "function SMF_header_include( ) {" . "\n\n" . $patchText, $contents );
	if ($fp = fopen ( $patchFile, 'wb' )) {
		fwrite ( $fp, $contents );
		fclose ( $fp );
	}

	echo '<h1>' . ('Success') . '</h1>';
	echo '<a href="index2.php?option=' . $mainframe->get ( 'component' ) . '">' . ('Click here to continue') . '...</a>';
}

/**
 * Tell them they need xajax in order to save the world
 *
 */
function bfneedXajax() {
	global $mainframe;
	?>
<div
	style="text-align: left; width: 500px; border: 1px solid #ccc; padding: 20px; margin-bottom: 0pt; margin-left: auto; margin-right: auto; margin-top: 0pt;">
<h1>One moment please...</h1>

<p>We have detected that you currently do not have the xajax plugin
installed. This plugin is required for the correct operation of the
current component.</p>

<p>We can install this for you - its a simple one click procedure :-)
just make sure the following folder is writeable and then click the
install button</p>

				<?php
	$folder = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system';
	@chmod ( $folder, 0777 );
	echo '<b>' . $folder . '</b><br />';
	echo 'This folder is currently: <b>';
	echo (file_exists ( $folder ) && is_writeable ( $folder )) ? '<span style="color: green;">Writeable</span>' : '<span style="color: red;">NOT WRITEABLE</span>';
	echo '</b>';
	if (! file_exists ( $folder ) or ! is_writeable ( $folder )) {
		echo '<br/><br/><b>The path doesnt exist or is not writeable - fix this and then refresh this page</b>';
		return;
	}
	?>
				<br />
<br />
<center><a
	href="index<?php
	echo (_BF_PLATFORM == 'JOOMLA1.0') ? '2' : '';
	?>.php?option=com_form&entry_task=installxajax">Install
the xAjax Plugin (Required) </a></center>
</div>

<?php
}

function bfinstallxajax() {
	global $mainframe;

	@set_time_limit ( '9000' );
	$debug = 0;
	$filename = 'bfXajax.zip'
	?>
<div style="text-align: left; width: 800px; border: 1px solid #ccc; padding: 20px;">
<h1>Install xAJAX Plugin...</h1>

	<?php
	$archivename = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . $filename;
	if ($debug)
		echo '$archivename = ' . $archivename . '<br />';

	$extractdir = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system';
	if ($debug)
		echo '$extractdir = ' . $extractdir . '<br />';

	if (_BF_PLATFORM == 'JOOMLA1.0') {
		global $database;
		$database->setQuery ( "INSERT INTO `#__mambots` VALUES ('', 'Blue Flame Framework inc. xAJAX', 'xajax.system', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');" );
		$database->query ();

		require_once (JPATH_ROOT . '/administrator/includes/pcl/pclzip.lib.php');
		require_once (JPATH_ROOT . '/administrator/includes/pcl/pclerror.lib.php');

		$zipfile = new PclZip ( $archivename );

		if ((substr ( PHP_OS, 0, 3 ) == 'WIN')) {
			define ( 'OS_WINDOWS', 1 );
		} else {
			define ( 'OS_WINDOWS', 0 );
		}

		$ret = $zipfile->extract ( PCLZIP_OPT_PATH, $extractdir );
		if ($ret == 0) {
			echo 'Unrecoverable error "' . $zipfile->errorName ( true );
			return false;
		} else {
			mosRedirect ( 'index2.php?option=' . $mainframe->get ( 'component' ) );
		}

	} else {

		$db = & JFactory::getDBO ();
		$db->setQuery ( "INSERT INTO `#__plugins` (
`id` ,
`name` ,
`element` ,
`folder` ,
`access` ,
`ordering` ,
`published` ,
`iscore` ,
`client_id` ,
`checked_out` ,
`checked_out_time` ,
`params`
)
VALUES (
NULL , 'Blue Flame Framework inc. xAJAX', 'xajax', 'system', '0', '0', '1', '1', '0', '0', '0000-00-00 00:00:00', ''
);
" );
		$db->query ();
		/* Joomla 1.5 */
		jimport ( 'joomla.filesystem.file' );
		jimport ( 'joomla.filesystem.folder' );
		jimport ( 'joomla.filesystem.archive' );
		jimport ( 'joomla.filesystem.path' );
		$p_filename = $archivename;

		// Clean the paths to use for archive extraction
		if ($debug)
			echo '$extractdir = ' . $extractdir . '<br />';

		$archivename = JPath::clean ( $archivename );
		if ($debug)
			echo '$archivename = ' . $archivename . '<br />';

		$adapter = & JArchive::getAdapter ( 'zip' );
		$result = $adapter->extract ( $archivename, $extractdir );

		if ($result === false) {
			print_r ( $adapter->_errors );
			echo 'failed';
		} else {
			echo '<h1>Success</h1>';
			echo '<a href="index.php?option=' . $mainframe->get ( 'component' ) . '">' . 'Click here to continue' . '...</a>';
		}

	}

	?>
	</div>
<?php
}

function bfInstallFramework($isUpgrade = false, $ver = null) {
	global $mainframe;

	@set_time_limit ( '9000' );
	$debug = 0;
	$filename = 'bfFramework.zip'?>
<div
	style="text-align: left; width: 800px; border: 1px solid #ccc; padding: 20px;">
<h1>Install bfFramework...</h1>

	<?php
	$archivename = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . $filename;
	if ($debug)
		echo '$archivename = ' . $archivename . '<br />';

	//	$tmpdir 		= uniqid( 'install_' );
	//	if($debug)  echo '$tmpdir = '.$tmpdir .'<br />';


	$extractdir = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system';
	if ($debug)
		echo '$extractdir = ' . $extractdir . '<br />';

	// Extract functions
	if (_BF_PLATFORM == 'JOOMLA1.0') {
		require_once (JPATH_ROOT . '/administrator/includes/pcl/pclzip.lib.php');
		require_once (JPATH_ROOT . '/administrator/includes/pcl/pclerror.lib.php');

		$zipfile = new PclZip ( $archivename );

		if ((substr ( PHP_OS, 0, 3 ) == 'WIN')) {
			define ( 'OS_WINDOWS', 1 );
		} else {
			define ( 'OS_WINDOWS', 0 );
		}

		if ($isUpgrade) {
			/* clean up */
			$x = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'xajax.php';
			@unlink($x);
			$x = JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'xajax.xml';
			@unlink($x);
			$ret = rename ( JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame', JPATH_ROOT . DS . _PLUGIN_DIR_NAME . DS . 'system' . DS . 'blueflame' . $ver );
			if ($ret == 0) {
				die ( 'Fatal error - please make sure the /' . _PLUGIN_DIR_NAME . '/system/blueflame folder is writeable!' );
			}
		}

		$ret = $zipfile->extract ( PCLZIP_OPT_PATH, $extractdir );
		if ($ret == 0) {
			echo 'Unrecoverable error "' . $zipfile->errorName ( true );
			return false;
		} else {
			if (_BF_PLATFORM == 'JOOMLA1.0') {
				mosRedirect ( 'index2.php?option=' . $mainframe->get ( 'component' ) );
			} else {
				echo '<h1>Success</h1>';
				echo '<a href="index.php?option=' . $mainframe->get ( 'component' ) . '">' . 'Click here to continue' . '...</a>';
			}
		}

	} else {
		/* Joomla 1.5 */
		jimport ( 'joomla.filesystem.file' );
		jimport ( 'joomla.filesystem.folder' );
		jimport ( 'joomla.filesystem.archive' );
		jimport ( 'joomla.filesystem.path' );
		$p_filename = $archivename;

		// Clean the paths to use for archive extraction
		if ($debug)
			echo '$extractdir = ' . $extractdir . '<br />';

		$archivename = JPath::clean ( $archivename );
		if ($debug)
			echo '$archivename = ' . $archivename . '<br />';

		$adapter = & JArchive::getAdapter ( 'zip' );
		$result = $adapter->extract ( $archivename, $extractdir );

		if ($result === false) {
			if ($debug)
				echo 'failed';
		} else {
			if ($debug)
				echo 'success';
			echo '<h1>Success</h1>';
			echo '<a href="index.php?option=' . $mainframe->get ( 'component' ) . '">' . 'Click here to continue' . '...</a>';
		}
	}

	?>
	</div>
<?php
}