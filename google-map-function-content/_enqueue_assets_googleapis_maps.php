<?php
if ( ! is_admin() ) {// Do not use the API in the WordPress backend as it will be called twice
	$key = $this->get_api_key();
	if ($key) {
		wp_enqueue_script( 
		  'google-maps', 
		  '//maps.googleapis.com/maps/api/js?v=3.exp&key='.$key, 
		  array(), 
		  '1.0', 
		  true 
		);
	}
}