<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @package WooCommerce
 * @since WooCommerce 1.6
 */
 
global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) 
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) 
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );

// Ensure visibilty
if ( ! $product->is_visible() ) 
	return; 

// Increase loop count
$woocommerce_loop['loop']++;
?>
<?php if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 ) { ?><div class="list-items"><?php }?>
<li class="single-item <?php 
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 ) 
		echo 'last'; 
	elseif ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 ) 
		echo 'first'; 
	?>">

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	
	<span class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></span>
	
	<?php
		/** 
		 * woocommerce_after_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_template_loop_price - 10
		 */	  
		do_action( 'woocommerce_after_shop_loop_item_title' ); 
	?>
	
	<?php if(!apply_filters( 'woocommerce_short_description', $post->post_excerpt ) == "") { ?><span class="archive_desc"><?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?><a href="<?php the_permalink() ?>" class="regular"><?php _e('View more...', 'woocommerce'); ?></a></span><?php } ?>
	
	<div class="list-item-image"><a href="<?php the_permalink() ?>"><?php
		/** 
		 * woocommerce_before_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */	  
		do_action( 'woocommerce_before_shop_loop_item_title' ); 
	?></a></div>
	
	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	
	<span class="list-link">
		<a href="<?php the_permalink() ?>" class="regular"><?php _e('View more...', 'woocommerce'); ?></a>
	</span>

</li>
<?php if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 ) { ?></div><?php }?>