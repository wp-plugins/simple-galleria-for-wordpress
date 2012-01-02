<?php
/*
Plugin Name: Simple Galleria For WordPress
Version: 1.0.1
Plugin URI: http://beapi.fr
Description: Simple Galleria for WordPress is a jQuery image gallery based on WordPress native galleries.
Author: Benjamin Niess
Author URI: http://www.benjamin-niess.fr
*/


define ( 'SGFW_URL', plugins_url('', __FILE__) );
define ( 'SGFW_DIR', dirname(__FILE__) );
define ( 'SGFW_OPTIONS', 'sgwf-options' );

// Call all class and functions
require( SGFW_DIR . '/inc/class.client.php' );
require( SGFW_DIR . '/inc/class.admin.php' );
require( SGFW_DIR . '/inc/class.shortcode.php' );
require( SGFW_DIR . '/inc/functions.plugin.php' );

// Activate SGFW
register_activation_hook  ( __FILE__, 'SGFW_Install' );

add_action( 'plugins_loaded', 'initSimpleGalleriaForWordpress' );
function initSimpleGalleriaForWordpress() {
	global $simple_galleria_for_wordpress;
	
	// Load up the localization file if we're using WordPress in a different language
	// Place it in this plugin's "lang" folder and name it "sgfw-[value in wp-config].mo"
	load_plugin_textdomain( 'sgfw', false, basename(rtrim(dirname(__FILE__), '/')) . '/languages' );
	
	$simple_galleria_for_wordpress['client'] = new SimpleGalleriaForWordpress_Client();
	
	if ( is_admin() )
		$simple_galleria_for_wordpress['admin'] = new SimpleGalleriaForWordpress_Admin();
		
	// shortcodes
	$simple_galleria_for_wordpress['shortcode'] = new SimpleGalleriaForWordpress_Shortcodes();
}
?>