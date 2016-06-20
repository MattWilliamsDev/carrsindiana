<?php /**  * @copyright	Copyright (C) 2011 JoomlaThemes.co - All Rights Reserved. **/
defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'YOURBASEPATH', dirname(__FILE__) );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
<?php if ($this->error->getCode()>=400 && $this->error->getCode() < 500) { 	?>
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/styles.css" type="text/css" />
<?php
	$files = JHtml::_('stylesheet','templates/'.$this->template.'/css/general.css',null,false,true);
	if ($files):
		if (!is_array($files)):
			$files = array($files);
		endif;
		foreach($files as $file):
?>
		<link rel="stylesheet" href="<?php echo $file;?>" type="text/css" />
<?php
	 	endforeach;
	endif;
?>

</head>
<body class="background">
	<div id="error">
		<h2><?php echo JText::_('JERROR_AN_ERROR_HAS_OCCURRED'); ?></h2>
							
		<p class="error"><strong>ERROR <?php echo $this->error->getCode() ;?></strong> - <?php echo $this->error->getMessage();?></p>
		<p><a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>">Go to the <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></p>
	</div>
</div>

</body>
</html>
<?php } ?>
