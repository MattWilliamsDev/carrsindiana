<?php defined('_JEXEC') or die('Restricted access'); 

?><div id="phocagallery-comments"><?php
	echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';//because of IE bug 
	
	//$option = JRequest::getVar('option', 'com_phocagallery');
	//$view 	= JRequest::getVar('view', 'category');
	//$xid 	= md5(JURI::base() . $option . $view) . 'pgcat'.(int)$this->category->id;
	$uri 		= &JFactory::getURI();
	$uri->delVar('limitstart');
	$uri->delVar('start');
	
	if ($this->tmpl['fb_comment_app_id'] == '') {
		echo JText::_('COM_PHOCAGALLERY_ERROR_FB_APP_ID_EMPTY');
	} else {
	
		$cCount = '';
		if ((int)$this->tmpl['fb_comment_count'] > 0) {
			$cCount = 'numposts="'.$this->tmpl['fb_comment_count'].'"';
		}

?><fb:comments href="<?php echo $uri->toString(); ?>" simple="1" <?php echo $cCount;?> width="<?php echo (int)$this->tmpl['fb_comment_width'] ?>"></fb:comments>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
   FB.init({
     appId: '<?php echo $this->tmpl['fb_comment_app_id'] ?>',
     status: true,
	 cookie: true,
     xfbml: true
   });
 }; 
  (function() {
    var e = document.createElement('script');
    e.type = 'text/javascript';
    e.src = document.location.protocol + '//connect.facebook.net/<?php echo $this->tmpl['fb_comment_lang']; ?>/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
   }());
</script>
<?php } ?>
</div>
