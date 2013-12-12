<?php get_header('shop');
remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
add_action( 'woocommerce_before_shop_loop' , 'woocommerce_catalog_ordering' );

if (isset($_COOKIE['products_cookie']) && $_COOKIE['products_cookie'] == "list")
	$product_view = "list";
else
	$product_view = "grid";
 ?>

<?php do_action('woocommerce_before_main_content'); ?>

<?php do_action('woocommerce_sidebar'); ?>

<div class="main-content<?php if(of_get_option('page_layout') == 'right') echo ' main-content-left'; ?> theme-shop">
		<h1 class="page-title">
			<?php if ( is_search() ) : ?>
				<?php 
					printf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() ); 
					if ( get_query_var( 'paged' ) )
						printf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );
				?>
			<?php elseif ( is_tax() ) : ?>
				<?php echo single_term_title( "", false ); ?>
			<?php else : ?>
				<?php 
					$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
					
					echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
				?>
			<?php endif; ?>
		</h1>
				
		<?php if ( is_tax() && get_query_var( 'paged' ) == 0 ) : ?>
			<?php echo '<div class="term-description">' . wpautop( wptexturize( term_description() ) ) . '</div>'; ?>
		<?php elseif ( ! is_search() && get_query_var( 'paged' ) == 0 && ! empty( $shop_page ) && is_object( $shop_page ) ) : ?>
			<?php echo '<div class="page-description">' . apply_filters( 'the_content', $shop_page->post_content ) . '</div>'; ?>
		<?php endif; ?>
				
		<?php if ( have_posts() ) : ?>
		
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

					<?php woocommerce_product_subcategories(); ?>
			
					<?php while ( have_posts() ) : the_post(); ?>
			
						<?php woocommerce_get_template_part( 'content', 'product' ); ?>
			
					<?php endwhile; // end of the loop. ?>

			</ul>

			<?php do_action('woocommerce_after_shop_loop'); ?>
		
		<?php else : ?>
		
			<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>
					
				<p><?php _e( 'No products found which match your selection.', 'woocommerce' ); ?></p>
					
			<?php endif; ?>
		
		<?php endif; ?>
		
		<div class="clear"></div>
		
		<?php 
			/** 
			 * woocommerce_pagination hook
			 *
			 * @hooked woocommerce_pagination - 10
			 * @hooked woocommerce_catalog_ordering - 20
			 */		
			do_action( 'woocommerce_pagination' ); 
		?>
</div>

<br class="clear" />

<?php do_action('woocommerce_after_main_content'); ?>

<?php get_footer('shop'); ?>