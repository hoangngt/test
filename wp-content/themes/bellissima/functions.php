<?php


// REMOVING UNNECESSARY CLASSES
add_filter('body_class', 'wps_body_class', 10, 2);
function wps_body_class($wp_classes, $extra_classes)
{
    // List of classes allowed
    $whitelist = array('portfolio', 'home', 'error404');
    $wp_classes = array_intersect($wp_classes, $whitelist);
    return array_merge($wp_classes, (array) $extra_classes);
}

// CREATING THEME DIR CONSTANT
define("THEME_DIR", get_template_directory_uri());

// INCLUDE IMPORTANT FILES
define('OF_FILEPATH', get_stylesheet_directory_uri());
define('OF_DIRECTORY', get_stylesheet_directory_uri());

require_once (TEMPLATEPATH . '/functions/mywidgets.php');
require_once (TEMPLATEPATH . '/functions/slider-manager/slider-manager.php');
require_once (TEMPLATEPATH . '/functions/myshortcodes.php');
require_once (TEMPLATEPATH . '/functions/custom-posts.php');
require_once (TEMPLATEPATH . '/functions/tinymce/shortcode_button.php');
require_once (TEMPLATEPATH . '/functions/thumbnails/multi-post-thumbnails.php');
include'functions/theme-admin/init.php';

// INCLUDE THEME ADMIN
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', THEME_DIR . '/functions/theme-admin/' );
	require_once dirname( __FILE__ ) . '/functions/theme-admin/options-framework.php';
}
// THEME UPDATES
if (of_get_option('updates_switch', true)) { require_once (TEMPLATEPATH . '/functions/updates.php'); }


// SETTING CONTENT WIDTH
if ( ! isset( $content_width ) ) $content_width = 690;


// ADDING SOME ECOMMERCE FILTERS
add_filter('loop_shop_per_page', create_function('$cols', 'return ' . of_get_option('number_of_products', '12') . ';'));
add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');
function custom_woocommerce_placeholder_img_src( $src ) {
     $src = THEME_DIR . '/images/product1.jpg';
     return $src;
}
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25);

function woocommerce_output_related_products() {
    woocommerce_related_products(3,3);
}
// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;	
	ob_start();
	?>
	<span id="top_item_count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'bellissima'), $woocommerce->cart->cart_contents_count);?></span>
	<?php
	$fragments['span#top_item_count'] = ob_get_clean();
	return $fragments;
}



// THEME LOCALIZATION
add_action('after_setup_theme', 'bellissima_theme_setup');
function bellissima_theme_setup(){
    load_theme_textdomain('bellissima', get_template_directory() . '/languages');
}



// EXECUTE SHORTCODES IN WIDGETS
add_filter('widget_text', 'do_shortcode');

// REMOVE GENERATOR META TAG
remove_action('wp_head', 'wp_generator');


