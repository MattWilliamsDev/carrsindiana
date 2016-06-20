<?php
/**
 * @version $Id: selectcurrency.php 184 2010-01-03 20:44:13Z  $
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
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/* Needed on Apply */
if (! class_exists ( 'plugins_fields_base' )) {
	require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'helper.php';
	require_once bfCompat::getAbsolutePath () . DS . 'components' . DS . 'com_form' . DS . 'plugins' . DS . 'fields' . DS . '_baseClass.php';
}

/**
 * Class for form fields
 *
 */
final class plugins_fields_selectcurrency extends plugins_fields_base {

	/**
	 * The plugin name
	 *
	 * @var unknown_type
	 */
	public $_pname = 'selectcurrency';

	/**
	 * The plugin title
	 *
	 * @var string The Plugin Title
	 */
	public $_title = 'Drop Down List: Prepopulated with all known world currencies';

	/**
	 * The defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_attributes = array ('type' => 'select', 'id' => '', 'params' => '', 'name' => '', 'size' => '1', 'class' => 'inputbox', 'value' => '', 'style' => '', 'onblur' => '' );

	/**
	 * whether to show blank attributes in html
	 *
	 * @var bool
	 */
	private $_showBlankAttributes = false;

	/**
	 * The base html
	 *
	 * @var string
	 */
	private $_barehtml = '<select %s>%s</select>';

	/**
	 * The creation defaults for this plugin
	 *
	 * @var array The defaults
	 */
	public $_creation_defaults = array ('plugin' => 'selectcurrency', 'published' => '1', 'access' => '0', 'allowbyemail' => '1', 'size' => '1', 'class' => 'inputbox', 'form_id' => '-1', 'type' => 'select', 'verify_isinarray' => '' );

	/**
	 * The plugin description
	 *
	 * @var desk The plugin description
	 */
	public $_desc = 'A Drop Down With all known world currencies as Options';

	/**
	 * The sql required to extend the submitted data
	 * table to accomodate submitted data from this field
	 *
	 * @var unknown_type
	 */
	public $_extendSQL = 'ALTER TABLE `%s` ADD `%s` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;';

	/**
	 * The nuke sql to remove this element from the schema of the data table
	 *
	 * @var unknown_type
	 */
	public $_nukeSQL = 'ALTER TABLE `%s` DROP `%s`;';

