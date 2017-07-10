<?php
$options = get_option( 'wp_swift_google_map_settings' );
// echo "<pre>"; var_dump($options); echo "</pre>";
if (isset($options['show_sidebar_options_google_map_api_key']) && $options['show_sidebar_options_google_map_api_key'] != '') {
    if( function_exists('acf_add_local_field_group') ) {

        acf_add_local_field_group(array (
            'key' => 'group_59612c4191e29',
            'title' => 'Google Map',
            'fields' => array (
                array (
                    'key' => 'field_59612c4b9f1c0',
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
                array (
                    'key' => 'field_59612cd69f1c2',
                    'label' => 'Directions',
                    'name' => 'directions',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => 'field_59612ce99f1c3',
                    'min' => 0,
                    'max' => 8,
                    'layout' => 'block',
                    'button_label' => 'Add Directions',
                    'sub_fields' => array (
                        array (
                            'key' => 'field_59612ce99f1c3',
                            'label' => 'From Location',
                            'name' => 'from_location',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array (
                            'key' => 'field_59612d139f1c4',
                            'label' => 'Directions',
                            'name' => 'directions',
                            'type' => 'wysiwyg',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'tabs' => 'visual',
                            'toolbar' => 'basic',
                            'media_upload' => 0,
                            'delay' => 0,
                        ),
                    ),
                ),
                array (
                    'key' => 'field_59612c909f1c1',
                    'label' => 'WordPress Shortcodes',
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
'message' => 'Using shortcodes, you have the following options:
<pre class="prettyprint custom">
// WordPress shortcode

[google_map]

// This also accepts parameters

[google-map address="true"]
</pre>',
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