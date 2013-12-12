<?php
/*
Template Name: Home_Page
*/
?>
<?php get_header(); ?>

	<div id="content">
		<?php include (TEMPLATEPATH . '/slider.php'); ?>
		
		<?php if(!of_get_option('headline') == "") { ?>
		<!-- Message Begin -->		
		<div class="message">
			<?php echo of_get_option('headline') ?>
		</div>		
		<!-- Message End --><?php } ?>
		
		<?php if ( is_active_sidebar( 'home_sidebar_wide' ) ) { ?><!-- Bestsellers Begin -->
		<div class="content-top">
		</div>
		
		<div class="content-inner home">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home_sidebar_wide') ) : ?><?php endif; ?>
		</div>
		<div class="shadow"></div>
		<!-- Bestsellers End --><?php } ?>
	
		<?php if ( is_active_sidebar( 'home_sidebar_one' ) || is_active_sidebar( 'home_sidebar_two' ) ) { ?><div class="content-top blog-home"></div>
		<div class="content-inner home">
			
			<!-- Gallery Begin -->
			<div class="one-half float-left">				
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home_sidebar_one') ) : ?><?php endif; ?>
			</div>
			<!-- Gallery End -->
			
			<!-- Recent Posts Begin -->
			<div class="one-half float-right">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home_sidebar_two') ) : ?><?php endif; ?>
			</div>
			<br class="clear"/>
		</div>
		<!-- Recent Posts End -->
		
		<div class="clear"></div>
		
		<div class="shadow"></div><?php } ?>
		
		<div class="clear"></div>
		
		<div id="home_special">
			<?php if ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php the_content(); ?>
			<?php endif; ?>
		</div>
		
		<div class="clear"></div>
	</div>

	<!-- Footer -->
	<?php get_footer(); ?>