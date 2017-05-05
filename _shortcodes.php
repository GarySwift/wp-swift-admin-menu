<?php
/*
 * email Shortcode
 */
function shortcode_email($atts = array(), $content = null, $tag = '') {
	$value = '';
	if( get_field('email' , 'option') ) {
		$value = get_field('email' , 'option');
		$value = '<span class="key-value email"><span class="key">Email: </span><span class="value"><a href="mailto:'.$value.'">'.$value.'</a></span></span>';
	}
	return generic_shortcode_wrap($value, $atts);  
}
function register_email_shortcode() {
  add_shortcode('email', 'shortcode_email');
}
add_action( 'init', 'register_email_shortcode');

/*
 * Address Shortcode
 */
function shortcode_address($atts = array(), $content = null, $tag = '') {
	$value = '';
	if( get_field('address' , 'option') ) {
		$value = get_field('address' , 'option');
	}
	return generic_shortcode_wrap($value, $atts);  
}
function register_address_shortcode() {
  add_shortcode('address', 'shortcode_address');
}
add_action( 'init', 'register_address_shortcode');

/*
 * Mobile Shortcode
 */
function shortcode_mobile($atts = array(), $content = null, $tag = '') {
	$value = '';
	if ( function_exists('get_phone') )  {
	    $mobile_readable = get_phone('mobile');
	    $mobile = get_phone('mobile', true);
		$value = '<span class="key-value phone"><span class="key">Tel: </span><span class="value"><a href="tel:'.$mobile.'">'.$mobile_readable.'</a></span></span>';
	}
	return generic_shortcode_wrap($value, $atts);
}
function register_mobile_shortcode() {
  add_shortcode('mobile', 'shortcode_mobile');
}
add_action( 'init', 'register_mobile_shortcode');

/*
 * Check for generic attributes
 */
function generic_shortcode_wrap($value='', $atts = array(), $content = null, $tag = '') {
	$class = '';
	$wrap_open = '';
	$wrap_close  = '';
	$wrap='p';

	if (isset($atts["class"])) {
		$class = ' class="'.$atts["class"].'"';
	}

	if (!isset($atts["wrap"])) {
		$wrap_open = '<'.$wrap.$class.'>';
		$wrap_close = '</'.$wrap.'>';
	}
	elseif (isset($atts["wrap"]) && $atts["wrap"] != 'false') {
		$wrap_open = '<'.$atts["wrap"].$class.'>';
		$wrap_close = '</'.$atts["wrap"].'>';
	}
	return $wrap_open.$value.$wrap_close;
}