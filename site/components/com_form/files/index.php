<?php
/**
 * @version $Id: index.php 147 2009-07-14 20:20:18Z  $
 * @package Joomla Forms
 * @subpackage bfFramework
 * @copyright Copyright (C) 2008 Blue Flame IT Ltd. All rights reserved.
 * @license see LICENSE.php
 * @link http://www.blueflameit.ltd.uk
 * @author Blue Flame IT Ltd.
 */
header ( "HTTP/1.0 404 Not Found" );
?>
<html>
<title>404 - Page Not Found.</title>
<style type="text/css">
div#error {
	align: center;
	text-align: center;
	border: 2px double red;
	width: 50%;
	margin: 0pt auto;
	width: 770px;
	padding: 50px;
}

#bfCopyright {
	border-top: 1px solid #CCCCCC;
	clear: both;
	display: block;
	margin-top: 50px;
	padding-top: 20px;
	text-align: center;
	color: #333333;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>
<body>
<div id="error">
<h1>Page Not Found</h1>
For more Joomla Components Please visit our site at: <a
	href="http://www.joomla-components.co.uk">Joomla Extensions</a></div>

<div id="bfCopyright"><b><i>Power In Simplicity!</i></b> <br />
<a target="_blank" href="http://www.phil-taylor.com/" class="hasTip">&copy; <?php
echo date ( 'Y' );
?> Blue Flame IT Ltd.</a> <br />
</div>
</body>
</html>
<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );
/**
 * @version $Id: index.php 147 2009-07-14 20:20:18Z  $
 * @package Joomla Knowledgebase
 * @subpackage bfFramework
 * @copyright Copyright (C) 2008 Blue Flame IT Ltd. All rights reserved.
 * @license see LICENSE.php
 * @link http://www.blueflameit.ltd.uk
 * @author Blue Flame IT Ltd.
 *
 */
?>