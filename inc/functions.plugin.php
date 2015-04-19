<?php 
/**
 * The function lunched on plugin activation. It will create all default options
 * 
 * @author Benjamin Niess
 */
function SGFW_Install(){
	//enable default features on plugin activation
	$ips_options = get_option ( SGFW_OPTIONS );
	if ( empty( $ips_options ) ) {
		update_option( SGFW_OPTIONS, array( 'show_close_button' => 1, 'width' => 640, 'height' => 480, 'background_color' => '000', 'show_counter' => 1, 'show_info' => 1, 'autoplay' => 0, 'autoplay_time' => 3000 ) );
	}
}