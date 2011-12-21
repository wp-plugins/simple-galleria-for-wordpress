<?php
Class SimpleGalleriaForWordpress_Client {

	function __construct() {
		add_action ( 'init', array( &$this, 'init' ) );
	}
	
	/**
	 * Init gallery inclusion
	 * 
	 * @access public
	 * @return void
	 * @author Benjamin Niess
	 */
	function init() {
		wp_enqueue_script('jquery');
		
		// Galleria
		wp_enqueue_script( 'galleria-lib', SGFW_URL . '/ressources/galleria/galleria-1.2.6.min.js', 'jquery', '1.2.6' );
		wp_enqueue_script( 'galleria', SGFW_URL . '/ressources/galleria/themes/classic/galleria.classic.min.js', 'galeria-lib', '1.0' );
		wp_enqueue_style('galleria-css', SGFW_URL . '/ressources/galleria/themes/classic/galleria.classic.css', false, false, 'screen');
		
		// Fancybox
		wp_enqueue_script( 'fancybox', SGFW_URL . '/ressources/fancybox/jquery.fancybox-1.3.4.pack.js', 'jquery', '1.3.4' );
		wp_enqueue_style('fancybox-css', SGFW_URL . '/ressources/fancybox/jquery.fancybox-1.3.4.css', false, false, 'screen');
		
	}
	
}
?>