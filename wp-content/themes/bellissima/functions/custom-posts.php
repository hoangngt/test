<?php

//		CUSTOM POST TYPE
add_action('init', 'portfolio_register');

function portfolio_register() {
   	$args = array(
       	'label' => __('Portfolio', 'bellissima'),
       	'singular_label' => __('Portfolio', 'bellissima'),
       	'public' => true,
       	'show_ui' => true,
       	'capability_type' => 'post',
       	'hierarchical' => false,
       	'rewrite' => true,
       	'supports' => array('title', 'editor', 'thumbnail')
	);
	
	register_taxonomy("galleries", array("portfolio"), array(
		"hierarchical" => true, 
		"label" => __("Galleries", 'bellissima'), 
		"singular_label" => __("Galleries", 'bellissima'), 
		"rewrite" => true)
	);
	
	register_post_type( 'portfolio' , $args );
}


add_action("admin_init", "admin_init");
add_action('save_post', 'save_portfolio_options');

function admin_init(){
	add_meta_box("gallerymeta", __("Gallery Options", 'bellissima'), "portfolio_meta_options", "portfolio", "normal", "low");
}

function portfolio_meta_options(){
	global $post;
	$custom = get_post_custom($post->ID);
	$excerpt = $custom["excerpt"][0];
	$type = $custom["type"][0];
	$linkto = $custom["linkto"][0];
?>

<div class="form-wrap">
	
	<div class="form-field">	
		<label for="excerpt"><?php _e('Excerpt', 'bellissima'); ?> :</label>
		<textarea name="excerpt" style="width: 100%;"><?php echo $excerpt; ?></textarea>
		<p><?php _e("A summary of the project or item. This excerpt would be used to show the item's data on a Gallery page.", 'bellissima'); ?></p>
	</div>
	
	<div class="form-field" style="width: 47%; float: left;">
		<label for="linkto"><?php _e('Link to', 'bellissima'); ?> :</label>
		<input type="text" name="linkto" value="<?php echo $linkto; ?>" />
		<p><?php _e("The URL the Portfolio Item will link to from the Gallery Page. Leaving this field blank, the item would link to its own page, while entering 'none' would not link anywhere.", 'bellissima'); ?></p>
	</div>
	
	<div class="form-field" style="width: 47%; float: left;">
		<label for="type"><?php _e('Item Type', 'bellissima'); ?></label>
		<select name="type" style="width: 100%;">
			<option <?php if($type == "blank") echo "selected"; ?> value="blank"><?php _e('none', 'bellissima'); ?></option>
			<option <?php if($type == "photo") echo "selected"; ?> value="photo"><?php _e('Photo', 'bellissima'); ?></option>
			<option <?php if($type == "design") echo "selected"; ?> value="design"><?php _e('Design', 'bellissima'); ?></option>
			<option <?php if($type == "logo") echo "selected"; ?> value="logo"><?php _e('Logo', 'bellissima'); ?></option>
			<option <?php if($type == "vector") echo "selected"; ?> value="vector"><?php _e('Vector', 'bellissima'); ?></option>
			<option <?php if($type == "html") echo "selected"; ?> value="html"><?php _e('HTML', 'bellissima'); ?></option>
			<option <?php if($type == "psd") echo "selected"; ?> value="psd"><?php _e('PSD', 'bellissima'); ?></option>
		</select>
		<p><?php _e('An icon of the selected type would appear on the item on Portfolio pages.', 'bellissima'); ?></p>
	</div>
	
	<div style="clear: both;" />
</div>
	
<?php
}

function save_portfolio_options(){
	global $post;
	update_post_meta($post->ID, "excerpt", $_POST["excerpt"]);
	update_post_meta($post->ID, "type", $_POST["type"]);
	update_post_meta($post->ID, "linkto", $_POST["linkto"]);
}

?>