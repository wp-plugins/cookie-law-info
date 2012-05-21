function doCookie(dc_message, dc_link_tag, dc_speed_down, dc_speed_up, dc_adipose_speed, dc_sticky, js_array, doc_base) {

	var ACCEPT_COOKIE_NAME = 'viewed_cookie_policy';
	var hasViewedPolicy = jQuery.cookie(ACCEPT_COOKIE_NAME);
	
	var expand_button = "<img src='" + doc_base + "/expand.png' height='32' width='32' class='icon' alt='Click to expand EU Cookie Law policy header' />";
	var collapse_button = "<img src='" + doc_base + "/collapse.png' height='32' width='32' class='icon' alt='Click to collapse EU Cookie Law policy header' />";
	
	function displayHeader() {
		if (dc_sticky) {
			jQuery("#cookie-header").show();
			jQuery('#adipose-tab').hide();
		}
		else {
			jQuery("#cookie-header").slideDown(dc_speed_down, function wwffrRRt() {
				jQuery('#adipose-tab').hide(); });
		}
	}
	
	function recursiveStrip(field) {
		if (field.charAt(0) == "#") {
			field = field.substring(1, field.length);
		}
		else {
			return "#" + field;
		}
		return recursiveStrip(field);
	}
	
	// Split testing:
	var option_a = "";
	var option_b = "<div id='cookie-header'><div class='left-panel'>" + dc_message + dc_link_tag + "</div><div class='right-panel'><a href='#' id='cookie_policy_close'>" + collapse_button + "</a></div></div><div id='adipose-tab'><a href='#' id='adipose-tab-open'>" + expand_button + "</a></div>";
	
	// On page ready, plugin the header HTML and hide it
	jQuery('body').prepend(option_b);
	jQuery('#cookie-header').hide();
	jQuery('#adipose-tab').hide();
	
	var palette = eval("(" + js_array + ")");
	jQuery('#cookie-header').css({
		'background-color': recursiveStrip(palette['colour_bg']),
		'color': recursiveStrip(palette['colour_text']),
		'border-bottom': '4px solid' + recursiveStrip(palette['colour_border'])
	});
	jQuery('.cookie-link-button').css({
		'background-color': recursiveStrip(palette['colour_button_bg']),
		'color': recursiveStrip(palette['colour_link'])
	});
	jQuery('.cookie-link-text').css({
		'color': recursiveStrip(palette['colour_link'])
	});
	jQuery('#adipose-tab').css({
		'background-color': recursiveStrip(palette['colour_adipose']),
		'color': recursiveStrip(palette['colour_link']),
		'border': '1px solid' + recursiveStrip(palette['colour_border'])
	});
	
	// On page load, if no cookie has been set then display (un-hide) the header, and hide the adipose-tab:
	if (hasViewedPolicy == null) {
		// Display:
		displayHeader()
	}
	else {
		// if a cookie has been set, you still want to show the adipose-tab but hide the header
		jQuery('#adipose-tab').slideDown(dc_adipose_speed);
	}
	
	// action event listener for "show header" event:
	jQuery("#adipose-tab-open").click(function() {	
		jQuery('#adipose-tab').slideUp(dc_adipose_speed, function slideShow() {
			jQuery("#cookie-header").slideDown(dc_speed_down);
		});
	});
	
	// action event listener to capture delete cookies message
	jQuery("#cookie_policy_delete").click(function() {
		jQuery.cookie(ACCEPT_COOKIE_NAME, null, { expires: 7, path: '/' });
	});
	
	// action event listeners to capture "hide" events:
	jQuery("#cookie_policy_close").click(function() {
		// Set cookie:
		jQuery.cookie(ACCEPT_COOKIE_NAME, 'yes', { expires: 7, path: '/' });
		// Hide the header:
		jQuery("#cookie-header").slideUp(dc_speed_up, function slideHide() {
			jQuery('#adipose-tab').slideDown(dc_adipose_speed) });
	});
}
