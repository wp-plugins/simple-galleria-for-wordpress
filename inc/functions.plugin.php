<?php 
function SGFW_Install(){
	
	//enable default features on plugin activation
	$ips_options = get_option ( SGFW_OPTIONS );
	if ( empty( $ips_options ) )
		update_option( SGFW_OPTIONS, array( 'show_close_button' => 1, 'width' => 640, 'height' => 480, 'overlay_color' => 'CCC', 'background_color' => '000' ) );
}

?>