// SMART JAVASCRIPT INCLUSION
function load_my_scripts() {
   	if (!is_admin()) {
		
		wp_enqueue_script('jquery');

		wp_enqueue_script( 'tools', THEME_DIR . '/js/jquerytools.js', array( 'jquery' ), '1', true );
		wp_enqueue_script( 'custom', THEME_DIR . '/js/custom.js', array( 'jquery' ), '1', true );
		wp_enqueue_script( 'plugins', THEME_DIR . '/js/plugins.js', array( 'jquery' ), '1', true );
		wp_enqueue_script( 'mobilemenu', THEME_DIR . '/js/mobilemenu.js', array( 'jquery' ), '1', true );
		
		if ( is_singular() ) wp_enqueue_script( "comment-reply" );
		
		// Adding Skin
		$theme_skin = of_get_option('color_scheme');
		if($theme_skin == "white") ; else {
			$theme_skin = THEME_DIR . '/css/skins/' . $theme_skin . '/style.css';
			wp_enqueue_style( 'themeskin', $theme_skin , array(), '1', 'all' );
		}
		
		if(is_page_template( 'homepage.php' )) {
			wp_enqueue_style( 'product-slider', THEME_DIR . '/css/product-slider.css', array(), '1', 'all' );
			wp_enqueue_style( 'scrollable', THEME_DIR . '/css/scrollable-navig.css', array(), '1', 'all' );			
			add_action( 'wp_footer', 'home_inline_script' );
		}
		else {
			if(function_exists('is_product')) {
				if (is_product()){
				wp_enqueue_style( 'exposurecss', THEME_DIR . '/css/exposure.css', array(), '1', 'all' );
				wp_enqueue_script( 'exposurejs', THEME_DIR . '/exposure/exposure.js', array( 'jquery' ), '1', true );
				}
			}
			
			if(function_exists('is_woocommerce')) {
				if (is_woocommerce()){
				add_action( 'wp_head', 'product_scripts' );
				}
			}
			
			if(is_page_template('portfolio2.php') || is_page_template('portfolio3.php') || is_page_template('portfolio4.php')){
				wp_enqueue_style( 'portfolio-style', THEME_DIR . '/mofm-source/css/style.css', array(), '1', 'all' );
				wp_enqueue_style( 'prettyphoto-style', THEME_DIR . '/mofm-source/css/prettyPhoto.css', array(), '1', 'all' );
				wp_enqueue_script( 'portfolio-scripts', THEME_DIR . '/mofm-source/js/script.js', array( 'jquery' ), '1', true );
				wp_enqueue_script( 'quicksand', THEME_DIR . '/mofm-source/js/quicksand.js', array( 'jquery' ), '1', true );
				wp_enqueue_script( 'prettyphoto-script', THEME_DIR . '/mofm-source/js/prettyPhoto.js', array( 'jquery' ), '1', true );
				wp_enqueue_script( 'equal-heights', THEME_DIR . '/mofm-source/js/equalheights.js', array( 'jquery' ), '1', true );
			}		
			add_action( 'wp_footer', 'inner_inline_script' );
		}
		
		wp_enqueue_style( 'product-slider', THEME_DIR . '/jquery-ui/css/jquery-ui.css', array(), '1', 'all' );
		wp_enqueue_style( 'scrollable', THEME_DIR . '/jquery-ui/css/redmond/custom.css', array(), '1', 'all' );
			
		wp_enqueue_script( 'jqueryui', THEME_DIR . '/jquery-ui/js/ui-min.js', array( 'jquery' ), '1', true );
		wp_enqueue_script( 'fancybox', THEME_DIR . '/fancybox/fancybox.js', array( 'jquery' ), '1', true );
		wp_enqueue_style( 'css-updates', THEME_DIR . '/css/updates.css', array(), '1', 'all' );
		if (of_get_option('mobile_switch', true)) { wp_enqueue_style( 'responsive-styles', THEME_DIR . '/css/mobile.css', array(), '1', 'all' ); }

   	}
}
add_action('wp_enqueue_scripts', 'load_my_scripts');


function home_inline_script() {
?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		// Main Promo Scroller
		$("#main").scrollable({
			circular: true,
			vertical: true,
			onSeek: function(event, i) {
				horizontal.eq(i).data("scrollable").focus();
			}			
		})<?php if(of_get_option('autoplay')) { ?>.autoscroll(<?php echo of_get_option('autoplay_timer') ?>)<?php } ?>.navigator("#main_navi");
		var horizontal = $(".scrollable").scrollable({ circular: true }).navigator(".navi");
		horizontal.eq(0).data("scrollable").focus();
		
		$('body').bind('added_to_cart', function(){
			$('.add_to_cart_button.added').text(<?php _e("'Added'", "bellissima"); ?>);		
		});
	});
</script>
<?php
}

function inner_inline_script() {
?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		$('body').bind('added_to_cart', function(){
			$('.add_to_cart_button.added').text(<?php _e("'Added'", "bellissima"); ?>);		
		});
	});
</script>
<?php
}


