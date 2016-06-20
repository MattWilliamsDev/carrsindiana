<?php
/**
 * @version $Id: welcome.php 147 2009-07-14 20:20:18Z  $
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

$controller->setPageTitle ( bfText::_ ( 'Quick Start Guide for Blue Flame Forms' ) );
$controller->setPageHeader ( bfText::_ ( 'Quick Start Guide for Blue Flame Forms' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'help', 'xhelp', bfText::_ ( 'Click here to view Help and Support Information' ) );
$toolbar->render ( true );

?>
<div style="text-align: left; width: 100%;">

<table style="margin-left: 40px; margin-top: 20px;" cellpadding="5">
	<tr>
		<td><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step1.png"
			alt="step1" /></td>
		<td>
		<h2>Create or Choose Form to Work with</h2>
		<br />
		<p><a href="javascript:void(0);"
			onclick="killTinyMCE();jQuery('div#bf-main-content').fadeOut('fast');bfHandler('xforms');"><?php
			echo bfText::_ ( 'Click here</a> to view the list of forms on this site, from that page you can also create your first form' )?>
				</a></p>
		</td>
	</tr>
	<!-- 
	<tr>
		<td><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step2.png"
			alt="step1" /></td>
		<td>
		<h2>Install Additional Free Addons</h2>
		<br />
		<p><a href="javascript:void(0);"
			onclick="killTinyMCE();jQuery('div#bf-main-content').fadeOut('fast');bfHandler('xplugins');">Click
		here to install the addition addons</a> (Mambots etc...) that provide
		additional features.</p>
		</td>
	</tr>
-->
	<tr>
		<td><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step2.png"
			alt="step3" /></td>
		<td>
		<h2>Set your preferences</h2>
		<br />
		<p><a href="javascript:void(0);"
			onclick="killTinyMCE();jQuery('div#bf-main-content').fadeOut('fast');bfHandler('xconfiguration');">Click
		here to set your preferences</a></p>
		</td>
	</tr>

	<tr>
		<td><img
			src="../<?php
			echo bfCompat::mambotsfoldername ();
			?>/system/blueflame/view/images/step3.png"
			alt="step5" /></td>
		<td>
		<h2>Join our Support Forum or Leave Feeback</h2>
		<br />
		<p><a href="http://www.joomla-forms.com/forum/" target="_blank">Click
		here to visit the customer support forum</a>, while you are there feel
		free to post your feedback on the component, or help others as well :)</p>
		</td>
	</tr>

</table>

</div>