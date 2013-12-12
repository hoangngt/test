jQuery(document).ready(function($) {
	$('#skin_switcher a.skin_switcher_toggle').toggle(function(){
		$('#skin_switcher').stop().animate({left:'0'},400);
		$(this).css('background-position','0px -190px');
	},function(){
		$('#skin_switcher').stop().animate({left:'-250px'});
		$(this).css('background-position','0px 0px');
	});
	
	$('#menu_wrapper').mobileMenu({
		defaultText: 'Navigate to...',
		className: 'select-menu',
		subMenuDash: '&nbsp;'
	});

	// Slider
	$(".slider").scrollable({
		next: '.next2', 
		prev: '.prev2'
	});
	
	
	// Fancybox
	$("a.grouped-elements").fancybox({
		'titlePosition'	: 'inside'
	});
	$("a[rel=group4]").fancybox({
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'titlePosition' 	: 'over',
		'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
			return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
		}
	});
	

	// Accordion
	$('.accordion, .accordion-simple').each(function(i, obj) {
		$(this).children("h2:first").addClass("current");
		$(this).children(".pane:first").css("display", "block");
	});
	
	// Megamenu
	var $menu = $('#ldd_menu');
	$menu.children('li').each(function(){
		var $this = $(this);
		var $span = $this.children('span');
		$span.data('width',$span.width());
		
		$this.bind('mouseenter',function(){
			$menu.find('.ldd_submenu').stop(true,true).hide();
			$span.stop().animate({'width':'auto'},150,function(){
				$this.find('.ldd_submenu').slideDown(300);
			});
		}).bind('mouseleave',function(){
			$this.find('.ldd_submenu').stop(true,true).hide();
			$span.stop().animate({'width':$span.data('width')+'px'},300);
		});
	});
	
	// Collapsible menu
	$(".shop_widget, #features .box").collapse({
		show: function() {
			this.animate({opacity: 'toggle', height: 'toggle'}, 300);
		},
		hide : function() {
			this.animate({opacity: 'toggle', height: 'toggle'}, 300);
		}
	});
	
	// Contact Form
	$('#send_message').click(function(e){
		e.preventDefault();
		var error = false;
		var name = $('#contact_name').val();
		var email = $('#contact_email').val();
		var message = $('#contact_message').val();

		if(name.length == 0){
			error = true;
			$('#name_error').fadeIn(500);
		}else{
			$('#name_error').fadeOut(500);
		}
		if(email.length == 0 || email.indexOf('@') == '-1'){
			error = true;
			$('#email_error').fadeIn(500);
		}else{
			$('#email_error').fadeOut(500);
		}
		if(message.length == 0){
			error = true;
			$('#message_error').fadeIn(500);
		}else{
			$('#message_error').fadeOut(500);
		}

		if(error == false){
			$('#send_message').attr({'disabled' : 'true', 'value' : 'Sending..' });

			var contactformurl = mysiteurl+"/js/send_email.php";
			$.post(contactformurl, $("#contactform").serialize(),function(result){
				if(result == 'sent'){
					$('#cf_submit_p').remove();
					$('#mail_success').fadeIn(500);
				}else{
					$('#mail_fail').fadeIn(500);
					$('#send_message').removeAttr('disabled').attr('value', 'Send');
				}
			});
		}
	});
	
	
	
	
	// Tabs
	$("ul.tabs").tabs("div.panes > .tab-content");
	$("ul.tabs-simple").tabs("div.panes.simple > .tab-content");
	$(".accordion").tabs(".accordion div.pane", {tabs: 'h2', effect: 'slide', initialIndex: null});
	$(".accordion-simple").tabs(".accordion-simple div.pane", {tabs: 'h2', effect: 'slide', initialIndex: null});
	
	// Border effects
	$(".featured-product-item img").insetBorder({
		borderColor : '#EFE4DC',
		inset: 5
	});
	
	// Slider Thumbnail Border Effect
	$("#main_navi li img").insetBorder({
		borderColor : '#EFE4DC',
		inset: 4
	});
	
	// Navigation menu
	$('ul.sf-menu').superfish({ 
		delay: 100
	});
	
	// Mouseover effect for thumbnails
	$("a.grouped-elements").hover(function() {
	  $(this).find(".imagehover").toggleClass("mouseon");
	});
	
	// Dropdown show/hide
	$(".dropdown").click(function() {
		// Hiding any open menus
		$(".dropdown").not(this).each(function() {
			$(this).find("ul").hide();
			$(this).find("a.nav-link").removeClass('selected');
		})
	
		$(this).find("ul").toggle();
		$(this).find("a.nav-link").toggleClass('selected');
	});
	// Closing the menu if click outside
	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
         
		if (! $clicked.parents().hasClass("dropdown")) {
			$(this).find('.dropdown a.nav-link').removeClass("selected");
			$(".dropdown ul").hide();
		}
	});
	
});

jQuery.noConflict();
jQuery(window).load(function() {
	jQuery('.flickr_badge').fadeIn(300);
	
	jQuery(".flickr_badge_image a img").attr("width", 130);
	jQuery(".flickr_badge_image a img").attr("height", 90);
  
	jQuery('.flickr_badge_image').hover(function() {
		jQuery(this).stop().animate({"opacity": 0.7}, 300);
	}, function () {
		jQuery(this).stop().animate({"opacity": 1}, 300);
	});

});