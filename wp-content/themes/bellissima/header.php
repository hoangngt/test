<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
<head>

<!-- Meta Tags -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="description" content="Keywords">
<meta name="author" content="Name">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- Link Tags -->
<link rel="shortcut icon" href="<?php echo (!of_get_option('favicon') == "")? of_get_option('favicon'): THEME_DIR . '/images/favicon.png'; ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- Title -->
<title><?php wp_title('&raquo;','true','right'); ?><?php if ( is_single() ) { ?> Blog Archive &raquo; <?php } ?><?php bloginfo('name'); ?></title>

<!-- Main style -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
<?php 
wp_enqueue_style( 'woocommerce_fancybox_styles', THEME_DIR . '/fancybox/fancybox.css', array(), '1', 'all' );
wp_enqueue_style( 'plugins', THEME_DIR . '/css/plugins.css', array(), '1', 'all' );
?>

<!-- JS for jQuery -->
<?php wp_head(); ?>
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script type="text/javascript">	var mysiteurl = "<?php echo THEME_DIR ?>"; </script>

</head>
<?php flush(); ?>
<body <?php body_class(); ?>>
<div id="container">
<?php global $woocommerce; $my_site_url = get_home_url(); ?>
	<?php if(of_get_option('show_top_teaser')) { ?>
	<div id="header-top">
		<?php echo of_get_option('top_teaser') ?>
	</div><?php } ?>
	
	<div class="header-main">
		<div class="logo">
			<a href="<?php echo $my_site_url; ?>" name="top"><img src="<?php echo (!of_get_option('logo') == "")? of_get_option('logo'): THEME_DIR . '/images/logo.png'; ?>" alt="logo" /></a>
		</div>
		
		<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
		<div class="login-block">
			<span class="account">
				 <?php if ( is_user_logged_in() ) { ?>
				<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','bellissima'); ?>"><?php _e('My Account','bellissima'); ?></a>
				 <?php } 
				 else { ?>
				<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login','bellissima'); ?>"><?php _e('Login','bellissima'); ?></a>
				 <?php } ?>
			</span>
			<span class="cart"><a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><?php _e('My Cart', 'bellissima'); ?> (<span id="top_item_count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'bellissima'), $woocommerce->cart->cart_contents_count);?></span>)</a></span>
		</div><?php } ?>
	</div>
	
	<div id="navigation">
		
		<div class="search-container">
			<div class="search-inner">	
				<form method="get" action="<?php echo $my_site_url; ?>">
					<input type="text" value="<?php _e('Search...', 'bellissima'); ?>" onfocus="if(this.value=='<?php _e('Search...', 'bellissima'); ?>'){this.value=''};" onblur="if(this.value==''){this.value='<?php _e('Search...', 'bellissima'); ?>'};" class="search-field" name="s" />
					<input type="hidden" name="post_type" value="<?php echo of_get_option('top_search', 'post') ?>" />
					<input type="submit" id="s_submit" value="" class="search-btn"/>
				</form>
			</div>
		</div>
		<div class="navigation-inner">
			<div class="home-icon">
				<a href="<?php echo $my_site_url; ?>"><img src="<?php echo THEME_DIR; ?>/images/home_icon.png" /></a>
			</div>
			
			<!-- Menu -->
			<div id="menu_wrapper">
			<?php wp_nav_menu( array('theme_location' => 'primary', 'menu_class' => 'sf-menu', 'container' => 'false' )); ?>
			</div>
			
			<?php if(of_get_option('show_megamenu')) { ?>
			<!-- Megamenu Begin -->
			<ul id="ldd_menu" class="ldd_menu">
				<li>
					<span><?php echo of_get_option('megamenu_title', 'Mega Menu') ?></span>
					<div class="ldd_submenu">
					<?php echo do_shortcode(of_get_option('megamenu')) ?>
					</div>
				</li>
			</ul>
			<!-- Megamenu End --><?php } ?>
			
			<div class="search-inner">	
				<form method="get" action="<?php echo $my_site_url; ?>">
					<input type="text" value="<?php _e('Search...', 'bellissima'); ?>" onfocus="if(this.value=='<?php _e('Search...', 'bellissima'); ?>'){this.value=''};" onblur="if(this.value==''){this.value='<?php _e('Search...', 'bellissima'); ?>'};" class="search-field" name="s" />
					<input type="hidden" name="post_type" value="<?php echo of_get_option('top_search', 'post') ?>" />
					<input type="submit" id="s_submit" value="" class="search-btn"/>
				</form>
			</div>
		</div>
	</div>