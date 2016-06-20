<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >

<head>
<jdoc:include type="head" />
<link href="<?php echo $this->baseurl ?>/templates/99theme/CSS/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl ?>/templates/99theme/favicon.ico" rel="shortcut icon" />
</head>


<body>
<!--[if lte IE 6]><script src="<?php echo $this->baseurl ?>/templates/99theme/CSS/warning.js"></script><script>window.onload=function(){e("<?php echo $this->baseurl ?>/templates/99theme/CSS/")}</script><![endif]-->
<div id="all">

     <div class="top99">
          <?php if ($this->countModules('position-1')) : ?>
          <div class="bar99">                                        
               <div class="bar">
               <img class="bar-l" src="<?php echo $this->baseurl ?>/templates/99theme/images/bar-l.png" alt="http://99theme.com"/><span class="fix99"><jdoc:include type="modules" name="position-1"/></span><img class="bar-r" src="<?php echo $this->baseurl ?>/templates/99theme/images/bar-r.png" alt="http://99theme.com"/> 
               </div>
               <div class="clear"></div>
          </div>
          <?php endif; ?>
          
          <img class="logo99" src="<?php echo $this->baseurl ?>/templates/99theme/images/logo.png" alt="http://99theme.com"/>
          <div class="clear"></div>
     </div>

     <div class="center99"> 
          <div class="qq">   
          <div class="banner99">
          <img class="banner-l" src="<?php echo $this->baseurl ?>/templates/99theme/images/banner-l.png" alt="http://99theme.com"/>     
          </div>
          <img class="banner-r" src="<?php echo $this->baseurl ?>/templates/99theme/images/banner-r.png" alt="http://99theme.com"/> 
          <div class="clear"></div>
          </div>
          
          <div class="menu99">
          <img height="125px" width="232px" src="<?php echo $this->baseurl ?>/templates/99theme/images/banner-b.png" alt="http://99theme.com"/>
               <?php if ($this->countModules('randomimageload')) : ?>
               <div class="catalog99">
               <div class="photo">
               <jdoc:include type="modules" name="randomimageload" style="xhtml"/>
               </div>
               </div>
               <?php endif; ?>
               <?php if ($this->countModules('position-7')) : ?>
               <div class="left99">
               <div class="left">
               <jdoc:include type="modules" name="position-7" style="xhtml"/>
               </div>
               </div>
               <?php endif; ?>                             
          </div>
          
          <div class="body99">
          	   <?php if ($this->countModules('position-2')) : ?>
               <div class="left99">
               <div class="left">
               <jdoc:include type="modules" name="position-2" />
               </div>
               </div>
               <?php endif; ?> 
               
               <jdoc:include type="component" />
               
               <div class="new99">
                    <?php if ($this->countModules('articleslatestload')) : ?>         
                    <div class="user1">
                    <jdoc:include type="modules" name="articleslatestload" style="xhtml"/>
                    </div>
                    <?php endif; ?>
               
                    <?php if ($this->countModules('articlespopularload')) : ?>         
                    <div class="user2">
                    <jdoc:include type="modules" name="articlespopularload" style="xhtml"/>
                    </div>
                    <?php endif; ?>
                    <div class="clear"></div>
               </div>
               <div class="copyright99">
               Design by <a href="http://99theme.com">99Theme.com</a><br />
               Copyright 2010 &copy; Joomla
               </div>
          </div>  
          <div class="clear"></div> 
          
          
           
     </div>
     
     <div class="bottom99">
     </div>

</div>
</body>
</html>