	public function __construct() {
		$states = array ("|" . bfText::_ ( 'Please select' ), "AFN|Afghanistan, Afghani (AFN)", "ALL|Albania, Lek (ALL)", "DZD|Algeria, Dinar (DZD)", "USD|America (United States), Dollar (USD)", "USD|American Samoa, United States Dollar (USD)", "EUR|Andorra, Euro (EUR)", "AOA|Angola, Kwanza (AOA)", "XCD|Anguilla, East Caribbean Dollar (XCD)", "XCD|Antigua and Barbuda, East Caribbean Dollar (XCD)", "ARS|Argentina, Peso (ARS)", "AMD|Armenia, Dram (AMD)", "AWG|Aruba, Guilder (AWG)", "AUD|Ashmore and Cartier Islands, Australia Dollar (AUD)", "AUD|Australia, Dollar (AUD)", "EUR|Austria, Euro (EUR)", "AZN|Azerbaijan, New Manat (AZN)", "EUR|Azores, Euro (EUR)", "BSD|Bahamas, Dollar (BSD)", "BHD|Bahrain, Dinar (BHD)", "BBD|Bajan (Barbados), Dollar (BBD)", "EUR|Balearic Islands, Euro (EUR)", "BDT|Bangladesh, Taka (BDT)", "BBD|Barbados, Dollar (BBD)", "BYR|Belarus, Ruble (BYR)", "EUR|Belgium, Euro (EUR)", "BZD|Belize, Dollar (BZD)", "XOF|Benin, CFA Franc BCEAO (XOF)", "BMD|Bermuda, Dollar (BMD)", "INR|Bhutan, India Rupee (INR)", "BTN|Bhutan, Ngultrum (BTN)", "BOB|Bolivia, Boliviano (BOB)", "ANG|Bonaire, Netherlands Antilles Guilder (ANG)", "BAM|Bosnia and Herzegovina, Convertible Marka (BAM)", "BWP|Botswana, Pula (BWP)", "BRL|Brazil, Real (BRL)", "GBP|Britain (United Kingdom), Pound (GBP)", "GBP|British Indian Ocean Territory, United Kingdom Pound (GBP)", "USD|British Indian Ocean Territory, United States Dollar (USD)", "USD|British Virgin Islands, United States Dollar (USD)", "BND|Brunei, Dollar (BND)", "SGD|Brunei, Singapore Dollar (SGD)", "BGN|Bulgaria, Lev (BGN)", "XOF|Burkina Faso, CFA Franc BCEAO (XOF)", "MMK|Burma (Myanmar), Kyat (MMK)", "BIF|Burundi, Franc (BIF)", "KHR|Cambodia, Riel (KHR)", "XAF|Cameroon, CFA Franc BEAC (XAF)", "CAD|Canada, Dollar (CAD)", "EUR|Canary Islands, Euro (EUR)", "CVE|Cape Verde, Escudo (CVE)", "KYD|Cayman Islands, Dollar (KYD)", "XAF|Central African Republic, CFA Franc BEAC (XAF)", "XAF|CFA Communauté Financière Africaine BEAC Franc (XAF)", "XOF|CFA Communauté Financière Africaine BCEAO Franc (XOF)", "XAF|Chad, CFA Franc BEAC (XAF)", "CLP|Chile, Peso (CLP)", "CNY|China, Yuan Renminbi (CNY)", "AUD|Christmas Island, Australia Dollar (AUD)", "AUD|Cocos (Keeling Islands, Australia Dollar (AUD)", "COP|Colombia, Peso (COP)", "XAF|Communauté Financière Africaine BEAC Franc (XAF)", "XOF|Communauté Financière Africaine BCEAO Franc (XOF)", "KMF|Comoros, Franc (KMF)", "XPF|Comptoirs Français du Pacifique Franc (XPF)", "XAF|Congo/Brazzaville, CFA Franc BEAC (XAF)", "CDF|Congo/Kinshasa, Franc (CDF)", "NZD|Cook Islands, New Zealand Dollar (NZD)", "AUD|Coral Sea Islands, Australia Dollar (AUD)", "CRC|Costa Rica, Colon (CRC)", "XOF|Côte d\'Ivoire, CFA Franc BCEAO (XOF)", "HRK|Croatia, Kuna (HRK)", "CUC|Cuba, Convertible Peso (CUC)", "CUP|Cuba, Peso (CUP)", "ANG|Curaço, Netherlands Antilles Guilder (ANG)", "CYP|Cyprus, Pound (CYP)", "CZK|Czech Republic, Koruna (CZK)", "DKK|Denmark, Krone (DKK)", "DJF|Djibouti, Franc (DJF)", "XCD|Dominica, East Caribbean Dollar (XCD)", "DOP|Dominican Republic, Peso (DOP)", "EUR|Dutch (Netherlands), Euro (EUR)", "XCD|East Caribbean Dollar (XCD)", "USD|East Timor, United States Dollar (USD)", "USD|Ecuador, United States Dollar (USD)", "EGP|Egypt, Pound (EGP)", "SVC|El Salvador, Colon (SVC)", "USD|El Salvador, United States Dollar (USD)", "GBP|England (United Kingdom), Pound (GBP)", "XAF|Equatorial Guinea, CFA Franc BEAC (XAF)", "ERN|Eritrea, Nakfa (ERN)", "EEK|Estonia, Kroon (EEK)", "ETB|Ethiopia, Birr (ETB)", "EUR|Euro (EUR)", "EUR|Europa Island, Euro (EUR)", "FKP|Falkland Islands, Pound (FKP)", "DKK|Faroe Islands, Denmark Krone (DKK)", "FJD|Fiji, Dollar (FJD)", "EUR|Finland, Euro (EUR)", "EUR|France, Euro (EUR)", "EUR|French Guiana, Euro (EUR)", "XPF|French Polynesia, Comptoirs Français du Pacifique Franc (XPF)", "EUR|French Polynesia, Euro (EUR)", "EUR|French Southern and Antarctic Lands, Euro (EUR)", "XAF|Gabon, CFA Franc BEAC (XAF)", "GMD|Gambia, Dalasi (GMD)", "ILS|Gaza Strip, Israel New Shekel (ILS)", "GEL|Georgia, Lari (GEL)", "EUR|Germany, Euro (EUR)", "GHC|Ghana, Cedi [expires Dec. 31, 2007] (GHC)", "GHS|Ghana, Cedi (GHS)", "GIP|Gibraltar, Pound (GIP)", "XAU|Gold Ounce (XAU)", "GBP|Great Britain (United Kingdom), Pound (GBP)", "EUR|Greece, Euro (EUR)", "DKK|Greenland, Denmark Krone (DKK)", "XCD|Grenada, East Caribbean Dollar (XCD)", "EUR|Guadeloupe, Euro (EUR)", "USD|Guam, United States Dollar (USD)", "GTQ|Guatemala, Quetzal (GTQ)", "GGP|Guernsey, Pound (GGP)", "GNF|Guinea, Franc (GNF)", "XOF|Guinea-Bissau, CFA Franc BCEAO (XOF)", "GYD|Guyana, Dollar (GYD)", "HTG|Haiti, Gourde (HTG)", "EUR|Holland (Netherlands), Euro (EUR)", "EUR|Holy See (Vatican City), Euro (EUR)", "HNL|Honduras, Lempira (HNL)", "HKD|Hong Kong, Dollar (HKD)", "HUF|Hungary, Forint (HUF)", "ISK|Iceland, Krona (ISK)", "INR|India, Rupee (INR)", "IDR|Indonesia, Rupiah (IDR)", "XDR|International Monetary Fund Special Drawing Right (XDR)", "IRR|Iran, Rial (IRR)", "IQD|Iraq, Dinar (IQD)", "EUR|Ireland, Euro (EUR)", "FKP|Islas Malvinas (Falkland Islands), Pound (FKP)", "IMP|Isle of Man, Pound (IMP)", "ILS|Israel, New Shekel (ILS)", "EUR|Italy, Euro (EUR)", "XOF|Ivory Coast (Côte d\'Ivoire), CFA Franc BCEAO (XOF)", "JMD|Jamaica, Dollar (JMD)", "JPY|Japan, Yen (JPY)", "JEP|Jersey, Pound (JEP)", "USD|Johnson, United States Dollar (USD)", "JOD|Jordan, Dinar (JOD)", "EUR|Juan de Nova, Euro (EUR)", "KZT|Kazakhstan, Tenge (KZT)", "KES|Kenya, Shilling (KES)", "AUD|Kiribati, Australia Dollar (AUD)", "KWD|Kuwait, Dinar (KWD)", "KGS|Kyrgyzstan, Som (KGS)", "LAK|Laos, Kip (LAK)", "LVL|Latvia, Lat (LVL)", "LBP|Lebanon, Pound (LBP)", "LSL|Lesotho, Loti (LSL)", "LRD|Liberia, Dollar (LRD)", "LYD|Libya, Dinar (LYD)", "CHF|Liechtenstein, Switzerland Franc (CHF)", "LTL|Lithuania, Litas (LTL)", "EUR|Luxembourg, Euro (EUR)", "MOP|Macau, Pataca (MOP)", "MKD|Macedonia, Denar (MKD)", "MGA|Madagascar, Ariary (MGA)", "EUR|Madeira Islands, Euro (EUR)", "MWK|Malawi, Kwacha (MWK)", "MYR|Malaysia, Ringgit (MYR)", "MVR|Maldives, Rufiyaa (MVR)", "XOF|Mali, CFA Franc BCEAO (XOF)", "MTL|Malta, Lira (MTL)", "FKP|Malvinas (Falkland Islands), Pound (FKP)", "USD|Marshall Islands, United States Dollar (USD)", "EUR|Martinique, Euro (EUR)", "MRO|Mauritania, Ouguiya (MRO)", "MUR|Mauritius, Rupee (MUR)", "EUR|Mayotte, Euro (EUR)", "MXN|Mexico, Peso (MXN)", "USD|Micronesia, United States Dollar (USD)", "USD|Midway Islands, United States Dollar (USD)", "MDL|Moldova, Leu (MDL)", "EUR|Monaco, Euro (EUR)", "MNT|Mongolia, Tughrik (MNT)", "EUR|Montenegro, Euro (EUR)", "XCD|Montserrat, East Caribbean Dollar (XCD)", "MAD|Morocco, Dirham (MAD)", "MZN|Mozambique, Metical (MZN)", "MMK|Myanmar (Burma), Kyat (MMK)", "NAD|Namibia, Dollar (NAD)", "AUD|Nauru, Australia Dollar (AUD)", "HTG|Navassa, Haiti Gourde (HTG)", "USD|Navassa, United States Dollar (USD)", "NPR|Nepal, Rupee (NPR)", "ANG|Netherlands Antilles, Guilder (ANG)", "EUR|Netherlands, Euro (EUR)", "XPF|New Caledonia, Comptoirs Français du Pacifique Franc (XPF)", "NZD|New Zealand, Dollar (NZD)", "NIO|Nicaragua, Cordoba (NIO)", "XOF|Niger, CFA Franc BCEAO (XOF)", "NGN|Nigeria, Naira (NGN)", "NZD|Niue, New Zealand Dollar (NZD)", "AUD|Norfolk Island, Australia Dollar (AUD)", "KPW|North Korea, Won (KPW)", "USD|Northern Mariana Islands, United States Dollar (USD)", "NOK|Norway, Krone (NOK)", "OMR|Oman, Rial (OMR)", "PKR|Pakistan, Rupee (PKR)", "USD|Palau, United States Dollar (USD)", "XPD|Palladium Ounce (XPD)", "PAB|Panama, Balboa (PAB)", "USD|Panama, United States Dollar (USD)", "PGK|Papua New Guinea, Kina (PGK)", "CNY|Paracel Islands, China Yuan Renminbi (CNY)", "VND|Paracel Islands, Vietnam Dong (VND)", "PYG|Paraguay, Guarani (PYG)", "PEN|Peru, Nuevo Sol (PEN)", "PHP|Philippines, Peso (PHP)", "NZD|Pitcairn, New Zealand Dollar (NZD)", "XPT|Platinum Ounce (XPT)", "PLN|Poland, Zloty (PLN)", "EUR|Portugal, Euro (EUR)", "USD|Puerto Rico, United States Dollar (USD)", "QAR|Qatar, Riyal (QAR)", "EUR|Réunion, Euro (EUR)", "RON|Romania, New Leu (RON)", "RUB|Russia, Ruble (RUB)", "RWF|Rwanda, Franc (RWF)", "ANG|Saba, Netherlands Antilles Guilder (ANG)", "SHP|Saint Helena, Pound (SHP)", "XCD|Saint Kitts and Nevis, East Caribbean Dollar (XCD)", "XCD|Saint Lucia, East Caribbean Dollar (XCD)", "EUR|Saint Pierre and Miquelon, Euro (EUR)", "XCD|Saint Vincent and The Grenadines, East Caribbean Dollar (XCD)", "EUR|Saint-Martin, Euro (EUR)", "WST|Samoa, Tala (WST)", "EUR|San Marino, Euro (EUR)", "STD|São Tome and Principe, Dobra (STD)", "SAR|Saudi Arabia, Riyal (SAR)", "GBP|Scotland (United Kingdom), Pound (GBP)", "SPL|Seborga, Luigino (SPL)", "XOF|Senegal, CFA Franc BCEAO (XOF)", "RSD|Serbia, Dinar (RSD)", "SCR|Seychelles, Rupee (SCR)", "SLL|Sierra Leone, Leone (SLL)", "XAG|Silver Ounce (XAG)", "SGD|Singapore, Dollar (SGD)", "ANG|Sint Eustatius, Netherlands Antilles Guilder (ANG)", "ANG|Sint Maarten, Netherlands Antilles Guilder (ANG)", "SKK|Slovakia, Koruna (SKK)", "EUR|Slovenia, Euro (EUR)", "SBD|Solomon Islands, Dollar (SBD)", "SOS|Somalia, Shilling (SOS)", "ZAR|South Africa, Rand (ZAR)", "GBP|South Georgia, United Kingdom Pound (GBP)", "KRW|South Korea, Won (KRW)", "GBP|South Sandwich Islands, United Kingdom Pound (GBP)", "EUR|Spain, Euro (EUR)", "LKR|Sri Lanka, Rupee (LKR)", "SDG|Sudan, Pound (SDG)", "SRD|Suriname, Dollar (SRD)", "NOK|Svalbard and Jan Mayen, Norway Krone (NOK)", "SZL|Swaziland, Lilangeni (SZL)", "ZAR|Swaziland, South Africa Rand (ZAR)", "SEK|Sweden, Krona (SEK)", "CHF|Switzerland, Franc (CHF)", "SYP|Syria, Pound (SYP)", "TWD|Taiwan, New Dollar (TWD)", "TJS|Tajikistan, Somoni (TJS)", "RUB|Tajikistan, Russia Ruble (RUB)", "TZS|Tanzania, Shilling (TZS)", "THB|Thailand, Baht (THB)", "XOF|Togo, CFA Franc BCEAO (XOF)", "NZD|Tokelau, New Zealand Dollar (NZD)", "TOP|Tonga, Pa\'anga (TOP)", "MDL|Transnistria, Moldova Leu (MDL)", "TTD|Trinidad and Tobago, Dollar (TTD)", "TND|Tunisia, Dinar (TND)", "TRY|Turkey, New Lira (TRY)", "TMM|Turkmenistan, Manat (TMM)", "USD|Turks and Caicos Islands, United States Dollar (USD)", "AUD|Tuvalu, Australia Dollar (AUD)", "TVD|Tuvalu, Dollar (TVD)", "UGX|Uganda, Shilling (UGX)", "UAH|Ukraine, Hryvna (UAH)", "AED|United Arab Emirates, Dirham (AED)", "GBP|United Kingdom, Pound (GBP)", "USD|United States, Dollar (USD)", "UYU|Uruguay, Peso (UYU)", "UZS|Uzbekistan, Som (UZS)", "VUV|Vanuatu, Vatu (VUV)", "EUR|Vatican City, Euro (EUR)", "VEB|Venezuela, Bolivar (VEB)", "VEF|Venezuela, Bolivar Fuerte (VEF)", "VND|Vietnam, Dong (VND)", "USD|Virgin Islands, United States Dollar (USD)", "USD|Wake Island, United States Dollar (USD)", "XPF|Wallis and Futuna Islands, Comptoirs Français du Pacifique Franc (XPF)", "ILS|West Bank, Israel New Shekel (ILS)", "JOD|West Bank, Jordan Dinar (JOD)", "MAD|Western Sahara, Morocco Dirham (MAD)", "WST|Western Samoa (Samoa), Tala (WST)", "YER|Yemen, Rial (YER)", "ZMK|Zambia, Kwacha (ZMK)", "ZWD|Zimbabwe, Dollar (ZWD)" );

		$this->_creation_defaults ['params'] = implode ( "\n", $states );

	}

