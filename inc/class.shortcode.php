<?php
Class SimpleGalleriaForWordpress_Shortcodes {

	function __construct() {
		add_action ( 'init', array( __CLASS__, 'init' ) );
	}
	
	/**
	 * Init shortcode function
	 * 
	 * @access public
	 * @return void
	 * @author Benjamin Niess
	 */
	public static function init() {
		remove_shortcode('gallery');
		add_shortcode('gallery', array( __CLASS__, 'gallery_shortcode' ) );
	}
	
	
	
	/**
	 * The Simple Galleria shortcode function.
	 *
	 */
	function gallery_shortcode( $attr ) {
		global $post, $wp_locale;
		
		$sgfw_options = get_option( SGFW_OPTIONS );
		$options = array();
		$options['background_color'] = ( isset ( $sgfw_options['background_color'] ) && !empty( $sgfw_options['background_color'] ) ) ? esc_attr( $sgfw_options['background_color'] ) : '000';
		$options['width'] = ( isset ( $sgfw_options['width'] ) && (int) $sgfw_options['width'] > 0 ) ? (int) $sgfw_options['width'] : '640';
		$options['height'] = ( isset ( $sgfw_options['height'] ) && (int) $sgfw_options['height'] > 0 ) ? (int) $sgfw_options['height'] : '480';
		$options['show_close_button'] = ( isset ( $sgfw_options['show_close_button'] ) && (int) $sgfw_options['show_close_button'] == 1 ) ? 'true' : 'false';
		$options['show_counter'] = ( isset ( $sgfw_options['show_counter'] ) && (int) $sgfw_options['show_counter'] == 1 ) ? 'true' : 'false';
		$options['show_info'] = ( isset ( $sgfw_options['show_info'] ) && (int) $sgfw_options['show_info'] == 1 ) ? 'true' : 'false';
		$options['autoplay'] = ( isset ( $sgfw_options['autoplay'] ) && (int) $sgfw_options['autoplay'] == 1 && isset ( $sgfw_options['autoplay_time'] ) && (int) $sgfw_options['autoplay_time'] > 0 ) ? (int) $sgfw_options['autoplay_time'] : 'false';
		
		static $instance = 0;
		$instance++;
	
		// Allow plugins/themes to override the default gallery template.
		$output = apply_filters('post_gallery', '', $attr);
		if ( $output != '' )
			return $output;
	
		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		}
	
		extract(shortcode_atts(array(
			'order'	  => 'ASC',
			'orderby'	=> 'menu_order ID',
			'id'		 => $post->ID,
			'itemtag'	=> 'dl',
			'icontag'	=> 'dt',
			'captiontag' => 'dd',
			'columns'	=> 3,
			'size'	   => 'thumbnail',
			'include'	=> '',
			'exclude'	=> ''
		), $attr));
	
		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';
	
		if ( !empty($include) ) {
			$include = preg_replace( '/[^0-9,]+/', '', $include );
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	
			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}
	
		if ( empty($attachments) )
			return '';
	
		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}
	
		$itemtag = tag_escape($itemtag);
		$captiontag = tag_escape($captiontag);
		$columns = intval($columns);
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';
	
		$selector = "gallery-{$instance}";
	
		$gallery_style = $gallery_div = '';
		if ( apply_filters( 'use_default_gallery_style', true ) )
			$gallery_style = "
			<style type='text/css'>
				#{$selector} {
					margin: auto;
				}
				#{$selector} .gallery-item {
					float: {$float};
					margin-top: 10px;
					text-align: center;
					width: {$itemwidth}%;
				}
				#{$selector} img {
					border: 2px solid #cfcfcf;
				}
				#{$selector} .gallery-caption {
					margin-left: 0;
				}
			</style>
			<!-- see gallery_shortcode() in wp-includes/media.php -->";
		$size_class = sanitize_html_class( $size );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
		$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
	
		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
	
			$output .= "<{$itemtag} class='gallery-item colorbox' href='#" .$selector . "-galleria'>";
			$output .= "
				<{$icontag} class='gallery-icon'>
					$link
				</{$icontag}>";
			if ( $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption'>
					" . wptexturize($attachment->post_excerpt) . "
					</{$captiontag}>";
			}
			$output .= "</{$itemtag}>";
			if ( $columns > 0 && ++$i % $columns == 0 )
				$output .= '<br style="clear: both" />';
		}
	
		$output .= "
				<br style='clear: both;' />
			</div>\n";
			
		/*
		 * End of default gallery shortcode
		 * 
		 * Custom code for the galleria library
		 */
		
		// The container for the galleria
		$output .= '<div style="display:none"><div id="' . $selector . '-galleria"></div></div>';
		
		// Write the JS code
		$output .= "<script>
		var data = ";
		
		$items_array = array();
		foreach ( $attachments as $id => $attachment ) {
			$image = wp_get_attachment_image_src($id, 'thumbnail');
			$image = $image[0];
			$image_big = wp_get_attachment_image_src($id, 'large');
			$image_big = $image_big[0];
			$args = array(
				'post_id' => $post->ID,
				'selector' => $selector . "-galleria",
				'image_id' => $id,
				'image' => $image_big,
				'thumb' => $image,
				'title' => $attachment->post_title,
				'link' => $attachment->guid,
				'description' => wptexturize($attachment->post_excerpt),
				
			);
			// Hook for add custom params to the json array 
			$items_array[] = apply_filters( 'sgfw_args' , $args);
		}
		
		$output .= json_encode( $items_array );
		$output .= ";\n"; 
		
		$output .= "jQuery('#" . $selector . "-galleria').galleria({
			data_source: data,
			height: " . $options['height'] . ",
			width: " . $options['width'] . ",
			clicknext: true,
			showCounter: " . $options['show_counter'] . ",
			autoplay: " . $options['autoplay'] . ",
			showInfo: " . $options['show_info'] . "
		});";
		 
		
		// Hook for add custom JS
		$output .= apply_filters( 'sgfw_custom_js' , '');
		
		$output .= "jQuery(document).ready(function() {
			jQuery('#" . $selector . "-galleria .galleria-container').css('background-color', '#" . $options['background_color'] . "');
			jQuery('.colorbox').colorbox( {
				'inline' : true,
				'closeButton' : " . $options['show_close_button'] . "

			});
		});
		
		Galleria.ready(function(e) {
			jQuery('#" . $selector . "-galleria .galleria-container').css({'background-color': '#" . $options['background_color'] . "'});
		});
		
		</script>";
	
		return $output;
		
	}
}