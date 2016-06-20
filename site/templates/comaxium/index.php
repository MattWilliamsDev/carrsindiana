<?php
defined( '_JEXEC' ) or die( 'Restricted index access' );
define( 'TEMPLATEPATH', dirname(__FILE__) );
/*
-----------------------------------------
Comaxium - October 2010 Shape 5 Club Template
-----------------------------------------
Site:      www.shape5.com
Email:     contact@shape5.com
@license:  Copyrighted Commercial Software
@copyright (C) 2010 Shape 5

*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<?php

//
///////////////////////////////////////////////////////////////////////////////////////

	
		$s5_highlight = $this->params->get ("xml_s5_highlight");
		$s5_fonts = $this->params->get ("xml_s5_fonts");
		$s5_date = $this->params->get ("xml_s5_date");
		$s5_fixed_fluid = $this->params->get ("xml_s5_fixed_fluid");
		$s5_fixed_body_width = $this->params->get ("xml_s5_fixed_body_width");
		$s5_fluid_body_width = $this->params->get ("xml_s5_fluid_body_width");
		$s5_right_width = $this->params->get ("xml_s5_right_width");
		$s5_left_width = $this->params->get ("xml_s5_left_width"); 
		$s5_top2_width = $this->params->get ("xml_s5_top2_width");
		$s5_menu = $this->params->get ("xml_s5_menu");    
		$s5_jsmenu = $this->params->get ("xml_s5_jsmenu");  
		$s5_text_menu_1 = $this->params->get ("xml_s5_text_menu_1");
		$s5_text_menu_2 = $this->params->get ("xml_s5_text_menu_2");
		$s5_text_menu_3 = $this->params->get ("xml_s5_text_menu_3");
		$s5_text_menu_4 = $this->params->get ("xml_s5_text_menu_4");
		$s5_text_menu_5 = $this->params->get ("xml_s5_text_menu_5");
		$s5_text_menu_6 = $this->params->get ("xml_s5_text_menu_6");
		$s5_text_menu_7 = $this->params->get ("xml_s5_text_menu_7");
		$s5_text_menu_8 = $this->params->get ("xml_s5_text_menu_8");
		$s5_text_menu_9 = $this->params->get ("xml_s5_text_menu_9");
		$s5_text_menu_10 = $this->params->get ("xml_s5_text_menu_10");
		$s5_show_frontpage = $this->params->get ("xml_s5_frontpage");  
		$s5_urlforSEO = $this->params->get ("xml_s5_seourl");
		$s5_moover = "moo124"; 
		$s5_multibox = $this->params->get ("xml_s5_multibox");
		$s5_multioverlay = $this->params->get ("xml_s5_multioverlay");
		$s5_multicontrols = $this->params->get ("xml_s5_multicontrols");
		$s5_tooltips = $this->params->get ("xml_s5_tooltips"); 
		


// It is recommended that you do not edit below this line.
///////////////////////////////////////////////////////////////////////////////////////


if (($s5_menu  == "1") || ($s5_menu  == "3") || ($s5_menu  == "4")){ 
	if ($s5_jsmenu == "s5") { 
		require( TEMPLATEPATH.DS."s5_no_moo_menu.php");
		$menu_name = $this->params->get ("xml_menuname");
	}
	else if ($s5_jsmenu == "jq")  {
		require( TEMPLATEPATH.DS."s5_suckerfish.php");
		$menu_name = $this->params->get ("xml_menuname");
	}
}

else if ($s5_menu  == "2")  {
	require( TEMPLATEPATH.DS."s5_suckerfish.php");
	$menu_name = $this->params->get ("xml_menuname");
}

if ($s5_urlforSEO  == ""){ 
$LiveSiteUrl = JURI::root();}
if ($s5_urlforSEO  != ""){ 
$LiveSiteUrl = "$s5_urlforSEO/";}

$br = strtolower($_SERVER['HTTP_USER_AGENT']);
$browser = "other";

if(strrpos($br,"msie 7") > 1) {
$browser = "ie7";} 

if(strrpos($br,"msie 8") > 1) {
$browser = "ie8";} 

// Module size calculations

if(!$this->countModules('right')) {
$s5_right_width = "0";	
}

if(!$this->countModules('left')) {
$s5_left_width = "0";	
}

if(!$this->countModules('top_2')) {
$s5_top2_width = "0";	
}

$s5_quarter_size = "25%";

if ($browser == "ie7") {
$s5_quarter_size = "24.9%";
}

if ($this->countModules("top_row_1") && $this->countModules("top_row_2") && $this->countModules("top_row_3") && $this->countModules("top_row_4")) { $top_row1=$s5_quarter_size; }
else if (!$this->countModules("top_row_1") && $this->countModules("top_row_2") && $this->countModules("top_row_3") && $this->countModules("top_row_4")) { $top_row1="33.3%"; }
else if ($this->countModules("top_row_1") && !$this->countModules("top_row_2") && $this->countModules("top_row_3") && $this->countModules("top_row_4")) { $top_row1="33.3%"; }
else if ($this->countModules("top_row_1") && $this->countModules("top_row_2") && !$this->countModules("top_row_3") && $this->countModules("top_row_4")) { $top_row1="33.3%"; }
else if ($this->countModules("top_row_1") && $this->countModules("top_row_2") && $this->countModules("top_row_3") && !$this->countModules("top_row_4")) { $top_row1="33.3%"; }
else if (!$this->countModules("top_row_1") && !$this->countModules("top_row_2") && $this->countModules("top_row_3") && $this->countModules("top_row_4")) { $top_row1="49.9%"; }
else if (!$this->countModules("top_row_1") && $this->countModules("top_row_2") && !$this->countModules("top_row_3") && $this->countModules("top_row_4")) { $top_row1="49.9%"; }
else if (!$this->countModules("top_row_1") && $this->countModules("top_row_2") && $this->countModules("top_row_3") && !$this->countModules("top_row_4")) { $top_row1="49.9%"; }
else if ($this->countModules("top_row_1") && !$this->countModules("top_row_2") && !$this->countModules("top_row_3") && $this->countModules("top_row_4")) { $top_row1="49.9%"; }
else if ($this->countModules("top_row_1") && !$this->countModules("top_row_2") && $this->countModules("top_row_3") && !$this->countModules("top_row_4")) { $top_row1="49.9%"; }
else if ($this->countModules("top_row_1") && $this->countModules("top_row_2") && !$this->countModules("top_row_3") && !$this->countModules("top_row_4")) { $top_row1="49.9%"; }
else if (!$this->countModules("top_row_1") && !$this->countModules("top_row_2") && !$this->countModules("top_row_3") && $this->countModules("top_row_4")) { $top_row1="100%"; }
else if (!$this->countModules("top_row_1") && $this->countModules("top_row_2") && !$this->countModules("top_row_3") && !$this->countModules("top_row_4")) { $top_row1="100%"; }
else if (!$this->countModules("top_row_1") && !$this->countModules("top_row_2") && $this->countModules("top_row_3") && !$this->countModules("top_row_4")) { $top_row1="100%"; }
else if ($this->countModules("top_row_1") && !$this->countModules("top_row_2") && !$this->countModules("top_row_3") && !$this->countModules("top_row_4")) { $top_row1="100%"; }

if ($this->countModules("bottom_row_1") && $this->countModules("bottom_row_2") && $this->countModules("bottom_row_3") && $this->countModules("bottom_row_4")) { $bottom_row1=$s5_quarter_size; }
else if (!$this->countModules("bottom_row_1") && $this->countModules("bottom_row_2") && $this->countModules("bottom_row_3") && $this->countModules("bottom_row_4")) { $bottom_row1="33.3%"; }
else if ($this->countModules("bottom_row_1") && !$this->countModules("bottom_row_2") && $this->countModules("bottom_row_3") && $this->countModules("bottom_row_4")) { $bottom_row1="33.3%"; }
else if ($this->countModules("bottom_row_1") && $this->countModules("bottom_row_2") && !$this->countModules("bottom_row_3") && $this->countModules("bottom_row_4")) { $bottom_row1="33.3%"; }
else if ($this->countModules("bottom_row_1") && $this->countModules("bottom_row_2") && $this->countModules("bottom_row_3") && !$this->countModules("bottom_row_4")) { $bottom_row1="33.3%"; }
else if (!$this->countModules("bottom_row_1") && !$this->countModules("bottom_row_2") && $this->countModules("bottom_row_3") && $this->countModules("bottom_row_4")) { $bottom_row1="49.9%"; }
else if (!$this->countModules("bottom_row_1") && $this->countModules("bottom_row_2") && !$this->countModules("bottom_row_3") && $this->countModules("bottom_row_4")) { $bottom_row1="49.9%"; }
else if (!$this->countModules("bottom_row_1") && $this->countModules("bottom_row_2") && $this->countModules("bottom_row_3") && !$this->countModules("bottom_row_4")) { $bottom_row1="49.9%"; }
else if ($this->countModules("bottom_row_1") && !$this->countModules("bottom_row_2") && !$this->countModules("bottom_row_3") && $this->countModules("bottom_row_4")) { $bottom_row1="49.9%"; }
else if ($this->countModules("bottom_row_1") && !$this->countModules("bottom_row_2") && $this->countModules("bottom_row_3") && !$this->countModules("bottom_row_4")) { $bottom_row1="49.9%"; }
else if ($this->countModules("bottom_row_1") && $this->countModules("bottom_row_2") && !$this->countModules("bottom_row_3") && !$this->countModules("bottom_row_4")) { $bottom_row1="49.9%"; }
else if (!$this->countModules("bottom_row_1") && !$this->countModules("bottom_row_2") && !$this->countModules("bottom_row_3") && $this->countModules("bottom_row_4")) { $bottom_row1="100%"; }
else if (!$this->countModules("bottom_row_1") && $this->countModules("bottom_row_2") && !$this->countModules("bottom_row_3") && !$this->countModules("bottom_row_4")) { $bottom_row1="100%"; }
else if (!$this->countModules("bottom_row_1") && !$this->countModules("bottom_row_2") && $this->countModules("bottom_row_3") && !$this->countModules("bottom_row_4")) { $bottom_row1="100%"; }
else if ($this->countModules("bottom_row_1") && !$this->countModules("bottom_row_2") && !$this->countModules("bottom_row_3") && !$this->countModules("bottom_row_4")) { $bottom_row1="100%"; }

if ($this->countModules("above_body_1") && $this->countModules("above_body_2") && $this->countModules("above_body_3") && $this->countModules("above_body_4")) { $above_body1=$s5_quarter_size; }
else if (!$this->countModules("above_body_1") && $this->countModules("above_body_2") && $this->countModules("above_body_3") && $this->countModules("above_body_4")) { $above_body1="33.3%"; }
else if ($this->countModules("above_body_1") && !$this->countModules("above_body_2") && $this->countModules("above_body_3") && $this->countModules("above_body_4")) { $above_body1="33.3%"; }
else if ($this->countModules("above_body_1") && $this->countModules("above_body_2") && !$this->countModules("above_body_3") && $this->countModules("above_body_4")) { $above_body1="33.3%"; }
else if ($this->countModules("above_body_1") && $this->countModules("above_body_2") && $this->countModules("above_body_3") && !$this->countModules("above_body_4")) { $above_body1="33.3%"; }
else if (!$this->countModules("above_body_1") && !$this->countModules("above_body_2") && $this->countModules("above_body_3") && $this->countModules("above_body_4")) { $above_body1="49.9%"; }
else if (!$this->countModules("above_body_1") && $this->countModules("above_body_2") && !$this->countModules("above_body_3") && $this->countModules("above_body_4")) { $above_body1="49.9%"; }
else if (!$this->countModules("above_body_1") && $this->countModules("above_body_2") && $this->countModules("above_body_3") && !$this->countModules("above_body_4")) { $above_body1="49.9%"; }
else if ($this->countModules("above_body_1") && !$this->countModules("above_body_2") && !$this->countModules("above_body_3") && $this->countModules("above_body_4")) { $above_body1="49.9%"; }
else if ($this->countModules("above_body_1") && !$this->countModules("above_body_2") && $this->countModules("above_body_3") && !$this->countModules("above_body_4")) { $above_body1="49.9%"; }
else if ($this->countModules("above_body_1") && $this->countModules("above_body_2") && !$this->countModules("above_body_3") && !$this->countModules("above_body_4")) { $above_body1="49.9%"; }
else if (!$this->countModules("above_body_1") && !$this->countModules("above_body_2") && !$this->countModules("above_body_3") && $this->countModules("above_body_4")) { $above_body1="100%"; }
else if (!$this->countModules("above_body_1") && $this->countModules("above_body_2") && !$this->countModules("above_body_3") && !$this->countModules("above_body_4")) { $above_body1="100%"; }
else if (!$this->countModules("above_body_1") && !$this->countModules("above_body_2") && $this->countModules("above_body_3") && !$this->countModules("above_body_4")) { $above_body1="100%"; }
else if ($this->countModules("above_body_1") && !$this->countModules("above_body_2") && !$this->countModules("above_body_3") && !$this->countModules("above_body_4")) { $above_body1="100%"; }

if ($this->countModules("above_body_5") && $this->countModules("above_body_6") && $this->countModules("above_body_7") && $this->countModules("above_body_8")) { $above_body2=$s5_quarter_size; }
else if (!$this->countModules("above_body_5") && $this->countModules("above_body_6") && $this->countModules("above_body_7") && $this->countModules("above_body_8")) { $above_body2="33.3%"; }
else if ($this->countModules("above_body_5") && !$this->countModules("above_body_6") && $this->countModules("above_body_7") && $this->countModules("above_body_8")) { $above_body2="33.3%"; }
else if ($this->countModules("above_body_5") && $this->countModules("above_body_6") && !$this->countModules("above_body_7") && $this->countModules("above_body_8")) { $above_body2="33.3%"; }
else if ($this->countModules("above_body_5") && $this->countModules("above_body_6") && $this->countModules("above_body_7") && !$this->countModules("above_body_8")) { $above_body2="33.3%"; }
else if (!$this->countModules("above_body_5") && !$this->countModules("above_body_6") && $this->countModules("above_body_7") && $this->countModules("above_body_8")) { $above_body2="49.9%"; }
else if (!$this->countModules("above_body_5") && $this->countModules("above_body_6") && !$this->countModules("above_body_7") && $this->countModules("above_body_8")) { $above_body2="49.9%"; }
else if (!$this->countModules("above_body_5") && $this->countModules("above_body_6") && $this->countModules("above_body_7") && !$this->countModules("above_body_8")) { $above_body2="49.9%"; }
else if ($this->countModules("above_body_5") && !$this->countModules("above_body_6") && !$this->countModules("above_body_7") && $this->countModules("above_body_8")) { $above_body2="49.9%"; }
else if ($this->countModules("above_body_5") && !$this->countModules("above_body_6") && $this->countModules("above_body_7") && !$this->countModules("above_body_8")) { $above_body2="49.9%"; }
else if ($this->countModules("above_body_5") && $this->countModules("above_body_6") && !$this->countModules("above_body_7") && !$this->countModules("above_body_8")) { $above_body2="49.9%"; }
else if (!$this->countModules("above_body_5") && !$this->countModules("above_body_6") && !$this->countModules("above_body_7") && $this->countModules("above_body_8")) { $above_body2="100%"; }
else if (!$this->countModules("above_body_5") && $this->countModules("above_body_6") && !$this->countModules("above_body_7") && !$this->countModules("above_body_8")) { $above_body2="100%"; }
else if (!$this->countModules("above_body_5") && !$this->countModules("above_body_6") && $this->countModules("above_body_7") && !$this->countModules("above_body_8")) { $above_body2="100%"; }
else if ($this->countModules("above_body_5") && !$this->countModules("above_body_6") && !$this->countModules("above_body_7") && !$this->countModules("above_body_8")) { $above_body2="100%"; }

if ($this->countModules("below_body_1") && $this->countModules("below_body_2") && $this->countModules("below_body_3") && $this->countModules("below_body_4")) { $below_body1=$s5_quarter_size; }
else if (!$this->countModules("below_body_1") && $this->countModules("below_body_2") && $this->countModules("below_body_3") && $this->countModules("below_body_4")) { $below_body1="33.3%"; }
else if ($this->countModules("below_body_1") && !$this->countModules("below_body_2") && $this->countModules("below_body_3") && $this->countModules("below_body_4")) { $below_body1="33.3%"; }
else if ($this->countModules("below_body_1") && $this->countModules("below_body_2") && !$this->countModules("below_body_3") && $this->countModules("below_body_4")) { $below_body1="33.3%"; }
else if ($this->countModules("below_body_1") && $this->countModules("below_body_2") && $this->countModules("below_body_3") && !$this->countModules("below_body_4")) { $below_body1="33.3%"; }
else if (!$this->countModules("below_body_1") && !$this->countModules("below_body_2") && $this->countModules("below_body_3") && $this->countModules("below_body_4")) { $below_body1="49.9%"; }
else if (!$this->countModules("below_body_1") && $this->countModules("below_body_2") && !$this->countModules("below_body_3") && $this->countModules("below_body_4")) { $below_body1="49.9%"; }
else if (!$this->countModules("below_body_1") && $this->countModules("below_body_2") && $this->countModules("below_body_3") && !$this->countModules("below_body_4")) { $below_body1="49.9%"; }
else if ($this->countModules("below_body_1") && !$this->countModules("below_body_2") && !$this->countModules("below_body_3") && $this->countModules("below_body_4")) { $below_body1="49.9%"; }
else if ($this->countModules("below_body_1") && !$this->countModules("below_body_2") && $this->countModules("below_body_3") && !$this->countModules("below_body_4")) { $below_body1="49.9%"; }
else if ($this->countModules("below_body_1") && $this->countModules("below_body_2") && !$this->countModules("below_body_3") && !$this->countModules("below_body_4")) { $below_body1="49.9%"; }
else if (!$this->countModules("below_body_1") && !$this->countModules("below_body_2") && !$this->countModules("below_body_3") && $this->countModules("below_body_4")) { $below_body1="100%"; }
else if (!$this->countModules("below_body_1") && $this->countModules("below_body_2") && !$this->countModules("below_body_3") && !$this->countModules("below_body_4")) { $below_body1="100%"; }
else if (!$this->countModules("below_body_1") && !$this->countModules("below_body_2") && $this->countModules("below_body_3") && !$this->countModules("below_body_4")) { $below_body1="100%"; }
else if ($this->countModules("below_body_1") && !$this->countModules("below_body_2") && !$this->countModules("below_body_3") && !$this->countModules("below_body_4")) { $below_body1="100%"; }


if ($this->countModules("below_body_5") && $this->countModules("below_body_6") && $this->countModules("below_body_7") && $this->countModules("below_body_8")) { $below_body2=$s5_quarter_size; }
else if (!$this->countModules("below_body_5") && $this->countModules("below_body_6") && $this->countModules("below_body_7") && $this->countModules("below_body_8")) { $below_body2="33.3%"; }
else if ($this->countModules("below_body_5") && !$this->countModules("below_body_6") && $this->countModules("below_body_7") && $this->countModules("below_body_8")) { $below_body2="33.3%"; }
else if ($this->countModules("below_body_5") && $this->countModules("below_body_6") && !$this->countModules("below_body_7") && $this->countModules("below_body_8")) { $below_body2="33.3%"; }
else if ($this->countModules("below_body_5") && $this->countModules("below_body_6") && $this->countModules("below_body_7") && !$this->countModules("below_body_8")) { $below_body2="33.3%"; }
else if (!$this->countModules("below_body_5") && !$this->countModules("below_body_6") && $this->countModules("below_body_7") && $this->countModules("below_body_8")) { $below_body2="49.9%"; }
else if (!$this->countModules("below_body_5") && $this->countModules("below_body_6") && !$this->countModules("below_body_7") && $this->countModules("below_body_8")) { $below_body2="49.9%"; }
else if (!$this->countModules("below_body_5") && $this->countModules("below_body_6") && $this->countModules("below_body_7") && !$this->countModules("below_body_8")) { $below_body2="49.9%"; }
else if ($this->countModules("below_body_5") && !$this->countModules("below_body_6") && !$this->countModules("below_body_7") && $this->countModules("below_body_8")) { $below_body2="49.9%"; }
else if ($this->countModules("below_body_5") && !$this->countModules("below_body_6") && $this->countModules("below_body_7") && !$this->countModules("below_body_8")) { $below_body2="49.9%"; }
else if ($this->countModules("below_body_5") && $this->countModules("below_body_6") && !$this->countModules("below_body_7") && !$this->countModules("below_body_8")) { $below_body2="49.9%"; }
else if (!$this->countModules("below_body_5") && !$this->countModules("below_body_6") && !$this->countModules("below_body_7") && $this->countModules("below_body_8")) { $below_body2="100%"; }
else if (!$this->countModules("below_body_5") && $this->countModules("below_body_6") && !$this->countModules("below_body_7") && !$this->countModules("below_body_8")) { $below_body2="100%"; }
else if (!$this->countModules("below_body_5") && !$this->countModules("below_body_6") && $this->countModules("below_body_7") && !$this->countModules("below_body_8")) { $below_body2="100%"; }
else if ($this->countModules("below_body_5") && !$this->countModules("below_body_6") && !$this->countModules("below_body_7") && !$this->countModules("below_body_8")) { $below_body2="100%"; }


$s5_domain = $_SERVER['HTTP_HOST'];
$s5_url = "http://" . $s5_domain . $_SERVER['REQUEST_URI'];

$s5_frontpage = "yes";
$s5_current_page = "";
if (JRequest::getVar('view') == "featured") {
	$s5_current_page = "frontpage";
}
if (JRequest::getVar('view') != "featured") {
	$s5_current_page = "not_frontpage";
}
if ($s5_show_frontpage == "no" && $s5_current_page == "frontpage") {
	$s5_frontpage = "no";
}

?>

<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<link rel="stylesheet" href="<?php echo $LiveSiteUrl ?>templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $LiveSiteUrl ?>templates/system/css/general.css" type="text/css" />

<link href="<?php echo $LiveSiteUrl ?>templates/comaxium/css/template.css" rel="stylesheet" type="text/css" media="screen" />

<link href="<?php echo $LiveSiteUrl ?>templates/comaxium/css/s5_suckerfish.css" rel="stylesheet" type="text/css" media="screen" />

<link href="<?php echo $LiveSiteUrl ?>templates/comaxium/css/editor.css" rel="stylesheet" type="text/css" media="screen" />

<?php if($this->direction == "rtl") { ?>
<link href="<?php echo $LiveSiteUrl ?>templates/comaxium/css/template_rtl.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $LiveSiteUrl ?>templates/comaxium/css/editor_rtl.css" rel="stylesheet" type="text/css" media="screen" />
<?php } ?>

<?php if(($s5_fonts != "Arial") || ($s5_fonts != "Helvetica")|| ($s5_fonts != "Sans-Serif")) { ?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $s5_fonts;?>" />
<?php } ?>

<?php if ($s5_multibox  == "yes") { 
JHTML::_('behavior.mootools');
?>
<link href="<?php echo $LiveSiteUrl;?>templates/comaxium/css/multibox/multibox.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $LiveSiteUrl;?>templates/comaxium/css/multibox/ajax.css" rel="stylesheet" type="text/css" media="screen" />
<?php if ($s5_moover  == "moo112") { ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/comaxium/js/multibox/overlay.js"></script>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/comaxium/js/multibox/multibox.js"></script>
<?php } ?>
<?php if ($s5_moover  == "moo124") { ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/comaxium/js/multibox/mootools124/overlay.js"></script>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/comaxium/js/multibox/mootools124/multibox.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/comaxium/js/multibox/AC_RunActiveContent.js"></script>
<?php } ?>


<?php if ($s5_jsmenu == "jq") { ?>
<?php if (($s5_menu  == "1") || ($s5_menu  == "3") || ($s5_menu  == "4")) { ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl ?>templates/comaxium/js/jquery13.js"></script>
<script type="text/javascript" src="<?php echo $LiveSiteUrl ?>templates/comaxium/js/jquery_no_conflict.js"></script>
<script type="text/javascript">
<?php if ($s5_menu  == "3") { ?>
var s5_fading_menu = "yes";
<?php } ?>
<?php if ($s5_menu  != "3") { ?>
var s5_fading_menu = "no";
<?php } ?>
function s5_jqmainmenu(){
jQuery(" #navlist ul ").css({display: "none"}); // Opera Fix
jQuery(" #s5_navv li").hover(function(){
		jQuery(this).find('ul:first').css({visibility: "visible",display: "none"}).<?php if ($s5_menu  == "1") { ?>show(400)<?php } ?><?php if ($s5_menu  == "3") { ?>fadeIn(400)<?php } ?><?php if ($s5_menu  == "4") { ?>slideDown(400)<?php } ?>;
		},function(){jQuery(this).find('ul:first').css({visibility: "hidden"});	});}
  jQuery(document).ready(function(){ s5_jqmainmenu();});
</script>
<?php } ?>
<?php } ?>

<?php { 
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_1 = '".$s5_text_menu_1."';</script>";
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_2 = '".$s5_text_menu_2."';</script>";
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_3 = '".$s5_text_menu_3."';</script>";
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_4 = '".$s5_text_menu_4."';</script>";
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_5 = '".$s5_text_menu_5."';</script>";
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_6 = '".$s5_text_menu_6."';</script>";
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_7 = '".$s5_text_menu_7."';</script>";
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_8 = '".$s5_text_menu_8."';</script>";
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_9 = '".$s5_text_menu_9."';</script>";
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_10 = '".$s5_text_menu_10."';</script>";
}?>

<link href="<?php echo $LiveSiteUrl ?>templates/comaxium/favicon.ico" rel="shortcut icon" type="image/x-icon" />

<?php if($browser == "ie7" && $s5_menu != "5") { ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl ?>templates/comaxium/js/IEsuckerfish.js"></script>
<?php } ?>

<style type="text/css"> 

#s5_outer_wrap, #s5_header_wrap {
<?php if ($s5_fixed_fluid == "fluid") { ?>
width:<?php echo $s5_fluid_body_width ?>%;
<?php } ?>
<?php if ($s5_fixed_fluid == "fixed") { ?>
width:<?php echo $s5_fixed_body_width ?>px;
<?php } ?>
margin-left:auto;
margin-right:auto;
}

.s5_h3_first, a, .button, #cboxContent h3, .contentpagetitle, .contentheading, .s5_module_box .menu #current a, .s5_module_box .menu #current a, h2, h4, div.s5_accordion_menu_element #current a, #current span.s5_accordion_menu_left a.mainlevel {
color:#<?php echo $s5_highlight ?>;
}

.s5_module_box .menu #current ul li a {
color:#55554F;
}

#s5_navv ul li.active { 
background:#<?php echo $s5_highlight ?> url("<?php echo $LiveSiteUrl ?>templates/comaxium/images/s5_menu_act.png") repeat-x top left;
}

<?php if ($browser == "ie7") { ?>
<?php if($this->direction == "rtl") { ?>
.latestnews li, .mostread li, .sections li, .s5_module_box ul.menu a {
padding-right:32px;
}
#s5_search_wrap {
margin-top:-52px;
margin-left:-12px;
}
<?php } ?>
#s5_accordion_menu {
padding-bottom:0px;
}
<?php } ?>

body {font-family: '<?php echo $s5_fonts;?>',Helvetica,Arial,Sans-Serif ;} 

<?php if (!$this->countModules("top_row_1") && !$this->countModules("top_row_2") && !$this->countModules("top_row_3") && !$this->countModules("top_row_4")) { ?>
#s5_top_1 div, #s5_top_2 div {
margin-bottom:0px;
}
<?php } ?>

</style>

</head>

<body id="s5_body">

<div style="display:none">
	<img src="<?php echo $LiveSiteUrl ?>templates/comaxium/images/s5_menu_sub_li_hover.png" alt=""></img>
</div>

	<div id="s5_main_body_wrap">
		<div id="s5_header_wrap">
			<?php if($this->countModules('logo')) { ?>
            <div id="s5_logo_module" style="cursor:pointer;" onclick="window.document.location.href='<?php echo $LiveSiteUrl ?>'">
                <jdoc:include type="modules" name="logo" style="notitle" />
            </div>	
			<?php } else { ?>
				<div id="s5_logo" style="cursor:pointer;" onclick="window.document.location.href='<?php echo $LiveSiteUrl ?>'"></div>
			<?php } ?>
				<div id="s5_header_r_wrap">
					<div id="s5_top_menu">
						<jdoc:include type="modules" name="top_menu" style="notitle" />
					</div>
					<div style="clear:both; height:0px"></div>
					<div id="s5_login_register_wrap">
						<?php if ($s5_date == "yes") { ?>
							<div id="s5_date">
								<?php $today = date("l, F j, Y"); PRINT "$today"; ?>
							</div>
						<?php } ?>
						<?php if ($this->countModules("login")) { ?>
							<div id="s5_login" class="s5box_login">
							<div id="s5_login_inner">
								<jdoc:include type="modules" name="login" style="title_only" />
							</div>
							</div>
						<?php } ?>
						<?php if ($this->countModules("register")) { ?>
							<div id="s5_register" class="s5box_register">
							<div id="s5_register_inner">
								<jdoc:include type="modules" name="register" style="title_only" />
							</div>
							</div>
						<?php } ?>
					</div>
				</div>
			<div style="clear:both; height:0px"></div>
		</div>	

		<div id="s5_outer_wrap">
		
			<?php if ($s5_menu  != "5" || $this->countModules('login') || $this->countModules('register') || $this->countModules('search')) { ?>
				<div class="s5_t_shadow"></div>
				<div id="s5_menu_search_wrap">
				
					<?php if ($s5_menu  != "5") { ?>

						<div id="s5_navv">
											
							<?php mosShowListMenu($menu_name);	?>
							
							<?php if ($s5_jsmenu  == "s5") { ?>
								<?php if ($s5_menu  == "1") { ?>
									<script type="text/javascript" src="<?php echo $LiveSiteUrl ?>templates/comaxium/js/s5_drop_in_no_moo_menu.js"></script>																		
								<?php } ?>
								<?php if ($s5_menu  == "2") { ?>
									<script type="text/javascript" src="<?php echo $LiveSiteUrl ?>templates/comaxium/js/s5_fading_no_moo_menu.js"></script>																		
								<?php } ?>	
								<?php if ($s5_menu  == "3") { ?>
									<script type="text/javascript" src="<?php echo $LiveSiteUrl ?>templates/comaxium/js/s5_scroll_down_no_moo_menu.js"></script>																		
								<?php } ?>	
							<?php } ?>	
							
							<script type="text/javascript" src="<?php echo $LiveSiteUrl ?>templates/comaxium/js/s5_menu_active_and_parent_links.js"></script>																		
						</div>
										
					<?php } ?>
					
					<div id="s5_search_wrap">
						<div id="s5_search">
							<jdoc:include type="modules" name="search" style="notitle" />
							<div style="clear:both; height:0px"></div>
						</div>
					
					</div>
					
					<div style="clear:both; height:0px"></div>
				</div>
				<div class="s5_b_shadow"></div>
			<?php } ?>
			
			<?php if ($this->countModules("top_2") || $this->countModules("top_1") || $this->countModules("top_row_1") || $this->countModules("top_row_2") || $this->countModules("top_row_3") || $this->countModules("top_row_4")) { ?>
			
			<div class="s5_wrap_outer">
			<div class="s5_wrap_tl">
				<div class="s5_wrap_tr">
					<div class="s5_wrap_tm">
					</div>
				</div>
			</div>
			<div class="s5_wrap_ml">
				<div class="s5_wrap_mr">
					<div class="s5_wrap_mm">
						<div class="s5_mod_row_wrap">
						<?php if ($browser == "ie7") { ?>
							<div style="float:left; margin-left:-20px; width:100%">
						<?php } ?>
						<?php if ($this->countModules("top_2")) { ?>
							<div id="s5_top_2" style="float:right; width:<?php echo $s5_top2_width ?>px">
								<jdoc:include type="modules" name="top_2" style="transparent_box" />
							</div>
						<?php } ?>
						<?php if ($this->countModules("top_1")) { ?>
							<div id="s5_top_1" style="margin-right:<?php echo $s5_top2_width ?>px">
								<jdoc:include type="modules" name="top_1" style="transparent_box" />
							</div>
						<?php } ?>
						<div class="s5_mods_row_wrap">
							<?php if ($this->countModules("top_row_1")) { ?>
								<div id="s5_top_row_1" style="float:left; width:<?php echo $top_row1 ?>">
									<jdoc:include type="modules" name="top_row_1" style="transparent_box" />
								</div>
							<?php } ?>
							
							<?php if ($this->countModules("top_row_2")) { ?>
								<div id="s5_top_row_2" style="float:left; width:<?php echo $top_row1 ?>">
									<jdoc:include type="modules" name="top_row_2" style="transparent_box" />
								</div>
							<?php } ?>
							
							<?php if ($this->countModules("top_row_3")) { ?>
								<div id="s5_top_row_3" style="float:left; width:<?php echo $top_row1 ?>">
									<jdoc:include type="modules" name="top_row_3" style="transparent_box" />
								</div>
							<?php } ?>
							
							<?php if ($this->countModules("top_row_4")) { ?>
								<div id="s5_top_row_4" style="float:left; width:<?php echo $top_row1 ?>">
									<jdoc:include type="modules" name="top_row_4" style="transparent_box" />
								</div>
							<?php } ?>
						</div>
					
						<div style="clear:both; height:0px"></div>
						
						<?php if ($browser == "ie7") { ?>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="s5_wrap_bl">
				<div class="s5_wrap_br">
					<div class="s5_wrap_bm">
					</div>
				</div>
			</div>
			</div>
				
			<?php } ?>
			
			<?php if ($s5_frontpage == "yes" || $this->countModules("above_body_1") || $this->countModules("above_body_2") || $this->countModules("above_body_3") || $this->countModules("above_body_4") || $this->countModules("above_body_5") || $this->countModules("above_body_6") || $this->countModules("above_body_7") || $this->countModules("above_body_8") || $this->countModules("below_body_1") || $this->countModules("below_body_2") || $this->countModules("below_body_3") || $this->countModules("below_body_4") || $this->countModules("below_body_5") || $this->countModules("below_body_6") || $this->countModules("below_body_7") || $this->countModules("below_body_8") || $this->countModules("left") || $this->countModules("right")) { ?>
			
			<div class="s5_wrap_outer">
			<div class="s5_wrap_tl">
				<div class="s5_wrap_tr">
					<div class="s5_wrap_tm">
					</div>
				</div>
			</div>
			<div class="s5_wrap_ml">
				<div class="s5_wrap_mr">
					<div class="s5_wrap_mm">
						<div class="s5_wrap_inner_content">
								
								<?php if ($this->countModules("above_body_1") || $this->countModules("above_body_2") || $this->countModules("above_body_3") || $this->countModules("above_body_4")) { ?>
			
									<div class="s5_above_body_mods1">
									<div class="s5_above_body_mods1_inner">
									<?php if ($browser == "ie7") { ?>
										<div style="float:left; margin-left:-20px; width:100%">
									<?php } ?>
										<?php if ($this->countModules("above_body_1")) { ?>
											<div id="s5_above_body_1" style="float:left; width:<?php echo $above_body1 ?>">
												<jdoc:include type="modules" name="above_body_1" style="transparent_box" />
											</div>
										<?php } ?>
										
										<?php if ($this->countModules("above_body_2")) { ?>
											<div id="s5_above_body_2" style="float:left; width:<?php echo $above_body1 ?>">
												<jdoc:include type="modules" name="above_body_2" style="transparent_box" />
											</div>
										<?php } ?>
										
										<?php if ($this->countModules("above_body_3")) { ?>
											<div id="s5_above_body_3" style="float:left; width:<?php echo $above_body1 ?>">
												<jdoc:include type="modules" name="above_body_3" style="transparent_box" />
											</div>
										<?php } ?>
										
										<?php if ($this->countModules("above_body_4")) { ?>
											<div id="s5_above_body_4" style="float:left; width:<?php echo $above_body1 ?>">
												<jdoc:include type="modules" name="above_body_4" style="transparent_box" />
											</div>
										<?php } ?>
										
										<div style="clear:both; height:0px"></div>
									<?php if ($browser == "ie7") { ?>
										</div>
									<?php } ?>
									</div>
									</div>
									
								<?php } ?>
									
								<div id="s5_main_body_wrap2">
									<div id="s5_main_body_wrap2_inner">
										<div id="s5_main_body_wrap_inner2">	
											<div id="s5_main_content_wrap">
												<div id="s5_main_content_wrap_inner" style="margin-right:<?php echo $s5_right_width ?>px;margin-left:<?php echo $s5_left_width ?>px">
													<div id="s5_component_wrap">
														<div id="s5_body_wrap2">
														
															<?php if ($this->countModules("above_body_5") || $this->countModules("above_body_6") || $this->countModules("above_body_7") || $this->countModules("above_body_8")) { ?>
					
																<div id="s5_above_body_mods2">
																<div id="s5_above_body_mods2_inner">
																
																	<?php if ($this->countModules("above_body_5")) { ?>
																		<div id="s5_above_body_5" style="float:left; width:<?php echo $above_body2 ?>">
																			<jdoc:include type="modules" name="above_body_5" style="transparent_box" />
																		</div>
																	<?php } ?>
																	
																	<?php if ($this->countModules("above_body_6")) { ?>
																		<div id="s5_above_body_6" style="float:left; width:<?php echo $above_body2 ?>">
																			<jdoc:include type="modules" name="above_body_6" style="transparent_box" />
																		</div>
																	<?php } ?>
																	
																	<?php if ($this->countModules("above_body_7")) { ?>
																		<div id="s5_above_body_7" style="float:left; width:<?php echo $above_body2 ?>">
																			<jdoc:include type="modules" name="above_body_7" style="transparent_box" />
																		</div>
																	<?php } ?>
																	
																	<?php if ($this->countModules("above_body_8")) { ?>
																		<div id="s5_above_body_8" style="float:left; width:<?php echo $above_body2 ?>">
																			<jdoc:include type="modules" name="above_body_8" style="transparent_box" />
																		</div>
																	<?php } ?>
																	
																	<div style="clear:both; height:0px"></div>

																</div>
																</div>
																
															<?php } ?>
															
															<?php if ($s5_frontpage == "yes") { ?>
																<div id="s5_component_wrap_area">
																	<div id="s5_component_wrap_area_inner">
																	
																		<div class="s5_module_box_tl">
																			<div class="s5_module_box_tr">
																				<div class="s5_module_box_tm">
																				</div>
																			</div>
																		</div>
																		
																		<div class="s5_module_box_ml">
																			<div class="s5_module_box_mr">
																				<div class="s5_module_box_mm">
																					<?php if($this->countModules('breadcrumb')) { ?>
					
																						<div id="s5_pathway_wrap">
																							
																							<?php if($this->countModules('breadcrumb')) { ?>
																								<div id="s5_pathway">
																									<jdoc:include type="modules" name="breadcrumb" style="notitle" />
																								</div>
																							<?php } ?>
																							
																							<div style="clear:both; height:0px"></div>
																							
																						</div>
																					
																					<?php } ?>
																					<jdoc:include type="message" />
																					<jdoc:include type="component" />
																				</div>
																			</div>
																		</div>
																		
																		<div class="s5_module_box_bl">
																			<div class="s5_module_box_br">
																				<div class="s5_module_box_bm">
																				</div>
																			</div>
																		</div>
																		
																	</div>
																</div>
															<?php } ?>
															
															<?php if ($this->countModules("below_body_1") || $this->countModules("below_body_2") || $this->countModules("below_body_3") || $this->countModules("below_body_4")) { ?>
					
																<div id="s5_below_body_mods1">
																<div id="s5_below_body_mods1_inner">
																
																	<?php if ($this->countModules("below_body_1")) { ?>
																		<div id="s5_below_body_1" style="float:left; width:<?php echo $below_body1 ?>">
																			<jdoc:include type="modules" name="below_body_1" style="transparent_box" />
																		</div>
																	<?php } ?>
																	
																	<?php if ($this->countModules("below_body_2")) { ?>
																		<div id="s5_below_body_2" style="float:left; width:<?php echo $below_body1 ?>">
																			<jdoc:include type="modules" name="below_body_2" style="transparent_box" />
																		</div>
																	<?php } ?>
																	
																	<?php if ($this->countModules("below_body_3")) { ?>
																		<div id="s5_below_body_3" style="float:left; width:<?php echo $below_body1 ?>">
																			<jdoc:include type="modules" name="below_body_3" style="transparent_box" />
																		</div>
																	<?php } ?>
																	
																	<?php if ($this->countModules("below_body_4")) { ?>
																		<div id="s5_below_body_4" style="float:left; width:<?php echo $below_body1 ?>">
																			<jdoc:include type="modules" name="below_body_4" style="transparent_box" />
																		</div>
																	<?php } ?>
																	
																	<div style="clear:both; height:0px"></div>

																</div>
																</div>
																
															<?php } ?>
															
														</div>
													</div>
												</div>
											</div>
												
											<?php if($this->countModules('left')) { ?>
												<div id="s5_left_wrap" style="width:<?php echo $s5_left_width ?>px">
													<jdoc:include type="modules" name="left" style="transparent_box" />
												</div>
											<?php } ?>
											
											<?php if($this->countModules('right')) { ?>
												<div id="s5_right_wrap" style="width:<?php echo $s5_right_width ?>px;margin-left:-<?php echo $s5_right_width + $s5_left_width ?>px">
													<jdoc:include type="modules" name="right" style="transparent_box" />
												</div>
											<?php } ?>
										
											<div style="clear:both; height:0px"></div>
										</div>
									</div>
								</div>
								
								<div style="clear:both; height:0px"></div>
						
								<?php if ($this->countModules("below_body_5") || $this->countModules("below_body_6") || $this->countModules("below_body_7") || $this->countModules("below_body_8")) { ?>
			
									<div id="s5_below_body_mods2">
									<div id="s5_below_body_mods2_inner">
									<?php if ($browser == "ie7") { ?>
										<div style="float:left; margin-left:-20px; width:100%">
									<?php } ?>
										<?php if ($this->countModules("below_body_5")) { ?>
											<div id="s5_below_body_5" style="float:left; width:<?php echo $below_body2 ?>">
												<jdoc:include type="modules" name="below_body_5" style="transparent_box" />
											</div>
										<?php } ?>
										
										<?php if ($this->countModules("below_body_6")) { ?>
											<div id="s5_below_body_6" style="float:left; width:<?php echo $below_body2 ?>">
												<jdoc:include type="modules" name="below_body_6" style="transparent_box" />
											</div>
										<?php } ?>
										
										<?php if ($this->countModules("below_body_7")) { ?>
											<div id="s5_below_body_7" style="float:left; width:<?php echo $below_body2 ?>">
												<jdoc:include type="modules" name="below_body_7" style="transparent_box" />
											</div>
										<?php } ?>
										
										<?php if ($this->countModules("below_body_8")) { ?>
											<div id="s5_below_body_8" style="float:left; width:<?php echo $below_body2 ?>">
												<jdoc:include type="modules" name="below_body_8" style="transparent_box" />
											</div>
										<?php } ?>
										
										<div style="clear:both; height:0px"></div>

									<?php if ($browser == "ie7") { ?>
										</div>
									<?php } ?>
									</div>
									</div>
									
								<?php } ?>
						</div>
					</div>
				</div>
			</div>
			
			<div class="s5_wrap_bl">
				<div class="s5_wrap_br">
					<div class="s5_wrap_bm">
					</div>
				</div>
			</div>
			</div>
			
			<?php } ?>
			
			<?php if ($this->countModules("bottom_row_1") || $this->countModules("bottom_row_2") || $this->countModules("bottom_row_3") || $this->countModules("bottom_row_4")) { ?>
			
			<div class="s5_wrap_outer">
			<div class="s5_wrap_tl">
				<div class="s5_wrap_tr">
					<div class="s5_wrap_tm">
					</div>
				</div>
			</div>
			<div class="s5_wrap_ml">
				<div class="s5_wrap_mr">
					<div class="s5_wrap_mm">
						<div class="s5_mod_row_wrap">
						<div class="s5_mods_row_wrap">
							<?php if ($browser == "ie7") { ?>
								<div style="float:left; margin-left:-20px; width:100%">
							<?php } ?>
							<?php if ($this->countModules("bottom_row_1")) { ?>
								<div id="s5_bottom_row_1" style="float:left; width:<?php echo $bottom_row1 ?>">
									<jdoc:include type="modules" name="bottom_row_1" style="transparent_box" />
								</div>
							<?php } ?>
							
							<?php if ($this->countModules("bottom_row_2")) { ?>
								<div id="s5_bottom_row_2" style="float:left; width:<?php echo $bottom_row1 ?>">
									<jdoc:include type="modules" name="bottom_row_2" style="transparent_box" />
								</div>
							<?php } ?>
							
							<?php if ($this->countModules("bottom_row_3")) { ?>
								<div id="s5_bottom_row_3" style="float:left; width:<?php echo $bottom_row1 ?>">
									<jdoc:include type="modules" name="bottom_row_3" style="transparent_box" />
								</div>
							<?php } ?>
							
							<?php if ($this->countModules("bottom_row_4")) { ?>
								<div id="s5_bottom_row_4" style="float:left; width:<?php echo $bottom_row1 ?>">
									<jdoc:include type="modules" name="bottom_row_4" style="transparent_box" />
								</div>
							<?php } ?>
						</div>
					
						<div style="clear:both; height:0px"></div>
						
						<?php if ($browser == "ie7") { ?>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="s5_wrap_bl">
				<div class="s5_wrap_br">
					<div class="s5_wrap_bm">
					</div>
				</div>
			</div>
			</div>
				
			<?php } ?>
			
			<div class="s5_wrap_outer">
			<div class="s5_wrap_tl">
				<div class="s5_wrap_tr">
					<div class="s5_wrap_tm">
					</div>
				</div>
			</div>
			<div class="s5_wrap_ml">
				<div class="s5_wrap_mr">
					<div class="s5_wrap_mm">
						<div id="s5_footer_wrap">
							<div id="s5_footer_text">
								<?php include("templates/comaxium/footer.php"); ?>
							</div>
							<?php if($this->countModules('bottom_menu')) { ?>
							<div id="s5_bottom_menu">
								<jdoc:include type="modules" name="bottom_menu" style="notitle" />
							</div>	
							<?php } ?>
							<div style="clear:both; height:0px"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="s5_wrap_bl">
				<div class="s5_wrap_br">
					<div class="s5_wrap_bm">
					</div>
				</div>
			</div>
			</div>
					
		</div>
		
		<jdoc:include type="modules" name="debug" style="xhtml" />
		
	</div>
	
	<?php if ($s5_tooltips  == "yes") { ?>
		<script type="text/javascript" language="javascript" src="<?php echo $LiveSiteUrl ?>templates/comaxium/js/tooltips.js"></script>
	<?php } ?>
	
	<?php if ($s5_menu  != "5") { ?>
		<script type="text/javascript" language="javascript" src="<?php echo $LiveSiteUrl ?>templates/comaxium/js/s5_textmenu.js"></script>
	<?php } ?>
	
	<?php if ($s5_multibox  == "yes") { ?>
	<script type="text/javascript">
		var s5mbox = {};
		window.addEvent('domready', function(){	s5mbox = new MultiBox('s5mb', {descClassName: 's5_multibox', <?php if ($s5_multioverlay  == "1") { ?>useOverlay: true<?php } else {?>useOverlay: false<?php } ?>, <?php if ($s5_multicontrols  == "1") { ?>showControls: true<?php } else {?>showControls: false<?php } ?>});	});
	</script>
	<?php } ?>
	

</body>

</html>