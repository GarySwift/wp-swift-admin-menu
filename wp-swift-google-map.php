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

function parse_phone_number($phone_num) {
	$phone_num = str_replace('(0)', '', $phone_num);
	$phone_num = str_replace(' ', '', $phone_num);	
	return $phone_num;
}
