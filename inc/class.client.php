<?php
Class SimpleGalleriaForWordpress_Client {

	function __construct() {
		add_action ( 'init', array( __CLASS__, 'init' ) );
	}
	
	/**
	 * Init gallery inclusion
	 * 
	 * @access public
	 * @return void
	 * @author Benjamin Niess
	 */
	public static function init() {
		wp_enqueue_script('jquery');
		
		// Galleria
		wp_enqueue_script( 'galleria-lib', SGFW_URL . '/ressources/galleria/galleria-1.4.2.min.js', 'jquery', '1.4.2' );
		wp_enqueue_script( 'galleria', SGFW_URL . '/ressources/galleria/themes/classic/galleria.classic.min.js', 'galeria-lib', '1.4.2' );
		wp_enqueue_style('galleria-css', SGFW_URL . '/ressources/galleria/themes/classic/galleria.classic.css', false, false, 'screen');
		
		// Colorbox
		wp_enqueue_script( 'colorbox', SGFW_URL . '/ressources/colorbox/jquery.colorbox-min.js', 'jquery', '1.6.0' );
		wp_enqueue_style('colorbox-css', SGFW_URL . '/ressources/colorbox/colorbox.css', false, '1.6.0', 'screen');
		
	}
	
	/**
	 * Get template file depending on theme
	 * 
	 * @param (string) $tpl : the template name
	 * @return (string) the file path | false
	 * 
	 * @author Benjamin Niess
	 */
	public static function get_template( $tpl = '' ) {
		if ( empty( $tpl ) ) {
			return false;
		}
		
		if ( is_file( STYLESHEETPATH . '/views/sgfw/' . $tpl . '.tpl.php' ) ) {// Use custom template from child theme
			return ( STYLESHEETPATH . '/views/sgfw/' . $tpl . '.tpl.php' );
		} elseif ( is_file( TEMPLATEPATH . '/sgfw/' . $tpl . '.tpl.php' ) ) {// Use custom template from parent theme
			return (TEMPLATEPATH . '/views/sgfw/' . $tpl . '.tpl.php' );
		} elseif ( is_file( SGFW_DIR . 'views/' . $tpl . '.tpl.php' ) ) {// Use builtin template
			return ( SGFW_DIR . 'views/' . $tpl . '.tpl.php' );
		}
		
		return false;
	}
	
}