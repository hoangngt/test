<?php
/**
 * Single Product Short Description
 */

global $post;

if ( ! $post->post_excerpt ) return;
?>
<span class="description" itemprop="description">
	<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
</span>