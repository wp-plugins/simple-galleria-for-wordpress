<?php
/*
Plugin Name: Simple Galleria For WordPress
Version: 2.0.1
Plugin URI: http://beapi.fr
Description: Simple Galleria for WordPress is a jQuery image gallery based on WordPress native galleries.
Author: Benjamin Niess
Author URI: http://www.benjamin-niess.fr
Text Domain: sgfw
*/

define ( 'SGFW_URL', plugin_dir_url ( __FILE__ ) );
define ( 'SGFW_DIR', plugin_dir_path( __FILE__ ) );
define ( 'SGFW_OPTIONS', 'sgwf-options' );

// Call all class and functions
require( SGFW_DIR . '/inc/class.client.php' );
require( SGFW_DIR . '/inc/class.admin.php' );
require( SGFW_DIR . '/inc/class.shortcode.php' );
require( SGFW_DIR . '/inc/functions.plugin.php' );

// Activate SGFW
register_activation_hook  ( __FILE__, 'SGFW_Install' );

add_action( 'plugins_loaded', 'init_simple_galleria_for_wordpress' );
function init_simple_galleria_for_wordpress() {
	
	// Load up the localization file if we're using WordPress in a different language
	// Important: If you want to add you own translation file without having to hack this plugin, put you mo file in wp-content/languages/plugins/sgfw-xx_XX.mo
	if ( !load_textdomain( 'sgfw', trailingslashit( WP_LANG_DIR ) . 'plugins/sgfw-' . get_locale() . '.mo' ) ) {
		load_plugin_textdomain( 'sgfw', false, basename( rtrim( dirname( __FILE__ ), '/' ) ) . '/languages' );
	}
	
	new SimpleGalleriaForWordpress_Client();
	
	if ( is_admin() ) {
		new SimpleGalleriaForWordpress_Admin();
	}
		
	// Shortcodes
	new SimpleGalleriaForWordpress_Shortcodes();
}