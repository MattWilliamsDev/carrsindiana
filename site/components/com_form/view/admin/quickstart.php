<?php
/**
 * @version $Id: quickstart.php 147 2009-07-14 20:20:18Z  $
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

$controller->setPageTitle ( bfText::_ ( 'Quick Start Guide To Creating Great Forms' ) );
$controller->setPageHeader ( bfText::_ ( 'Quick Start Guide To Creating Great Forms' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'help', 'xhelp', bfText::_ ( 'Click here to view Help and Support Information' ) );
$toolbar->render ( true );

$session = bfSession::getInstance ( 'com_form' );
?>
<div style="text-align: left; width: 100%;">

<h1>Congratulations - You have created a form, but now we need to
configure it!</h1>

<table style="margin-left: 40px; margin-top: 20px;" cellpadding="5">
	<tr>
		<td><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step1.png"
			alt="step1" /></td>
		<td>
		<h2><?php
		echo bfText::_ ( 'Review and modify the form configuration' );
		?></h2>
		<br />
		<p><a href="javascript:void(0);"
			onclick="killTinyMCE();jQuery('div#bf-main-content').fadeOut('fast');bfHandler('xformconfiguration');"><?php
			echo bfText::_ ( 'Click here' ) . '</a> ' . bfText::_ ( 'to view this forms name and page title, also you can set the' )
			. ' <a href="javascript:void(0);" onclick="bfFramework.menuClick(\''.bfText::_('Loading...').'\',\'xspamcontrols\');">'
			. bfText::_ ( 'spam controls' ) . '</a>, <a href="javascript:void(0);" onclick="bfFramework.menuClick(\''.bfText::_('Loading...').'\',\'xformaccess\');">'
			. bfText::_ ( 'user permissions' ) . '</a> ' . bfText::_ ( 'and other defaults' );
			?>
				</a></p>
		</td>
	</tr>
	<tr>
		<td><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step2.png"
			alt="step1" /></td>
		<td>
		<h2><?php
		echo bfText::_ ( 'Add Form Fields To Your Form' );
		?></h2>
		<br />
		<p><a href="javascript:void(0);"
			onclick="killTinyMCE();jQuery('div#bf-main-content').fadeOut('fast');bfHandler('xfields');"><?php
			echo bfText::_ ( 'Next we need to add all our form fields to the form' );
			?></a> - <?php
			echo bfText::_ ( 'These are the questions and answer areas your visitors will fill in' );
			?></p>
		</td>
	</tr>

	<tr>
		<td><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step3.png"
			alt="step3" /></td>
		<td>
		<h2><?php
		echo bfText::_ ( 'Set The Form Actions To Process Your Form' );
		?></h2>
		<br />
		<p><a href="javascript:void(0);"
			onclick="killTinyMCE();jQuery('div#bf-main-content').fadeOut('fast');bfHandler('xactions');"><?php
			echo bfText::_ ( 'Add some actions to your form' );
			?></a> - <?php
			echo bfText::_ ( 'these plugins are triggered after the form is submitted, they tell the program what to do with the submitted form values' );
			?></p>
		</td>
	</tr>

	<tr>
		<td><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step4.png"
			alt="step5" /></td>
		<td>
		<h2><?php
		echo bfText::_ ( 'Preview Your Form' );
		?></h2>
		<br />
		<?php
		$url = '../index.php?option=com_form&form_id=' . $session->get ( 'lastFormId', '', 'default' );

		?>
		<p><a href="<?php
		echo $url;
		?>" target="_blank"><?php
		echo bfText::_ ( 'Click here to preview your form' );
		?></a></p>
		</td>
	</tr>

</table>

</div>