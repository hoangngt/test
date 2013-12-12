<?php
/**
 * Cart Page
 */
 
global $woocommerce;
?>

<?php $woocommerce->show_messages(); ?>

<form action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post">
<?php do_action( 'woocommerce_before_cart_table' ); ?>
<div class="full-width-content">
<table class="shop_table cart" cellpadding="0" cellspacing="0">
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>
		
		<tr>
			<td class="product-remove"><span class="heading">Remove</span></td>
			<td class="product-thumbnail"&nbsp;></td>
			<td class="product-name"><span class="heading">Products</span></td>
			<td class="product-price"><span class="heading">Unit Price</span></td>
			<td class="product-quantity"><span class="heading">Quantity</span></td>
			<td class="product-subtotal"><span class="heading">Price</span></td>
		</tr>
		
		<?php
		if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
			foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
				$_product = $values['data'];
				
				$image_url = wp_get_attachment_image_src(get_post_thumbnail_id( $_product->id ),'full');
				$image_url = $image_url[0];
				 
				if ( $_product->exists() && $values['quantity'] > 0 ) {
					?>
					<tr>
						<!-- Remove from cart link -->
						<td class="product-remove">
							<?php 
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&nbsp;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'woocommerce') ), $cart_item_key ); 
							?>
						</td>
						
						<!-- The thumbnail -->
						<td class="product-thumbnail">
							<?php 
								printf('<a href="%s"><img src="%s" alt="" /></a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), aq_resize($image_url, 60, 60, true) ); 
							?>
						</td>
						
						<!-- Product Name -->
						<td class="product-name">
							<?php 
								printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), apply_filters('woocommerce_in_cart_product_title', $_product->get_title(), $_product) );
							
								// Meta data
								echo $woocommerce->cart->get_item_data( $values );
                   				
                   				// Backorder notification
                   				if ( $_product->backorders_require_notification() && $_product->get_total_stock() < 1 ) 
                   					echo '<p class="backorder_notification">' . __('Available on backorder.', 'woocommerce') . '</p>';
							?>
						</td>
						
						<!-- Product price -->
						<td class="product-price">
							<?php 							
								$product_price = ( get_option('woocommerce_display_cart_prices_excluding_tax') == 'yes' ) ? $_product->get_price_excluding_tax() : $_product->get_price();
							
								echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $values, $cart_item_key ); 
							?>
						</td>
						
						<!-- Quantity inputs -->
						<td class="product-quantity">
							<?php 
								if ( $_product->is_sold_individually() ) {
									$product_quantity = '1';
								} else {
									$data_min = apply_filters( 'woocommerce_cart_item_data_min', '', $_product );
									$data_max = ( $_product->backorders_allowed() ) ? '' : $_product->get_stock_quantity();
									$data_max = apply_filters( 'woocommerce_cart_item_data_max', $data_max, $_product ); 
									
									$product_quantity = sprintf( '<div class="quantity"><input name="cart[%s][qty]" data-min="%s" data-max="%s" value="%s" size="4" title="Qty" class="input-text qty text" maxlength="12" /></div>', $cart_item_key, $data_min, $data_max, esc_attr( $values['quantity'] ) );
								}
								
								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key ); 					
							?>
						</td>
						
						<!-- Product subtotal -->
						<td class="product-subtotal">
							<?php 
								echo $woocommerce->cart->get_product_subtotal( $_product, $values['quantity'] ); 
							?>
						</td>
					</tr>
					<?php
				}
			}
		}
		
		do_action( 'woocommerce_cart_contents' );
		
		if ( get_option( 'woocommerce_enable_coupons' ) == 'yes' ) { 
		?>
		<tr class="promo">
			<td colspan="4" class="product-price"><span class="grey"><label for="coupon_code"><?php _e('Enter coupon code', 'woocommerce'); ?>:</label></span></td>
			<td class="product-quantity"><input type="text" name="coupon_code" class="input-text input-text-grey cart-field" id="coupon_code" value="" /></td>
			<td class="product-subtotal"><input type="submit" class="button" name="apply_coupon" value="<?php _e('Apply', 'woocommerce'); ?>" /><?php do_action('woocommerce_cart_coupon'); ?></td>
		</tr>
		<?php } ?>
		
		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>
<?php woocommerce_cart_totals(); ?>

<div class="submit-buttons">
<?php echo do_shortcode('[raw]'); ?>
<?php $woocommerce->nonce_field('cart') ?>
<input type="submit" class="button" name="update_cart" value="<?php _e('Update', 'woocommerce'); ?>" />
<a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="checkout-button button alt"><?php _e('Checkout &rarr;', 'woocommerce'); ?></a>
<?php echo do_shortcode('[/raw]'); ?>
</div>

<div class="clear"></div>

<?php do_action('woocommerce_proceed_to_checkout'); ?>
</div>
<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>
<div class="cart-collaterals">
	
	<?php do_action('woocommerce_cart_collaterals'); ?>
	
	<?php woocommerce_shipping_calculator(); ?>
	
</div>