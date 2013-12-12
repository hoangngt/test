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
					<?php while ( have_posts() ) : the_post();
					$image_id = get_post_thumbnail_id();
					$image_url = wp_get_attachment_image_src($image_id,'full');
					$image_url = $image_url[0];
					?>
					<li id="post-<?php the_ID(); ?>" <?php post_class('blog-entry'); ?>>
					
						<div class="blog-post-title">
							<div class="blog-date float-left">
								<?php $date_month = get_the_time(__('M', 'bellissima')); $date_day =  get_the_time(__('d', 'bellissima')); 
								?><div class="month"><?php echo $date_month; ?></div>
								<div class="date-number"><?php echo $date_day; ?></div>
							</div>
							<h3 class="blog-post-title-inner"><a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a></h3>
						</div>
						<br class="clear" />
						
						<?php if($image_url) { ?><img src="<?php echo aq_resize($image_url, 690, 300, true) ?>" alt="image" class="full-width-image" /><?php } ?>
						<div class="clear"></div>
						
						<div class="user float-left"><?php _e('by', 'bellissima'); ?> <?php the_author_link(); ?></div>
						<div class="category float-left"><?php _e('posted in', 'bellissima'); ?> <?php the_category(', '); ?></div>
						<div class="post-comment float-left"><?php comments_popup_link(__('No comments yet', 'bellissima'), __('1 Comment', 'bellissima'), __('% Comments', 'bellissima')); ?></div>
						<br class="clear" />
						
						<?php the_content(); ?>
						
						<div class="clear"></div>
						
						<a href="<?php the_permalink(); ?>" class="general-button-black"><span class="button-black"><?php _e('View more', 'bellissima'); ?></span></a>
						<div class="clear"></div>
					</li>
					<?php endwhile; ?>
				</ul>
				
				<div id="blog_navigation">
					<?php if(function_exists('kriesi_pagination')) : { kriesi_pagination(); } ?>
					<?php else : ?>
						<?php posts_nav_link('&nbsp;|&nbsp;',__('&laquo; Newer Posts', 'bellissima'),__('Older Posts &raquo;', 'bellissima')) ?>
					<?php endif; ?>
				</div>
					
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