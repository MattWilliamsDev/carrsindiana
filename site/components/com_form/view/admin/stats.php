<?php
/**
 * @version $Id: stats.php 147 2009-07-14 20:20:18Z  $
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
$controller->setPageTitle ( bfText::_ ( 'Statistics' ) );

/* Set the Page Header */
$controller->setPageHeader ( bfText::_ ( 'Statistics' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'help', 'xhelp', bfText::_ ( 'Click here to view Help and Support Information' ) );
$toolbar->render ( true );

$registry->setValue ( 'usedTabs', 1 );

?>

<div id="bfTabs">

<ul class="ui-tabs-nav">
	<li class=""><a href="#page-stats"><span><img
		src="<?php
		echo _BF_FRAMEWORK_LIB_URL;
		?>/view/images/bullet-statistics.gif"
		align="absmiddle" />&nbsp;Spam Statistics</span></a></li>
</ul>

<div id="page-stats" class="active">
<table class="bfadminlist">
	<tbody>
		<tr class="">
			<td style="padding: 10px;">
			<h2>Out of the <?php
			echo $form ['count_spamsubmissions'] + $form ['count_oksubmissions'];
			?>  Submissions, <?php
			echo $form ['count_oksubmissions'];
			?> have passed and <?php
			echo $form ['count_spamsubmissions'];
			?> have failed spammer checks</h2>
				
				<?php
				
				if ($form ['count_spamsubmissions'] >= 1 && $form ['count_oksubmissions'] >= 1) {
					?>
				<img
				src="<?php
					bfLoad ( 'bfGooglechartsapi' );
					echo bfGoogleChartsAPI::getPieChart ( bfText::_ ( 'Spam' ), bfText::_ ( 'Genuine' ), $form ['count_spamsubmissions'], $form ['count_oksubmissions'] );
					?>" />
				<?php
				}
				?>
				
		
		
		</tr>
	</tbody>
</table>
</div>

<?php
bfHTML::addHiddenIdField ( $form );
?>
</div>