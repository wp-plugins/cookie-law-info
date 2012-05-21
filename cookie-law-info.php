<?php
/*
Plugin Name: Cookie Law Info
Plugin URI: http://www.cookielawinfo.com/cli-plugin-01/
Description: A simple way to ensure your website complies with the EU Cookie Law, which comes into force from 26 May 2012.
Author: Richard Ashby
Author URI: http://www.cookielawinfo.com/
Version: 0.8.3
License: GPL2
	
	===============================================================================
	
	Whilst writing this plugin, somebody very close to me passed away from
	prostate cancer.
	
	If you found this software useful, please consider making a donation to
	cancer research. Your donation, no matter how small, makes a real difference.
	
	Thank You.
	
	http://uk.movember.com/mospace/1853714/
	www.cancerresearchuk.org

	===============================================================================

	Copyright 2012  Richard Ashby  (email : richard.ashby@mediacreek.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

define ( 'ADMIN_OPTIONS_NAME', 'CookieLawInfo-0.8.3' );


function cookielawinfo_get_admin_settings() {
	
	// REFACTOR:
	// Add 2 globals: $the_settings and $is_dirty
	// When move to OOP this can be implemented as lazy load
	//
	
	$the_options = array(
		'is_on' 				=> true,
		'message_text' 			=> 'We have updated our Privacy and Cookie Policy in line with the new EU privacy regulations.',
		'link_text' 			=> 'More Info',
		'link_url' 				=> home_url(),	// Website homepage (no trailing slash)
		'animation_style' 		=> 'Smooth slide',
		'skin' 					=> 'Standard',
		'colour_bg' 			=> '#ffffff',
		'colour_text'			=> '#000000',
		'colour_border'			=> '#333333',
		'colour_link'			=> '#ffffff',
		'colour_button_bg'		=> '#333333',
		'colour_adipose'		=> '#ffffff',
		'show_as_button'		=> true,
		'link_opens_new_window'	=> true
	);
	$stored_options = get_option(ADMIN_OPTIONS_NAME);
	if (!empty($stored_options)) {
		foreach ($stored_options as $key => $option) {
			$the_options[$key] = cookielawinfo_sanitise( $key, $option );
		}
	}
	update_option(ADMIN_OPTIONS_NAME, $the_options);
	return $the_options;
}

function cookielawinfo_sanitise($key, $value) {
	/**
	  Returns sanitised content based on field-specific rules defined here
	  Can be used for both read AND write operations: if it's not hard coded, it's unsafe.
	 */
	
	// REFACTOR:
	// This code stops boolean fields (in HTML form radio buttons) being stored as strings.
	// Currently a bit ugly and could benefit from a code review.
	
	$ret = null;
	
	switch ($key) {
		case 'link_opens_new_window':
		case 'is_on':
		case 'show_as_button':
			if ( $value == 'true' ) {
				$ret = true;
			}
			elseif ( $value == 'false' ) {
				$ret = false;
			}
			else {
				// Unexpected value returned from radio button, go fix the HTML.
				// But in the meantime assign null.
				$ret = null;
			}
			break;
		case 'colour_bg':
		case 'colour_text':
		case 'colour_border':
		case 'colour_link':
		case 'colour_button_bg':
		case 'colour_adipose':
			// Sanitise input
			// Any hex colour e.g. '#f00', '#FE01ab' '#ff0000' but not 'f00' or 'ff0000'
			if ( preg_match( '/^#([0-9a-fA-F]{1,2}){3}$/i', $value ) ) {
				$ret =  $value;
			}
			else {
				// Value is not an HTML colour code. Warn, and do not store:
				// Do NOT spit out $value in alert window! If contents are unsafe, you've just executed an XSS attack.
				echo '<script type="text/javascript">alert("Invalid HTML code: no action taken.' . '");</script>';
			}
			break;
		case 'message_text':
			// Allow some HTML, but no JavaScript
			$ret = sanitize_text_field( $value );
			break;
		case 'link_text':
			// Sanitise - allow alphanumeric only
			$ret = sanitize_text_field( $value );
			break;
		case 'link_url':
			// Sanitise - allow URL only, no JavaScript tho
			$ret = esc_url( $value );
			break;
		default:
			// Allow some HTML, but no JavaScript
			// REFACTOR: safer fallback (fewer bugs) would be warn and do not store,
			// then coder would be forced to sanitise according to field type.
			//
			$ret = sanitize_text_field( $value );
			break;
	}
	return $ret;
}