function product_scripts() {

	function products_cookie() {
		if (!isset($_COOKIE['products_cookie'])) {
			setcookie('products_cookie', 'grid', time()+1209600, COOKIEPATH, COOKIE_DOMAIN, false);
		}
	}
	add_action( 'init', 'products_cookie');

	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			
			// List or grid View
			var type;
			var delaySpeed = 500;
			var animateSpeed = 500;	
			$("a#switch-to-grid").click(function(){
				if(!$(this).hasClass("active-view")) {
					$('ul#woo-product-items').fadeOut(animateSpeed,function(){
						$('ul#woo-product-items').removeClass('list-view',animateSpeed);
						$('ul#woo-product-items').addClass('grid-view',animateSpeed);
					}).fadeIn(animateSpeed);
					$.cookie('products_cookie', 'grid');
				}
				$("a#switch-to-list").removeClass('active-view');
				$(this).addClass('active-view');
				return false;		
			});
			
			$("a#switch-to-list").click(function(){
				if(!$(this).hasClass("active-view")) {
					$('ul#woo-product-items').fadeOut(animateSpeed,function(){
						$('ul#woo-product-items').removeClass('grid-view',animateSpeed);
						$('ul#woo-product-items').addClass('list-view',animateSpeed);
					}).fadeIn(animateSpeed);
					$.cookie('products_cookie', 'list');
				}
				$(this).addClass('active-view');
				$("a#switch-to-grid").removeClass('active-view');		
				return false;		
			});
		
		});
	</script>
	<?php
}




// CALL WIDGETS USING SHORTCODE
function widget($atts) {
    
    global $wp_widget_factory;
    
    extract(shortcode_atts(array(
        'widget_name' => FALSE
    ), $atts));
    
    $widget_name = esc_html($widget_name);
    
    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
        
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;
    
    ob_start();
    the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance-'.$id,
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}
add_shortcode('widget','widget'); 




// CREATING MENU AND ADDING A CLASS TO PARENT 
register_nav_menu( 'primary', 'Primary Menu' );



// FEATURED IMAGE FUNCTIONALITY
add_theme_support( 'post-thumbnails');

set_post_thumbnail_size( 330, 250, true ); 
add_image_size( 'thumbnail-small', 90, 9999 ); 
add_image_size( 'thumbnail-medium', 150, 9999 );
add_image_size( 'thumbnail-large', 750, 330, true );

if (class_exists('MultiPostThumbnails')) {
	$thumb_num = of_get_option('subslides', '3');
	for($i=1; $i<=$thumb_num; $i++) {
		new MultiPostThumbnails(array(
			'label' => __('Slider Image', 'bellissima') . ' ' . $i,
			'id' => 'feature-image-' . $i,
			'post_type' => 'product'
			)
		);
	}
}



// POST EXCERPTS
function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}



