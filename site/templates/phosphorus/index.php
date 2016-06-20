<?php
defined( '_JEXEC' ) or die( 'Restricted index access' );
define( 'TEMPLATEPATH', dirname(__FILE__) );


/*
-----------------------------------------
Phosphorus - November 2010 Shape 5 Club Template
-----------------------------------------
Site:      www.shape5.com
Email:     contact@shape5.com
@license:  Copyrighted Commercial Software
@copyright (C) 2010 Shape 5

*/
// Template Configuration    

	$s5_menu = $this->params->get ("xml_s5_menu"); 
	$s5_effects = $this->params->get ("xml_s5_jsmenu"); 
	$s5_moover = $this->params->get ("xml_s5_moover"); 
	$s5_fonts = $this->params->get ("xml_s5_fonts");
	$s5_colors = $this->params->get ("xml_s5_colors");
	$s5_widthtype = $this->params->get ("xml_s5_widthtype");
	$s5_body_width = $this->params->get ("xml_s5_body_width");
	$s5_left_width = $this->params->get ("xml_s5_left_width");
	$s5_right_width = $this->params->get ("xml_s5_right_width");
	$s5_inset_width = $this->params->get ("xml_s5_inset_width");
	$s5_show_frontpage = $this->params->get ("xml_s5_frontpage");  
	$s5_topback = $this->params->get ("xml_s5_topback");
	$s5_headerback  = $this->params->get ("xml_s5_headerback");
	$s5_bottomback = $this->params->get ("xml_s5_bottomback");
	$s5_register = $this->params->get ("xml_s5_register");
	$s5_login = $this->params->get ("xml_s5_login");
	$s5_loginout = $this->params->get ("xml_s5_loginout");
	$s5_backimage  = $this->params->get ("xml_s5_backimage");	
	$s5_backcolor = $this->params->get ("xml_s5_backcolor");
	$s5_mbbackcolor = $this->params->get ("xml_s5_mbbackcolor");
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
	$s5_subtext = $this->params->get ("xml_s5_subtext");
	$s5_tooltips = $this->params->get ("xml_s5_tooltips");
	$s5_multibox = $this->params->get ("xml_s5_multibox");
	$s5_multioverlay = $this->params->get ("xml_s5_multioverlay");
	$s5_multicontrols = $this->params->get ("xml_s5_multicontrols");
	$s5_urlforSEO = $this->params->get ("xml_s5_seourl");
	$s5_thirdparty = $this->params->get ("xml_s5_thirdparty");
	$s5_lr_tab1_text = $this->params->get ("xml_s5_lr_tab1_text");
	$s5_lr_tab2_text = $this->params->get ("xml_s5_lr_tab2_text");
	$s5_lr_tab1_text = str_replace(" ","&nbsp;",$s5_lr_tab1_text);
	$s5_lr_tab2_text = str_replace(" ","&nbsp;",$s5_lr_tab2_text);	
	$s5_lr_tab1_height = $this->params->get ("xml_s5_lr_tab1_height");
	$s5_lr_tab2_height = $this->params->get ("xml_s5_lr_tab2_height");
	$s5_lr_tab1_top_percent = $this->params->get ("xml_s5_lr_tab1_vp");
	$s5_lr_tab2_top_percent = $this->params->get ("xml_s5_lr_tab2_vp");
	$s5_lr_tab1_class =  $this->params->get ("xml_s5_lr_tab1_class");	
	$s5_lr_tab2_class = $this->params->get ("xml_s5_lr_tab2_class");
	$s5_lr_tab1_left_right = $this->params->get ("xml_s5_lr_tab1_left_right");	
	$s5_lr_tab2_left_right = $this->params->get ("xml_s5_lr_tab2_left_right");
	$s5_lr_tab_border = $this->params->get ("xml_s5_lr_tab_border");
	$s5_lr_tab_color = $this->params->get ("xml_s5_lr_tab_color");
	$s5_lr_tab_font = $this->params->get ("xml_s5_lr_tab_font");
	$s5_lr_tab1_click = $this->params->get ("xml_s5_lr_tab1_click");
	$s5_lr_tab2_click = $this->params->get ("xml_s5_lr_tab2_click");
	
	
////////////////////////  DO NOT EDITBELOW THIS  ////////////////////////
// Middle content calculations
if (!$this->countModules("left") && !$this->countModules("right")) { $s5_mainbody_width = (($s5_body_width) - 39); }
else if ($this->countModules("left") && !$this->countModules("right")) { $s5_mainbody_width = $s5_body_width - ($s5_left_width + 52);}
else if (!$this->countModules("left") && $this->countModules("right")) { $s5_mainbody_width = $s5_body_width - ($s5_right_width + 52);}
else if ($this->countModules("left") && $this->countModules("right")) { $s5_mainbody_width = $s5_body_width - (($s5_left_width + $s5_right_width) + 66); }

// above body 1, 2, and 3 collapse calculations 
if ($this->countModules("above_body_1") && $this->countModules("above_body_2")  && $this->countModules("above_body_3")) { $abovebody="33"; }
else if ($this->countModules("above_body_1") && $this->countModules("above_body_2") && !$this->countModules("above_body_3")) { $abovebody="49.9"; }
else if ($this->countModules("above_body_1") && !$this->countModules("above_body_2") && $this->countModules("above_body_3")) { $abovebody="49.9"; }
else if (!$this->countModules("above_body_1") && $this->countModules("above_body_2") && $this->countModules("above_body_3")) { $abovebody="49.9"; }
else if ($this->countModules("above_body_1") && !$this->countModules("above_body_2") && !$this->countModules("above_body_3")) { $abovebody="100"; }
else if (!$this->countModules("above_body_1") && $this->countModules("above_body_2") && !$this->countModules("above_body_3")) { $abovebody="100"; }
else if (!$this->countModules("above_body_1") && !$this->countModules("above_body_2") && $this->countModules("above_body_3")) { $abovebody="100"; }


