<?php get_header(); ?>

	<div id="content">
	
		<div class="content-top"></div>
		<div class="content-inner">
			
			<!-- Breadcrumbs -->
			<?php include (TEMPLATEPATH . '/breadcrumbs.php'); ?>
			
			<!-- Sidebar -->
			<?php get_sidebar(); ?>
			
			<!-- Main Column Begin -->
			<div class="main-content<?php if(of_get_option('page_layout') == 'right') echo ' main-content-left'; ?>">
				
				<?php if ( have_posts() ) : ?>
				<ul id="blog-entries">
					<?php the_post(); ?>
					<li class="blog-entry">
					
						<h3 class="blog-page-title"><?php the_title(); ?></h3>
						
						<?php the_content(); ?>
						
					</li>
				</ul>					
				<?php else: ?>				
				<h3><?php _e("404, That page doesn't exist..", 'bellissima'); ?></h3>
				<p><?php _e('Sorry, no posts matched your criteria.', 'bellissima'); ?></p>
				<?php endif; ?>
				
			</div>
			<!-- Main Column End -->
			
			<br class="clear"/>			
		</div>
		
		<div class="shadow"></div>
		
		<div class="clear"></div>
	</div>

	<!-- Footer -->
	<?php get_footer(); ?>