	/**
	 * I set up the view template for the admin edit screen
	 *
	 */
	public function _editFieldView() {

		/* Call in Smarty to display template */
		bfLoad ( 'bfSmarty' );

		$tmp = bfSmarty::getInstance ( 'com_form' );
		$tmp->caching = false;
		$tmp->assignFromArray ( $this->_config );

		$disabled = bfHTML::yesnoRadioList ( 'disabled', '', $this->_config ['disabled'] );
		$tmp->assign ( 'DISABLED', $disabled );
		$tmp->assign ( 'CONFIG', $this->_config );

		/* Yes No Answers */
		$qs = array ('filter_strtoupper', 'filter_strtolower', 'verify_isvalidvatnumber', 'verify_isexistingusername', 'verify_isnotexistingusername', 'verify_isinteger', 'verify_isvalidurl', 'verify_isvalidcreditcardnumber', 'verify_isvalidukpostcode', 'published', 'allowsetbyget', 'allowbyemail', 'filter_a2z', 'filter_StripTags', 'filter_StringTrim', 'filter_Alnum', 'filter_Digits', 'required', 'verify_isemailaddress', 'verify_isblank', 'verify_isnotblank', 'verify_isipaddress', 'verify_isvalidukninumber', 'verify_isvalidssn', 'verify_isvaliduszip' );
		foreach ( $qs as $q ) {
			$tmp->assign ( strtoupper ( $q ), bfHTML::yesnoRadioList ( $q, '', $this->_config [$q] ) );
		}

		$OPTIONS = array (bfHTML::makeOption ( '0', 'Public' ), bfHTML::makeOption ( '1', 'Registered' ), bfHTML::makeOption ( '2', 'Special' ) );

		$access = bfHTML::selectList2 ( $OPTIONS, 'access', '', 'value', 'text', $this->_config ['access'] );
		$tmp->assign ( 'ACCESS', $access );

		$tmp->display ( dirname ( __FILE__ ) . DS . 'editView.tpl' );
	}

