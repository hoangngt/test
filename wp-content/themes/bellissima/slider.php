<?php if(of_get_option('ribbon')) { ?><div class="sales-label"></div><?php } ?>
		
		<!-- Promo Begin -->
		<?php $slider_src = of_get_option('slider_source');
		$slider_num = of_get_option('subslides');
		if($slider_src == "product") : ?>
		<div class="promo-inner" id="promo">
			<!-- main navigator -->
			<ul id="main_navi">
				<?php 
				$i = 0;
				$recent_widget = new WP_Query("post_type=$slider_src&meta_key=_featured&meta_value=yes&showposts=4");
				if($recent_widget->have_posts()) : 
				while ($recent_widget->have_posts()) : $recent_widget->the_post();
				$image_id = MultiPostThumbnails::get_post_thumbnail_id('product', 'feature-image-1', $post->ID);
				$image_url = wp_get_attachment_image_src($image_id,'full');
				$image_url = $image_url[0]; ?>
				<li<?php if($i == 0) echo ' class="active"'?>>
					<img src="<?php echo aq_resize($image_url, 80, 60, true) ?>" alt="<?php the_title() ?>" />
					<div class="slider_caption">
						<span class="title"><?php the_title() ?></span>
						<span><?php echo string_limit_words(get_the_excerpt(),5); ?></span>
					</div>
					<div class="clear"></div>
				</li>
				<?php $i++; endwhile; endif; wp_reset_query(); ?>
			</ul>
			
			<!-- root element for the main scrollable -->
			<div id="main">
				<div id="pages">
					<?php 
					$recent_widget = new WP_Query("post_type=$slider_src&meta_key=_featured&meta_value=yes&showposts=4");
					if($recent_widget->have_posts()) : 
					while ($recent_widget->have_posts()) : $recent_widget->the_post(); ?>
					<div class="page">
						<div class="navi">
						<?php for($i = 1; $i <= $slider_num; $i++) { ?>
							<a<?php if($i == 1) echo ' class="nivo-control active"'; ?>></a>
						<?php } ?>
						</div>
			
						<div class="scrollable">
							<div class="items">
								<?php for($i = 1; $i <= $slider_num; $i++) { ?>
								<?php if (MultiPostThumbnails::has_post_thumbnail($slider_src, "feature-image-$i")) { ?>
								<div class="item">
								<a href="<?php the_permalink() ?>"><?php
									MultiPostThumbnails::the_post_thumbnail($slider_src, "feature-image-$i");
								?></a>
								</div><?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php endwhile; endif; wp_reset_query(); ?>
				</div>
			</div>
		</div>
		
		<?php elseif($slider_src == "categories" && of_get_option('slider_categories') != "") : 
			$single_category = explode(",", of_get_option('slider_categories'));
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		?>
		<div class="promo-inner" id="promo">
			
			<ul id="main_navi">
				<?php foreach ($single_category as $prodcat) :
					$cat_term = get_term_by('slug', $prodcat, 'product_cat');
					
					$image_id = get_woocommerce_term_meta( $cat_term->term_id, 'thumbnail_id', true  );
					$image_url = wp_get_attachment_image_src($image_id,'full');  
					$image_url = $image_url[0];
				?>
				<li>
					<img src="<?php echo aq_resize($image_url, 80, 60, true) ?>" alt="<?php echo $cat_term->name; ?>" />
					<div class="slider_caption">
						<span class="title"><?php echo $cat_term->name; ?></span>
						<span><?php echo $cat_term->description; ?></span>
					</div>
					<div class="clear"></div>
				</li><?php endforeach; ?>
			</ul>
			
			<div id="main">
				<div id="pages"><?php 
				foreach ($single_category as $prodcat) :
						$cat_term = get_term_by('slug', $prodcat, 'product_cat');
					
						$image_id = get_woocommerce_term_meta( $cat_term->term_id, 'thumbnail_id', true  );
						$image_url = wp_get_attachment_image_src($image_id,'full');  
						$image_url = $image_url[0];
				?>				
					<div class="page">
						<?php $terms_children = get_term_children( $cat_term->term_id, 'product_cat' );
									$children_ctr = 0;
									$children_array = array();
									foreach ($terms_children as $child) {
										$child_term = get_term_by( 'id', $child, 'product_cat' );
										
										$thumbnail_id  = get_woocommerce_term_meta( $child_term->term_id, 'thumbnail_id', true  );

										if($thumbnail_id){
											$children_ctr++;
											if($children_ctr == 1)
												echo '<div class="navi"><a class="nivo-control active"></a><a></a>';
											else
												echo '<a></a>';
	
											$children_array[] = $child_term->term_id;
										}
									}
									if($children_ctr > 0)
									echo '</div>';
								?>
						<div class="scrollable">
							<div class="items">
								
								<div class="item">
									<a href="<?php echo get_term_link($prodcat, 'product_cat') ?>"><img src="<?php echo aq_resize($image_url, 750, 330, true) ?>" alt="<?php echo $cat_term->name ?>" /></a>
								</div>
								
								<?php if(count($children_array) > 0) { foreach ($children_array as $child) :
								$child_term = get_term_by( 'id', $child, 'product_cat' );
								$image_id = get_woocommerce_term_meta( $child_term->term_id, 'thumbnail_id', true  );
								$image_url = wp_get_attachment_image_src($image_id,'full');  
								$image_url = $image_url[0]; ?>
								<div class="item">
									<a href="<?php echo get_term_link(intval($child_term->term_id), 'product_cat'); ?>"><img src="<?php echo aq_resize($image_url, 750, 330, true) ?>" alt="<?php echo $child_term->name ?>" /></a>
								</div>
								<?php endforeach; } ?>								
							</div>
						</div>
					</div>			
				<?php endforeach; ?></div>			
			</div>		
		</div><?php } ?>
		
		<?php else : if(count($slides) > 0) : $slider_ctr = 0;  ?>
		<div class="promo-inner" id="promo">
			<!-- main navigator -->
			<ul id="main_navi">
				<?php foreach($slides as $num => $slide) : if($slider_ctr < 4) : ?>
				<li class="<?php if($slider_ctr == 0) echo "active first"; ?>">
					<img src="<?php echo aq_resize($slide['src'], 80, 60, true) ?>" alt="<?php echo $slide['title'] ?>" />
					<div class="slider_caption">
						<span class="title"><?php echo $slide['title'] ?></span>
						<span><?php echo $slide['caption'] ?></span>
					</div>
					<div class="clear"></div>
				</li>
				<?php $slider_ctr++; endif; endforeach; ?>
			</ul>
			
			<!-- root element for the main scrollable -->
			<div id="main">
				
				<div id="pages">
					<?php foreach($slides as $num => $slide) : ?>
					<div class="page">
						<!-- <div class="navi"><a class="nivo-control active"></a><a></a><a></a></div> -->
			
						<div class="scrollable">
							<div class="items">
								<div class="item">
									<a href="<?php echo ($slide['link'] == "" ? "javascript:void(0);" : $slide['link']); ?>"><img src="<?php echo $slide['src'] ?>"></a>
								</div>
							</div>
						</div>
					</div><?php endforeach; ?>
				</div>
				
			</div>
		</div>
		<?php endif; endif; ?>
		<!-- End Promo -->
		
		<div class="shadow"></div>
		<!-- Promo End -->