<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 */
 
global $post; 
?>
<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_container single-comment blog-page">

		<div class="avatar float-left"><?php echo get_avatar( $GLOBALS['comment'], $size='50' ); ?></div>
		
		<div class="comment-text blog-single-entry">
		
			<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo esc_attr( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ); ?>">
				<span style="width:<?php echo get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true )*16; ?>px"><span itemprop="ratingValue"><?php echo get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ); ?></span> <?php _e('out of 5', 'woocommerce'); ?></span>
			</div>
			
			<?php if ($GLOBALS['comment']->comment_approved == '0') : ?>
				<p class="meta"><em><?php _e('Your comment is awaiting approval', 'woocommerce'); ?></em></p>
			<?php else : ?>
				<span class="name" itemprop="author"><?php comment_author(); ?></span>
				<span class="date" itemprop="datePublished"><?php echo get_comment_date(__('M jS Y', 'woocommerce')); ?></span>
			<?php endif; ?>
			
				<div itemprop="description" class="description"><?php comment_text(); ?></div>
				<div class="clear"></div>
		</div>
		<div class="clear"></div>			
	</div>