<?php
/**
 * A shortcode for rendering the google map.
 *
 * @param  array   $attributes  Shortcode attributes.
 * @param  string  $content     The text content for shortcode. Not used.
 *
 * @return string  The shortcode output
 */
if ( !function_exists('get_google_map') )  {
    function get_google_map( $attributes=null, $content = null ) {
    	$options = get_option( 'wp_swift_google_map_settings' );
        ob_start();

        if (isset($options['show_sidebar_options_google_map_api_key']) && $options['show_sidebar_options_google_map_api_key'] != ''):
     		
     		$location = get_field('map', 'option');
			if( !empty($location) ):
			?>
				<?php if (isset($attributes['address'])): ?>
					<p><?php echo $location['address']; ?></p>
				<?php endif ?>
				
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<div class="callout">
				<h5>Sorry, there was a problem with the Google API key.</h5>
			</div>
			<?php
		endif;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }	
}




/**
 * A helper fuction to get contact page phone numnbers with optional parse
 *
 * @param  array    $field  	AV\Cf field
 * @param  boolean  $parse     	If the phone numbee will be parsed
 *
 * @return string  The shortcode output
 */
if ( !function_exists('get_phone') )  {
    function get_phone($field, $parse = false) {
    	if( function_exists('acf')) {
	    	if( get_field($field, 'option') ) {
	            $phone_num = get_field($field, 'option');
	            if ($parse) {
	            	$phone_num =  parse_phone_number($phone_num);
	            }
	            return $phone_num;
	        }
    	}
    	return '';
    }	
}

function parse_phone_number($phone_num) {
	$phone_num = str_replace('(0)', '', $phone_num);
	$phone_num = str_replace(' ', '', $phone_num);	
	return $phone_num;
}