function cookielawinfo_print_admin_page() {
	// Lock out non-admins:
	if ( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have sufficient permission to perform this operation' );
	}
	
	// Get options:
	$the_options = cookielawinfo_get_admin_settings();
	
	// Check if form has been set:
	if ( isset( $_POST['update_admin_settings_form'] ) ) {
		// Check nonce:
		check_admin_referer( 'cookielawinfo-update-' . ADMIN_OPTIONS_NAME );
		foreach ( $the_options as $key => $value ) {
			if (isset($_POST[$key . '_field'])) {
				// Store sanitised values only:
				$the_options[$key] = cookielawinfo_sanitise($key, $_POST[$key . '_field']);
			}
		}
		update_option(ADMIN_OPTIONS_NAME, $the_options);
		echo '<div class="updated"><p><strong>Settings Updated.</strong></p></div>';
	}
	
	// Display the form itself
	echo '<div class="wrap">';
	echo '<div class="fluid-selector-wrapper">';
	echo '<div class="fluid-column-left">';
	echo '<h2>Cookie Law Settings</h2>';
	echo '<form method="post" action="' . esc_url ( $_SERVER["REQUEST_URI"] ) . '">';
	
	// Set nonce:
	if ( function_exists('wp_nonce_field') ) 
		wp_nonce_field('cookielawinfo-update-' . ADMIN_OPTIONS_NAME);
	
	echo '<table class="form-table">';
	echo '<tr valign="top">';
	
	echo '<th scope="row">Display cookie bar?</th>';
	echo '<td><label for="is_on_yes"><input type="radio" id="is_on_yes" name="is_on_field" value="true"';
	
	if ( $the_options['is_on'] == true )
		echo ' checked="checked"';
	echo ' /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;';
	
	echo '<label for="is_on_no"><input type="radio" id="is_on_no" name="is_on_field" value="false"';
	if ( $the_options['is_on'] == false ) 
		echo ' checked="checked"';
	echo ' /> No</label><br /><span class="cookie-header-warning">Please note: if this is set to "no" then the header will NOT be shown.</span></td>';
	echo '</tr>';
	
	echo '<tr valign="top">';
	echo '<th scope="row">Message</th>';
	echo '<td><textarea name="message_text_field" class="vvv_textbox">';
	echo apply_filters('format_to_edit', (string)$the_options['message_text']) . '</textarea></td>';
	echo '</tr>';
	
	echo '<tr valign="top">';
	echo '<th scope="row">Link text</th>';
	echo '<td><input type="text" name="link_text_field" value="' . (string)$the_options['link_text'] . '" size="40" /></td>';
	echo '</tr>';
	
	echo '<tr valign="top">';
	echo '<th scope="row">Link URL</th>';
	echo '<td><input type="text" name="link_url_field" value="' . (string)$the_options['link_url'] . '" size="40" /></td>';
	echo '</tr>';
	
	echo '<th scope="row">Open link in new window?</th>';
	echo '<td><label for="link_opens_new_window_yes"><input type="radio" id="link_opens_new_window_yes" name="link_opens_new_window_field" value="true"';
	if ( $the_options['link_opens_new_window'] == true )
		echo ' checked="checked"';
	echo ' /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;';
	
	echo '<label for="link_opens_new_window_no"><input type="radio" id="link_opens_new_window_no" name="link_opens_new_window_field" value="false"';
	if ( $the_options['link_opens_new_window'] == false ) 
		echo ' checked="checked"';
	echo ' /> No</label></td>';
	echo '</tr>';
	
	echo 		'<tr valign="top">';
	echo 			'<th scope="row">Cookie bar skin</th>';
	echo 			'<td><select name="chosen_style_field" class="vvv_combobox">';
	echo 				'<option selected="selected" value="'.$the_options['skin'].'">'.$the_options['skin'].'</option>';
	echo 				'</select></td>';
	echo 		'</tr>';
	
	echo 		'<tr valign="top">';
	echo 			'<th scope="row">Cookie bar style</th>';
	echo 			'<td><select name="chosen_style_field" class="vvv_combobox">';
	echo 				'<option selected="selected" value="'.$the_options['animation_style'].'">'.$the_options['animation_style'].'</option>';
	echo 				'</select></td>';
	echo 		'</tr>';
	
	// colour pickers / styling components
	echo 		'<tr valign="top">';
	echo 			'<th scope="row">Background colour</th>';
	echo 			'<td><input type="text" name="colour_bg_field" id="cookie-cp1" value="' .$the_options['colour_bg']. '" /></td>';
	echo 		'</tr>';
	
	echo 		'<tr valign="top">';
	echo 			'<th scope="row">Text colour</th>';
	echo 			'<td><input type="text" name="colour_text_field" id="cookie-cp2" value="' .$the_options['colour_text']. '" /></td>';
	echo 		'</tr>';
	
	echo 		'<tr valign="top">';
	echo 			'<th scope="row">Border colour</th>';
	echo 			'<td><input type="text" name="colour_border_field" id="cookie-cp3" value="' .$the_options['colour_border']. '" /></td>';
	echo 		'</tr>';
	
	echo 		'<tr valign="top">';
	echo 			'<th scope="row">Link colour</th>';
	echo 			'<td><input type="text" name="colour_link_field" id="cookie-cp4" value="' .$the_options['colour_link']. '" /></td>';
	echo 		'</tr>';
	
	echo 		'<tr valign="top">';
	echo 			'<th scope="row">Expand header background colour</th>';
	echo 			'<td><input type="text" name="colour_adipose_field" id="cookie-cp6" value="' .$the_options['colour_adipose']. '" /></td>';
	echo 		'</tr>';
	
	echo '<th scope="row">Use a button?</th>';
	echo '<td><label for="show_as_button_yes"><input type="radio" id="show_as_button_yes" name="show_as_button_field" value="true"';
	if ( $the_options['show_as_button'] == true )
		echo ' checked="checked"';
	echo ' /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;';
	
	echo '<label for="show_as_button_no"><input type="radio" id="show_as_button_no" name="show_as_button_field" value="false"';
	if ( $the_options['show_as_button'] == false ) 
		echo ' checked="checked"';
	echo ' /> No</label></td>';
	echo '</tr>';
	
	echo 		'<tr valign="top">';
	echo 			'<th scope="row">Button colour</th>';
	echo 			'<td><input type="text" name="colour_button_bg_field" id="cookie-cp5" value="' .$the_options['colour_button_bg']. '" /></td>';
	echo 		'</tr>';
	
	echo 	'</table>';
	echo 	'<div class="submit"><input type="submit" name="update_admin_settings_form" value="Update Settings" /></div>';
		
	echo '</form>';
	
	echo '</div>';
	
	// right hand panel
	echo '<div class="fluid-column-right">';
	
	?>
			<div class="clearchimp">
			<!-- Begin MailChimp Signup Form -->
<div id="mc_embed_signup">
	<form action="http://mediacreek.us5.list-manage.com/subscribe/post?u=b32779d828ef2e37e68e1580d&amp;id=71af66b86e" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
		<h2>Plugin Help</h2>
		<p>
			<a href="http://www.cookielawinfo.com" target="_new">About the EU Cookie Law</a><br />
			<a href="http://www.cookielawinfo.com" target="_new">Plugin Support</a><br />
			<a href="http://www.cookielawinfo.com" target="_new">FAQ</a>
		</p>
		<h2>Subscribe to our newsletter</h2>
		<p>Don't get caught out by the new law.<p>
		<p>Sign up for occasional updates on compliance requirements, who's doing what and industry best practice.<p>
		<div class="indicates-required">
			<span class="asterisk">*</span> indicates required
		</div>
		<div class="mc-field-group">
			<label for="mce-MMERGE3">Name <span class="asterisk">*</span> </label> 
			<input type="text" value="" name="MMERGE3" class="required" id="mce-MMERGE3"> 
		</div>
		<div class="mc-field-group">
			<label for="mce-EMAIL">Email Address <span class="asterisk">*</span> </label> 
			<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL"> 
		</div>
		<div class="mc-field-group input-group">
			<strong>Email Format </strong> 
			<ul>
				<li>
				<input type="radio" value="html" name="EMAILTYPE" id="mce-EMAILTYPE-0" checked="checked"><label for="mce-EMAILTYPE-0">&nbsp;html</label></li>
				<li>
				<input type="radio" value="text" name="EMAILTYPE" id="mce-EMAILTYPE-1"><label for="mce-EMAILTYPE-1">&nbsp;text</label></li>
				<li>
				<input type="radio" value="mobile" name="EMAILTYPE" id="mce-EMAILTYPE-2"><label for="mce-EMAILTYPE-2">&nbsp;mobile</label></li>
			</ul>
		</div>
		<div id="mce-responses" class="clear">
			<div class="response" id="mce-error-response" style="display:none">
			</div>
			<div class="response" id="mce-success-response" style="display:none">
			</div>
		</div>
		<div class="clear">
			<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
			<p>We will not send you spam or pass your details to 3rd Parties.</p>
			<p>Cookie Law Info is provided by MediaCreek Limited, a UK-based eCommerce Consultancy<p>
		</div>
	</form>
	
</div>

<!--End mc_embed_signup-->
</div>
</div>
</div>
</div>
	<?php
}


