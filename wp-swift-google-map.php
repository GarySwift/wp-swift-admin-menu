<?php
<<<<<<< HEAD

=======
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
    	$class = 'acf-map';
    	if (isset($attributes['class'])) {
    		$class = $attributes['class'];
    	}
    	$options = get_option( 'wp_swift_google_map_settings' );
        ob_start();

        if (isset($options['show_sidebar_options_google_map_api_key']) && $options['show_sidebar_options_google_map_api_key'] != ''):
     		
     		$location = get_field('map', 'option');
			if( !empty($location) ):
			?>
				<?php if (isset($attributes['address'])): ?>
					<p><?php echo $location['address']; ?></p>
				<?php endif ?>
				
				<div class="<?php echo $class; ?>">
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
>>>>>>> db9ccac846208dd25d328005e49659bf1fdb0126




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
/*
 * Parse the number into a valid dialable number
 */
function parse_phone_number($phone_num) {
	$firstchar = mb_substr($phone_num,1,1);
	if ($firstchar === '0') {
		/*
		 * If the first character is 0, we assume the country is Ireland
		 * and append the country code +353 (and drop the 0)
		 */		
		$rest =  mb_substr($phone_num,2);
		$phone_num = '+353'.$rest;
		$phone_num = str_replace(' ', '', $phone_num);
	}
	else {
		/*
		 * Else we parse the string and remove spaces and brackets
		 */		
		$phone_num = str_replace('(0)', '', $phone_num);
		$phone_num = str_replace(' ', '', $phone_num);			
	}
	/*
	 * Return the valid dialable number
	 */
	return $phone_num;
}
