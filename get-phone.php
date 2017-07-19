<?php
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