// advert 1, 2, and 3 collapse calculations 
if ($this->countModules("advert1") && $this->countModules("advert2")  && $this->countModules("advert3")) { $advert="33"; }
else if ($this->countModules("advert1") && $this->countModules("advert2") && !$this->countModules("advert3")) { $advert="49.9"; }
else if ($this->countModules("advert1") && !$this->countModules("advert2") && $this->countModules("advert3")) { $advert="49.9"; }
else if (!$this->countModules("advert1") && $this->countModules("advert2") && $this->countModules("advert3")) { $advert="49.9"; }
else if ($this->countModules("advert1") && !$this->countModules("advert2") && !$this->countModules("advert3")) { $advert="100"; }
else if (!$this->countModules("advert1") && $this->countModules("advert2") && !$this->countModules("advert3")) { $advert="100"; }
else if (!$this->countModules("advert1") && !$this->countModules("advert2") && $this->countModules("advert3")) { $advert="100"; }

// top 1, 2, and 3 collapse calculations 
if ($this->countModules("top_1") && $this->countModules("top_2")  && $this->countModules("top_3")) { $advert2="33"; }
else if ($this->countModules("top_1") && $this->countModules("top_2") && !$this->countModules("top_3")) { $advert2="49.9"; }
else if ($this->countModules("top_1") && !$this->countModules("top_2") && $this->countModules("top_3")) { $advert2="49.9"; }
else if (!$this->countModules("top_1") && $this->countModules("top_2") && $this->countModules("top_3")) { $advert2="49.9"; }
else if ($this->countModules("top_1") && !$this->countModules("top_2") && !$this->countModules("top_3")) { $advert2="100"; }
else if (!$this->countModules("top_1") && $this->countModules("top_2") && !$this->countModules("top_3")) { $advert2="100"; }
else if (!$this->countModules("top_1") && !$this->countModules("top_2") && $this->countModules("top_3")) { $advert2="100"; }

// top 4, 5, and 6 collapse calculations 
if ($this->countModules("top_4") && $this->countModules("top_5")  && $this->countModules("top_6")) { $top2="33"; }
else if ($this->countModules("top_4") && $this->countModules("top_5") && !$this->countModules("top_6")) { $top2="49.9"; }
else if ($this->countModules("top_4") && !$this->countModules("top_5") && $this->countModules("top_6")) { $top2="49.9"; }
else if (!$this->countModules("top_4") && $this->countModules("top_5") && $this->countModules("top_6")) { $top2="49.9"; }
else if ($this->countModules("top_4") && !$this->countModules("top_5") && !$this->countModules("top_6")) { $top2="100"; }
else if (!$this->countModules("top_4") && $this->countModules("top_5") && !$this->countModules("top_6")) { $top2="100"; }
else if (!$this->countModules("top_4") && !$this->countModules("top_5") && $this->countModules("top_6")) { $top2="100"; }

// contentbottom 1, 2, and 3 collapse calculations 
if ($this->countModules("contentbottom1") && $this->countModules("contentbottom2")  && $this->countModules("contentbottom3")) { $contentbottom="33.3"; }
else if ($this->countModules("contentbottom1") && $this->countModules("contentbottom2") && !$this->countModules("contentbottom3")) { $contentbottom="49.5"; }
else if ($this->countModules("contentbottom1") && !$this->countModules("contentbottom2") && $this->countModules("contentbottom3")) { $contentbottom="49.5"; }
else if (!$this->countModules("contentbottom1") && $this->countModules("contentbottom2") && $this->countModules("contentbottom3")) { $contentbottom="49.5"; }
else if ($this->countModules("contentbottom1") && !$this->countModules("contentbottom2") && !$this->countModules("contentbottom3")) { $contentbottom="100"; }
else if (!$this->countModules("contentbottom1") && $this->countModules("contentbottom2") && !$this->countModules("contentbottom3")) { $contentbottom="100"; }
else if (!$this->countModules("contentbottom1") && !$this->countModules("contentbottom2") && $this->countModules("contentbottom3")) { $contentbottom="100"; }



// contentbottom 4, 5, and 6 collapse calculations 
if ($this->countModules("contentbottom4") && $this->countModules("contentbottom5")  && $this->countModules("contentbottom6")) { $contentbottom2="33.3"; }
else if ($this->countModules("contentbottom4") && $this->countModules("contentbottom5") && !$this->countModules("contentbottom6")) { $contentbottom2="49.5"; }
else if ($this->countModules("contentbottom4") && !$this->countModules("contentbottom5") && $this->countModules("contentbottom6")) { $contentbottom2="49.5"; }
else if (!$this->countModules("contentbottom4") && $this->countModules("contentbottom5") && $this->countModules("contentbottom6")) { $contentbottom2="49.5"; }
else if ($this->countModules("contentbottom4") && !$this->countModules("contentbottom5") && !$this->countModules("contentbottom6")) { $contentbottom2="100"; }
else if (!$this->countModules("contentbottom4") && $this->countModules("contentbottom5") && !$this->countModules("contentbottom6")) { $contentbottom2="100"; }
else if (!$this->countModules("contentbottom4") && !$this->countModules("contentbottom5") && $this->countModules("contentbottom6")) { $contentbottom2="100"; }	

//user1 and 2 calculations
if ($this->countModules("user1") && $this->countModules("user2")) { $user23="49.5"; }
else if (!$this->countModules("user1") && $this->countModules("user2")) { $user23="100";  }
else if ($this->countModules("user1") && !$this->countModules("user2")) { $user23="100";  }

