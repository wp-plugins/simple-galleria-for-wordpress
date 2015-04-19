<?php
Class SimpleGalleriaForWordpress_Admin {
	
	public static $message = '';
	public static $status = '';

	function __construct() {
		add_action ( 'init', array( __CLASS__, 'init' ) );
	}
	
	/**
	 * Init admin class
	 * 
	 * @author Benjamin Niess
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'check_changes') );
	}
	
	/*
	 * Add the galleria admin menu
	 * 
	 * @author Benjamin Niess
	 */
	public static function add_menu() {
		add_options_page( __( 'Simple Galleria for WordPress', 'sgfw' ), __( 'Simple Galleria', 'sgfw'), 'manage_options', 'simple-galleria-for-wordpress', array( __CLASS__, 'page_manage' ) );
	}
	
	/**
	 * Display options on admin
	 *
	 * @author Benjamin Niess
	 */
	public static function page_manage() {
		// Current settings
		$sgfw_options = get_option( SGFW_OPTIONS );
		
		$tpl = SimpleGalleriaForWordpress_Client::get_template( 'admin/settings' );
		if ( empty( $tpl ) ) {
			return false;
		}
		
		include( $tpl );
		
		return true;
	}

	/**
	 * Check for submition
	 * 
	 * @author Benjamin Niess
	 */
	public static function check_changes() {
		if ( !isset($_POST['save-sgfw']) ) {
			return false;
		}
		
		check_admin_referer( 'sgfw-update-options' );
		
		if ( !isset( $_POST['sgfw'] ) || !is_array( $_POST['sgfw'] ) ) {
			return false;
		}
		
		$sgfw_options = array();
		foreach ( $_POST['sgfw'] as $option_key => $option_value ) {
			$sgfw_options[esc_attr( $option_key )] = esc_attr( $option_value );
		}
		
		// Save settings
		self::$message = __('Settings updated with success !', 'sgfw');
		update_option( SGFW_OPTIONS, $sgfw_options );
	}

	/**
	 * Display a message in top of admin page
	 * 
	 * @author Benjamin Niess
	 */
	public static function display_message() {
		if ( self::$message != '') {
			$message = self::$message;
			$status = self::$status;
			self::$message = self::$status = ''; // Reset
		}
		
		if ( isset($message) && !empty($message) ) {

			echo '<div id="message" class="';
			echo ( $status != '' ) ? $status :'updated';
			echo '" >';
				echo '<p><strong>' . $message . '</strong></p>';
			echo '</div>';
		
		}
	}	
}