// SIDEBARS REGISTRATION
if ( function_exists('register_sidebar') ) 
//home sidebar wide
register_sidebar(array('name'=> __('home_sidebar_wide', 'bellissima'),
	'id' => 'home_sidebar_wide',
	'before_widget' => '<div id="%1$s" class="sidebar-widget home-sidebar-widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));
//home sidebar one
register_sidebar(array('name'=> __('home_sidebar_one', 'bellissima'),
	'id' => 'home_sidebar_one',
	'before_widget' => '<div id="%1$s" class="sidebar-widget home-sidebar-widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));
//home sidebar two
register_sidebar(array('name'=> __('home_sidebar_two', 'bellissima'),
	'id' => 'home_sidebar_two',
	'before_widget' => '<div id="%1$s" class="sidebar-widget home-sidebar-widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));
//blog sidebar
register_sidebar(array('name'=> __('blog_sidebar', 'bellissima'),
	'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));
//internal pages
register_sidebar(array('name'=> __('page_sidebar', 'bellissima'),
	'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));
//shop pages
register_sidebar(array('name'=> __('shop_sidebar', 'bellissima'),
	'before_widget' => '<div id="%1$s" class="sidebar-widget shop_widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="active">',
	'after_title' => '</h3>'
));
//footer column 1
register_sidebar(array('name'=> __('footer_column_1', 'bellissima'),
	'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h5>',
	'after_title' => '</h5>'
));
//footer column 2
register_sidebar(array('name'=> __('footer_column_2', 'bellissima'),
	'before_widget' => '<div class="footer-widget">',
	'after_widget' => '</div>',
	'before_title' => '<h5>',
	'after_title' => '</h5>'
));
//footer column 3
register_sidebar(array('name'=> __('footer_column_3', 'bellissima'),
	'before_widget' => '<div class="footer-widget">',
	'after_widget' => '</div>',
	'before_title' => '<h5>',
	'after_title' => '</h5>'
));



//  CUSTOM COMMENTS STYLING
function mytheme_comment($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class('single-comment blog-page'); ?> id="li-comment-<?php comment_ID() ?>">
	
	<div class="avatar float-left">
		<?php echo get_avatar($comment,$size='50',$default= THEME_DIR . '/images/avatar.png' ); ?>
	</div>
		
	<div class="comment-text">
		<span class="name"><?php comment_author_link(); ?></span>
		<span class="date"><?php printf(__('%1$s at %2$s'), get_comment_date(),get_comment_time()) ?>
		<?php edit_comment_link(__('(Edit)', 'bellissima'),'  ','') ?></span>			
			
		<p><?php comment_text() ?></p>
	</div>
	
	<?php if ($comment->comment_approved == '0') : ?>
	<em><?php _e('Your comment is awaiting moderation.', 'bellissima') ?></em>
	<br />
	<?php endif; ?>
	<div class="clear"></div>
</li>
<?php
}


// EQUAL SIZE OF TAGS IN TAGS WIDGET
function my_tag_cloud_filter($args = array()) {
   $args['smallest'] = 11;
   $args['largest'] = 11;
   $args['unit'] = 'px';
   return $args;
}

add_filter('widget_tag_cloud_args', 'my_tag_cloud_filter', 90);



// PAGINATION BY KREISI
function kriesi_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='blog_pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='paginate_current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}


//  SEARCH ONLY POSTS
function vibeExcludePages($query) {
if ($query->is_search) {
$query->set("post_type", "post");
}
return $query;
}
// if (!is_admin()) { add_filter("pre_get_posts","vibeExcludePages"); }



/**
* Title		: Aqua Resizer
* Description	: Resizes WordPress images on the fly
* Version	: 1.1.3
* Author	: Syamil MJ
* Author URI	: http://aquagraphite.com
*/
function aq_resize( $url, $width, $height = null, $crop = null, $single = true ) {

	//validate inputs
	if(!$url OR !$width ) return false;

	//define upload path & dir
	$upload_info = wp_upload_dir();
	$upload_dir = $upload_info['basedir'];
	$upload_url = $upload_info['baseurl'];

	//check if $img_url is local
	if(strpos( $url, home_url() ) === false) return false;

	//define path of image
	$rel_path = str_replace( $upload_url, '', $url);
	$img_path = $upload_dir . $rel_path;

	//check if img path exists, and is an image indeed
	if( !file_exists($img_path) OR !getimagesize($img_path) ) return false;

	//get image info
	$info = pathinfo($img_path);
	$ext = $info['extension'];
	list($orig_w,$orig_h) = getimagesize($img_path);

	//get image size after cropping
	$dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
	$dst_w = $dims[4];
	$dst_h = $dims[5];

	//use this to check if cropped image already exists, so we can return that instead
	$suffix = "{$dst_w}x{$dst_h}";
	$dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
	$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

	//if orig size is smaller
	if($width >= $orig_w) {

		if(!$dst_h) :
			//can't resize, so return original url
			$img_url = $url;
			$dst_w = $orig_w;
			$dst_h = $orig_h;

		else :
			//else check if cache exists
			if(file_exists($destfilename) && getimagesize($destfilename)) {
				$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
			} 
			//else resize and return the new resized image url
			else {
				$resized_img_path = image_resize( $img_path, $width, $height, $crop );
				$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
				$img_url = $upload_url . $resized_rel_path;
			}

		endif;

	}
	//else check if cache exists
	elseif(file_exists($destfilename) && getimagesize($destfilename)) {
		$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
	} 
	//else, we resize the image and return the new resized image url
	else {
		$resized_img_path = image_resize( $img_path, $width, $height, $crop );
		$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
		$img_url = $upload_url . $resized_rel_path;
	}

	//return the output
	if($single) {
		//str return
		$image = $img_url;
	} else {
		//array return
		$image = array (
			0 => $img_url,
			1 => $dst_w,
			2 => $dst_h
		);
	}

	return $image;
}




/* ADDING STYLES FROM THEME OPTIONS */
if (!function_exists('optionsframework_wp_head')) {
	function optionsframework_wp_head() { 
	
		of_head_css();
	}
}
add_action('wp_head', 'optionsframework_wp_head');

function fontface_selector($face, $facerepeat) {
	
	switch($face) {
		case "droid" : 
			if($facerepeat == false) { $output['script'] = '<link href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet" type="text/css">' . "\n"; } else {$output['script'] = "";}
			$output['style'] = '"Droid Sans",serif';
			return $output; break;
		case "kaushan" : 
			if($facerepeat == false) { $output['script'] = '<link href="http://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" type="text/css">' . "\n"; } else {$output['script'] = "";}
			$output['style'] = '"Kaushan Script",serif';
			return $output; break;
		case "droidserif" : 
			if($facerepeat == false) { $output['script'] = '<link href="http://fonts.googleapis.com/css?family=Droid+Serif:400,700,700italic" rel="stylesheet" type="text/css">' . "\n"; } else {$output['script'] = "";}
			$output['style'] = '"Droid Serif",serif';
			return $output; break;
		case "oswald" : 
			if($facerepeat == false) { $output['script'] = '<link href="http://fonts.googleapis.com/css?family=Oswald:400,700" rel="stylesheet" type="text/css">' . "\n"; } else {$output['script'] = "";}
			$output['style'] = '"Oswald",serif';
			return $output; break;
		case "merriweather" : 
			if($facerepeat == false) { $output['script'] = '<link href="http://fonts.googleapis.com/css?family=Merriweather:400,700" rel="stylesheet" type="text/css">' . "\n"; } else {$output['script'] = "";}
			$output['style'] = '"Merriweather",serif';
			return $output; break;
		case "mavenpro" : 
			if($facerepeat == false) { $output['script'] = '<link href="http://fonts.googleapis.com/css?family=Maven+Pro:400,700" rel="stylesheet" type="text/css">' . "\n"; } else {$output['script'] = "";}
			$output['style'] = '"Maven Pro",serif';
			return $output; break;
		default :
			$output['script'] = "";
			$output['style'] = '"' . $face . '",sans-serif';
			return $output;
	}
}

function font_style_selector($style) {
	switch($style) {
		case "italic":
			return "font-style: italic"; break;
		case "bold":
			return "font-weight: bold"; break;
		case "bold italic":
			return "font-weight: bold; font-style: italic;";
		default:
			return "font-style: normal; font-weight: normal;";			
	}
}

function of_head_css() {
	// Font face Selection
	$heading = of_get_option('heading_typography');	
	$content = of_get_option('content_typography');
	$hyperlink = of_get_option('link_typography');
	$theme_skin = of_get_option('color_scheme');
	$background = of_get_option('background_image', 'white_default');
	$background_image = '';
	
	// Background Image
	if($theme_skin == 'white') {	
		switch($background){
			case 'graffiti':
				$background_image = 'body {background-image: url(' . THEME_DIR . '/images/bkg2.jpg);} #container {background: url(' . THEME_DIR . '/images/graffiti.png) no-repeat 50% 0;}'; break;
			default :
				;
		}
	}
	elseif($theme_skin == 'purple') {
		switch($background){
			case 'bokeh':
				$background_image = 'body {background: #711043 url(' . THEME_DIR . '/css/skins/purple/images/bkg2.jpg) no-repeat center top;} #container {background: transparent;}'; break;
			default :
				;
		}
	}
	
	// Custom Background Image
	if (of_get_option('show_custombg') == true) {
		$background = of_get_option('theme_background');
		if ($background['image']) {
			$background_image = 'body {background: ' . $background['color'] . ' url(' . $background['image'] . ') ' . $background['repeat'] . ' ' . $background['position'] . ' ' . $background['attachment'] . ';} #container {background: transparent;}';;
		}
		else {
			$background_image = 'body {background: ' . $background['color'] . ';} #container {background: transparent;}';
		}
	}
	
	
	// Typography
	$default = of_get_option('default_typography', 1);	
	$facerepeat = ($heading['face'] == $content['face'])? true : false;	
	$content_face = fontface_selector($content['face'], false);
	$heading_face = fontface_selector($heading['face'], $facerepeat);
	
	if($default) {
		$content = 'html, body, .blog-post-home-title-inner, .accordion-simple h2, .accordion h2, .list-items span.title,.single-item span.title,.woocommerce_tabs .panel h2,h2.related_products_title,h4.related_products_title,.upsells h2,#respond #reply-title { font-family: ' . $content_face["style"] . '; }' . "\n";
		$heading = 'h1,h2,h3,h4,h5,h6, .message { font-family: ' . $heading_face['style'] . '; }' . "\n";
		$heading .= 'h5 { font-weight: bold; font-family: ' . $content_face["style"] . '; }' . "\n";
		$hyperlink = "";
	
	} else {	
		$content = 'html, body { color: ' . $content["color"] . '; ' . font_style_selector($content['style']) . ' font-family: ' . $content_face["style"] . '; }' . "\n";
		$content .= '.blog-post-home-title-inner, .accordion-simple h2, .accordion h2, .list-items span.title,.single-item span.title,.woocommerce_tabs .panel h2,h2.related_products_title,h4.related_products_title,.upsells h2,#respond #reply-title { font-family: ' . $content_face["style"] . '; }' . "\n";
		$heading = 'h1,h2,h3,h4,h5,h6, .message { color: ' . $heading["color"] . '; ' . font_style_selector($heading['style']) . ' font-family: ' . $heading_face['style'] . '; }' . "\n";
		$heading .= '.message { color: #fff; } h5 { font-weight: bold; font-family: ' . $content_face["style"] . '; }' . "\n";
		$hyperlink = 'a, a:visited,a.regular,a.regular:visited,a.arrow,a.arrow:visited,.blog-post-home-title-inner,.blog-entry .calendar,.detail-item .text-info span.title,.blog-entry a.title,#promo #main_navi li span.title{color: ' . $hyperlink["color"] . ';}' . "\n";
	}

	
	// WooCommerce Styles
	$woocommerce_styles = '';
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		global $woocommerce;
		$woocommerce_styles = '.exposureTarget {height:' . $woocommerce->get_image_size("shop_single_image_height") . 'px; width:' . $woocommerce->get_image_size("shop_single_image_width") . 'px;} ' . "\n";
	}
	
	echo $content_face['script'] . $heading_face['script'];
	
	// Adding All Custom Styles to Markup
	echo "\n<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $background_image . "\n" . $content . $heading . $hyperlink . $woocommerce_styles . of_get_option('add_styles') . "\n</style>\n";
}


// AUTOMATED FEED LINKS
add_theme_support( 'automatic-feed-links' );


// ADD FEATURED IMAGE FIELDS IN POSTS AND PORTFOLIO MANAGEMENT PAGES
function ST4_get_featured_image($post_ID) {
	$post_thumbnail_id = get_post_thumbnail_id($post_ID);
	if ($post_thumbnail_id) {
		$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
		return $post_thumbnail_img[0];
	}
}

function ST4_columns_head($defaults) {
	$defaults['featured_image'] = 'Featured Image';
	return $defaults;
}

function ST4_columns_content($column_name, $post_ID) {
	if ($column_name == 'featured_image') {
		$post_featured_image = ST4_get_featured_image($post_ID);
		if ($post_featured_image) {
			echo '<img src="' . aq_resize($post_featured_image, 100, 60, true) . '" alt="" />';
		}
	}
}

add_filter('manage_portfolio_posts_columns', 'ST4_columns_head');
add_action('manage_portfolio_posts_custom_column', 'ST4_columns_content', 10, 2);

?>