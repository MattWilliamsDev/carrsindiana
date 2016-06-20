<bfSQL>
	<task>
		<applytoversion>0.1</applytoversion>
		<provides>0.2</provides>
		<tablename>form_fields</tablename>
		<tasktitle>Add cssfile</tasktitle>
		<sql><![CDATA[SHOW TABLES;]]></sql>
	</task>
	<task>
		<applytoversion>0.2</applytoversion>
		<provides>0.3</provides>
		<tablename>form_fields</tablename>
		<tasktitle>Add cssfile</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_fields` ADD `cssfile` VARCHAR( 255 ) NOT NULL AFTER `style` ;]]></sql>
	</task>
	<task>
		<applytoversion>0.3</applytoversion>
		<provides>0.4</provides>
		<tablename>form_fields</tablename>
		<tasktitle>Add cssfile</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_fields` ADD `option1` VARCHAR( 255 ) NOT NULL;]]></sql>
	</task>
	<task>
		<applytoversion>0.4</applytoversion>
		<provides>0.5</provides>
		<tablename>form_fields</tablename>
		<tasktitle>Add cssfile</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_fields` ADD `option2` VARCHAR( 255 ) NOT NULL;]]></sql>
	</task>
	<task>
		<applytoversion>0.5</applytoversion>
		<provides>0.6</provides>
		<tablename>form_fields</tablename>
		<tasktitle>Add cssfile</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_fields` ADD `multiple` VARCHAR( 255 ) NOT NULL;]]></sql>
	</task>
	<task>
		<applytoversion>0.1</applytoversion>
		<provides>0.2</provides>
		<tablename>form_layouts</tablename>
		<tasktitle>Add please wait loading screen</tasktitle>
		<sql><![CDATA[INSERT INTO `#__form_layouts` VALUES(3, 0, 'Please Wait Layout', '', 'Global', 'This is displayed when the form submit button is pressed', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0);]]></sql>
	</task>
	<task>
		<applytoversion>0.6</applytoversion>
		<provides>0.7</provides>
		<tablename>form_fields</tablename>
		<tasktitle>Add verify_iban</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_fields` ADD `verify_iban` INT( 11 ) NOT NULL;]]></sql>
	</task>	
	<task>
		<applytoversion>0.7</applytoversion>
		<provides>0.8</provides>
		<tablename>form_fields</tablename>
		<tasktitle>Add verify_isalloweddomain</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_fields` ADD `verify_isalloweddomain`  mediumtext NOT NULL;]]></sql>
	</task>	
	<task>
		<applytoversion>0.8</applytoversion>
		<provides>0.9</provides>
		<tablename>form_fields</tablename>
		<tasktitle>Add verify_isdenieddomain</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_fields` ADD `verify_isdenieddomain` mediumtext NOT NULL;]]></sql>
	</task>	
	<task>
		<applytoversion>0.1</applytoversion>
		<provides>0.2</provides>
		<tablename>form_forms</tablename>
		<tasktitle>Add target</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_forms` ADD `target` VARCHAR( 255 ) NOT NULL AFTER `classid` ;]]></sql>
	</task>	
	<task>
		<applytoversion>0.2</applytoversion>
		<provides>0.3</provides>
		<tablename>form_forms</tablename>
		<tasktitle>Add target</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_forms` ADD `allowpause` INT( 11 ) NOT NULL ;]]></sql>
	</task>	
	<task>
		<applytoversion>0.3</applytoversion>
		<provides>0.4</provides>
		<tablename>form_forms</tablename>
		<tasktitle>Add target</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_forms` ADD `allowownsubmissionedit` INT( 11 ) NOT NULL ;]]></sql>
	</task>	
	<task>
		<applytoversion>0.4</applytoversion>
		<provides>0.5</provides>
		<tablename>form_forms</tablename>
		<tasktitle>Add target</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_forms` ADD `allowownsubmissiondelete` INT( 11 ) NOT NULL ;]]></sql>
	</task>	
	<task>
		<applytoversion>0.5</applytoversion>
		<provides>0.6</provides>
		<tablename>form_forms</tablename>
		<tasktitle>Add allowownsubmissiondelete</tasktitle>
		<sql><![CDATA[UPDATE `#__form_forms` SET `allowownsubmissiondelete` = '0'; ]]></sql>
	</task>	
	<task>
		<applytoversion>0.6</applytoversion>
		<provides>0.7</provides>
		<tablename>form_forms</tablename>
		<tasktitle>Add allowownsubmissionedit</tasktitle>
		<sql><![CDATA[UPDATE `#__form_forms` SET `allowownsubmissionedit` = '1'; ]]></sql>
	</task>	
	<task>
		<applytoversion>0.7</applytoversion>
		<provides>0.8</provides>
		<tablename>form_forms</tablename>
		<tasktitle>Add allowpause</tasktitle>
		<sql><![CDATA[UPDATE `#__form_forms` SET `allowpause` = '1'; ]]></sql>
	</task>	
	<task>
		<applytoversion>0.8</applytoversion>
		<provides>0.9</provides>
		<tablename>form_forms</tablename>
		<tasktitle>update target</tasktitle>
		<sql><![CDATA[UPDATE `#__form_forms` SET `target` = '_self'; ]]></sql>
	</task>	
	<task>
		<applytoversion>0.9</applytoversion>
		<provides>1.0</provides>
		<tablename>form_forms</tablename>
		<tasktitle>update ixedit</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_forms` ADD `enableixedit` INT( 11 ) NOT NULL ;]]></sql>
	</task>
	<task>
		<applytoversion>1.0</applytoversion>
		<provides>1.1</provides>
		<tablename>form_forms</tablename>
		<tasktitle>update enablejankomultipage</tasktitle>
		<sql><![CDATA[ALTER TABLE `#__form_forms` ADD `enablejankomultipage` INT( 11 ) NOT NULL ;]]></sql>
	</task>
	<task>
		<applytoversion>0.9</applytoversion>
		<provides>1.0</provides>
		<tablename>form_fields</tablename>
		<tasktitle>update ucwords</tasktitle>
		<sql><![CDATA[ALTER TABLE `jos_form_fields` ADD `filter_ucwords` int(11) NULL AFTER `filter_a2z`;]]></sql>
	</task>
</bfSQL>