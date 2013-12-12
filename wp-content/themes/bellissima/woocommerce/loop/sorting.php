<?php
/**
 * Sorting
 */
?>
<form class="woocommerce_ordering" method="POST">
	<div class="catalog-order"><select name="sort" class="orderby">
		<?php
			$catalog_orderby = apply_filters('woocommerce_catalog_orderby', array(
				'date' 			=> __('Most recent', 'woocommerce'),
				'title' 		=> __('Alphabetically', 'woocommerce'),
				'price' 		=> __('Price', 'woocommerce')
			));

			foreach ( $catalog_orderby as $id => $name ) 
				echo '<option value="' . $id . '" ' . selected( $_SESSION['orderby'], $id, false ) . '>' . $name . '</option>';
		?>
	</select></div>
</form>