	/**
	 * I return a form element
	 *
	 * @return string
	 */
	public function toString() {
		$html = '';
		if ($this->_config ['published'] == '0') {
			return;
		}

		$options = array ();

		$params = explode ( "\n", $this->_attributes ['params'] );

		/* allowsetbyget overide */
		$val = bfRequest::getVar ( $this->_config ['slug'], null, 'GET' );
		if ($val && $this->_config ['allowsetbyget'] == '1') {
			$this->_attributes ['value'] = $this->runFilters ( $val );
		}

		/* if coming from validation rules then prepopulate again */
		if ($this->_attributes ['value'])
			$this->_config ['value'] = $this->_attributes ['value'];

		foreach ( $params as $v ) {
			$selected = '';
			if (preg_match ( '/\|/', $v )) {
				$parts = explode ( '|', $v );
				if (isset ( $this->_config ['value'] ))
					($parts [0] == $this->_config ['value']) ? $selected = ' selected="selected"' : $selected = '';
				$options [] = '<option' . $selected . ' value="' . addslashes ( bfString::trim ( ($parts [0] ? $parts [0] : $parts [1]) ) ) . '">' . addslashes ( bfString::trim ( $parts [1] ) ) . '</option>';
			} else {
				if (isset ( $this->_config ['value'] ))
					($v == $this->_config ['value']) ? $selected = ' selected="selected"' : $selected = '';
				$options [] = '<option' . $selected . ' value="' . addslashes ( bfString::trim ( $v ) ) . '">' . addslashes ( bfString::trim ( $v ) ) . '</option>';
			}
		}

		/* override */
		$this->_attributes ['id'] = $this->_config ['slug'];
		$this->_attributes ['name'] = $this->_config ['slug'];

		/* unset unrequired attributes */
		unset ( $this->_attributes ['params'] );
		unset ( $this->_attributes ['value'] );
		unset ( $this->_attributes ['type'] );

		$attributesHTML = array ();

		foreach ( $this->_attributes as $k => $v ) {
			if ($v == "" && $this->_showBlankAttributes === true) {
				$attributesHTML [$k] = strtolower ( $k ) . '="' . $v . '"';
			} else if ($v != "") {
				$attributesHTML [$k] = strtolower ( $k ) . '="' . $v . '"';
			}
		}

		ksort ( $attributesHTML );

		$attributesSpacedHTML = implode ( ' ', $attributesHTML );

		$html .= sprintf ( $this->_barehtml, $attributesSpacedHTML, implode ( "\n", $options ) );

		if ($this->_config ['required'] == '1') {
//			$html .= '<span class="required">*</span>';
		}

		return $html;
	}

	public function postProcess() {
		$this->setSubmittedValue ( $this->getSubmittedValue () );
	}
}
?>