function cookielawinfo_get_json_palette() {
	/** returns array of individual colour settings */
	
	$settings = cookielawinfo_get_admin_settings();
	$palette = array(
		'colour_bg' 			=> $settings['colour_bg'],
		'colour_text'			=> $settings['colour_text'],
		'colour_border'			=> $settings['colour_border'],
		'colour_link'			=> $settings['colour_link'],
		'colour_button_bg'		=> $settings['colour_button_bg'],
		'colour_adipose'		=> $settings['colour_adipose']
	);
	
	return json_encode( $palette );
}


function cookielawinfo_get_message() {
	/** Returns the message which will appear in the banner */
	$the_settings = cookielawinfo_get_admin_settings();
	return $the_settings['message_text'];
}

function cookielawinfo_get_link_tag() {
	/**
	 Returns the full <a> tag which will appear in the banner
	 Includes support for open in new tab/window
	 Includes support for "show as button"
	 */
	
	$the_settings = cookielawinfo_get_admin_settings();
	
	$opens_new_window = true;
	if ( $the_settings["link_opens_new_window"] = false ) {
		$opens_new_window = false;
	}
	
	$button_yes = false;
	if ( $the_settings["show_as_button"] ) {
		$button_yes = true;
	}
	$button_code = ' class="cookie-link"';
	
	$link_tag = '<a href="' . $the_settings["link_url"] . '"';
	if ( $button_yes ) {
		$link_tag .= ' class="cookie-link-button"';
	}
	else {
		$link_tag .= ' class="cookie-link-text"';
	}
	if ($opens_new_window) {
		$link_tag .= ' target="_new_">' . $the_settings["link_text"] . '</a>';
	}
	else {
		$link_tag .= '>' . $the_settings["link_text"] . '</a>';
	}
	return $link_tag;
}

