<?php
/*
Template Name: Full_Width
*/
?>
<?php get_header(); ?>

	<div id="content">
	
		<div class="content-top"></div>
		<div class="content-inner">
			
			<!-- Breadcrumbs -->
			<?php include (TEMPLATEPATH . '/breadcrumbs.php'); ?>
			
			<!-- Full Width Content Begin -->
			<div class="full-width-content">
				
				<?php if ( have_posts() ) : ?>
				<ul id="blog-entries">
					<?php the_post(); ?>
					<li class="blog-entry single">
					
						<h3 class="blog-page-title"><?php the_title(); ?></h3>
						
						<?php the_content(); ?>
						
					</li>
				</ul>					
				<?php else: ?>				
				<h3 class="blog-page-title"><?php _e("404, That page doesn't exist..", 'bellissima'); ?></h3>
				<p><?php _e('Sorry, no posts matched your criteria.', 'bellissima'); ?></p>
				<?php endif; ?>
				
			</div>
			<!-- Full Width Content End -->
			<div class="clear"></div>
		</div>
		
		<div class="shadow"></div>
		
		<div class="clear"></div>
	</div>

	<!-- Footer -->
	<?php get_footer(); ?>