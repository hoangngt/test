<?php
/**
 * Single Product Thumbnails
 */

global $post, $woocommerce;
?>
<?php
	$attachments = get_posts( array(
		'post_type' 	=> 'attachment',
		'numberposts' 	=> -1,
		'post_status' 	=> null,
		'post_parent' 	=> $post->ID,
		'post__not_in'	=> array( get_post_thumbnail_id() ),
		'post_mime_type'=> 'image',
		'orderby'		=> 'menu_order',
		'order'			=> 'ASC'
	) );
	if ($attachments) {
		
		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
		
		foreach ( $attachments as $key => $attachment ) {
			
			if ( get_post_meta( $attachment->ID, '_woocommerce_exclude_image', true ) == 1 ) 
				continue;
				
			$classes = array( 'zoom' );
			
			if ( $loop == 0 || $loop % $columns == 0 ) 
				$classes[] = 'first';
			
			if ( ( $loop + 1 ) % $columns == 0 ) 
				$classes[] = 'last';
				
			$cropornot = (get_option('woocommerce_single_image_crop')==1) ? true : false;

			printf( '<li><a data-id="%s" href="%s" title="%s" rel="thumbnails" class="%s"><img src="%s" alt="" /></a></li>', wp_get_attachment_url( $attachment->ID ), aq_resize(wp_get_attachment_url( $attachment->ID ), $woocommerce->get_image_size('shop_single_image_width'), $woocommerce->get_image_size('shop_single_image_height'), $cropornot), esc_attr( $attachment->post_title ), implode(' ', $classes), aq_resize(wp_get_attachment_url( $attachment->ID ), 60, 60, true) );
			
			$loop++;

		}
		
	}
?>