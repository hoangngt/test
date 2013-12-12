<?php

/*     SHORTCODES      */

// CLEAR SHORTCODE
function clear_code() {
return '<div class="clear"></div>';
}
add_shortcode('clear', 'clear_code');

// RAW SHORTCODE FOR DISABLING AUTO FORMATTING IN POSTS
function raw_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}
	return $new_content;
}
// Remove the 2 main auto-formatters
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
// Before displaying for viewing, apply this function
add_filter('the_content', 'raw_formatter', 99);
add_filter('widget_text', 'raw_formatter', 99);


function rawr_code( $atts, $content = null ) {
	
	$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	return do_shortcode($content);
	
}
add_shortcode('rawr', 'rawr_code');

// HALF COLUMN
function col2_code( $atts, $content = null ) {
	return '<div class="sh-one-half float-left">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('col2', 'col2_code');

// HALF LAST
function col2_last_code( $atts, $content = null ) {
	return '<div class="sh-one-half float-left column-last">' . "\n" . do_shortcode($content) . "\n" . '</div><div class="clear"></div>';
}
add_shortcode('col2_last', 'col2_last_code');

// ONE THIRD COLUMN
function col3_code( $atts, $content = null ) {
	return '<div class="sh-one-third float-left">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('col3', 'col3_code');

// ONE THIRD LAST
function col3_last_code( $atts, $content = null ) {
	return '<div class="sh-one-third float-left column-last">' . "\n" . do_shortcode($content) . "\n" . '</div><div class="clear"></div>';
}
add_shortcode('col3_last', 'col3_last_code');

// ONE FOURTH COLUMN
function col4_code( $atts, $content = null ) {
	return '<div class="sh-one-fourth float-left">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('col4', 'col4_code');

// ONE FOURTH LAST
function col4_last_code( $atts, $content = null ) {
	return '<div class="sh-one-fourth float-left column-last">' . "\n" . do_shortcode($content) . "\n" . '</div><div class="clear"></div>';
}
add_shortcode('col4_last', 'col4_last_code');

// TWO THIRD COLUMN
function col23_code( $atts, $content = null ) {
	return '<div class="sh-two-third float-left ">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('col23', 'col23_code');

// TWO THIRD LAST
function col23_last_code( $atts, $content = null ) {
	return '<div class="sh-two-third float-left column-last">' . "\n" . do_shortcode($content) . "\n" . '</div><div class="clear"></div>';
}
add_shortcode('col23_last', 'col23_last_code');

// THREE FOURTH COLUMN
function col34_code( $atts, $content = null ) {
	return '<div class="sh-three-fourth float-left">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('col34', 'col34_code');

// THREE FOURTH LAST
function col34_last_code( $atts, $content = null ) {
	return '<div class="sh-three-fourth float-left column-last">' . "\n" . do_shortcode($content) . "\n" . '</div><div class="clear"></div>';
}
add_shortcode('col34_last', 'col34_last_code');


// TABS MAIN SHORTCODE
function tabs_main($atts, $content = null) {

	$output = '<div class="tab-wrap">
				<ul class="tabs">';
	foreach ($atts as $tab) {
		$output .= '<li><a href="#">' .$tab. '</a></li>';
	}	
	$output .= '</ul><div class="clear"></div><div class="panes">' . do_shortcode($content) . '</div></div>';
	return $output;
}
add_shortcode('tabgroup', 'tabs_main');

// ALTERNATIVE STYLED TAB
function simple_tabs_main($atts, $content = null) {

	$output = '<div class="tab-wrap">
				<ul class="tabs-simple">';
	foreach ($atts as $tab) {
		$output .= '<li><a href="#">' .$tab. '</a></li>';
	}	
	$output .= '</ul><div class="clear"></div><div class="panes simple">' . do_shortcode($content) . '</div></div>';
	return $output;
}
add_shortcode('alt-tabgroup', 'simple_tabs_main');


// TAB ELEMENT
function tab_elements($atts, $content = null) {
	return '<div class="tab-content"><p>' . do_shortcode($content) . '</p></div>';
}
add_shortcode('tab', 'tab_elements');


// ACCORDION
function accordion_main($atts, $content = null) {
	return '<div class="accordion">' . do_shortcode($content) . '</div>';
}
add_shortcode('accordion', 'accordion_main');

// ALTERNATIVE ACCORDION
function simple_accordion_main($atts, $content = null) {
	return '<div class="accordion-simple">' . do_shortcode($content) . '</div>';
}
add_shortcode('alt-accordion', 'simple_accordion_main');


// ACCORDION ELEMENT
function accordion_elements($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => "Title"
	), $atts));
	$output = '<h2>' . $title . '</h2><div class="pane"><p>' . do_shortcode($content) . '</p></div>';
	return $output;
}
add_shortcode('pane', 'accordion_elements');


//		LIST TYPE SHORTCODE
function list_code($atts, $content = null) {
	extract(shortcode_atts(array( "type" => 'list' ), $atts));	
	
	return '<div class="bullet-list bullet-list-' . $type . '">'  . do_shortcode($content) . '</div>';	
}
add_shortcode('list', 'list_code');

//		ICONS SHORTCODE
function icon_code($atts, $content = null) {
	extract(shortcode_atts(array( "type" => 'notepad' ), $atts));	
	
	return '<p class="icon-list-' . $type . '">'  . do_shortcode($content) . '</p>';	
}
add_shortcode('icon', 'icon_code');

//		DIVIDER SHORTCODE
function divider_code($atts, $content = null) {
	return '<div class="divider"></div>';
}
add_shortcode('divider', 'divider_code');


//     SHORTCODES FOR BUTTONS
function btn_code($atts, $content = null) {
	extract(shortcode_atts(array( "linkto" => '', "color" => 'orange', "size" => '' ), $atts));
	
	$btnsize = "";
	if($size == "big")
	$btnsize = '-' . $size;
	
	if($color == "purple" || $color == "grey" || $color == "black" || $color == "red" || $color == "green" || $color == "blue")
	return '<a href="' . $linkto . '" class="general-button' . $btnsize . '-' . $color . ' sh-button-margin"><span class="button' . $btnsize . '-' . $color . '">' . do_shortcode($content) . '</span></a>';
	else
	return '<a href="' . $linkto . '" class="general-button' . $btnsize . '-orange sh-button-margin"><span class="button' . $btnsize . '-orange">' . do_shortcode($content) . '</span></a>';
}
add_shortcode('button', 'btn_code');


//		SUCESS SHORTCODE
function success_code( $atts, $content = null ) {
	return '<div class="alert_success">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('success', 'success_code');

//		ERROR SHORTCODE
function error_code( $atts, $content = null ) {
	return '<div class="alert_error">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('error', 'error_code');

//		INFO SHORTCODE
function info_code( $atts, $content = null ) {
	return '<div class="alert_info">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('info', 'info_code');

//		WARNING SHORTCODE
function warning_code( $atts, $content = null ) {
	return '<div class="alert_warning">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('warning', 'warning_code');


//		FAQ SHORTCODE
function faq_code( $atts, $content = null ) {
	return '<ul class="faq-item">' . "\n" . do_shortcode($content) . "\n" . '</ul>';
}
add_shortcode('faq', 'faq_code');

//		FAQITEM SHORTCODE
function faqitem_code($atts, $content = null) {
	extract(shortcode_atts(array( "question" => 'Add a question here.' ), $atts));
		
	$output = '<li><dl>';
	$output .= '<dd><span class="question-symbol">Q:</span><p class="question">' . $question . '</p></dd>';
	$output .= '<dd><span class="answer-symbol">A:</span><p>' . do_shortcode($content) . '</p></dd>';
	$output .= '<dd><a href="#top" class="regular" title="Back to top">Back to top</a></dd>';
	$output .= '</dl></li>';
	return $output;
}
add_shortcode('faqitem', 'faqitem_code');


//		SOCIAL SHORTCODE
function social_code($atts, $content = null) {
	extract(shortcode_atts(array( "type" => 'twitter' ), $atts));
		
	switch($type) {
		case 'facebook': return '<a href="' . do_shortcode($content) . '" class="social_icons social_facebook">facebook</a>'; break;
		case 'vimeo': return '<a href="' . do_shortcode($content) . '" class="social_icons social_vimeo">vimeo</a>'; break;
		case 'youtube': return '<a href="' . do_shortcode($content) . '" class="social_icons social_youtube">youtube</a>'; break;
		case 'google': return '<a href="' . do_shortcode($content) . '" class="social_icons social_google">google</a>'; break;
		default : return '<a href="' . do_shortcode($content) . '" class="social_icons social_twitter">twitter</a>'; break;
	}
}
add_shortcode('social', 'social_code');



//		TEXT HIGHLIGHT SHORTCODE
function highlight_code($atts, $content = null) {
	extract(shortcode_atts(array( "color" => 'light' ), $atts));
	
	if($color=='dark')
		return '<span class="sh-highlight-text">'  . do_shortcode($content) . '</span>';
	else
		return '<span class="sh-highlight-lite-text">'  . do_shortcode($content) . '</span>';
}
add_shortcode('highlight', 'highlight_code');

//		FANCY LINK SHORTCODE
function link_code($atts, $content = null) {
	extract(shortcode_atts(array( "type" => 'regular', "linkto" => ''), $atts));
	
	if($type=='arrow')
		return '<a href="' . $linkto . '" class="arrow"><span>'  . do_shortcode($content) . '</span></a>';
	else
		return '<a href="' . $linkto . '" class="regular"><span>'  . do_shortcode($content) . '</span></a>';
}
add_shortcode('link', 'link_code');


//		CONTACT SHORTCODE
function contactform_code($atts, $content = null) {
		extract(shortcode_atts(array(
				"sendto" => ''
		), $atts));
		
		return "<div class='comment-form-container' id='contact-wrapper'>
	<form action='index.php' method='post' id='contactform'>

		<div class='form-name float-left'>
			<label for='contact_name'>" . __('Your Name', 'bellissima') . ":</label>
			<input type='text' size='50' name='contact_name' id='contact_name' value='' class='required form-name input-text' />
			<div class='clear'></div>
			<span id='name_error' class='contact_error'>* " . __('Please enter your name', 'bellissima') . "</span>
		</div>
		
		
		<div class='form-name float-right'>
			<label for='contact_email'>" . __('Your Email', 'bellissima') . ": </label>
			<input type='text' size='50' name='contact_email' id='contact_email' value='' class='required email form-name input-text' />
			<div class='clear'></div>
			<span id='email_error' class='contact_error'>* " . __('Please enter a valid email id', 'bellissima') . "</span>
		</div>
		<br class='clear'/>

		<div class='form-comment'>
			<label for='contact_message'>" . __('Message', 'bellissima') . ":</label>
			<textarea rows='4' cols='20' name='contact_message' id='contact_message' class='required txtarea-comment'></textarea>		
			<div class='clear'></div>
			<span id='message_error' class='contact_error'>* " . __('What do you want to tell us?', 'bellissima') . "</span>
		</div>

		<input id='emailAddress' type='hidden' name='emailAddress' value='" . $sendto . "' />

		<div class='clear'></div>

		<div id='mail_success' class='contact_error alert_success'>" . __('Email sent! We will get back to you as soon as we can.', 'bellissima') . "</div>
		<div id='mail_fail' class='contact_error alert_error'>" . __('Sorry, we dont know what happened. Try again later.', 'bellissima') . "</div>
		
		<p id='cf_submit_p'>
		<input type='submit' id='send_message' class='button' value='" . __('Send Message', 'bellissima') . "' name='submit' />
		</p>

	</form>
</div>";
}
add_shortcode('contactform', 'contactform_code');

?>