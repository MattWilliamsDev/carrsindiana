<?php
/**
 * @version $Id: help.php 184 2010-01-03 20:44:13Z  $
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

$controller->setPageTitle ( bfText::_ ( 'Help &amp; Assistance1' ) );
$controller->setPageHeader ( bfText::_ ( 'Help &amp; Assistance' ) );

/* Create a toolbar, or use a deafult index type toolbar */
$toolbar = bfToolbar::getInstance ( $controller );
$toolbar->addButton ( 'refresh', 'xhelp', bfText::_ ( 'Reload configuration' ) );
$toolbar->render ( true );

?><div style="text-align: left; float: left;">	<?php

$sourcesite = 'http://www.phil-taylor.com';
$sourceurl = $sourcesite . '/index2.php?option=com_kb&task=rss&format=RSS2.0&no_html=1&pop=1&type=latestlistingspercategory&category=';

switch ($mainframe->get ( 'component' )) {
	case 'com_kb' :
		$sourcesite = 'http://www.joomla-knowledgebase.com';
		$sourceurl = $sourcesite . '/index2.php?option=com_kb&task=rss&format=RSS2.0&no_html=1&pop=1&type=latestlistings'; //&type=latestlistingspercategory&category=
		$xmlFile = $sourceurl; //. '23';
		break;
	case 'com_form' :
		$sourcesite = 'http://www.joomla-forms.com';
		$sourceurl = $sourcesite . '/index2.php?option=com_kb&task=rss&format=RSS2.0&no_html=1&pop=1&type=latestlistings'; //&type=latestlistingspercategory&category=
		$xmlFile = $sourceurl; //. '23';
		break;
	case 'com_tag' :
		$sourcesite = 'http://www.joomla-tags.com';
		$sourceurl = $sourcesite . '/index2.php?option=com_kb&task=rss&format=RSS2.0&no_html=1&pop=1&type=latestlistings'; //&type=latestlistingspercategory&category=
		$xmlFile = $sourceurl; //. '23';
		break;
	default :
		$xmlFile = 'NONE';
		break;
}

if ($xmlFile !== 'NONE') {

	include_once (bfCompat::getAbsolutePath () . DS . 'administrator' . DS . 'components' . DS . $mainframe->get ( 'component' ) . DS . 'bfXML.php');

	$string = file_get_contents ( $xmlFile );

	if (preg_match ( '/rss version/', $string )) {
		$xml = new bfXml ( );
		?><h1><?php
		echo bfText::_ ( 'FAQ For this product' );
		?></h1><?php
		$arr = $xml->parse ( $string, 'STRING' );

		echo '<Span style="text-align: left;"><ul class="bfsubmenu">';
		if (count ( $arr ['channel'] ['item'] )) {
			foreach ( $arr ['channel'] ['item'] as $item ) {
				//				$link = implode('',$item['link']);
				$link = $item ['link'];
				echo '<li class="bullet-info"><a href="' . $link . '" target="_blank">' . $item ['title'] . '</a></li>';
			}
		} else {
			echo '<li class="bullet-info">None Found</li>';
		}

		echo '</ul></span>';
	}
}
?>

	<h1><?php
	echo bfText::_ ( 'Where to get help and assistance' );
	?></h1>

<ul class="bfsubmenu">


	<li class="submenuicon-blueflame"><a href="http://blog.phil-taylor.com"><?php
	echo bfText::_ ( 'Latest Blue Flame News' );
	?></a></li>
	<li class="submenuicon-blueflame"><a
		href="http://www.phil-taylor.com/Contact_Us/"><?php
		echo bfText::_ ( 'Contact Blue Flame IT Support Desk' );
		?></a></li>
	<li class="submenuicon-download-refresh"><a
		href="https://secure.myJoomla.com"><?php
		echo bfText::_ ( 'Download Latest Version' );
		?></a></li>
</ul>
</div>
