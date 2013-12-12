<?php
/**
 * Cart Totals
 */
 
global $woocommerce;

$available_methods = $woocommerce->shipping->get_available_shipping_methods();
?>
<div class="cart_totals <?php if ( $woocommerce->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">
	
	<?php do_action('woocommerce_before_cart_totals'); ?>
	
	<?php if ( ! $woocommerce->shipping->enabled || $available_methods || ! $woocommerce->customer->get_shipping_country() || ! $woocommerce->customer->has_calculated_shipping() ) : ?>
		<table cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr class="cart-subtotal">
					<td colspan="4" class="product-price"></td>
					<td class="product-quantity"><span class="summary"><?php _e('Cart Subtotal', 'woocommerce'); ?></span></td>
					<td class="product-subtotal"><span class="summary"><?php echo $woocommerce->cart->get_cart_subtotal(); ?></span></td>
				</tr>
				
				<?php if ($woocommerce->cart->get_discounts_before_tax()) : ?>
				
				<tr class="discount">
					<td colspan="4" class="product-price"></td>
					<td class="product-quantity"><span class="summary"><?php _e('Cart Discount', 'woocommerce'); ?></span> <a href="<?php echo add_query_arg('remove_discounts', '1', $woocommerce->cart->get_cart_url()) ?>"><?php _e('[Remove]', 'woocommerce'); ?></a></td>
					<td class="product-subtotal"><span class="summary">-<?php echo $woocommerce->cart->get_discounts_before_tax(); ?></span></td>
				</tr>
				
				<?php endif; ?>
				
				<?php if ( $woocommerce->cart->needs_shipping() && $woocommerce->cart->show_shipping() && ( $available_methods || get_option( 'woocommerce_enable_shipping_calc' ) == 'yes' ) ) { ?>
				
				<tr class="shipping">
					<td colspan="4" class="product-price"></td>
					<td class="product-quantity"><span class="summary"><?php _e('Shipping', 'woocommerce'); ?></span></td>
					<td class="product-subtotal"><?php
						// If at least one shipping method is available
						if ( $available_methods ) {

							// Prepare text labels with price for each shipping method
							foreach ( $available_methods as $method ) {
								$method->full_label = esc_html( $method->label );

								if ( $method->cost > 0 ) {
									$method->full_label .= ' &mdash; ';

									// Append price to label using the correct tax settings
									if ( $woocommerce->cart->display_totals_ex_tax || ! $woocommerce->cart->prices_include_tax ) {
										$method->full_label .= woocommerce_price( $method->cost );
										if ( $method->get_shipping_tax() > 0 && $woocommerce->cart->prices_include_tax ) {
											$method->full_label .= ' '.$woocommerce->countries->ex_tax_or_vat();
										}
									} else {
										$method->full_label .= woocommerce_price( $method->cost + $method->get_shipping_tax() );
										if ( $method->get_shipping_tax() > 0 && ! $woocommerce->cart->prices_include_tax ) {
											$method->full_label .= ' '.$woocommerce->countries->inc_tax_or_vat();
										}
									}
								}
							}

							// Print a single available shipping method as plain text
							if ( 1 === count( $available_methods ) ) {

								echo '<span class="summary">' . $method->full_label . '</span>';
								echo '<input type="hidden" name="shipping_method" id="shipping_method" value="'.esc_attr( $method->id ).'">';

							// Show multiple shipping methods in a select list
							} else {
								if ( get_option('woocommerce_shipping_method_format') == 'select' ) {
									echo '<select name="shipping_method" id="shipping_method">';
									foreach ( $available_methods as $method ) {
										echo '<option value="'.esc_attr( $method->id ).'" '.selected( $method->id, $_SESSION['_chosen_shipping_method'], false).'>';
										echo strip_tags( $method->full_label );
										echo '</option>';
									}
									echo '</select>';
								}
								else {
									echo '<ul id="shipping_method">';
									
									foreach ( $available_methods as $method )
										echo '<li><input type="radio" name="shipping_method" id="shipping_method_' . sanitize_title( $method->id ) . '" value="' . esc_attr( $method->id ) . '" ' . checked( $method->id, $_SESSION['_chosen_shipping_method'], false) . ' /> <label for="shipping_method_' . sanitize_title( $method->id ) . '">' . $method->full_label . '</label></li>';
									
									echo '</ul>';
								}								
							}

						// No shipping methods are available
						} else {

							if ( ! $woocommerce->customer->get_shipping_country() || ! $woocommerce->customer->get_shipping_state() || ! $woocommerce->customer->get_shipping_postcode() ) {
								echo '<p>'.__('Please fill in your details to see available shipping methods.', 'woocommerce').'</p>';
							} else {
								echo '<p>'.__('Sorry, it seems that there are no available shipping methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce').'</p>';
							}

						}
					?></td>
					
				</tr>
	
				<?php } ?>
				
				<?php 
					if ( get_option('woocommerce_display_cart_taxes') == 'yes' && $woocommerce->cart->get_cart_tax() ) :
						
						$taxes = $woocommerce->cart->get_taxes();
						
						if (sizeof($taxes)>0) :
						
							$has_compound_tax = false;
							
							foreach ($taxes as $key => $tax) : 
								if ($woocommerce->cart->tax->is_compound( $key )) : $has_compound_tax = true; continue; endif;
								if ($tax==0) continue;
								?>
								<tr class="tax-rate tax-rate-<?php echo $key; ?>">
									<td colspan="4" class="product-price"></td>
									<td class="product-quantity"><span class="summary">
										<?php
										if ( get_option( 'woocommerce_display_totals_excluding_tax' ) == 'no' && get_option( 'woocommerce_prices_include_tax' ) == 'yes' ) {
											_e( 'incl.', 'woocommerce' );
										}
										echo $woocommerce->cart->tax->get_rate_label( $key );
										?>
									</span></td>
									<td class="product-subtotal"><span class="summary"><?php echo woocommerce_price($tax); ?></span></td>
								</tr>
								<?php
								
							endforeach;
							
							if ($has_compound_tax && !$woocommerce->cart->prices_include_tax) :
								?>
								<tr class="order-subtotal">
									<td colspan="4" class="product-subtotal"></td>
									<td class="product-quantity"><span class="summary"><?php _e('Subtotal', 'woocommerce'); ?></span></td>
									<td class="product-subtotal"><span class="summary"><?php echo $woocommerce->cart->get_cart_subtotal( true ); ?></span></td>
								</tr>
								<?php
							endif;
							
							foreach ($taxes as $key => $tax) : 
								if (!$woocommerce->cart->tax->is_compound( $key )) continue;
								if ($tax==0) continue;
								?>
								<tr class="tax-rate tax-rate-<?php echo $key; ?>">
									<td colspan="4" class="product-price"></td>
									<td class="product-quantity"><span class="summary">
										<?php
										if ( get_option( 'woocommerce_display_totals_excluding_tax' ) == 'no' && get_option( 'woocommerce_prices_include_tax' ) == 'yes' ) {
											_e( 'incl.', 'woocommerce' );
										}
										echo $woocommerce->cart->tax->get_rate_label( $key );
										?>
									</span></td>
									<td class="product-subtotal"><span class="summary"><?php echo woocommerce_price($tax); ?></span></td>
								</tr>
								<?php
								
							endforeach;
						
						else :
						
							?>
							<tr class="tax">
								<td colspan="4" class="product-price"></td>
								<td class="product-quantity"><span class="summary"><?php _e('Tax', 'woocommerce'); ?></span></td>
								<td class="product-subtotal"><span class="summary"><?php echo $woocommerce->cart->get_cart_tax(); ?></span></td>
							</tr>
							<?php
						
						endif;	
					elseif ( get_option('woocommerce_display_cart_taxes_if_zero') == 'yes' ) :
						
						?>
						<tr class="tax">
							<td colspan="4" class="product-price"></td>
							<td class="product-quantity"><span class="summary"><?php _e('Tax', 'woocommerce'); ?></span></td>
							<td class="product-subtotal"><span class="summary"><?php _ex( 'N/A', 'Relating to tax', 'woocommerce' ); ?></span></td>
						</tr>
						<?php
							
					endif;
				?>
	
				<?php if ($woocommerce->cart->get_discounts_after_tax()) : ?>
				
				<tr class="discount">
					<td colspan="4" class="product-price"></td>
					<td class="product-quantity"><span class="summary"><?php _e('Order Discount', 'woocommerce'); ?> <a href="<?php echo add_query_arg('remove_discounts', '2', $woocommerce->cart->get_cart_url()) ?>"><?php _e('[Remove]', 'woocommerce'); ?></a></span></td>
					<td class="product-subtotal"><span class="summary">-<?php echo $woocommerce->cart->get_discounts_after_tax(); ?></span></td>
				</tr>
				
				<?php endif; ?>
				
				<tr class="total">
					<td colspan="4" class="product-price"></td>
					<td class="product-quantity"><span class="summary"><?php _e('Order Total', 'woocommerce'); ?></strong></th>
					<td class="product-subtotal"><span class="summary"><strong><?php 
						
						if (get_option('woocommerce_display_cart_taxes')=='no' && !$woocommerce->cart->prices_include_tax) :
							echo $woocommerce->cart->get_total_ex_tax(); 
						else :
							echo $woocommerce->cart->get_total(); 
						endif;
						
					?></span></td>
				</tr>
				
			</tbody>
		</table>
		
		<p class="float-right"><small><?php 
		
			$estimated_text = ( $woocommerce->customer->is_customer_outside_base() && ! $woocommerce->customer->has_calculated_shipping() ) ? sprintf( ' ' . __('(taxes estimated for %s)', 'woocommerce'), $woocommerce->countries->estimated_for_prefix() . __($woocommerce->countries->countries[ $woocommerce->countries->get_base_country() ], 'woocommerce') ) : '';
			
			printf(__('Note: Shipping and taxes are estimated%s and will be updated during checkout based on your billing and shipping information.', 'woocommerce'), $estimated_text ); 
			
		?></small></p><div class="clear"></div>
	
	<?php elseif( $woocommerce->cart->needs_shipping() ) : ?>
		
		<?php if ( ! $woocommerce->customer->get_shipping_state() || ! $woocommerce->customer->get_shipping_postcode() ) : ?>
		
			<div class="woocommerce_info">
				<p><?php _e('No shipping methods were found; please recalculate your shipping and enter your state/county and zip/postcode to ensure their are no other available methods for your location.', 'woocommerce'); ?></p>
			</div>
		
		<?php else : ?>
		
			<div class="woocommerce_error">
		
				<p><?php printf(__('Sorry, it seems that there are no available shipping methods for your location (%s).', 'woocommerce'), $woocommerce->countries->countries[ $woocommerce->customer->get_shipping_country() ]); ?></p>
				
				<p><?php _e('If you require assistance or wish to make alternate arrangements please contact us.', 'woocommerce'); ?></p>
				
			</div>
		
		<?php endif; ?>
		
	<?php endif; ?>
	
	<?php do_action('woocommerce_after_cart_totals'); ?>
	
</div>