<?php
/**
 * Loop Add to Cart
 */
 
global $product; 

if( $product->get_price() === '' && $product->product_type!=='external') return;
?>

<?php if (!$product->is_in_stock()) : ?>
		
	<span class="float-left">Out of stock</span>

<?php 
else :
		
	switch ($product->product_type) :
		case "variable" :
			$link 	= get_permalink($product->id);
			$label 	= apply_filters('variable_add_to_cart_text', __('Select options', 'woocommerce'));
		break;
		case "grouped" :
			$link 	= get_permalink($product->id);
			$label 	= apply_filters('grouped_add_to_cart_text', __('View options', 'woocommerce'));
		break;
		case "external" :
			$link 	= get_permalink($product->id);
			$label 	= apply_filters('external_add_to_cart_text', __('Read More', 'woocommerce'));
		break;
		default :
			$link 	= esc_url( $product->add_to_cart_url() );
			$label 	= apply_filters('add_to_cart_text', __('Add to cart', 'woocommerce'));
		break;
	endswitch;

	printf('<a href="%s" rel="nofollow" data-product_id="%s" class="button add_to_cart_button product_type_%s float-left">%s</a>', $link, $product->id, $product->product_type, $label);

endif; 
?>