<bfSQL>
	<form_layouts>
		<![CDATA[
			INSERT INTO `#__form_layouts` VALUES(1, 0, 'List of all forms', '', 'Global', 0x5468697320697320646973706c61796564207768656e2074686520636f6d706f6e656e742069732063616c6c65642066726f6d207468652066726f6e7420656e6420776974686f7574206120666f726d206964, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0);
		]]>
	</form_layouts>
	<form_layouts>
		<![CDATA[
			INSERT INTO `#__form_layouts` VALUES(2, 0, 'Form Submission Preview', '', 'Global', 0x54686973206973206120736d617274792074656d706c6174652074686174206973207573656420746f20646973706c617920796f757220666f726d207375626d697373696f6e2070726576696577207669657720696e20612074776f20636f6c756d6e207461626c65, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0);
		]]>
	</form_layouts>
	<form_layouts>
		<![CDATA[
			INSERT INTO `#__form_layouts` VALUES(3, 0, 'Please Wait Layout', '', 'Global', 'This is displayed when the form submit button is pressed', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0);
		]]>
	</form_layouts>
<!--
	<form_forms>
		<![CDATA[
			INSERT INTO `#__form_forms` (`id`, `form_name`, `published`, `access`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `accesssubmit`, `introtext`, `submitbuttontext`, `resetbuttontext`, `showresetbutton`, `showpreviewbutton`, `showsubmitbutton`, `nextbuttontext`, `prevbuttontext`, `processorurl`, `onlyssl`, `formtype`, `method`, `enctype`, `accept-charset`, `classid`, `disablebuttons`, `embedinmodules`, `embedinplugins`, `layout`, `template`, `hasusertable`, `page_title`, `showtitle`, `created`, `created_by`, `slug`, `useblacklist`, `maxsubmissionsperuser`, `maxsubmissions`, `count_spamsubmissions`, `count_oksubmissions`, `spam_akismet_key`, `spam_akismet_author`, `spam_akismet_email`, `spam_akismet_website`, `spam_akismet_body`, `spam_mollom_privatekey`, `spam_mollom_publickey`, `spam_ipblacklist`, `spam_wordblacklist`, `spam_hiddenfield`, `usecustomtemplate`, `custom_smarty`, `custom_js`, `custom_css`) VALUES
			(1, 0x5b4578616d706c6520466f726d20315d204120426173696320436f6e7461637420466f726d, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0x5375626d697420466f726d, 0x5265736574, 1, 1, 1, '', '', '', 0, 'normal', 'POST', 'multipart/form-data', 0x5554462d38, '', 0, 0, 0, 'default', 0x626c616e6b, '#__form_submitteddata_form1', '[Example Form 1] A Basic Contact Form', 1, '2008-06-24 22:47:59', 64, 'example_form_1_a_basic_contact_form', 1, 0, 0, 0, 1, '', '', '', '', '', '', '', '', '', '', 0, '', '', '');
		]]>
	</form_forms>
	<form_fields>
		<![CDATA[
			INSERT INTO `#__form_fields` (`id`, `form_id`, `plugin`, `type`, `title`, `publictitle`, `slug`, `desc`, `accept`, `checked`, `disabled`, `readonly`, `value`, `dir`, `lang`, `style`, `class`, `idattribute`, `accesskey`, `size`, `cols`, `rows`, `maxlength`, `layoutoption`, `params`, `onblur`, `ordering`, `allowbyemail`, `required`, `published`, `access`, `checked_out`, `checked_out_time`, `emsg`, `allowsetbyget`, `populatebysql`, `created`, `created_by`, `showonsubmissionindex`, `fileupload_destdir`, `fileupload_filenamemask`, `fileupload_setvalueto`, `filter_StringTrim`, `filter_StripTags`, `filter_Alnum`, `filter_Digits`, `filter_strtoupper`, `filter_strtolower`, `filter_a2z`, `verify_isemailaddress`, `verify_isblank`, `verify_isnotblank`, `verify_isipaddress`, `verify_isvalidukninumber`, `verify_isvalidssn`, `verify_isvaliduszip`, `verify_isvalidukpostcode`, `verify_isvalidcreditcardnumber`, `verify_isvalidurl`, `verify_isvalidvatnumber`, `verify_isinteger`, `verify_stringlengthgreaterthan`, `verify_stringlengthlessthan`, `verify_stringlengthequals`, `verify_numbergreaterthan`, `verify_numberlessthan`, `verify_regex`, `verify_numberequals`, `verify_equalto`, `verify_isinarray`, `verify_isexistingusername`, `verify_isnotexistingusername`, `verify_fileupload_extensions`, `verify_fileupload_maxsize`, `verify_fileupload_overwritemode`, `verify_brazil_cpf`, `verify_brazil_cnpj`) VALUES
			(1, 1, 'textbox', 'text', 0x596f757220456d61696c2041646472657373202846726f6d2074657874626f78204669656c642054656d706c61746529, 'Your Email Address', 'youremailaddress', 0x506c6561736520656e737572652074686973206164647265737320697320636f72726563742c207765206d696768742077616e7420746f20636f6e7461637420796f7521, '', 0, 0, 0, '', '', '', '', 0x696e707574626f78, '', '', '30', '', '', '255', 0, '', '', 3, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', '', 0, '', '2008-06-24 22:49:42', 64, 0, '', '', 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0),
			(2, 1, 'textbox', 'text', 0x596f75204e616d65202846726f6d2074657874626f78204669656c642054656d706c61746529, 'You Name', 'youname', '', '', 0, 0, 0, '', '', '', '', 0x696e707574626f78, '', '', '30', '', '', '255', 0, '', '', 2, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', '', 0, '', '2008-06-24 22:48:17', 64, 0, '', '', 0, 1, 1, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0),
			(3, 1, 'textarea', 'textarea', 0x596f7572204d657373616765202846726f6d207465787461726561204669656c642054656d706c61746529, 'Your Message', 'yourmessage', 0x506c6561736520626520636c65617220616e6420636f6e63697365, '', 0, 0, 0, '', '', '', '', 0x696e707574626f78, '', '', '50', '40', '10', '', 0, '', '', 5, 1, 0, 1, 0, 0, '0000-00-00 00:00:00', '', 0, '', '2008-06-24 22:50:30', 64, 0, '', '', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0);
		]]>	
	</form_fields>
	<form_actions>
		<![CDATA[
			INSERT INTO `#__form_actions` (`id`, `form_id`, `plugin`, `title`, `desc`, `published`, `access`, `dbtable`, `emailfrom`, `emailfromname`, `emailto`, `emailsubject`, `emailbcc`, `emailcc`, `emailplain`, `emailhtml`, `gpgpublickey`, `senduploadedfiles`, `attachments`, `custom4`, `custom5`, `custom6`, `custom7`, `custom8`, `custom9`, `custom10`, `ordering`, `checked_out`, `checked_out_time`, `created`, `created_by`) VALUES
			(20, 1, 'thankyou', 'Say Thank You', 0x3c703e5468616e6b7320666f7220796f7572206d6573736167652c2077652077696c6c20726573706f6e6420736f6f6e3c2f703e3c703e3c7374726f6e673e5b544849532049532041204558414d504c45202d204e4f20454d41494c5320574552452053454e54215d203c2f7374726f6e673e3c2f703e, 1, 0, '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0, 0, 0, 0, 0, 2, 0, '0000-00-00 00:00:00', '2008-06-24 22:52:09', 64),
			(18, 1, 'save', 'Save Submission to Database', '', 1, 0, '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0, 0, 0, 0, 0, 4, 0, '0000-00-00 00:00:00', '2008-06-24 22:51:55', 64);
		]]>	
	</form_actions>
	<form_forms>
		<![CDATA[
			CREATE TABLE IF NOT EXISTS `#__form_submitteddata_form1` (
			  `id` int(11) NOT NULL auto_increment,
			  `FIELD_1` varchar(255) collate utf8_bin NOT NULL,
			  `FIELD_2` varchar(255) collate utf8_bin NOT NULL,
			  `FIELD_3` mediumtext collate utf8_bin NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin; 
		]]>	
	</form_forms> -->
</bfSQL>