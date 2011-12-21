<?php
Class SimpleGalleriaForWordpress_Admin {

	function __construct() {
		add_action ( 'init', array( &$this, 'init' ) );
	}
	
	/**
	 * Init admin class
	 * 
	 * @access public
	 * @return void
	 * @author Benjamin Niess
	 */
	function init() {
		add_action( 'admin_menu', array( &$this, 'add_menu' ) );
		add_action( 'admin_init', array( &$this, 'checkChanges') );
	}
	
	/*
	 * Add the galleria admin menu
	 */
	function add_menu() {
		add_options_page( __( 'Simple Galleria for WordPress', 'sgfw' ), __( 'Simple Galleria', 'sgfw'), 'manage_options', 'simple-galleria-for-wordpress', array( &$this, 'pageManage' ) );
	}
	
	/**
	 * Display options on admin
	 *
	 * @return void
	 * @author Benjamin Niess
	 */
	function pageManage() {
		// Display message
		$this->displayMessage();
		
		// Current settings
		$sgfw_options = get_option( SGFW_OPTIONS );
		?>
		<div class="wrap" id="sgfw_options">
			<h2><?php _e('Simple Galleria for WordPress: Settings', 'sgfw'); ?></h2>
			
			<form method="post" action="#">
				<table class="form-table describe">
					
					<tr valign="top" class="field">
						<th class="label" scope="row"><label for="sgfw[width]"><span class="alignleft"><?php _e('Width', 'sgfw'); ?></span></label></th>
						<td><input id="sgfw[width]" type="number" min="0" max="2000" name="sgfw[width]" value="<?php echo isset(  $sgfw_options['width'] ) ? (int)$sgfw_options['width'] : ''; ?>" /> px</td>
					</tr>
					
					<tr valign="top" class="field">
						<th class="label" scope="row"><label for="sgfw[height]"><span class="alignleft"><?php _e('Height', 'sgfw'); ?></span></label></th>
						<td><input id="sgfw[height]" type="number" min="0" max="2000" name="sgfw[height]" value="<?php echo isset(  $sgfw_options['height'] ) ? (int)$sgfw_options['height'] : ''; ?>" /> px</td>
					</tr>
					
					<tr valign="top" class="field">
						<th class="label" scope="row"><label for="sgfw[overlay_color]"><span class="alignleft"><?php _e('Overlay color', 'sgfw'); ?></span></label></th>
						<td># <input id="sgfw[overlay_color]" style="width:65px;" type="text" maxlength="6" name="sgfw[overlay_color]" value="<?php echo isset(  $sgfw_options['overlay_color'] ) ? esc_attr( $sgfw_options['overlay_color'] ) : ''; ?>" /></td>
					</tr>
					
					<tr valign="top" class="field">
						<th class="label" scope="row"><label for="sgfw[background_color]"><span class="alignleft"><?php _e('Background color', 'sgfw'); ?></span></label></th>
						<td># <input id="sgfw[background_color]" style="width:65px;" type="text" maxlength="6" name="sgfw[background_color]" value="<?php echo isset(  $sgfw_options['background_color'] ) ? esc_attr( $sgfw_options['background_color'] ) : ''; ?>" /></td>
					</tr>
					
					<tr valign="top" class="field">
						<th class="label" scope="row"><label for="sgfw[show_close_button]"><span class="alignleft"><?php _e('Show the close button at the top of the lightbox', 'sgfw'); ?></span></label></th>
						<td><input id="sgfw[show_close_button]" type="checkbox" <?php checked( isset( $sgfw_options['show_close_button'] ) ? (int) $sgfw_options['show_close_button'] : '' , 1 ); ?> name="sgfw[show_close_button]" value="1" /></td>
					</tr>
					
					</tr>
						<td>
							<p class="submit">
								<?php wp_nonce_field( 'sgfw-update-options'); ?>
								<input type="hidden" name="save-sgfw" value="1" />
								<input type="submit" name="save" class="button-primary" value="<?php _e('Save Changes', 'sgfw') ?>" />
							</p>
						</td>
					<tr>
					
					
				</table>
				
			</form>
		</div>
		<?php
		return true;
	}

	/**
	 * Check $_POST datas 
	 * 
	 * @return boolean
	 */
	function checkChanges() {
		if ( isset($_POST['save-sgfw']) ) {
			
			check_admin_referer( 'sgfw-update-options' );

			if ( !isset( $_POST['sgfw'] ) || !is_array( $_POST['sgfw'] ) )
				return false;
			
			$sgfw_options = array();
			foreach ( $_POST['sgfw'] as $option_key => $option_value ) {
				$sgfw_options[esc_attr( $option_key )] = esc_attr( $option_value );
			}
				
			// Save settings
			$this->message = __('Settings updated with success !', 'sgfw');
			update_option( SGFW_OPTIONS, $sgfw_options );
		}
		return false;
	}

	/**
	 * Display WP alert
	 *
	 */
	function displayMessage() {
		if ( $this->message != '') {
			$message = $this->message;
			$status = $this->status;
			$this->message = $this->status = ''; // Reset
		}
		
		if ( isset($message) && !empty($message) ) {
		?>
			<div id="message" class="<?php echo ($status != '') ? $status :'updated'; ?> fade">
				<p><strong><?php echo $message; ?></strong></p>
			</div>
		<?php
		}
	}
	
}
?>