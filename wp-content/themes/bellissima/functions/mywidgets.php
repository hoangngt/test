<?php

/* Recent Posts Widget */
add_action( 'widgets_init', 'bellissima_recent_load_widgets' );

function bellissima_recent_load_widgets() {
	register_widget( 'Bellissima_recent_Widget' );
}

class Bellissima_recent_Widget extends WP_Widget {

	function Bellissima_recent_Widget() {
		$widget_ops = array( 'classname' => 'bellissima_recent', 'description' => __('Recent posts widget for Bellissima theme.', 'bellissima') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bellissima_recent-widget' );
		$this->WP_Widget( 'bellissima_recent-widget', __('bellissima - Recent Posts', 'bellissima'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$post_cat = $instance['post_cat'];
		$post_num = $instance['post_num'];
		$post_type = $instance['post_type'];
		
		remove_filter( 'the_content', 'wpautop' );
		
		echo $before_widget . "\n";
		
		if($post_type == "no") {
			if ( $title )
			echo $before_title . $title . $after_title . "\n";
			echo '<ul class="home-blog-entries">' . "\n";
			?>
				<?php $recent_widget = new WP_Query("showposts=$post_num&cat=$post_cat"); if($recent_widget->have_posts()) : 
				while ($recent_widget->have_posts()) : $recent_widget->the_post();
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'full');
				$image_url = $image_url[0];
				?>			
				<li>
					<div class="blog-post-home-title">
						<div class="blog-home-date float-left">
							<div class="date-number"><?php echo get_the_time('d') ?><br/><?php echo get_the_time('M'); ?></div>
						</div>
						<div class="blog-post-home-title-inner">
							<a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
						</div>
					</div>
						
					<p class="post-content">
					<?php echo string_limit_words(get_the_excerpt(),45); ?>...<a href="<?php the_permalink(); ?>" class="regular">Read more</a>
					</p>
				</li>
			<?php endwhile; ?>
				</ul> <br class="clear" /><?php endif; wp_reset_query();
		} else {
			echo '<div class="latest-comments-list">' . "\n";
			if ( $title )
			echo $before_title . $title . $after_title . "\n";
			?>
				<?php $recent_widget = new WP_Query("showposts=$post_num&cat=$post_cat"); if($recent_widget->have_posts()) : ?>
				<ul>
				<?php while ($recent_widget->have_posts()) : $recent_widget->the_post();
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'full');
				$image_url = $image_url[0];
				?>
					<li class="latest-comments">
						<?php if($image_url) { ?>
						<div class="image-container float-left">
							<a href="<?php the_permalink(); ?>"><img src="<?php echo aq_resize($image_url, 60, 60, true) ?>" alt="" /></a>
						</div><?php } ?>
						<div class="comment-text">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<p><?php the_time('M j, Y') ?></p>
						</div>
						<div class="clear"></div>
					</li>
				<?php endwhile; ?>
				</ul><?php endif; wp_reset_query(); ?>
			<?php echo "\n" . '</div>';
		}
		echo $after_widget . "\n";
		add_filter( 'the_content', 'wpautop' );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_cat'] = strip_tags( $new_instance['post_cat'] );
		$instance['post_num'] = strip_tags( $new_instance['post_num'] );
		$instance['post_type'] = $new_instance['post_type'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => '', 'post_cat' => '', 'post_num' => '3', 'post_type' => 'yes' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'post_cat' ); ?>"><?php _e('Enter Category ID', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'post_cat' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'post_cat' ); ?>" value="<?php echo $instance['post_cat']; ?>" style="width:90%;" />
		</p>
		
		<p><small><?php _e('Enter a Category ID to show recent posts from that Category. Leave blank to show all posts.', 'bellissima'); ?></small></p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'post_num' ); ?>"><?php _e('Number of Posts to Show', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'post_num' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'post_num' ); ?>" value="<?php echo $instance['post_num']; ?>" style="width:90%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e('Show Thumbnails? (Widget Type)', 'bellissima'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>" class="widefat" style="width:90%;">
				<option <?php if ( 'yes' == $instance['post_type'] ) echo 'selected="selected"'; ?>><?php _e('yes', 'bellissima'); ?></option>
				<option <?php if ( 'no' == $instance['post_type'] ) echo 'selected="selected"'; ?>><?php _e('no', 'bellissima'); ?></option>
			</select>
		</p>

	<?php
	}
}