// [deletecookies linktext="delete cookies"]
function cookielawinfo_delete_cookies_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'text' => 'Delete Cookies'
	), $atts ) );
	return "<a href='' id='cookie_policy_delete'>{$text}</a>";
}

function cookielawinfo_register_custom_menu_page() {
	/**
	 Registers menu options
	 Hooked into admin_menu
	 */
	add_options_page(
		'Cookie Law Settings', 
		'Cookie Law Settings', 
		'manage_options', 
		'cookie-law-info', 
		'cookielawinfo_print_admin_page'
	);
}

function cookielawinfo_custom_dashboard_styles_chimp() {
	echo '<link href="http://cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css"> <style type="text/css">#mc_embed_signup{background:#fff; clear:left; border: 1px solid #ccc;  margin: 0; padding: 0; }</style>';
}

function cookielawinfo_custom_dashboard_styles($hook) {
	/**
	 Registers dashboard scripts and styles used for Cookie Law Info plugin settings panel
	 Hooked into admin_enqueue_script
	 */
	
	if( 'settings_page_cookie-law-info' != $hook )
        return;
    
	wp_register_style( 'cookielawinfo-admin-style', plugins_url('/css/cli-admin-style.css', __FILE__) );
    wp_enqueue_style( 'cookielawinfo-admin-style' );
	
	wp_enqueue_script('spectrum-colorpicker', plugins_url('/admin/bgrins-spectrum/spectrum.js', __FILE__), array('jquery'));
	//wp_enqueue_script('spectrum-custom', plugins_url('/admin/bgrins-spectrum/my-colours.js', __FILE__));
	
	wp_register_style( 'spectrum-style', plugins_url('/admin/bgrins-spectrum/spectrum.css', __FILE__) );
    wp_enqueue_style( 'spectrum-style' );
}

