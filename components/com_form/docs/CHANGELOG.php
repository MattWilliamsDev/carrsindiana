<?php
/**
 * @version $Id: CHANGELOG.php 205 2010-01-24 23:12:52Z  $
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
?>

Changelog
------------
This is a non-exhaustive (but still near complete) changelog for
bfForms, including alpha, beta and release candidate versions.
Our thanks to all those people who've contributed bug reports and
code fixes.

Legend
---------
* -> Security Fix
# -> Bug Fix
+ -> Addition
^ -> Change
- -> Removed
! -> Note

--------------- Blue Flame Forms (bfForms) v0.2.204/bfFramework 3.4.6 Released-- [24-Jan-2010 22:30 UTC] ---------------------
# Various small tweaks to make preg_match and PHP 5.3 compatibility - thanks for the reports guys!

+ New UcWords filter on textbox and textarea

--------------- Blue Flame Forms (bfForms) v0.2.193/bfFramework 3.4.3 Released-- [Jan 2010 22:30 UTC] ---------------------
+ NEW FEATURE !! - Mailchimp.com MailingList API Action Plugin
+ NEW FEATURE !! - PHP 5.3. Compatibility
+ NEW FEATURE !! - ixedit integration for more advanced javascript features see: http://blog.phil-taylor.com/2009/11/22/how-to-make-form-fields-hide-and-show-with-no-coding/  

# WysiWYG Editors now fixed
+ You can now use ::USERNAME:: in the file upload filename as a placeholder
^ Changes made to Mollom integration
^ Upgraded PEAR Libs
# fix maximum submission limits again

--------------- Blue Flame Forms (bfForms) v0.2.176/bfFramework 3.4.1 Released-- [21-Nov-2009 22:30 UTC] ---------------------
# Loads of small bug fixes, including pauseable forms and sef compatibility - a minor release really :-) 

--------------- Blue Flame Forms (bfForms) v0.2.169/bfFramework 3.4.0 Released-- [02-Aug-2009 22:30 UTC] ---------------------
+ NEW FEATURE !! - Pausable forms!
+ NEW FEATURE !! - My Forms view

+ Allow JOOMLA_USERNAME, JOOMLA_NAME, JOOMLA_EMAIL placeholders
# Fixed referer bugs
# Fixed Horizontal/Vertical checkboxes/radioboxes
- Remove required stars in favour of an upcoming new feature for showing required fields
- IE8 IN-Compatibility with autogrowing text areas - so removed for now.

--------------- Blue Flame Forms (bfForms) v0.2.xxx Released-- [xx-April-2009 20:30 UTC] ---------------------

+ NEW FEATURE !! - Hidden element that contains the article title that a form is embedded into using the plugin.
+ NEW FEATURE !! - Action Plugin to pass leads to the Sales Force Web2Lead API.
+ NEW FEATURE !! - Ability to set the forms target

# Fix to assigned Joomla templates no showing after form submit - workaround underlying Joomla 1.5.x issue.
# Line breaks are now converted to <br /> in HTML emails
# Fix refering url field plugin
# Fix ListMessenger Action Plugin when running in https 
# Hidden random number not hidden field but text - Thanks Martin.
# Typo caused custom JS not to load - Thanks Brett.
# Toggle for MX Lookup checking to be able to disable it
# calendar.js fix for IE7/8 - Thanks Brett!
# bfMollom updated with php_mollom 1.1.3

--------------- Blue Flame Forms (bfForms) v0.2.128 Released-- [08-April-2009 20:30 UTC] ---------------------
# Darn hostname bug :-) unknown_type

--------------- Blue Flame Forms (bfForms) v0.2.125 Released-- [08-April-2009 15:30 UTC] ---------------------

+ NEW FEATURE !! - Validate Bank IBAN Numbers :-)
+ NEW FEATURE !! - A nice "One Moment Please" screen on form submit  

^ jQuery noConflict reenabled on frontend
^ Parse email addresses for placeholders
^ Allow textarea default value to be a textarea with linebreaks
# Fix to module and plugin embedders when form is set to registered/special users only - Thanks Adam!
# Fix like above fix but for main links to forms - Thanks Adam!
+ New Export format specifically for MS Excel users, preserves the leading Zeros in fields like phon
+ Add new blanket option
+ Add new toggles to internal spam checks - Thanks Gary
^ Zend Framework 1.8.0 Alpha Components Added/Upgraded
# Fix for Mac/Safari users to be able to select the form actions
+ Show form name when editing the form - Thanks Lee!
+ isAllowedDomain and isDeniedDomain validation rules on textboxes - Thanks omar.ramos!

....and a load of other smaller fixes...


--------------- Blue Flame Forms (bfForms) v0.2.107 Released-- [31-March-2009 00:03 UTC] ---------------------

# Rush job to fix broken IE support: http://blog.phil-taylor.com/2009/04/01/internet-explorer-issues-with-yesterdays-release/

--------------- Blue Flame Forms (bfForms) v0.2.93 Released-- [23-March-2009 00:03 UTC] ---------------------

+ NEW FEATURE !! - JCE Editor Support - Use the popular JCE Editor in our extensions :-) 

# Fixed Cannot Load Editor issue
# Fixed IP black listing
# Fixed submitting form from embedded in content

--------------- Blue Flame Forms (bfForms) v0.2.87 Released-- [xx-March-2009 00:03 UTC] ---------------------


--------------- Blue Flame Forms (bfForms) v0.2.81 Released-- [23-March-2009 00:03 UTC] ---------------------

# :: bfHTML     :: Fix link to forms page form index2 to index
# :: bfCombine  :: add noConflict mode to frontend and reconfig for backend 
!	Alternate Select Multiple (asmSelect) 1.0.4 beta

--------------- Blue Flame Forms (bfForms) v0.2.77 Released-- [13-March-2009 00:03 UTC] ---------------------

# 	Fix linking to forms (Again) :-)

--------------- Blue Flame Forms (bfForms) v0.2.75 Released-- [12-March-2009 00:03 UTC] ---------------------

# 	Fix linking to forms

--------------- Blue Flame Forms (bfForms) v0.2.72 Released-- [26-February-2009 00:03 UTC] ---------------------

! 	Table changes !
! 	Name Change !
!	Not a complete list of changes !

+ NEW FEATURE !! - Manual resize of textareas
+ NEW FEATURE !! - Automatic resize of textareas
+ NEW FEATURE !! - Fancy Multiple Select Alternative
+ NEW FEATURE !! - Set the content of a select box by quering the database
+ NEW FEATURE !! - Redirect Browser with POST/GET of submitted data
+ NEW FEATURE !! - sh404SEF SEF Extension, now all urls to forms are SEF
+ NEW FEATURE !! - Joomla 1.5 Router SEF Extension, now all urls to forms are SEF
+ NEW FEATURE !! - Automatically Generate the content of the emails send - ONE CLICK!
+ NEW FEATURE !! - Ability to set the default checked checkboxes and radioboxes
+ NEW FEATURE !! - Ability to copy form elements and have them actually work :-)
+ NEW FEATURE !! - Ability to embed forms in content items with a plugin
+ NEW FEATURE !! - Ability to embed forms in module positions
+ NEW FEATURE !! - Integration with ListMessenger to subscribe/unsubscribe behind the scenes
+ NEW FEATURE !! - New Hidden Form Field to store the refering page URL/PageTitle
+ NEW FEATURE !! - New Hidden Form Field to store submitted date
+ NEW FEATURE !! - New Hidden Form Field to store visitors IP address
+ NEW FEATURE !! - New Hidden Form Field to store Random Number
+ NEW FEATURE !! - Paste in existing form HTML and parse it to auto generate new fields
+ UPDATE LIBS +  - xAJAX 0.5 Released
+ UPDATE LIBS +  - jQuery 1.3.2, Smarty 2.6.22 and Crypt_GPG 1.0.0 all upgated
+ UPDATE FEATURE - Greater Spam protection with transparent home grown methods
+ UPDATE FEATURE - Compatible with Google Gears for speedier admin console

# Compress Javascripts more for smaller downloads
# Admin side jQuery now loaded form Googles CDN
# Fixed Ordering of fields in CSV after copy fields
# Copy fields now creates correct database structures
# Strip slashes on email bodies
# Fix file upload when server is windows host
# Admin Console Edit form button fix
# IE Incompatibility with Page Title in form config page
# fix issue when more than one datepicker on a page (Thanks Hichem Agrebi)
# Fix GPG Encryption for Apple Mac Mail App
# File upload when there is more than one file upload element
# Edit button in submission view now works
# Replace : with . in time when files uploaded on windows hosts
^ Improved preview mode with dynamic field highlighting on validation errors
- Remove silly "loading" throbber from frontend
^ Email Action now prefils defaults for speedier and more accurate defaults
+ Apply button on edit form layout options page
# SSL Cross over - a bug in Joomla 1.5.x to be worked around - now working
# Changes to email address validation in bfVerify class
# Countries dropdown validations not working quite right
# Fix ordering of fields/actions and the up arrow issue - Thanks Leolam

--------------- Joomla Forms v0.1.2153 Released-- [12-July-2008 00:03 UTC] ---------------------

+ NEW FEATURE !! - Redirect Browser Submit Action
+ NEW FEATURE !! - Date Picker Form Element
# Export CSV was pulling IE Users warning - remove this
# Defaults for field widths not applying
# Drop downs not displaying ' and " correctly
# bfDBUtils.php mysql version check syntax error
# EMAILTO place holder replacement fix
+ PHP5 Version Check
# Fixed: Adding of mail action caused Swift include error

--------------- Technology Preview Released v0.1.2125-- [01-July-2008 23:00 UTC] ---------------------

01-Jul-2008
! Joomla Forms first ever public release! Yoo Hoo!