/* Popular Posts Widget */
add_action( 'widgets_init', 'bellissima_popular_load_widgets' );

function bellissima_popular_load_widgets() {
	register_widget( 'Bellissima_popular_Widget' );
}

class Bellissima_popular_Widget extends WP_Widget {

	function Bellissima_popular_Widget() {
		$widget_ops = array( 'classname' => 'bellissima_popular', 'description' => __('Popular posts widget for Bellissima theme.', 'bellissima') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bellissima_popular-widget' );
		$this->WP_Widget( 'bellissima_popular-widget', __('bellissima - Popular Posts', 'bellissima'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$post_cat = $instance['post_cat'];
		$post_num = $instance['post_num'];
		
		echo $before_widget . "\n";

		echo '<div class="latest-comments-list">' . "\n";
		if ( $title )
		echo $before_title . $title . $after_title . "\n";
		?>
			<?php $popular_widget = new WP_Query("orderby=comment_count&showposts=$post_num&cat=$post_cat"); if($popular_widget->have_posts()) : ?>
			<ul>
			<?php while ($popular_widget->have_posts()) : $popular_widget->the_post();
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id,'full');
			$image_url = $image_url[0];
			?>
				<li class="latest-comments">
					<?php if($image_url) { ?>
					<div class="image-container float-left">
						<a href="<?php the_permalink(); ?>"><img src="<?php echo aq_resize($image_url, 60, 60, true) ?>" alt="" /></a>
					</div><?php } ?>
					<div class="comment-text">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<p><?php the_time('M j, Y') ?></p>
					</div>
					<div class="clear"></div>
				</li>
			<?php endwhile; ?>
			</ul><?php endif; wp_reset_query(); ?>
		<?php echo "\n" . '</div>' . $after_widget . "\n";
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_cat'] = strip_tags( $new_instance['post_cat'] );
		$instance['post_num'] = strip_tags( $new_instance['post_num'] );

		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => '', 'post_cat' => '', 'post_num' => '3' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'post_cat' ); ?>"><?php _e('Enter Category ID', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'post_cat' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'post_cat' ); ?>" value="<?php echo $instance['post_cat']; ?>" style="width:90%;" />
		</p>
		
		<p><small><?php _e('Enter a Category ID to show popular posts from that Category. Leave blank to show from all posts.', 'bellissima'); ?></small><br /><br /></p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'post_num' ); ?>"><?php _e('Posts', 'bellissima'); ?>Number of Posts to Show:</label>
			<input id="<?php echo $this->get_field_id( 'post_num' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'post_num' ); ?>" value="<?php echo $instance['post_num']; ?>" style="width:90%;" />
		</p>

	<?php
	}
}




/* Subscribe Widget */
add_action( 'widgets_init', 'subscribe_load_widgets' );

function subscribe_load_widgets() {
	register_widget( 'Subscribe_Widget' );
}

class Subscribe_Widget extends WP_Widget {