function cookielawinfo_custom_dashboard_styles_my_colours() {
	wp_enqueue_script('spectrum-custom', plugins_url('/admin/bgrins-spectrum/my-colours.js', __FILE__));
}

function cookielawinfo_inject_cli_script() {
	/**
	 Outputs the cookie control script in the footer
	 N.B. This script MUST be output in the footer.
	 
	 This function should be attached to the wp_footer action hook.
	*/
	$the_options = cookielawinfo_get_admin_settings();
	if ( $the_options['is_on'] == true ) {
		// Pass JS the base URL for the icons:
		$icon_url = plugins_url('images' , __FILE__);
		
		echo '<script type="text/javascript">';
		echo '	jQuery(document).ready(function() {';
		echo "		doCookie('" . cookielawinfo_get_message() . "', '" . cookielawinfo_get_link_tag() . "', 500, 500, 200, true, '" . cookielawinfo_get_json_palette() ."', '" . $icon_url ."');";
		echo '	});';
		echo '</script>';
	}
}

function cookielawinfo_enqueue_frontend_scripts() {
	/**
	 Outputs frontend scripts in the header.
	 N.B. These scripts MUST be output in the header.
	 
	 This function should be attached to the wp_enqueue_script action hook, not wp_head!
	 Else gets output in footer (incorrect).
	 */
	$the_options = cookielawinfo_get_admin_settings();
	if ( $the_options['is_on'] == true ) {
		
		// https://github.com/carhartl/jquery-cookie
		wp_enqueue_script( 'jquery-cookie', plugins_url('/js/jquery.cookie.js', __FILE__), array('jquery') );
		wp_enqueue_script( 'cookie-law-info-script', plugins_url('/js/cli-script.js', __FILE__ ), array( 'jquery' ) );
		
		wp_register_style( 'cookielawinfo-style', plugins_url('/css/cli-style.css', __FILE__) );
		wp_enqueue_style( 'cookielawinfo-style' );
		
		//cookielawinfo_inject_workhorse_script();
	}
}

function cookielawinfo_activate() {
	// register the uninstall function
	register_uninstall_hook( __FILE__, 'cookielawinfo_uninstall_plugin' );
}

function cookielawinfo_uninstall_plugin() {
	/**
	  Uninstalls the plugin (removes settings)
	  This is done within the plugin PHP file rather than a separate file as the settings
	  are stored in a variable called ADMIN_OPTIONS_NAME, which is outsde that file's scope.
	*/
	delete_option( ADMIN_OPTIONS_NAME );
}


register_activation_hook( __FILE__, 'cookielawinfo_activate' );					// adds plugin's uninstall method
add_action( 'admin_menu', 'cookielawinfo_register_custom_menu_page' );			// add custom menu
add_action('wp_enqueue_scripts', 'cookielawinfo_enqueue_frontend_scripts');		// add jQuery plugins
add_action('wp_footer', 'cookielawinfo_inject_cli_script');						// add main jQuery script (runs header)
add_shortcode( 'delete_cookies', 'cookielawinfo_delete_cookies_shortcode' );	// a shortcode [delete_cookies text="Delete Cookies"]

add_action('admin_enqueue_scripts', 'cookielawinfo_custom_dashboard_styles');
add_action( 'admin_head', 'cookielawinfo_custom_dashboard_styles_chimp' );
add_action( 'admin_footer', 'cookielawinfo_custom_dashboard_styles_my_colours' );


// Debug assistance:
function cookielawinfo_debug($gubbins) {
	echo '<script type="text/javascript"> alert("' . $gubbins .'")</script>';
}

?>
