<?php
function opening_hours_repeater_filter( $value, $post_id, $field ){
    if (!is_array($value)) {
        $value = array();
    }
    $days = array(
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    );
    foreach( $days as $key => $day ) {
        if ($key == 0 ) {
            if (!isset($value[$key])) {
                if (!isset($value[$key]['field_56e59b65baec3'])) {
                    $value[$key]['field_56e59b65baec3'] = $day;
                }
                if (!isset($value[$key]['field_56e59b88baec4'])) {
                    $value[$key]['field_56e59b88baec4'] = '09:00';
                }
                if (!isset($value[$key]['field_56e59bd1baec5'])) {
                   $value[$key]['field_56e59bd1baec5'] = '17:30';
                }
            }
        }    
        elseif ($key > 0 && $key < 5 ) {
            if (!isset($value[$key])) {
                if (!isset($value[$key]['field_56e59b65baec3'])) {
                    $value[$key]['field_56e59b65baec3'] = $day;
                }
            }
        }
        else {
            if (!isset($value[$key])) {
                if (!isset($value[$key]['field_56e59b65baec3'])) {
                    $value[$key]['field_56e59b65baec3'] = $day;
                }
                if (!isset($value[$key]['field_56e59ebff4178'])) {
                   $value[$key]['field_56e59ebff4178'] = 0;
                }
            }
        }
    }
    return $value;
}

// acf/load_value/name={$field_name} - filter for a specific value load based on it's field name
add_filter('acf/load_value/key=field_56e59b43baec2', 'opening_hours_repeater_filter', 10, 3);

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
    'key' => 'group_56e59ac742c09',
    'title' => 'Opening Hours',
    'fields' => array (
        array (
            'key' => 'field_56e59ff9f9aab',
            'label' => 'Notes',
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
            'message' => 'Days marked as open will inherit the previous days hours if left empty.<div><b>Shortcodes</b></div><pre class="prettyprint custom">
// WordPress shortcodes
[opening-hours]
[opening-hours-custom]
</pre><i>Place any of the above shortcodes in into a text editor to output opening times.</i>',
            'new_lines' => 'wpautop',
            'esc_html' => 0,
        ),
        array (
            'key' => 'field_56e59b43baec2',
            'label' => 'Days',
            'name' => 'days',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => 'disable-sorting',
                'id' => '',
            ),
            'collapsed' => '',//field_56e59b65baec3
            'min' => 7,
            'max' => 7,
            'layout' => 'table',
            'button_label' => 'Add Row',
            'sub_fields' => array (
                array (
                    'key' => 'field_56e59b65baec3',
                    'label' => 'Day',
                    'name' => 'day',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
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
                    'readonly' => 0,
                    'disabled' => 0,
                    'readonly' => 1
                ),
                array (
                    'key' => 'field_56e59b88baec4',
                    'label' => 'Opening Time',
                    'name' => 'open',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array (
                        array (
                            array (
                                'field' => 'field_56e59ebff4178',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '09:00',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                    'readonly' => 0,
                    'disabled' => 0,
                ),
                array (
                    'key' => 'field_56e59bd1baec5',
                    'label' => 'Closing Time',
                    'name' => 'close',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array (
                        array (
                            array (
                                'field' => 'field_56e59ebff4178',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '17:30',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                    'readonly' => 0,
                    'disabled' => 0,
                ),
                array (
                    'key' => 'field_56e59ebff4178',
                    'label' => 'Open',
                    'name' => 'status',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => '',
                    'default_value' => 1,
                ),
            ),
        ),
        array (
            'key' => 'field_56e59ce39bff3',
            'label' => 'Custom Days',
            'name' => 'custom_days',
            'type' => 'repeater',
            'instructions' => 'Use this feature to add hours for holidays etc.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => 'disable-sorting',
                'id' => '',
            ),
            'collapsed' => '',//field_56e59ce39bff4
            'min' => '',
            'max' => '',
            'layout' => 'table',
            'button_label' => 'Add Day',
            'sub_fields' => array (
                array (
                    'key' => 'field_56e59ce39bff4',
                    'label' => 'Day',
                    'name' => 'day',
                    'type' => 'date_picker',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'display_format' => 'F j, Y',
                    'return_format' => 'd/m/Y',
                    'first_day' => 1,
                ),
                array (
                    'key' => 'field_56e59ce39bff5',
                    'label' => 'Opening Times',
                    'name' => 'open',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array (
                        array (
                            array (
                                'field' => 'field_56e5adf2841b1',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '09:00',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                    'readonly' => 0,
                    'disabled' => 0,
                ),
                array (
                    'key' => 'field_56e59ce39bff6',
                    'label' => 'Closing Time',
                    'name' => 'close',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array (
                        array (
                            array (
                                'field' => 'field_56e5adf2841b1',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '17:30',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                    'readonly' => 0,
                    'disabled' => 0,
                ),
                array (
                    'key' => 'field_56e5adf2841b1',
                    'label' => 'Open',
                    'name' => 'status',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => '',
                    'default_value' => 1,
                ),
            ),
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'opening-hours',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',//default
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));

endif;