	function Subscribe_Widget() {
		$widget_ops = array( 'classname' => 'subscribe', 'description' => __('Give your readers another way to stay updated.', 'bellissima') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'subscribe-widget' );
		$this->WP_Widget( 'subscribe-widget', __('bellissima - Subscribe Widget', 'bellissima'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$rss_id = $instance['rss_id'];
		$content = $instance['content'];
		
		echo $before_widget . "\n";

		echo '<div class="subscribe_widget">' . "\n";

		if ( $title )
		echo $before_title . $title . $after_title . "\n"; ?>
		
		<p><?php echo $content ?></p>

		<form method="post" class="newsletter" action="http://feedburner.google.com/fb/a/mailverify" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $rss_id ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
			<input type="text" class="newsletter-field" onclick="if(this.value == '<?php _e('Enter your e-mail...', 'bellissima'); ?>') this.value='';" onblur="if(this.value.length == 0) this.value='<?php _e('Enter your e-mail...', 'bellissima'); ?>';" value="<?php _e('Enter your e-mail...', 'bellissima'); ?>" name="email" />
			<input type="hidden" value="<?php echo $rss_id ?>" name="uri"/>
			<input type="hidden" name="loc" value="en_US"/>
			<input type="submit" class="go-btn" value="<?php _e('Go', 'bellissima'); ?>" />
		</form>
		
		<?php echo "\n" . '</div>' . $after_widget . "\n";
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['rss_id'] = strip_tags( $new_instance['rss_id'] );
		$instance['content'] = strip_tags( $new_instance['content'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('Subscribe', 'bellissima') );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$content = esc_attr($instance['content']); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'rss_id' ); ?>"><?php _e('Enter your newsletter ID name', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'rss_id' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'rss_id' ); ?>" value="<?php echo $instance['rss_id']; ?>" style="width:90%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Custom text that appears before the form:', 'bellissima'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $instance['content']; ?></textarea>
		</p>

	<?php
	}
}




/* Products Widget */
add_action( 'widgets_init', 'products_load_widgets' );

function products_load_widgets() {
	register_widget( 'Products_Widget' );
}

class Products_Widget extends WP_Widget {

	function Products_Widget() {
		$widget_ops = array( 'classname' => 'products slider-container', 'description' => __('Show your best products right on the homepage below the slider area.', 'bellissima') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'products-widget' );
		$this->WP_Widget( 'products-widget', __('bellissima - Products Widget', 'bellissima'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$product_cat = $instance['product_cat'];
		$product_total = $instance['product_total'];
		$product_width = $instance['product_width'];
		
		if(!is_numeric($product_total))
		$product_total = 12;

		echo $args['before_widget'] . "\n";

		if ( $title )
		echo $before_title . $title . $after_title . "\n"; ?>
		
		<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
		<div id="slider-container">
			<div class="slider-nav">
				<a class="prev2"></a>
				<a class="next2"></a>
			</div>
			
			<div class="slider">
				<div class="items">
				<?php $args = array( 'post_type' => 'product', 'product_cat' => "$product_cat", 'posts_per_page' => $product_total );
					$loop = new WP_Query( $args );
					$i = 1;
					if ($loop->found_posts < 4)
						$counter = $loop->found_posts;
					else
						$counter = 4;
						
					$products_available = $loop->found_posts;
					while ( $loop->have_posts() ) : $loop->the_post(); global $product;
					$image_id = get_post_thumbnail_id($loop->post->ID);
					$image_url = wp_get_attachment_image_src($image_id,'full');
					$image_url = $image_url[0];
					global $woocommerce;
				?>
					<?php if($i%$counter == 1) { ?><div class="group-items"><?php } ?>
						<div class="single-item">
							<?php woocommerce_show_product_sale_flash( $loop->post, $product ); ?>
							<span class="title"><a href="<?php echo get_permalink( $loop->post->ID ) ?>"><?php the_title(); ?></a></span>
							<span class="price"><?php echo $product->get_price_html(); ?></span>
							<?php if(!$image_url == "") { $cropornot = (get_option('woocommerce_catalog_image_crop')==1) ? true : false; ?><div class="products_image"><a href="<?php echo get_permalink( $loop->post->ID ) ?>"><img src="<?php echo aq_resize($image_url, $woocommerce->get_image_size("shop_catalog_image_width"), $woocommerce->get_image_size("shop_catalog_image_height"), $cropornot) ?>" alt="Item"/></a></div><?php } else { ?><a href="<?php echo get_permalink( $loop->post->ID ) ?>"><img src="<?php echo woocommerce_placeholder_img_src() ?>" width="<?php echo $woocommerce->get_image_size("shop_catalog_image_width") ?>" height="<?php echo $woocommerce->get_image_size("shop_catalog_image_height") ?>" alt="Item" /></a><?php } ?>
							<?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
							<span class="list-link">
								<a href="<?php echo get_permalink( $loop->post->ID ) ?>" class="regular">View more...</a>
							</span>
							<div class="clear"></div>
						</div>
					<?php if($i%$counter == 0 || $i == $product_total || $i == $products_available ){ ?></div><!-- Group Ends --><?php } ?>
				<?php $i++; endwhile; wp_reset_query(); ?>
				</div>
			</div>
			
			<div class="clear"></div>
		</div><?php } ?>
		</div>
		
		<?php 
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['product_cat'] = strip_tags( $new_instance['product_cat'] );
		$instance['product_total'] = strip_tags( $new_instance['product_total'] );
		$instance['product_width'] = $new_instance['product_width'];
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => '', 'product_cat' => '', 'product_width' => 'wide', 'product_total' => '12' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$content = esc_attr($instance['content']); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'product_cat' ); ?>"><?php _e('Product Categories', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'product_cat' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'product_cat' ); ?>" value="<?php echo $instance['product_cat']; ?>" style="width:90%;" />
			<small><?php _e('Enter the slugs of the categories from which the product items would be fetched. Separate multiple slugs with commas. Leave blank if all categories are to be included.', 'bellissima'); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'product_total' ); ?>"><?php _e('Maximum products', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'product_total' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'product_total' ); ?>" value="<?php echo $instance['product_total']; ?>" style="width:90%;" />
			<small><?php _e('Enter the maximum number of product items to show. Leave blank to show the default 12 items.', 'bellissima'); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'product_width' ); ?>"><?php _e('Widget Width', 'bellissima'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'product_width' ); ?>" name="<?php echo $this->get_field_name( 'product_width' ); ?>" class="widefat" style="width:90%;">
				<option <?php if ( 'wide' == $instance['product_width'] ) echo 'selected="selected"'; ?>><?php _e('wide', 'bellissima'); ?></option>
				<option <?php if ( 'narrow' == $instance['product_width'] ) echo 'selected="selected"'; ?>><?php _e('narrow', 'bellissima'); ?></option>
			</select>
			<small><?php _e('Select a width type. Wide widget type would require full-page-width widget area. While the narrow one is about half the width.', 'bellissima'); ?></small>
		</p>

	<?php
	}
}



