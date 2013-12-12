<?php
/**
 * Single Product Price
 */

global $post, $product;
?>
<span itemprop="price" class="price"><?php echo $product->get_price_html(); ?></span>