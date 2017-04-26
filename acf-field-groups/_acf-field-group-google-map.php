<?php
$options = get_option( 'wp_swift_admin_menu_settings' );
if (isset($options['show_sidebar_options_google_map_api_key']) && $options['show_sidebar_options_google_map_api_key'] != '') {
	if( function_exists('acf_add_local_field_group') ) {

		acf_add_local_field_group(array (
			'key' => 'group_58b53ef2b3176',
			'title' => 'Google Map',
			'fields' => array (
				array (
					'key' => 'field_58b5464b3d00a',
					'label' => 'Map',
					'name' => 'map',
					'type' => 'google_map',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'center_lat' => '52.259320',
					'center_lng' => '-7.110070',
					'zoom' => 16,
					'height' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'google-map',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'seamless',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));

	}
}
else {
	if( function_exists('acf_add_local_field_group') ) {

		acf_add_local_field_group(array (
			'key' => 'group_58ed23a5ab9e1',
			'title' => 'Google Map Warning',
			'fields' => array (
				array (
					'key' => 'field_58ed27d01ffdf',
					'label' => 'API Key Warning',
					'name' => '',
					'type' => 'message',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '<p>Google maps require an API key to be set.</p>
		<p>Please set now <b>BrightLight > Settings</b> or contact side admin if you do not have permission.</p>',
					'new_lines' => '',
					'esc_html' => 0,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'google-map',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'seamless',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));
	}
}