/* Bellissima Photos Widget */
add_action( 'widgets_init', 'bellphoto_load_widgets' );

function bellphoto_load_widgets() {
	register_widget( 'Bellphoto_Widget' );
}

class Bellphoto_Widget extends WP_Widget {

	function Bellphoto_Widget() {
		$widget_ops = array( 'classname' => 'bellissima_photo', 'description' => __('A widget to display a photo gallery of posts or products.', 'bellissima') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bellphoto-widget' );
		$this->WP_Widget( 'bellphoto-widget', __('bellissima - Photo Gallery', 'bellissima'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$bellphoto_id = $instance['bellphoto_id'];
		$bellphoto_src = $instance['bellphoto_src'];
		$bellphoto_num = $instance['bellphoto_num'];
		$bellphoto_flickr = $instance['bellphoto_flickr'];

		echo $before_widget . "\n";

		if ( $title )
			echo $before_title . $title . $after_title . "\n";
			?>
			
			<?php if($bellphoto_src == "flickr") { if(!$bellphoto_flickr == "") { ?>
			<div class="flickr_badge">
				<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $bellphoto_num ?>&amp;display=latest&amp;size=m&amp;layout=x&amp;source=user&amp;user=<?php echo $bellphoto_flickr ?>"></script>
			</div>			
			<?php } } else { ?>
			<ul class="thumb_gallery">
				<?php
				$recent_widget = new WP_Query("post_type=$bellphoto_src&showposts=$bellphoto_num&cat=$bellphoto_id&meta_key=_thumbnail_id");
				if($recent_widget->have_posts()) : 
				while ($recent_widget->have_posts()) : $recent_widget->the_post();
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'full');
				$image_url = $image_url[0];
				?>
				<li>
					<a href="<?php echo $image_url ?>" rel="home_group" class="grouped-elements" title="<a href='<?php echo get_permalink() ?>'><?php the_title(); ?></a>">
						<img border="0" alt="" src="<?php echo aq_resize($image_url, 135, 90, true) ?>" class="portfolio-image">
						<span class="imagehover"></span>
					</a>
				</li>
				<?php endwhile; endif; wp_reset_query(); ?>
			</ul>
			<?php } ?>
			<br class="clear" />
			<?php 
		
		echo "\n" . $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['bellphoto_id'] = strip_tags( $new_instance['bellphoto_id'] );
		$instance['bellphoto_src'] = $new_instance['bellphoto_src'];
		$instance['bellphoto_num'] = $new_instance['bellphoto_num'];
		$instance['bellphoto_flickr'] = $new_instance['bellphoto_flickr'];
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => 'Our Photostream', 'bellphoto_id' => '', 'bellphoto_num' => '9', 'bellphoto_num' => 'posts', 'bellphoto_flickr' => '25062265@N06' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'bellphoto_src' ); ?>"><?php _e('Photo Source', 'bellissima'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'bellphoto_src' ); ?>" name="<?php echo $this->get_field_name( 'bellphoto_src' ); ?>" class="widefat" style="width:90%;">
				<option <?php if ( 'post' == $instance['bellphoto_src'] ) echo 'selected="selected"'; ?>><?php _e('post', 'bellissima'); ?></option>
				<option <?php if ( 'product' == $instance['bellphoto_src'] ) echo 'selected="selected"'; ?>><?php _e('product', 'bellissima'); ?></option>
				<option <?php if ( 'flickr' == $instance['bellphoto_src'] ) echo 'selected="selected"'; ?>><?php _e('flickr', 'bellissima'); ?></option>
			</select>
			<small><?php _e('Please note that only those posts/products would be shown that have a thumbnail added.', 'bellissima'); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'bellphoto_num' ); ?>"><?php _e('Number of Photos', 'bellissima'); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'bellphoto_num' ); ?>" name="<?php echo $this->get_field_name( 'bellphoto_num' ); ?>" class="widefat" style="width:90%;">
				<option <?php if ( '3' == $instance['bellphoto_num'] ) echo 'selected="selected"'; ?>>3</option>
				<option <?php if ( '6' == $instance['bellphoto_num'] ) echo 'selected="selected"'; ?>>6</option>
				<option <?php if ( '9' == $instance['bellphoto_num'] ) echo 'selected="selected"'; ?>>9</option>
				<option <?php if ( '12' == $instance['bellphoto_num'] ) echo 'selected="selected"'; ?>>12</option>
				<option <?php if ( '15' == $instance['bellphoto_num'] ) echo 'selected="selected"'; ?>>15</option>
				<option <?php if ( '18' == $instance['bellphoto_num'] ) echo 'selected="selected"'; ?>>18</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'bellphoto_flickr' ); ?>"><?php _e('Flickr ID', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'bellphoto_flickr' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'bellphoto_flickr' ); ?>" value="<?php echo $instance['bellphoto_flickr']; ?>" style="width:90%;" />
			<div class="clear"></div><small><?php _e('In case your photo source is Flickr, enter your Flickr ID here. Visit this site to get your ID', 'bellissima'); ?>: <a href="http://idgettr.com">idgettr.com</a></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'bellphoto_id' ); ?>"><?php _e('Categories', 'bellissima'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'bellphoto_id' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'bellphoto_id' ); ?>" value="<?php echo $instance['bellphoto_id']; ?>" style="width:90%;" />
			<div class="clear"></div><small><?php _e('In case your photo source is Posts or Products, if you want to show items only from select categories, enter there ID here. Separate multiple IDs with commas.', 'bellissima'); ?></small>
		</p>
	<?php
	}
}
?>