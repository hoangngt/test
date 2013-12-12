<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'bellissima'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __('One', 'bellissima'),
		'two' => __('Two', 'bellissima'),
		'three' => __('Three', 'bellissima'),
		'four' => __('Four', 'bellissima'),
		'five' => __('Five', 'bellissima')
	);
	
	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'bellissima'),
		'two' => __('Pancake', 'bellissima'),
		'three' => __('Omelette', 'bellissima'),
		'four' => __('Crepe', 'bellissima'),
		'five' => __('Waffle', 'bellissima')
	);
	
	$numbers_array = array(
		'1' => __('One', 'bellissima'),
		'2' => __('Two', 'bellissima'),
		'3' => __('Three', 'bellissima'),
		'4' => __('Four', 'bellissima'),
		'5' => __('Five', 'bellissima')
	);
	
	$products_array = array(
		'-1' => 'All',
		'3' => '3',
		'6' => '6',
		'9' => '9',
		'12' => '12',
		'15' => '15',
		'18' => '18',
		'21' => '21',
		'24' => '24',
		'27' => '27',
		'30' => '30'
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'face' => 'georgia',
		'style' => 'normal',
		'color' => '#863200' );
		
	$typography_content = array(
		'size' => '13px',
		'face' => 'arial',
		'style' => 'normal',
		'color' => '#373737' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => false,
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  THEME_DIR . '/images/';

	$options = array();

	$options[] = array(
		'name' => __('General', 'bellissima'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Upload Logo', 'bellissima'),
		'desc' => __('Upload a logo image file or enter the url of the file.', 'bellissima'),
		'id' => 'logo',
		'std' => $imagepath . 'logo.png',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Upload favicon', 'bellissima'),
		'desc' => __('Upload a favicon image file.', 'bellissima'),
		'id' => 'favicon',
		'std' => $imagepath . 'favicon.ico',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Show Top Text Teaser?', 'bellissima'),
		'desc' => __('Show a teaser text above the header.', 'bellissima'),
		'id' => 'show_top_teaser',
		'type' => 'checkbox');
		
	
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
		
	$options[] = array(
		'name' => __('Top Teaser Text', 'bellissima'),
		'desc' => __('Enter the top teaser text here. You can enter text/HTML.', 'bellissima'),
		'id' => 'top_teaser',
		'type' => 'editor',
		'class' => 'hidden',
		'settings' => $wp_editor_settings );
		
	$options[] = array(
		'name' => __('Top Search', 'bellissima'),
		'desc' => __('Select which kind of items should be fetched when a user searches using the Search Box in the header.', 'bellissima'),
		'id' => 'top_search',
		'std' => 'post',
		'type' => 'radio',
		'options' => array('post' => __('Posts', 'bellissima'), 'product' => __('Products', 'bellissima'), 'all' => __('All Items (including Posts, Products, Pages, Portfolio Items, etc)', 'bellissima')));
	
	$options[] = array(
		'name' => __('Headline', 'bellissima'),
		'desc' => __('Enter a headline text. This would appear just below the slider on homepage.', 'bellissima'),
		'id' => 'headline',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => __('Show Megamenu?', 'bellissima'),
		'desc' => __('Show megamenu in the top menu?', 'bellissima'),
		'id' => 'show_megamenu',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Megamenu Title', 'bellissima'),
		'desc' => __('Enter the title of the Megamenu section. This would appear in the menu area alongside other menu links.', 'bellissima'),
		'id' => 'megamenu_title',
		'std' => 'Mega Menu',
		'class' => 'hidden',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Megamenu Content', 'bellissima'),
		'desc' => __('Enter the content of megamenu. You can enter text/HTML and shortcodes.', 'bellissima'),
		'id' => 'megamenu',
		'type' => 'editor',
		'class' => 'hidden',
		'settings' => $wp_editor_settings );
		
	$options[] = array(
		'name' => __('Show List/Grid View Filter?', 'bellissima'),
		'desc' => __('Show List/Grid view option on the product pages.', 'bellissima'),
		'id' => 'show_grid_view',
		'std' => true,
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Show Social Bookmarking Links?', 'bellissima'),
		'desc' => __('If selected, Google Plus, Tweet and Facebook Like links would be shown below the single post and portfolio items.', 'bellissima'),
		'id' => 'show_social',
		'std' => true,
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Styling', 'bellissima'),
		'type' => 'heading' );
		
	$options[] = array(
		'name' => __("Default Page Layout", 'bellissima'),
		'desc' => __("Select the default page layout. This layout will be used in the blog and inner pages.", 'bellissima'),
		'id' => "page_layout",
		'std' => "left",
		'type' => "images",
		'options' => array(
			'left' => $imagepath . '2cl.png',
			'right' => $imagepath . '2cr.png')
	);
		
	$options[] = array( 'name' => __('Heading Font', 'bellissima'),
		'desc' => __('All the heading fonts including h1, h2, h3, etc will be styled using these options. The default color is #863200.', 'bellissima'),
		'id' => "heading_typography",
		'std' => $typography_defaults,
		'type' => 'typography',
		'options' => $typography_options);
		
	$options[] = array(
		'name' => __('Content Typography', 'bellissima'),
		'desc' => __('All the content text would be styled using these options. The default color is #373737.', 'bellissima'),
		'id' => "content_typography",
		'std' => $typography_content,
		'type' => 'typography',
		'options' => $typography_options);
		
	$options[] = array(
		'name' => __('Hyperlink Typography', 'bellissima'),
		'desc' => __('All the hyperlinks would be styled using these options. The default color is #c75603.', 'bellissima'),
		'id' => "link_typography",
		'std' => array('style' => 'normal','color' => '#c75603' ),
		'type' => 'typography',
		'options' => array('sizes' => false, 'faces' => false));
		
	$options[] = array(
		'name' => __('Theme Skin', 'bellissima'),
		'desc' => __('Choose a color scheme.', 'bellissima'),
		'id' => 'color_scheme',
		'std' => 'white',
		'type' => 'select',
		'options' => array('white'=> __('white default', 'bellissima'), 'purple'=> __('purple', 'bellissima')));
		
	$options[] = array(
		'name' => __('Use Skin Default Typography?', 'bellissima'),
		'desc' => __('If checked, any typography option selected above would be overlooked and the default styles related to the currently selected theme skin would be applied. *Please note that the Font Face styles would still be applied as selected above.', 'bellissima'),
		'id' => 'default_typography',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Custom Styles', 'bellissima'),
		'desc' => __('Add additional CSS styles here. These styles would be loaded after all the stylesheets.', 'bellissima'),
		'id' => 'add_styles',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Slider', 'bellissima'),
		'type' => 'heading' );
		
	$options[] = array(
		'name' => __('Show "Featured" Ribbon?', 'bellissima'),
		'desc' => __('If checked a red colored ribbon image would appear on the top left of the slider area.', 'bellissima'),
		'id' => 'ribbon',
		'std' => '1',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Pick Slides From', 'bellissima'),
		'desc' => __('Pick Slides from Slider Manager or Featured Products', 'bellissima'),
		'id' => 'slider_source',
		'std' => 'manager',
		'type' => 'radio',
		'options' => array('manager' => __('Slider Manager', 'bellissima'), 'product' => __('Featured Products', 'bellissima'), 'categories' => __('Product Categories', 'bellissima')));
		
	$options[] = array(
		'name' => __('Product Categories for Slider', 'bellissima'),
		'desc' => __("If you've selected 'Product Categories' as the source of slides above, enter the Slugs of four categories here, separated by commas.", 'bellissima'),
		'id' => 'slider_categories',
		'std' => 'first, second, third, fourth',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Autoplay Slider?', 'bellissima'),
		'desc' => __('If checked the slider would be set to autoplay.', 'bellissima'),
		'id' => 'autoplay',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Autoplay Timer', 'bellissima'),
		'desc' => __('Enter the time between auto slide transitions in milliseconds. 1 second = 1000 milliseconds', 'bellissima'),
		'id' => 'autoplay_timer',
		'std' => '7000',
		'class' => 'hidden',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Slides per Item', 'bellissima'),
		'desc' => __('When the slides are being fetched from posts or products, you can select to show multiple images of a single product in the slider. Here, select the minimum numbers of images to show per product. Please note that for this slider to work properly, every item should have this minimum number of slide images added.', 'bellissima'),
		'id' => 'subslides',
		'std' => '3',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $numbers_array);
		
	$options[] = array(
		'name' => __('Background', 'bellissima'),
		'type' => 'heading' );
		
	$options[] = array(
		'name' => __('Background Image', 'bellissima'),
		'desc' => __('Choose a background image. Note that purple background images will only be shown when purple theme skin has been selected.', 'bellissima'),
		'id' => 'background_image',
		'std' => 'white_default',
		'type' => 'select',
		'options' => array('white_default'=> __('white default', 'bellissima'), 'graffiti' => __('white graffiti', 'bellissima'), 'purple_default'=> __('purple default', 'bellissima'), 'bokeh' => __('purple bokeh', 'bellissima')));
		
	$options[] = array(
		'name' => __('Show Custom Background?', 'bellissima'),
		'desc' => __('If checked the custom background you create below will be shown. Otherwise the default background image selected above will be shown.', 'bellissima'),
		'id' => 'show_custombg',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' =>  __('Custom Background', 'options_framework_theme'),
		'desc' => __('Select the background color and Image Source.', 'options_framework_theme'),
		'id' => 'theme_background',
		'std' => $background_defaults,
		'type' => 'background' );
		
	$options[] = array(
		'name' => __('Integration', 'bellissima'),
		'type' => 'heading' );
		
	$options[] = array(
		'name' => __('Number of Products on Shop Page', 'bellissima'),
		'desc' => __('Select the maximum number of products that can be shown on the Shop page without needing page navigation.', 'bellissima'),
		'id' => 'number_of_products',
		'std' => '12',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $products_array);
		
	$options[] = array(
		'name' => __('Additional Scripts', 'bellissima'),
		'desc' => __('If you need to add any javascripts or Google Analytics code, enter it here.', 'bellissima'),
		'id' => 'scripts',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Turn Theme Updates On?', 'bellissima'),
		'desc' => __("If checked, you'll see a 'Bellissima Updates' notification link under the Dashboard link in the Admin, whenever an update is available on themeforest.", 'bellissima'),
		'id' => 'updates_switch',
		'std' => true,
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Activate Mobile/Responsive theme?', 'bellissima'),
		'desc' => __("If checked, a mobile version of the theme will be shown on the smartphone/tablet devices. Else, all the devices will render the theme similarly.", 'bellissima'),
		'id' => 'mobile_switch',
		'std' => true,
		'type' => 'checkbox');
		
	return $options;
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function($) {

	$('#example_showhidden').click(function() {
  		$('#section-example_text_hidden').fadeToggle(400);
	});

	if ($('#example_showhidden:checked').val() !== undefined) {
		$('#section-example_text_hidden').show();
	}
	
	
	$('#show_top_teaser').click(function() {
  		$('#section-top_teaser').fadeToggle(400);
	});

	if ($('#show_top_teaser:checked').val() !== undefined) {
		$('#section-top_teaser').show();
	}
	
	$('#show_megamenu').click(function() {
  		$('#section-megamenu, #section-megamenu_title').fadeToggle(400);
		
	});

	if ($('#show_megamenu:checked').val() !== undefined) {
		$('#section-megamenu, #section-megamenu_title').show();
	}
	
	$('#autoplay').click(function() {
  		$('#section-autoplay_timer').fadeToggle(400);
	});

	if ($('#autoplay:checked').val() !== undefined) {
		$('#section-autoplay_timer').show();
	}

});
</script>

<?php
}