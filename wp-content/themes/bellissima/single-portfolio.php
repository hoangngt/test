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
					<?php the_post();
					$image_id = get_post_thumbnail_id();
					$image_url = wp_get_attachment_image_src($image_id,'full');
					$image_url = $image_url[0]; ?>
					<li class="blog-entry">
					
						<h3 class="blog-page-title"><?php the_title(); ?></h3>
						
						<?php if($image_url) { ?><img src="<?php echo aq_resize($image_url, 690, 300, true) ?>" alt="image" class="full-width-image" /><br class="clear" /><?php } ?>
						
						<?php the_content(); ?>

						<div class="clear"></div>
						
						<?php if(of_get_option('show_social', true) == true) { ?>
						<div class="social-container">
							<!-- Google Begin -->
							<div class="social-container float-left">
								<g:plusone size="medium" width="120"></g:plusone>

								<script type="text/javascript">
								  (function() {
									var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
									po.src = 'https://apis.google.com/js/plusone.js';
									var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
								  })();
								</script>
							</div>
							<!-- Google End -->
							
							<!-- Twitter Begin -->
							<div class="social-container float-left">
								<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
							</div>
							<!-- Twitter End -->
							
							<!-- Facebook Begin -->
							<div class="social-container float-left">
								<div id="fb-root"></div>
								<script>(function(d, s, id) {
								  var js, fjs = d.getElementsByTagName(s)[0];
								  if (d.getElementById(id)) return;
								  js = d.createElement(s); js.id = id;
								  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
								  fjs.parentNode.insertBefore(js, fjs);
								}(document, 'script', 'facebook-jssdk'));</script>
								<div class="fb-like" data-send="false" data-layout="button_count" data-width="120" data-show-faces="false"></div>
							</div>
							<!-- Facebook End -->
							
						</div><?php } ?>
						
						<br class="clear"/>
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