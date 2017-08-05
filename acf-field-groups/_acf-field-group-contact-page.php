<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_58ee803f4eb5d',
	'title' => 'Contact Details',
	'fields' => array (
		array (
			'key' => 'field_58ee80cbf9d78',
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
			'message' => 'You should input the phone number so that it is easily readable by humans. This is then parsed in the background to become a machine dialable number. (ie. users can click to call on their phone.) The number input here is the publically visible number that users will see.

<b>Example:</b>

<pre>+353 (0)51 124 1234</pre>

This will then be parsed into:

<pre>+35351124234</pre>

As you can see, spaces are removed as is the optional zero and brackets before the area code.

<b>Shortcodes:</b>

Shortcodes are automatically wrapped in a p tag. Most shortcodes will take the following attributes like this:

<pre>[shortcode wrap="h3" class="highlight"]</pre>

Or you can remove the wrap using the false attribute.

<pre>[shortcode wrap="false"]</pre>',
			'new_lines' => 'wpautop',
			'esc_html' => 0,
		),
		array (
			'key' => 'field_58ee806d145a3',
			'label' => 'Mobile',
			'name' => 'mobile',
			'type' => 'text',
			'instructions' => 'Shortcode: [mobile]',
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
		),
		array (
			'key' => 'field_58ee804f145a2',
			'label' => 'Office Phone',
			'name' => 'office_phone',
			'type' => 'text',
			'instructions' => 'Shortcode: [phone]',
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
		),
		array (
			'key' => 'field_58ee8078145a4',
			'label' => 'Email',
			'name' => 'email',
			'type' => 'email',
			'instructions' => 'Shortcode: [email]',
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
		),
		array (
			'key' => 'field_58ee83cdc7f47',
			'label' => 'First Name',
			'name' => 'first_name',
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
		),
		array (
			'key' => 'field_58ee83e2c7f48',
			'label' => 'Last Name',
			'name' => 'last_name',
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
		),
		array (
			'key' => 'field_590c74274a2ac',
			'label' => 'Address',
			'name' => 'address',
			'type' => 'textarea',
			'instructions' => 'Shortcodes: [address], [address name description]',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => 5,
			'new_lines' => 'br',
		),
		array (
			'key' => 'field_59143534ff9b1',
			'label' => 'Short Address',
			'name' => 'short_address',
			'type' => 'textarea',
			'instructions' => 'Shortcode: [short_address]',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => 2,
			'new_lines' => 'br',
		),
		array (
			'key' => 'field_598480a1b721c',
			'label' => 'Opening Hours',
			'name' => 'opening_hours',
			'type' => 'textarea',
			'instructions' => 'Shortcode: [opening_hours]',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => 2,
			'new_lines' => 'br',
		),	
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'contact_details',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;