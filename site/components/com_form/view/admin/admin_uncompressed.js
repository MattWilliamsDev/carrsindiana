/* $Id: admin_uncompressed.js 171 2009-08-10 12:18:12Z  $ */

var bfBase64 = {

	_keyStr :"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

	encode : function(input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;

		while (i < input.length) {

			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);

			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;

			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}

			output = output + this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) + this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

		}

		return output;
	}
};

var bf_form_admin = {
	_toXAJAX : function(args) {
		return xajax.call(this.bfAdminHandler(), {
			parameters :args
		});
	},
	bfAdminHandler : function() {
		return 'bf_com_bfform_AdminHandler';
	},
	createNewForm : function() {
		var f_title = jQuery('input#form_title').val();
		var f_template = jQuery('input[name=template]:checked').val();
		var args = [ 'xadmin_createform', f_title, f_template ];
		return this._toXAJAX(args);
	},
	createNewField : function() {
		var f_title = jQuery('input#title').val();
		var f_template = jQuery('input[name=template]:checked').val();
		if (typeof f_template == 'undefined') {
			alert('You must choose a field to add!');
			return false;
		}
		if (f_title === '') {
			alert('Please give this field a unique short name!');
			return false;
		}
		var args = [ 'xadmin_createfield', f_title, f_template ];
		return this._toXAJAX(args);
	},
	createNewAction : function() {
		var f_title = jQuery('input#title').val();
		var f_template = jQuery('input[name=template]:checked').val();
		var args2 = [ 'xadmin_createaction', f_title, f_template ];
		return this._toXAJAX(args2);
	},
	validateFieldSlug : function() {
		var slug = jQuery('input#slug').val();
		var args = [ 'xadmin_validatefieldslug', slug ];
		return this._toXAJAX(args);
	},
	applyFilterSubmission : function() {
		var val = xajax.getFormValues('adminForm');
		jQuery('#bftoolbar').toggle();
		jQuery('#bf_optionsbox').toggle();
		jQuery('#bf_pagenav_table').toggle();
		jQuery('#indexTableHTML').toggle();
		var args = [ 'xadmin_setsubmissionfilter', val ];
		return this._toXAJAX(args);
	},
	sendTestEmail : function() {
		jQuery('#results').html('');
		jQuery('#gpgresults').html('');
		var email = jQuery('input#_testemail').val();
		var args = [ 'xadmin_sendtestemail', email ];
		return this._toXAJAX(args);
	},
	sendTestEmailGPG : function() {
		jQuery('#gpgresults').html('');
		jQuery('#results').html('');
		var email = jQuery('input#_testemailgpg').val();
		var gpg = jQuery('#gpgpublickey').val();
		var args = [ 'xadmin_sendtestemail', email, gpg ];
		return this._toXAJAX(args);
	},
	checkFileUploadWritable : function() {
		var folder = jQuery('#fileupload_destdir').val();
		var args = [ 'xadmin_checkfileuploadfolder', folder ];
		return this._toXAJAX(args);
	},
	generateEmailContents : function() {
		var args = [ 'xadmin_generateEmailContents' ];
		return this._toXAJAX(args);
	},
	createCustomForm : function() {
		var args = [ 'xadmin_generateBasicFormLayout' ];
		return this._toXAJAX(args);
	},
	parseCustomForm : function() {
		var customHTML = jQuery('#custom_smarty').val();
		h = bfBase64.encode(customHTML);
		var args3 = [ 'xadmin_parseCustomForm', h ];
		return this._toXAJAX(args3);
	},
	parseSalesForcew2lfields: function(){
		var customSFHTML = jQuery('#custom5').val();
		h = bfBase64.encode(customSFHTML);
		var args3 = [ 'xadmin_parseCustomSalesForceForm', h ];
		this._toXAJAX(args3);
		return false;
	}
};

/**
 * Used by framework
 */
function bfHandler(func, args) {
	var argsBF = [ func, args ];
	return bf_form_admin._toXAJAX(argsBF);
}

/**
 * Used by framework
 */
function getbfHandler(func) {
	return bf_form_admin.bfAdminHandler();
}
