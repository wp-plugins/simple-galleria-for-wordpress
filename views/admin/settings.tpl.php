<div class="wrap" id="sgfw_options">
	<?php self::display_message(); ?>
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
				<th class="label" scope="row"><label for="sgfw[background_color]"><span class="alignleft"><?php _e('Background color', 'sgfw'); ?></span></label></th>
				<td># <input id="sgfw[background_color]" style="width:65px;" type="text" maxlength="6" name="sgfw[background_color]" value="<?php echo isset(  $sgfw_options['background_color'] ) ? esc_attr( $sgfw_options['background_color'] ) : ''; ?>" /></td>
			</tr>
			
			<tr valign="top" class="field">
				<th class="label" scope="row"><label for="sgfw[show_counter]"><span class="alignleft"><?php _e('Show the images counter', 'sgfw'); ?></span></label></th>
				<td><input id="sgfw[show_counter]" type="checkbox" <?php checked( isset( $sgfw_options['show_counter'] ) ? (int) $sgfw_options['show_counter'] : '' , 1 ); ?> name="sgfw[show_counter]" value="1" /></td>
			</tr>
			
			<tr valign="top" class="field">
				<th class="label" scope="row"><label for="sgfw[show_info]"><span class="alignleft"><?php _e('Show info button displaying the image description', 'sgfw'); ?></span></label></th>
				<td><input id="sgfw[show_info]" type="checkbox" <?php checked( isset( $sgfw_options['show_info'] ) ? (int) $sgfw_options['show_info'] : '' , 1 ); ?> name="sgfw[show_info]" value="1" /></td>
			</tr>
			
			<tr valign="top" class="field">
				<th class="label" scope="row"><label for="sgfw[show_close_button]"><span class="alignleft"><?php _e('Show the close button at the top of the lightbox', 'sgfw'); ?></span></label></th>
				<td><input id="sgfw[show_close_button]" type="checkbox" <?php checked( isset( $sgfw_options['show_close_button'] ) ? (int) $sgfw_options['show_close_button'] : '' , 1 ); ?> name="sgfw[show_close_button]" value="1" /></td>
			</tr>
			
			<tr valign="top" class="field">
				<th class="label" scope="row"><label for="sgfw[autoplay]"><span class="alignleft"><?php _e('Autoplay ?', 'sgfw'); ?></span></label></th>
				<td><input id="sgfw[autoplay]" type="checkbox" <?php checked( isset( $sgfw_options['autoplay'] ) ? (int) $sgfw_options['autoplay'] : '' , 1 ); ?> name="sgfw[autoplay]" value="1" /></td>
			</tr>
			
			<tr valign="top" class="field">
				<th class="label" scope="row"><label for="sgfw[autoplay_time]"><span class="alignleft"><?php _e('Autoplay time', 'sgfw'); ?></span></label></th>
				<td><input id="sgfw[autoplay_time]" type="number" min="500" max="60000" name="sgfw[autoplay_time]" value="<?php echo isset(  $sgfw_options['autoplay_time'] ) ? (int)$sgfw_options['autoplay_time'] : '3000'; ?>" /> px</td>
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