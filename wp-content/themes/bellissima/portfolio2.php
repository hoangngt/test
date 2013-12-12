<?php
/*
Template Name: Portfolio 2 Column
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
				
				<div id="blog-entries">
				<?php if ( have_posts() ) : the_post(); ?>
				
					
						<h3 class="blog-page-title"><?php the_title(); ?></h3>
						
						<?php the_content() ?>
						
						<div class="portfolio-container">
							<ul class="filter">
								<li class="current all"><a href="#"><?php _e('All', 'bellissima'); ?></a></li>
								<?php $categories=  get_categories('taxonomy=galleries'); 
								foreach ($categories as $category) {
									$option = '<li class="' . $category->slug . '"><a href="#">' . $category->name . '</a></li>';
									echo $option;
								} ?>								
							</ul>
						</div>
						
						<ul class="portfolio">						
							<?php 
							$i = 1;
							$portfolio_items = new WP_Query("post_type=portfolio&meta_key=_thumbnail_id&showposts=-1");
							if($portfolio_items->have_posts()) : 
							while ($portfolio_items->have_posts()) : $portfolio_items->the_post();
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'full');
							$image_url = $image_url[0];
							$custom = get_post_custom($portfolio_items->post->ID);
							$itemtype = $custom["type"][0];
							$linkto = $custom["linkto"][0];
							$excerpt = $custom["excerpt"][0]; ?>
							<li data-id="id-<?php echo $i ?>" data-type="<?php 
							$term_list = get_the_terms($portfolio_items->post->ID, 'galleries');
							foreach($term_list as $cats) {
								echo $cats->slug . ' ';
							} ?>" class="two-columns">
								<?php if ($itemtype == "photo" || $itemtype == "design" || $itemtype == "logo" || $itemtype == "html" || $itemtype == "psd" || $itemtype == "vector") { ?>
								<div class="portfolio-label"><img src="<?php echo THEME_DIR ?>/images/portfolio_label_<?php echo $itemtype ?>.png"/></div>
								<?php } ?>
								<a href="<?php echo $image_url; ?>" rel="prettyPhoto[portfolio]" class="portfolio-link">
									<img src="<?php echo aq_resize($image_url, 450, 240, true) ?>" alt="" />
									<span class="mouseon-portfolio"></span>
								</a>
								<p>
									<a href="<?php if($linkto == "") the_permalink(); elseif($linkto == "none") echo "javascript:;"; else echo $linkto; ?>" class="portfolio-title"><?php the_title() ?></a>
									<?php echo $excerpt  ?>
								</p>
							</li>
							<?php $i++; endwhile; endif; ?>
						</ul>
						
				<?php endif; ?>
				</div>
			</div>
			
			<!-- Full Width Content End -->
			<div class="clear"></div>
		</div>
		
		<div class="shadow"></div>
		
		<div class="clear"></div>
	</div>

	<!-- Footer -->
	<?php get_footer(); ?>