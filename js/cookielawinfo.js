function cli_show_cookiebar( html, json_payload ) {
	var ACCEPT_COOKIE_NAME = 'viewed_cookie_policy';
	var ACCEPT_COOKIE_EXPIRE = 365;
	var settings = eval('(' + json_payload +')');
	
	jQuery('body').prepend(html);
	var cached_header = jQuery(settings.notify_div_id);
	var cached_showagain_tab = jQuery(settings.showagain_div_id);
	var btn_accept = jQuery('#cookie_hdr_accept');
	var btn_decline = jQuery('#cookie_hdr_decline');
	var btn_moreinfo = jQuery('#cookie_hdr_moreinfo');
	var btn_settings = jQuery('#cookie_hdr_settings');
	
	cached_header.hide();
	if ( !settings.showagain_tab ) {
		cached_showagain_tab.hide();
	}
	
	var hdr_args = {
		'background-color': settings.background,
		'color': settings.text,
		'font-family': settings.font_family
	};
	var showagain_args = {
		'background-color': settings.background,
		'color': l1hs(settings.text),
		'position': 'fixed',
		'font-family': settings.font_family
	};
	if ( settings.border_on ) {
		var border_to_hide = 'border-' + settings.notify_position_vertical;
		showagain_args['border'] = '1px solid ' + l1hs(settings.border);
		showagain_args[border_to_hide] = 'none';
	}
	if ( settings.notify_position_vertical == "top" ) {
		if ( settings.border_on ) {
			hdr_args['border-bottom'] = '4px solid ' + l1hs(settings.border);
		}
		showagain_args.top = '0';
	}
	else if ( settings.notify_position_vertical == "bottom" ) {
		if ( settings.border_on ) {
			hdr_args['border-top'] = '4px solid ' + l1hs(settings.border);
		}
		hdr_args['position'] = 'fixed';
		hdr_args['bottom'] = '0';
		showagain_args.bottom = '0';
	}
	if ( settings.notify_position_horizontal == "left" ) {
		showagain_args.left = settings.showagain_x_position;
	}
	else if ( settings.notify_position_horizontal == "right" ) {
		showagain_args.right = settings.showagain_x_position;
	}
	cached_header.css( hdr_args );
	cached_showagain_tab.css( showagain_args );
	
	if (jQuery.cookie(ACCEPT_COOKIE_NAME) == null) {
		displayHeader();
	}
	else {
		cached_header.hide();
	}
	
	var main_button = jQuery('.cli-plugin-main-button');
	main_button.css( 'color', settings.button_1_link_colour );
	
	if ( settings.button_1_as_button ) {
		main_button.css('background-color', settings.button_1_button_colour);
		
		main_button.hover(function() {
			jQuery(this).css('background-color', settings.button_1_button_hover);
		},
		function() {
			jQuery(this).css('background-color', settings.button_1_button_colour);
		});
	}
	var main_link = jQuery('.cli-plugin-main-link');
	main_link.css( 'color', settings.button_2_link_colour );
	
	if ( settings.button_2_as_button ) {
		main_link.css('background-color', settings.button_2_button_colour);
		
		main_link.hover(function() {
			jQuery(this).css('background-color', settings.button_2_button_hover);
		},
		function() {
			jQuery(this).css('background-color', settings.button_2_button_colour);
		});
	}
	
	// Action event listener for "show header" event:
	cached_showagain_tab.click(function() {	
		cached_showagain_tab.slideUp(settings.animate_speed_hide, function slideShow() {
			cached_header.slideDown(settings.animate_speed_show);
		});
	});
	
	// Action event listener to capture delete cookies shortcode click. This simply deletes the viewed_cookie_policy cookie. To use:
	// <a href='#' id='cookielawinfo-cookie-delete' class='cookie_hdr_btn'>Delete Cookies</a>
	jQuery("#cookielawinfo-cookie-delete").click(function() {
		jQuery.cookie(ACCEPT_COOKIE_NAME, null, { expires: 365, path: '/' });
		return false;
	});
	
	// Action event listener for debug cookies value link. To use:
	// <a href='#' id='cookielawinfo-debug-cookie'>Show Cookie Value</a>
	jQuery("#cookielawinfo-debug-cookie").click(function() {
		alert("Cookie value: " + jQuery.cookie(ACCEPT_COOKIE_NAME));
		return false;
	});
	
	// action event listeners to capture "accept/continue" events:
	jQuery("#cookie_action_close_header").click(function() {
		// Set cookie then hide header:
		jQuery.cookie(ACCEPT_COOKIE_NAME, 'yes', { expires: ACCEPT_COOKIE_EXPIRE, path: '/' });
		
		if (settings.notify_animate_hide) {
			cached_header.slideUp(settings.animate_speed_hide);
		}
		else {
			cached_header.hide();
		}
		cached_showagain_tab.slideDown(settings.animate_speed_show);
		return false;
	});
	
	function displayHeader() {
		if (settings.notify_animate_show) {
			cached_header.slideDown(settings.animate_speed_show);
		}
		else {
			cached_header.show();
		}
		cached_showagain_tab.hide();
	}
	
};
function l1hs(str){if(str.charAt(0)=="#"){str=str.substring(1,str.length);}else{return "#"+str;}return l1hs(str);}