//user3, 4, 5, 6, 7 and 8 calculations
if ($this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="16.5"; }
else if (!$this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="20"; }
else if ($this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="20"; }
else if ($this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="20"; }
else if ($this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5")  && !$this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="20"; }
else if ($this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5")  && $this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="20"; }
else if ($this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="20"; }

else if ($this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5")  && $this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="24.5"; }
else if ($this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5")  && !$this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="24.5"; }
else if ($this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="24.5"; }
else if ($this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="24.5"; }
else if (!$this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="24.5"; }
else if (!$this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="24.5"; }
else if ($this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="24.5"; }
else if ($this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5")  && !$this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="24.5"; }
else if ($this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5")  && !$this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="24.5"; }
else if (!$this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5")  && $this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="24.5"; }
else if ($this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5")  && !$this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="24.5"; }
else if ($this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5")  && $this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="24.5"; }

else if (!$this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5") && $this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5") && $this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && $this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="33";  }
else if (!$this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="33";  }
else if (!$this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5") && $this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && $this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="33";  }
else if (!$this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && $this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="33";  }
else if (!$this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && $this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="33";  }
else if (!$this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && $this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="33";  }
else if ($this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="33";  }
else if (!$this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="33";  }

else if (!$this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5") && $this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="49.5"; }
else if ($this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && $this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="49.5"; }
else if ($this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="49.5"; }
else if (!$this->countModules("user3") && $this->countModules("user4") && $this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="49.5"; }
else if (!$this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && $this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="49.5"; }
else if ($this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="49.5"; }
else if ($this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="49.5"; }
else if (!$this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="49.5"; }
else if (!$this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="49.5"; }
else if (!$this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && $this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="49.5"; }
else if (!$this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && $this->countModules("user8")) { $bottom4="49.5"; }
else if (!$this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && $this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="49.5"; }
else if (!$this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="49.5"; }
else if (!$this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="49.5"; }
else if ($this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="49.5"; }

else if ($this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="100"; }
else if (!$this->countModules("user3") && $this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="100"; }
else if (!$this->countModules("user3") && !$this->countModules("user4") && $this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="100"; }
else if (!$this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && $this->countModules("user6") && !$this->countModules("user7") && !$this->countModules("user8")) { $bottom4="100"; }
else if (!$this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && $this->countModules("user7") && !$this->countModules("user8")) { $bottom4="100"; }
else if (!$this->countModules("user3") && !$this->countModules("user4") && !$this->countModules("user5") && !$this->countModules("user6") && !$this->countModules("user7") && $this->countModules("user8")) { $bottom4="100"; }


if ($s5_effects == "s5") { 
if (($s5_menu  == "1") || ($s5_menu  == "3") || ($s5_menu  == "4")){ 
require( TEMPLATEPATH.DS."s5_no_moo_menu.php");}
else if ($s5_menu  == "2")  {
require( TEMPLATEPATH.DS."s5_suckerfish.php");}
$menu_name = $this->params->get ("xml_menuname");}

if ($s5_effects == "jq") { 
require( TEMPLATEPATH.DS."s5_suckerfish.php");
$menu_name = $this->params->get ("xml_menuname");}

if ($s5_urlforSEO  == ""){ 
$LiveSiteUrl = JURI::root();}
if ($s5_urlforSEO  != ""){ 
$LiveSiteUrl = "$s5_urlforSEO/";}

JHTML::_('behavior.mootools');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<meta http-equiv="Content-Type" content="text/html;" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link rel="stylesheet" href="<?php echo $LiveSiteUrl ?>templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $LiveSiteUrl ?>templates/system/css/general.css" type="text/css" />

<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/template.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/editor.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/suckerfish.css" rel="stylesheet" type="text/css" media="screen" />

<?php if ($s5_colors == "preset2") { ?>
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/preset2.css" rel="stylesheet" type="text/css" media="screen" /><?php } ?>
<?php if ($s5_colors == "preset3") { ?>
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/preset3.css" rel="stylesheet" type="text/css" media="screen" /><?php } ?>
<?php if ($s5_colors == "preset4") { ?>
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/preset4.css" rel="stylesheet" type="text/css" media="screen" /><?php } ?>
<?php if ($s5_colors == "preset5") { ?>
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/preset5.css" rel="stylesheet" type="text/css" media="screen" /><?php } ?>
<?php if ($s5_colors == "preset6") { ?>
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/preset6.css" rel="stylesheet" type="text/css" media="screen" /><?php } ?>
<?php if ($s5_colors == "preset7") { ?>
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/preset7.css" rel="stylesheet" type="text/css" media="screen" /><?php } ?>

<?php if($s5_thirdparty == "enabled") { ?>
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/thirdparty.css" rel="stylesheet" type="text/css" media="screen" />
<?php } ?>
<?php if($this->direction == "rtl") { ?>
<link href="<?php echo $LiveSiteUrl ?>templates/phosphorus/css/template_rtl.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $LiveSiteUrl ?>templates/phosphorus/css/editor_rtl.css" rel="stylesheet" type="text/css" media="screen" />
<?php } ?>
<?php if(($s5_fonts != "Arial") || ($s5_fonts != "Helvetica")|| ($s5_fonts != "Sans-Serif")) { ?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $s5_fonts;?>" />
<?php } ?>
<?php if ($s5_multibox  == "yes") { ?>
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/multibox/multibox.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $LiveSiteUrl;?>templates/phosphorus/css/multibox/ajax.css" rel="stylesheet" type="text/css" media="screen" />
<?php if ($s5_moover  == "moo112") { ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/multibox/overlay.js"></script>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/multibox/multibox.js"></script>
<?php } ?>
<?php if ($s5_moover  == "moo124") { ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/multibox/mootools124/overlay.js"></script>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/multibox/mootools124/multibox.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/multibox/AC_RunActiveContent.js"></script>
<?php } ?>

<?php if ($s5_effects == "jq") { ?>
<?php if (($s5_menu  == "1") || ($s5_menu  == "3") || ($s5_menu  == "4")) { ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/jquery13.js"></script>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/jquery_no_conflict.js"></script>
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
		jQuery(this).find('ul:first').css({visibility: "visible",display: "none"}).<?php if ($s5_menu  == "1") { ?>show(400)<?php } ?><?php if ($s5_menu  == "3") { ?>fadeIn(500)<?php } ?><?php if ($s5_menu  == "4") { ?>slideDown(400)<?php } ?>;
		},function(){jQuery(this).find('ul:first').css({visibility: "hidden"});	});}
  jQuery(document).ready(function(){ s5_jqmainmenu();});
</script>
<?php } ?>
<?php } ?>
<?php if ($s5_subtext == "yes") { 
echo "<script language=\"javascript\" type=\"text/javascript\" >var s5_text_menu_1 = '".$s5_text_menu_1."';var s5_text_menu_2 = '".$s5_text_menu_2."';var s5_text_menu_3 = '".$s5_text_menu_3."';var s5_text_menu_4 = '".$s5_text_menu_4."';var s5_text_menu_5 = '".$s5_text_menu_5."';var s5_text_menu_6 = '".$s5_text_menu_6."';var s5_text_menu_7 = '".$s5_text_menu_7."';var s5_text_menu_8 = '".$s5_text_menu_8."';var s5_text_menu_9 = '".$s5_text_menu_9."';var s5_text_menu_10 = '".$s5_text_menu_10."';</script>";
}?>

<script type="text/javascript">
var s5searchopenorno = 0;		
var s5searchopenoryes = 0;	
function s5_searchactive() {
if (s5searchopenoryes == 0) {
		if (s5searchopenorno == 0) {
		document.getElementById("s5_topgradsearch").style.display = "block";
		s5searchopenorno = 1;
		s5searchopenoryes = 1;
		} else if (s5searchopenorno == 1) {
		document.getElementById("s5_topgradsearch").style.display = "none";
		s5searchopenorno = 0;
		s5searchopenoryes = 1;
		}}}

function s5_searchactiveh() {document.getElementById("s5_topgradsearch").style.display = "none";s5searchopenoryes = 0;setTimeout('s5_searchreset()',100);}
function s5_searchreset() {s5searchopenorno = 0;s5searchopenoryes = 0;}
</script>



<?php
$br = strtolower($_SERVER['HTTP_USER_AGENT']);
$browser = "other";
if(strrpos($br,"msie 6") > 1) {$browser = "ie6";}
if(strrpos($br,"msie 7") > 1) {$browser = "ie7";}
if(strrpos($br,"msie 8") > 1) {$browser = "ie8";}

$s5_domain = $_SERVER['HTTP_HOST'];
$s5_url = "http://" . $s5_domain . $_SERVER['REQUEST_URI'];
$s5_frontpage = "yes";
$s5_current_page = "";

	if (JRequest::getVar('view') == "frontpage") {
		$s5_current_page = "frontpage";	}
	
	if (JRequest::getVar('view') != "frontpage") {
		$s5_current_page = "not_frontpage";	}
	
	$s5_check_frontpage = strrpos($s5_url,"index.php");
	if ($s5_check_frontpage > 1) {
		$s5_current_page = "not_frontpage";	}
	
	$s5_check_frontpage2 = strrpos($s5_url,"view=frontpage&Itemid=1");
	if ($s5_check_frontpage2 > 1) {
		$s5_current_page = "frontpage";	}
	
	if ($s5_show_frontpage == "no" && $s5_current_page == "frontpage") {
		$s5_frontpage = "no";}
?>	
	
<?php if ($browser == "ie6" || $browser == "ie7" || $browser == "ie8") { ?>	
<?php if (($s5_menu  == "1") || ($s5_menu  == "2") || ($s5_menu  == "3") || ($s5_menu  == "4")) { ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/IEsuckerfish.js"></script>
<?php } ?>	
<?php } ?>	


<style type="text/css"> 
.s5_wrap, .s5_wrap2{width:<?php echo ($s5_body_width);?><?php echo ($s5_widthtype);?>;}
<?php if($this->countModules('right')) { ?>	
#s5_mainbody, #s5_mainbodybread {margin-right:<?php echo ($s5_right_width) + 1;?>px;}
<?php } ?><?php if($this->countModules('left')) { ?>	
#s5_mainbody, #s5_mainbodybread {margin-left:<?php echo ($s5_left_width) + 20;?>px;}
<?php } ?>	
<?php if ($browser == "ie7") { ?>	
.s5_yeardate {margin-left:-5px;margin-top:-23px;}
<?php } ?>	
<?php if ($browser == "ie7") { ?>	
<?php if($this->direction == "rtl") { ?>
.s5_yeardate {	margin-right:-5px;}
#s5_navv ul {float:none;}
.s5_radiobutton {padding-right:23px;}
#s5_navv ul li.s5_menutop, #s5_navv ul li.s5_menutop:hover {margin-left:2px;}
#s5_navv ul li.s5_toparrow, #s5_navv ul li.s5_toparrow:hover {margin-left:1px;}
<?php } ?>
<?php } ?>	
<?php if ($browser == "ie7" || $browser == "ie8") { ?>
.s5_lr_tab_inner, .s5_yeardate{writing-mode: bt-rl;filter: flipV flipH;}
<?php } ?>
<?php if ($browser == "ie8") { ?>
#mod_search_searchword {padding-top:4px;}
<?php } ?>	
body {font-family: '<?php echo $s5_fonts;?>',Helvetica,Arial,Sans-Serif ;} 
<?php if($s5_thirdparty == "enabled") { ?>
/* k2 stuff */
div.itemHeader h2.itemTitle, div.catItemHeader h3.catItemTitle, h3.userItemTitle a {font-family: '<?php echo $s5_fonts;?>',Helvetica,Arial,Sans-Serif ;} 
<?php } ?>	
</style>
</head>
<body style="background:#<?php echo $s5_backcolor; ?> url(<?php echo $s5_headerback; ?>) repeat;">
<div id="s5_topback" style="background: url(<?php echo $s5_topback; ?>) no-repeat scroll center 99px transparent;"> 


		<!-- Fixed tabs -->	
		<!-- Called by javascript to validate text rotate with W3C -->	
		<?php if ($browser != "ie7" && $browser != "ie8") { ?>
			<script type="text/javascript">//<![CDATA[
			document.write('<style type="text/css">.s5_lr_tab_inner{-webkit-transform: rotate(270deg);-moz-transform: rotate(270deg);-o-transform: rotate(270deg);}</style>');
			//]]></script>
		<?php } ?>

		<?php if($s5_lr_tab1_text != "") { ?>
			<div class="<?php echo $s5_lr_tab1_class;?> s5_lr_tab" <?php if($s5_lr_tab1_click != "") { ?>onclick="window.document.location.href='<?php echo $s5_lr_tab1_click; ?>'"<?php } ?> style="color:#<?php echo $s5_lr_tab_font; ?>;background-color:#<?php echo $s5_lr_tab_color; ?>;border:2px solid #<?php echo $s5_lr_tab_border; ?>;<?php if($s5_lr_tab1_left_right == "left") { ?>left:-2px;<?php } ?><?php if($s5_lr_tab1_left_right == "right") { ?>right:-2px;<?php } ?>top:<?php echo $s5_lr_tab1_top_percent;?>%;height:<?php echo $s5_lr_tab1_height ?>px" id="s5_lr_tab1">
				<div class="s5_lr_tab_inner" id="s5_lr_tab_inner1" <?php if ($browser != "ie7" && $browser != "ie8") { ?>style="margin-top: <?php echo ($s5_lr_tab1_height) - 30?>px;"<?php } ?>>
					<?php echo $s5_lr_tab1_text; ?>
				</div>
			</div>
		<?php } ?>

		<?php if($s5_lr_tab2_text != "") { ?>
			<div class="<?php echo $s5_lr_tab2_class;?> s5_lr_tab" <?php if($s5_lr_tab2_click != "") { ?>onclick="window.document.location.href='<?php echo $s5_lr_tab2_click; ?>'"<?php } ?> style="color:#<?php echo $s5_lr_tab_font; ?>;background-color:#<?php echo $s5_lr_tab_color; ?>;border:2px solid #<?php echo $s5_lr_tab_border; ?>;<?php if($s5_lr_tab2_left_right == "left") { ?>left:-2px;<?php } ?><?php if($s5_lr_tab2_left_right == "right") { ?>right:-2px;<?php } ?>top:<?php echo $s5_lr_tab2_top_percent;?>%;height:<?php echo $s5_lr_tab2_height ?>px" id="s5_lr_tab2">
				<div class="s5_lr_tab_inner" id="s5_lr_tab_inner2" <?php if ($browser != "ie7" && $browser != "ie8") { ?>style="margin-top: <?php echo ($s5_lr_tab1_height) - 30?>px;"<?php } ?>>
					<?php echo $s5_lr_tab2_text; ?>
				</div>
			</div>
		<?php } ?>
		<!-- End fixed tabs -->	



<div id="s5_topmenu">
<div class="s5_leftshadow">
<div class="s5_rightshadow">
	<div class="s5_wrap">	
		<?php if($this->countModules('top')) { ?>
		<div id="s5_topmod">
			<jdoc:include type="modules" name="top" style="xhtml" />	
		</div>
		<?php } ?>
		<?php if (($s5_login  != "") || ($s5_register  != "")) { ?>	
		<div id="s5_logreg">	
				<div id="s5_logregtm">
					<?php if ($s5_login  != "") { ?>
					<div id="s5_login" class="s5box_login"><ul class="s5boxmenu"><li><span><span>
						<?php  $user =& JFactory::getUser();   
					  $user_id = $user->get('id');   
					  if ($user_id) { echo $s5_loginout; } else {?>
						<?php echo $s5_login;?>
						<?php } ?>
						</span></span></li></ul></div>
					<?php } ?>
					<?php if ($s5_register  != "") { ?>

					<?php  $user =& JFactory::getUser();   
					  $user_id = $user->get('id');   
					  if ($user_id) { } else {?>
					<div id="s5_register" class="s5box_register"><ul class="s5boxmenu"><li><span><span><?php echo $s5_register;?></span></span></li></ul></div>
					<?php } ?>
					<?php } ?>
				</div>
		
		</div>
		<?php } ?>
	</div>
</div>	
</div>	





<div id="s5_topbar">
<div id="s5_topbar_line">
<div class="s5_leftshadow">
<div class="s5_rightshadow">
	<div class="s5_wrap">		
		<?php if($this->countModules('logo')) { ?>
            <div id="s5_logo_module" style="cursor:pointer;" onclick="window.document.location.href='<?php echo $LiveSiteUrl ?>'">
                <jdoc:include type="modules" name="logo" style="notitle" />
            </div>	
        <?php } else { ?>
            <div id="s5_logo" style="cursor:pointer;" onclick="window.document.location.href='<?php echo $LiveSiteUrl ?>'"></div>
		<?php } ?>
		

		<?php if($this->countModules('search')) { ?>	
				<div style="display:none;"><img src="<?php echo $LiveSiteUrl ?>templates/phosphorus/images/Shape5_Phosphorus_searchback.png" alt="search back preload" /></div>
				<div id="s5_searchicon" onclick="s5_searchactive();">
				<div id="s5_topgradsearch">
					<jdoc:include type="modules" name="search" style="xhtml" />	
					<div id="s5_searchclose" onclick="s5_searchactiveh();"></div>
				</div>	
				</div>
		<?php } ?>	
		
		<?php if (($s5_menu  == "1") || ($s5_menu  == "2") || ($s5_menu  == "3") || ($s5_menu  == "4")) { ?>
				<!-- Start Menu -->
				<div id="s5_menu">						
					<div id="s5_navv">	
						<?php mosShowListMenu($menu_name);	?>
						<?php if ($s5_effects == "s5") { ?>
						<?php if ($s5_menu  == "1") { ?>
							<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/s5_no_moo_menu.js"></script>																		
						<?php } ?>
						<?php if ($s5_menu  == "3") { ?>
							<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/s5_fading_no_moo_menu.js"></script>																		
						<?php } ?>	
						<?php if ($s5_menu  == "4") { ?>
							<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/s5_scroll_down_no_moo_menu.js"></script>																		
						<?php } ?>	
						<?php } ?>	
						<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/s5_menu_active_and_parent_links.js"></script>	
					</div>	
				</div>
				<!-- End Menu -->
			<?php } ?>	
			
		<div style="clear:both;"></div>
	</div>
</div>	
</div>	
</div>
</div>


<div id="s5_topbar_shad"></div>	

<?php if($this->countModules('top_1') || $this->countModules('top_2') || $this->countModules('top_3') || $this->countModules('top_4') || $this->countModules('top_5') || $this->countModules('top_6') || $this->countModules('advert1') || $this->countModules('advert2') || $this->countModules('advert3')) { ?>	
<div style="width:100%;">
	<div class="s5_topbar_line2">
	<div class="s5_leftshadow">
	<div class="s5_rightshadow">
		<div class="s5_wrap">	
				<div id="s5_topgradient_back">
					<div id="s5_topgradient">	
					<div id="s5_bottomgradient">
						<div class="s5_wrap">
						<div <?php if(($this->countModules('top_1') || $this->countModules('top_2') || $this->countModules('top_3')) && ($this->countModules('top_4') || $this->countModules('top_5') || $this->countModules('top_6') || $this->countModules('advert1') || $this->countModules('advert2') || $this->countModules('advert3'))) { ?>class="s5_leftset50"<?php } ?><?php if(!$this->countModules('top_4') && !$this->countModules('top_5') && !$this->countModules('top_6') && !$this->countModules('advert1') && !$this->countModules('advert2') && !$this->countModules('advert3')) { ?>class="s5_leftset100"<?php } ?>>
							<?php if($this->countModules('top_1') || $this->countModules('top_2') || $this->countModules('top_3')) { ?>	
								<div class="s5_w_modwrap" >
									<!-- Start top 1-3 -->
											<?php if($this->countModules('top_1')) { ?>	
												<div id="s5_advert4_<?php echo $advert2; ?>">
													<jdoc:include type="modules" name="top_1" style="round_box" />	
												</div>
											<?php } ?>
											<?php if($this->countModules('top_2')) { ?>	
												<div id="s5_advert5_<?php echo $advert2; ?>">	
													<jdoc:include type="modules" name="top_2" style="round_box" />
												</div>
											<?php } ?>
											<?php if($this->countModules('top_3')) { ?>	
												<div id="s5_advert6_<?php echo $advert2; ?>">
													<jdoc:include type="modules" name="top_3" style="round_box" />
												</div>
											<?php } ?>		
											<div style="clear:both;"></div>		
									<!-- End top 1-3 -->
								</div>
							<?php } ?>						
						</div>	
						<div <?php if(($this->countModules('top_1') || $this->countModules('top_2') || $this->countModules('top_3')) && ($this->countModules('top_4') || $this->countModules('top_5') || $this->countModules('top_6') || $this->countModules('advert1') || $this->countModules('advert2') || $this->countModules('advert3'))) { ?>class="s5_rightset50"<?php } ?> <?php if(!$this->countModules('top_1') && !$this->countModules('top_2') && !$this->countModules('top_3')) { ?>class="s5_rightset100"<?php } ?>>
							<?php if($this->countModules('top_4') || $this->countModules('top_5') || $this->countModules('top_6')) { ?>	
								<div class="s5_w_modwrap">
									<!-- Start top 1-3 -->
											<?php if($this->countModules('top_4')) { ?>	
												<div id="s5_top4_<?php echo $top2; ?>">
													<div class="s5_modspadding" <?php if($this->direction == "rtl") { ?>style="padding-right:25px;"<?php } ?>>
													<jdoc:include type="modules" name="top_4" style="round_box" />	
													</div>
												</div>
											<?php } ?>
											<?php if($this->countModules('top_5')) { ?>	
												<div id="s5_top5_<?php echo $top2; ?>">	
													<div class="s5_modspadding" <?php if($this->direction == "rtl") { ?>style="padding-right:25px;"<?php } ?>>
													<jdoc:include type="modules" name="top_5" style="round_box" />
													</div>
												</div>
											<?php } ?>
											<?php if($this->countModules('top_6')) { ?>	
												<div id="s5_top6_<?php echo $top2; ?>">
													<div class="s5_modspadding" <?php if($this->direction == "rtl") { ?>style="padding-right:25px;"<?php } ?>>
													<jdoc:include type="modules" name="top_6" style="round_box" />
													</div>	
												</div>
											<?php } ?>		
											<div style="clear:both;"></div>		
									<!-- End top 1-3 -->
								</div>
							<?php } ?>
							<div style="clear:both;"></div>		
							<?php if($this->countModules('advert1') || $this->countModules('advert2') || $this->countModules('advert3')) { ?>	
							<div id="s5_advertwrap">
										<!-- Adverts -->	
											<?php if($this->countModules('advert1')) { ?>	
											<div id="s5_advert1_<?php echo $advert; ?>">
												<div class="s5_modspadding">
												<jdoc:include type="modules" name="advert1" style="round_box" />	
												</div>
											</div>
											<?php } ?>
											<?php if($this->countModules('advert2')) { ?>	
											<div id="s5_advert2_<?php echo $advert; ?>">	
												<div class="s5_modspadding">
												<jdoc:include type="modules" name="advert2" style="round_box" />
												</div>
											</div>
											<?php } ?>
											<?php if($this->countModules('advert3')) { ?>	
											<div id="s5_advert3_<?php echo $advert; ?>">
												<div class="s5_modspadding">
												<jdoc:include type="modules" name="advert3" style="round_box" />
												</div>
											</div>
											<?php } ?>		
											<div style="clear:both;"></div>										
										<!-- End Adverts -->	
							</div>		
							<?php } ?>						
						</div>	
						<div style="clear:both;"></div>		
	
						</div>
					</div>
					</div>
				</div>
		</div>
	</div>	
	</div>	
	</div>	
</div>
<?php } ?>
<div style="clear:both;"></div>



<?php if($this->countModules('above_body_1') || $this->countModules('above_body_2') || $this->countModules('above_body_3')) { ?>	
<div id="s5_abovebodymods">
<div id="s5_abovebodymodsbot">
	<div class="s5_leftshadow">
	<div class="s5_rightshadow">
		<div class="s5_wrap">
				<!-- Start Above Body -->	
						<?php if($this->countModules('above_body_1')) { ?>	
							<div class="s5_above_body" style="width:<?php echo $abovebody; ?>%">
								<jdoc:include type="modules" name="above_body_1" style="round_box" />	
							</div>
						<?php } ?>
						<?php if($this->countModules('above_body_2')) { ?>	
							<div class="s5_above_body" style="width:<?php echo $abovebody; ?>%">	
								<jdoc:include type="modules" name="above_body_2" style="round_box" />
							</div>
						<?php } ?>
						<?php if($this->countModules('above_body_3')) { ?>	
							<div class="s5_above_body" style="width:<?php echo $abovebody; ?>%">
								<jdoc:include type="modules" name="above_body_3" style="round_box" />
							</div>
						<?php } ?>		
						<div style="clear:both;"></div>
				<!-- End Above Body -->		
		</div>
	</div>	
	</div>		
</div>	
</div>	
<div style="clear:both;"></div>
<?php } ?>	


<div class="s5_mainouter">
	<div class="s5_leftshadow">
	<div class="s5_rightshadow">
		<div class="s5_wrap">	
		<!-- Main Body -->				
			<div style="width:100%;overflow:hidden;position:relative;">
				<div id="s5_mainbodyfullw">
				<div id="s5_mainbodywrapper">
				<div id="s5_mainbodybread">	
					<div id="s5_middlecolwrap">
										<div class="s5_mainmiddle_padding">	
											<div id="s5_abovebodyusers">	

											<?php if($this->countModules('user1') || $this->countModules('user2')) { ?>	
												<div id="s5_positions">
													<?php if($this->countModules('user1')) { ?>	
														<div id="s5_user1_<?php echo $user23; ?>">
															<jdoc:include type="modules" name="user1" style="round_box" />
														</div>
													<?php } ?>
													<?php if($this->countModules('user2')) { ?>	
														<div id="s5_user2_<?php echo $user23; ?>">
															<jdoc:include type="modules" name="user2" style="round_box" />
														</div>
													<?php } ?>
												</div>
												<div style="clear:both;"></div>	
											<?php } ?>	
											</div>
											
										<?php if ($s5_frontpage == "yes") { ?>																		
												<div id="s5_mainbodyleft">
												<div id="s5_mainbodyright">
													<div id="s5_mainbodyshadright"></div>
												
													<div <?php if($this->countModules('inset')) { ?>id="s5_bodygradient"<?php } else {?>id="s5_bodygradientnoin"<?php } ?>>	
													<div <?php if($this->countModules('inset')) { ?>style="margin-right:<?php echo ($s5_inset_width) + 20;?>px;position:relative;float:left;left:0;"<?php } ?>>
														
													<?php if($this->countModules('breadcrumb')) { ?>
													
														<!-- Breadcrumbs -->
														<div id="s5_breadcrumbs">
															<div id="s5_breadcrumbsinner">
																<jdoc:include type="modules" name="breadcrumb" style="xhtml" />
															</div>
														</div>
														<!-- End Breadcrumbs -->	
														
													<?php } ?>
														
														<div style="clear:both;"></div>	
														<jdoc:include type="message" />
														<jdoc:include type="component" />		
													</div>
													
													<?php if($this->countModules('inset')) { ?>	
													<div id="s5_inset" style="padding-right:10px;float:right;margin-left:-<?php echo ($s5_inset_width) + 10;?>px;width:<?php echo ($s5_inset_width) - 10;?>px;">
														<div style="clear:both;"></div>	
														<jdoc:include type="modules" name="inset" style="round_box" />
													</div>
													<?php } ?>
														<div style="clear:both;"></div>	
														
													<?php if($this->countModules('contentbottom1') || $this->countModules('contentbottom2') || $this->countModules('contentbottom3')) { ?>	
										<div class="s5_w_modwrap">
											<!-- Start User 1-3 -->
													<?php if($this->countModules('contentbottom1')) { ?>	
														<div class="s5_contentbottom" style="width:<?php echo $contentbottom; ?>%;">
															<div class="s5_modspadding">
															<jdoc:include type="modules" name="contentbottom1" style="round_box" />	
															</div>
														</div>
													<?php } ?>
													<?php if($this->countModules('contentbottom2')) { ?>	
														<div class="s5_contentbottom" style="width:<?php echo $contentbottom; ?>%;">	
															<div class="s5_modspadding">
															<jdoc:include type="modules" name="contentbottom2" style="round_box" />
															</div>
														</div>
													<?php } ?>
													<?php if($this->countModules('contentbottom3')) { ?>	
														<div class="s5_contentbottom" style="width:<?php echo $contentbottom; ?>%;">
															<div class="s5_modspadding">
															<jdoc:include type="modules" name="contentbottom3" style="round_box" />
															</div>
														</div>
													<?php } ?>	
													<div style="clear:both;"></div>		
											<!-- EndUser 1-3 -->
										</div>
										<div style="clear:both;"></div>
										<?php } ?>	
													</div>	
												</div>	
												</div>																					
										<?php } ?>										
											
								<div style="clear:both;"></div>	
							</div>
						</div>
					</div>
				</div>	
		
				
				<?php if($this->countModules('left')) { ?>	
				<div id="s5_leftcolumn" style="width:<?php echo ($s5_left_width) + 1;?>px;">
					<div style="clear:both;"></div>
							<div class="s5_backmiddlemiddle_r" style="width:<?php echo ($s5_left_width) - 13;?>px;">	
								<jdoc:include type="modules" name="left" style="round_box" />
							<div style="clear:both;"></div>
					</div>
					<div style="clear:both;"></div>		
					
				</div>
				<?php } ?>		
				
				<?php if($this->countModules('right')) { ?>	
				<div id="s5_rightcolumn" style="width:<?php echo ($s5_right_width) + 1;?>px;margin-left:-<?php if($this->countModules('left') && $this->countModules('right')) { echo (($s5_right_width) + ($s5_left_width) + 15); } else { echo ($s5_right_width) + 1; } ?>px;">
							<div class="s5_backmiddlemiddle_r" style="width:<?php echo ($s5_right_width) - 13;?>px;">
									<jdoc:include type="modules" name="right" style="round_box" />			
								<div style="clear:both;"></div>
							</div>
				</div>	
				<?php } ?>
	
				</div>
			</div>					
			<!-- End Main Body -->			
		</div>
	</div>	
	</div>			
</div>	
<div style="clear:both;"></div>






<?php if($this->countModules('contentbottom4') || $this->countModules('contentbottom5') || $this->countModules('contentbottom6')) { ?>	
<div id="s5_belowbodymods">
<div id="s5_belowbodymodsbot">
	<div class="s5_leftshadow">
	<div class="s5_rightshadow">
		<div class="s5_wrap">		
				<div class="s5_w_modwrap">
					<!-- Start contentbottom 4-6 -->
							<?php if($this->countModules('contentbottom4')) { ?>	
								<div class="s5_contentbottom" style="width:<?php echo $contentbottom2; ?>%;">
									<div class="s5_modspadding">
									<jdoc:include type="modules" name="contentbottom4" style="round_box" />	
									</div>
								</div>
							<?php } ?>
							<?php if($this->countModules('contentbottom5')) { ?>	
								<div class="s5_contentbottom" style="width:<?php echo $contentbottom2; ?>%;">	
									<div class="s5_modspadding">
									<jdoc:include type="modules" name="contentbottom5" style="round_box" />
									</div>
								</div>
							<?php } ?>
							<?php if($this->countModules('contentbottom6')) { ?>	
								<div class="s5_contentbottom" style="width:<?php echo $contentbottom2; ?>%;">
									<div class="s5_modspadding">
									<jdoc:include type="modules" name="contentbottom6" style="round_box" />
									</div>
								</div>
							<?php } ?>	
							<div style="clear:both;"></div>		
					<!-- End contentbottom 4-6 -->
				</div>
			<div style="clear:both;"></div>
		</div>
	</div>	
	</div>		
</div>
</div>
<div style="clear:both;"></div>
<?php } ?>	



<?php if($this->countModules('user3') || $this->countModules('user4') || $this->countModules('user5') || $this->countModules('user6') || $this->countModules('user7')) { ?>	
<div class="s5_mainouter">
<div class="s5_mainouterline">
	<div class="s5_leftshadow">
	<div class="s5_rightshadow">
		<div class="s5_wrap">		
			<div id="s5_gradientusers">		
				<!-- Bottom Modules -->
					<div class="s5_backmiddlemiddle">
						<?php if($this->countModules('user3')) { ?>	
							<div id="s5_user3_<?php echo $bottom4; ?>" class="s5_userpositions" style="width:<?php echo $bottom4; ?>%">
								<jdoc:include type="modules" name="user3" style="round_box" />
							</div>
						<?php } ?>
						<?php if($this->countModules('user4')) { ?>	
							<div id="s5_user4_<?php echo $bottom4; ?>" class="s5_userpositions" style="width:<?php echo $bottom4; ?>%">
								<jdoc:include type="modules" name="user4" style="round_box" />
							</div>
						<?php } ?>
						<?php if($this->countModules('user5')) { ?>	
							<div id="s5_user5_<?php echo $bottom4; ?>" class="s5_userpositions" style="width:<?php echo $bottom4; ?>%">
								<jdoc:include type="modules" name="user5" style="round_box" />
							</div>
						<?php } ?>
						<?php if($this->countModules('user6')) { ?>	
							<div id="s5_user6_<?php echo $bottom4; ?>" class="s5_userpositions" style="width:<?php echo $bottom4; ?>%">
								<jdoc:include type="modules" name="user6" style="round_box" />
							</div>
						<?php } ?>
						<?php if($this->countModules('user7')) { ?>	
							<div id="s5_user7_<?php echo $bottom4; ?>" class="s5_userpositions" style="width:<?php echo $bottom4; ?>%">
								<jdoc:include type="modules" name="user7" style="round_box" />
							</div>
						<?php } ?>
						<?php if($this->countModules('user8')) { ?>	
							<div id="s5_user8_<?php echo $bottom4; ?>" class="s5_userpositions" style="width:<?php echo $bottom4; ?>%">
								<jdoc:include type="modules" name="user8" style="round_box" />
							</div>
						<?php } ?>
						<div style="clear:both;"></div>
					</div>
				<!-- End Bottom Modules -->
			</div>			
		</div>
	</div>	
	</div>	
</div>
</div>
<?php } ?>



<?php if($this->countModules('bottom')) { ?>	
<div id="s5_footertop">
	<div class="s5_leftshadow">
	<div class="s5_rightshadow">
		<div class="s5_wrap">				
		<div id="s5_bottommenu">
			<jdoc:include type="modules" name="bottom" style="xhtml" />
		</div>				
		</div>
	</div>	
	</div>	
</div>
<?php } ?>	

<div id="s5_footerbottom">
	<div class="s5_wrap">	
		<div id="s5_copyright">
		<?php include("templates/phosphorus/footer.php"); ?>
		</div>
	</div>
</div>

</div>	
</div>
<?php if (($s5_menu  == "1") || ($s5_menu  == "2") || ($s5_menu  == "3") || ($s5_menu  == "4")) { ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/s5_suckerfish.js"></script>
<?php } ?>
<?php if ($s5_tooltips  == "yes") { ?>
<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>templates/phosphorus/js/tooltips.js"></script>
<?php } ?>
<?php if($this->countModules('debug')) { ?>
<div style="clear:both;"></div>
<div style="width:100%;">
	<jdoc:include type="modules" name="debug" style="xhtml" />
</div>
<?php } ?> 
<?php if (($s5_menu  == "1") || ($s5_menu  == "2") || ($s5_menu  == "3") || ($s5_menu  == "4")) { ?>
<?php if ($s5_subtext == "yes") { ?>
	<script type="text/javascript" src="<?php echo $LiveSiteUrl;?>/templates/phosphorus/js/s5_textmenu.js"></script>																		
<?php } ?>
<?php } ?>
<?php if ($s5_multibox  == "yes") { ?>
<script type="text/javascript">
	var s5mbox = {};
	window.addEvent('domready', function(){	s5mbox = new MultiBox('s5mb', {descClassName: 's5_multibox', <?php if ($s5_multioverlay  == "1") { ?>useOverlay: true<?php } else {?>useOverlay: false<?php } ?>, <?php if ($s5_multicontrols  == "1") { ?>showControls: true<?php } else {?>showControls: false<?php } ?>});	});
</script>
<?php } ?>
</body>
</html>


