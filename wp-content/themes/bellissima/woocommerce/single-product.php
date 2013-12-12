<?php get_header('shop'); ?>

<?php do_action('woocommerce_before_main_content'); ?>

<?php do_action('woocommerce_sidebar'); ?>

<div class="main-content<?php if(of_get_option('page_layout') == 'right') echo ' main-content-left'; ?> theme-shop">
<div class="detail-item">
<?php while ( have_posts() ) : the_post(); ?>
<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>
<?php endwhile; // end of the loop. ?>
</div>
</div>

<br class="clear" />

<?php do_action('woocommerce_after_main_content'); ?>

<?php get_footer('shop'); ?>