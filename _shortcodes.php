<?php
/*
 * email Shortcode
 */
function shortcode_email($atts = array(), $content = null, $tag = '') {
	$value = '';
	$key = '';
	if( get_field('email' , 'option') ) {
		$value = get_field('email' , 'option');
		if (isset($atts["key"]) && $atts["key"] !== "false") {
			$key = '<span class="key">Email: </span>';
		}
		$value = '<span class="key-value email">'.$key.'<span class="value"><a href="mailto:'.$value.'">'.$value.'</a></span></span>';
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
	$site = array(
		'name' => get_bloginfo('name'),
		'description' => get_bloginfo('description'),
	);
	if ( is_array($atts) && in_array('name', $atts)) {
		$value = $site['name'].'<br>';
	}
	if (is_array($atts) && in_array('description', $atts)) {
		$value .= $site['description'].'<br>';
	}

	if( get_field('address' , 'option') ) {
		$value .= get_field('address' , 'option');
	}
	return '<p>'.$value.'</p>';
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
 * Mobile Shortcode
 */
function shortcode_phone($atts = array(), $content = null, $tag = '') {
	$value = '';
	if ( function_exists('get_phone') )  {
	    $phone_readable = get_phone('office_phone');
	    $phone = get_phone('office_phone', true);
		$value = '<span class="key-value phone"><span class="key">Tel: </span><span class="value"><a href="tel:'.$phone.'">'.$phone_readable.'</a></span></span>';
	}
	return generic_shortcode_wrap($value, $atts);
}
function register_phone_shortcode() {
  add_shortcode('phone', 'shortcode_phone');
}
add_action( 'init', 'register_phone_shortcode');

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