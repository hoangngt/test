<?php

global $woocommerce_loop;

$woocommerce_loop['loop'] = 0;
$woocommerce_loop['show_products'] = true;

if (!isset($woocommerce_loop['columns']) || !$woocommerce_loop['columns']) $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 3);
remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
add_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering' );

if (isset($_COOKIE['products_cookie']) && $_COOKIE['products_cookie'] == "list")
	$product_view = "list";
else
	$product_view = "grid";
	
?>
<div class="list-options">
	<?php if(of_get_option('show_grid_view') == true) { ?>
	<div class="float-left">
		<img src="<?php echo THEME_DIR; ?>/images/icon_grid.png"/><a href="#" id="switch-to-grid" class="regular<?php if($product_view == "grid") { ?> active-view<?php } ?>"><?php _e('View as grid', 'woocommerce'); ?></a>
		<img src="<?php echo THEME_DIR; ?>/images/icon_list.png"/><a href="#" id="switch-to-list" class="regular<?php if($product_view == "list") { ?> active-view<?php } ?>"><?php _e('View as list', 'woocommerce'); ?></a>
	</div><?php } ?>
	
	<div class="float-right sortby">
		<?php do_action('woocommerce_before_shop_loop'); ?>
	</div>
</div>

<ul id="woo-product-items" class="products <?php echo $product_view ?>-view">
<div class="list-items">
	<?php 
	
	do_action('woocommerce_before_shop_loop_products');
	
	if ($woocommerce_loop['show_products'] && have_posts()) : while (have_posts()) : the_post(); 
	
		global $product;
		
		if (!$product->is_visible()) continue; 
		
		$woocommerce_loop['loop']++;
		
		?>
		<li class="single-item<?php if ($woocommerce_loop['loop']%$woocommerce_loop['columns']==0) echo ' last'; if (($woocommerce_loop['loop']-1)%$woocommerce_loop['columns']==0) echo ' first'; ?>">
			
			<?php do_action('woocommerce_before_shop_loop_item'); ?>
			<span class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></span>
			<?php do_action('woocommerce_after_shop_loop_item_title'); ?>
			<?php if(!apply_filters( 'woocommerce_short_description', $post->post_excerpt ) == "") { ?><span class="archive_desc"><?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?><a href="<?php the_permalink() ?>" class="regular"><?php _e('View more...', 'woocommerce'); ?></a></span><?php } ?>
			<div class="list-item-image"><?php do_action('woocommerce_before_shop_loop_item_title'); ?></div>
			<?php do_action('woocommerce_after_shop_loop_item'); ?>
			<span class="list-link">
				<a href="<?php the_permalink() ?>" class="regular"><?php _e('View more...', 'woocommerce'); ?></a>
			</span>
			<br class="clear"/>
		</li><?php 
		if ($woocommerce_loop['loop']%$woocommerce_loop['columns']==0) echo '</div><div class="list-items">';
	endwhile; endif;
	
	if ($woocommerce_loop['loop']==0) echo '<li class="woocommerce_info">'.__('No products found which match your selection.', 'woocommerce').'</li>'; 

	?>
</div>
</ul>

<div class="clear"></div>

<?php do_action('woocommerce_after_shop_loop'); ?>