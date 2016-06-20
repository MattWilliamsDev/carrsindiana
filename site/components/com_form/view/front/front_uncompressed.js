/* $Id: front_uncompressed.js 171 2009-08-10 12:18:12Z  $ */

var bf_js_options = [ bf_js_options_useblanket, // Use Blanket On Submit
		0, // unused
		0, // unused
		0, // unused
		0 // unused
];

var bf_form = {
	_toXAJAX : function(args) {
		return xajax.call(this.bfHandler(), {
			parameters : args
		});
	},
	bfHandler : function() {
		return 'bf_com_form_Handler';
	},
	pauseMode : function(formid) {
		jQuery('#bf_preview_' + formid).val('2');
		var formFields = xajax.getFormValues('BF_FORM_' + formid);
		jQuery('#bf_failvalidation_messages').hide();
		if (bf_js_options[0] == '1') {
			this._createBlanket(formid);
		} else {
			jQuery('form#BF_FORM_' + formid).submit();
		}
	},
	previewMode : function(formid) {
		scroll(0, 0);
		jQuery('#bf_preview_' + formid).val('1');
		var formFields = xajax.getFormValues('BF_FORM_' + formid);
		jQuery('#bf_failvalidation_messages').hide();
		var args = [ 'xpublic_preview', formFields ];
		return this._toXAJAX(args);
	},
	formSubmit : function(formid) {
		scroll(0, 0);
		if (bf_js_options[0] == '1') {
			this._createBlanket(formid);
		} else {
			jQuery('form#BF_FORM_' + formid).submit();
		}
	},
	displayPreview : function(formid) {
		jQuery('form#BF_FORM_' + formid).hide();
		jQuery('div#bf_previewform_div_' + formid).show();
	},
	reset : function(formid) {
		jQuery('div#bf_previewform_div_' + formid).hide();
		jQuery('form#BF_FORM_' + formid).reset();
		jQuery('#bf_preview').val('0');
		jQuery("div").removeClass('failvalidation').removeClass(
				'passvalidation');
		jQuery("input").removeClass('bf_fail_validation').removeClass(
				'bf_pass_validation');
		jQuery("select").removeClass('bf_fail_validation').removeClass(
				'bf_pass_validation');
		jQuery("textarea").removeClass('bf_fail_validation').removeClass(
				'bf_pass_validation');
		jQuery("div#bf_failvalidation_messages").hide();
	},
	edit : function(formid) {
		this.displayPreview(formid);
		jQuery('div#bf_previewform_div_' + formid).hide();
		jQuery('form#BF_FORM_' + formid).show();
		jQuery('#bf_preview').val('0');
		jQuery("div").removeClass('failvalidation');
		jQuery("div").removeClass('passvalidation');
		jQuery("div#bf_failvalidation_messages").hide();
		jQuery("input").removeClass('bf_fail_validation');
		jQuery("select").removeClass('bf_fail_validation');
		jQuery("textarea").removeClass('bf_fail_validation');
		jQuery("input").removeClass('bf_pass_validation');
		jQuery("select").removeClass('bf_pass_validation');
		jQuery("textarea").removeClass('bf_pass_validation');
	},
	_bfblanket_str_replace : function(search, replace, subject) {
		var s = subject;
		var ra = r instanceof Array, sa = s instanceof Array;
		var f = [].concat(search);
		var r = [].concat(replace);
		var i = (s = [].concat(s)).length;
		var j = 0;

		while (j = 0, i--) {
			if (s[i]) {
				while (s[i] = (s[i] + '').split(f[j]).join(
						ra ? r[j] || "" : r[0]), ++j in f) {
				}
				;
			}
		}
		return sa ? s : s[0];
	},
	_createBlanket : function(formid) {
		var overlay = jQuery("<div id ='splashscreen_progress_container' class='splashscreen_progress_container'><div id='interstitial' style='width:550px; margin:0px auto; text-align:center; margin-top: 100px;'></div></div>");
		jQuery("#splashscreen_progress_container").remove();
		jQuery("body").append(overlay);

		jQuery('.splashscreen_progress_container').css('position', 'absolute');
		jQuery('.splashscreen_progress_container').css('top', '0');
		jQuery('.splashscreen_progress_container').css('left', '0');
		jQuery('.splashscreen_progress_container').css('right', '0');
		jQuery('.splashscreen_progress_container').css('bottom', '0');
		jQuery('.splashscreen_progress_container').css('min-height', '999');
		jQuery('body').css('height', '100%');
		jQuery('.splashscreen_progress_container').css('height',
				jQuery(document).height());
		jQuery('.splashscreen_progress_container').css('width',
				jQuery(document).width());
		jQuery('.splashscreen_progress_container').css('background-color',
				'#F9F9F9');
		jQuery('.splashscreen_progress_container').css('z-index', '999');
		jQuery('.splashscreen_progress_container').css('color', 'black');
		jQuery("#interstitial")
				.load(
						bf_live_site
								+ "/components/com_form/view/user_templates/eccbc87e4b5ce2fe28308fd9f2a7baf3.php",
						null,
						function(txt) {
							var t = jQuery('#interstitial').html();
							var newhtml = bf_form._bfblanket_str_replace(
									'%7B$LIVE_SITE%7D', bf_live_site, t);
							var newhtml2 = bf_form._bfblanket_str_replace(
									'{$LIVE_SITE}', bf_live_site, newhtml);
							jQuery('#interstitial').html(newhtml2);
							jQuery('form#BF_FORM_' + formid).submit();

						});

	}
};

jQuery.fn.extend( {
	reset : function() {
		return this.each(function() {
			jQuery(this).is('form') && this.reset();
		})
	}
});

if ("undefined" == typeof (bf_live_site)){
	bf_live_site = '';
}
jQuery("<img>").attr("src", bf_live_site + "/plugins/system/blueflame/view/images/throbber.gif");
