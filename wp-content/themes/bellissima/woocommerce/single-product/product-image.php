<?php
/**
 * Single Product Image
 */

global $post, $woocommerce;

?>
<!-- Product Gallery Begin -->
<div class="product-gallery float-left images">
	<div id="exposure"></div>
	<div class="panel">
		<div id="controls"></div>
		<div id="slideshow"></div>
		<ul id="images">
		
			
			<?php $cropornot = (get_option('woocommerce_single_image_crop')==1) ? true : false; if ( has_post_thumbnail() ) : $thumb_id = get_post_thumbnail_id(); $large_thumbnail_size = apply_filters('single_product_large_thumbnail_size', 'shop_single'); ?>
			
			<li><a data-id="<?php echo wp_get_attachment_url( $thumb_id ); ?>" itemprop="image" href="<?php echo aq_resize(wp_get_attachment_url( $thumb_id ), $woocommerce->get_image_size('shop_single_image_width'), $woocommerce->get_image_size('shop_single_image_height'), $cropornot) ?>" title="<?php echo get_the_title( $thumb_id ); ?>"><img src="<?php echo aq_resize(wp_get_attachment_url( $thumb_id ), 60, 60, true) ?>" alt="<?php echo get_the_title( $thumb_id ); ?>" /></a></li>

			<?php else : $default_thumb = woocommerce_placeholder_img_src(); ?>
			
			<li><a data-id="<?php echo $default_thumb ?>" href="<?php echo $default_thumb ?>"><img src="<?php echo THEME_DIR ?>/images/default-thumb.jpg" alt="Placeholder" /></a></li>
			
			<?php endif; ?>

			<?php do_action('woocommerce_product_thumbnails'); ?>
		</ul>
	</div>
</div>
<!-- Product Gallery End -->

<div class="text-info">