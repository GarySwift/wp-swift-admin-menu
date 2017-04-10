<?php
/*
Plugin Name: 		WP Swift: Admin Menu
Plugin URI:         https://github.com/GarySwift/wp-swift-admin-menu
Description: 		Creates a top level menu item in the admin sidebar.
Version:           	1.0.0
Author:            	Gary Swift
Author URI:        	https://github.com/GarySwift
License:            GPL-2.0+
License URI:        http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:       	wp-swift-admin-menu
*/
class WP_Swift_Admin_Menu {
	private $menu_slug = 'wp-swift-admin-menu';
	private $page_title = 'Settings';
	private $menu_title = 'BrightLight';
	private $capability = 'manage_options';
	
    /*
     * Initializes the plugin.
     */
    public function __construct() {
    	add_action( 'admin_menu', array($this, 'wp_swift_admin_menu_add_admin_menu') );
    	// register_deactivation_hook( __FILE__, 'wp_swift_admin_menu_plugin_deactivate' );
		add_action( 'admin_init', array($this, 'wp_swift_admin_menu_settings_init') );
    }

    /*
     * register_activation_hook
     */
    static function install() {
    	$menu_slug = 'wp-swift-admin-menu';
        // do not generate any output here
     	if ( get_option( 'wp_swift_admin_menu' ) === false ) {
			// $new_options['page_title'] = $this->page_title;
			// $new_options['menu_title'] = $this->menu_title;
			$new_options['menu_slug'] = $menu_slug;
			add_option( 'wp_swift_admin_menu', $menu_slug );
		} 
		// else {
	 //    	$existing_options = get_option( 'wp_swift_admin_menu' );
	 //    	if ( $existing_options['version'] < 1.1 ) {
		// 		$existing_options['track_outgoing_links'] = false;
		// 		$existing_options['version'] = "1.1";
		// 		update_option( 'wp_swift_admin_menu', $existing_options );
		// 	} 
		// }
    }

    static function wp_swift_admin_menu_plugin_deactivate() {
		// Check if options exist and delete them if present
		if ( get_option( 'wp_swift_admin_menu' ) ) {
			delete_option( 'wp_swift_admin_menu' );
		}
		if ( get_option( 'wp_swift_admin_menu_settings' ) ) {
			delete_option( 'wp_swift_admin_menu_settings' );
		}
	}

	public function wp_swift_admin_menu_add_admin_menu() {
	
		# Create top-level menu item
		add_menu_page( 
			$this->page_title,
		   	$this->menu_title,
		   	$this->capability,
		   	$this->menu_slug, 
		   	array($this, 'wp_swift_admin_menu_options_page'), 
		   	plugins_url( 'icon.png', __FILE__ )
		);

				  // add_menu_page('My Page Title', 'My Menu Title', 'manage_options', 'my-menu', 'my_menu_output' );
    add_submenu_page($this->menu_slug, $this->page_title, $this->page_title, $this->capability, $this->menu_slug );
    // add_submenu_page('my-menu', 'Submenu Page Title2', 'Whatever You Want2', 'manage_options', 'my-menu2' );

//     add_menu_page("my-plugin", "Main Menu", "publish_posts", "activate_plugin", "wpqs_active_plugin");
// add_submenu_page("activate_plugin", "Sub menu", "Activation", "publish_posts", "activate_plugin", "wpqs_active_plugin");
	
		# Choose what sidebar fields to show - these are ACF input fields that can be used globally
		// $show_sidebar_options=true;
		// $show_sidebar_option_contact_details=false;
		// $show_sidebar_option_social_media=true;
		// $show_sidebar_option_company_details=false;
		// $show_sidebar_option_contact_numbers=false;
		// $show_sidebar_options_opening_hours=false;
		// $show_sidebar_option_location=false;
		// $show_sidebar_option_global_contact_form=false;

		// $options = get_option( 'wp_swift_admin_menu_settings' );

		// if (isset($options['show_sidebar_option_contact_details'])) {
		// 	$show_sidebar_option_contact_details = $options['show_sidebar_option_contact_details'];
		// }
		// if (isset($options['show_sidebar_option_social_media'])) {
		// 	$show_sidebar_option_social_media = $options['show_sidebar_option_social_media'];
		// }
		// if (isset($options['show_sidebar_options_opening_hours'])) {
		// 	$show_sidebar_options_opening_hours = $options['show_sidebar_options_opening_hours'];
		// }

  //       if($show_sidebar_option_contact_details) {
       
        // }
        if ($this->show_sidebar_option('show_sidebar_option_contact_details')) {
            acf_add_options_sub_page(array(
                'title' => 'Contact Details',
                'slug' => 'contact_details',
                'parent' => $this->menu_slug,
            ));
        }
	    if($this->show_sidebar_option('show_sidebar_option_social_media')) {
            acf_add_options_sub_page(array(
                'title' => 'Social Media',
                'slug' => 'social_media',
                'parent' => $this->menu_slug,
            ));
        }
	    if($this->show_sidebar_option('show_sidebar_options_google_map')) {
            acf_add_options_sub_page(array(
                'title' => 'Google Map Set',
                'slug' => 'google-map-set',
                'parent' => $this->menu_slug,
            )); 
        }        
	    if($this->show_sidebar_option('show_sidebar_options_opening_hours')) {
            acf_add_options_sub_page(array(
                'title' => 'Opening Hours',
                'slug' => 'opening-hours',
                'parent' => $this->menu_slug,
            )); 
        }
	}

	private function show_sidebar_option($option) {
		$options = get_option( 'wp_swift_admin_menu_settings' );
		if (isset($options[$option]) && $options[$option]) {
			return true;
		}
		return false;
	}

function wp_swift_admin_menu_settings_init(  ) { 

	register_setting( 'pluginPage', 'wp_swift_admin_menu_settings' );

	add_settings_section(
		'wp_swift_admin_menu_pluginPage_section', 
		__( 'Configuration Page', 'wp-swift-admin-menu' ), 
		array($this, 'wp_swift_admin_menu_settings_section_callback'), 
		'pluginPage'
	);

	add_settings_field( 
		'show_sidebar_option_contact_details', 
		__( 'Show Contact Page', 'wp-swift-admin-menu' ), 
		array($this, 'show_sidebar_option_contact_details_render'), 
		'pluginPage', 
		'wp_swift_admin_menu_pluginPage_section' 
	);

	add_settings_field( 
		'show_sidebar_option_social_media', 
		__( 'Show Social Media', 'wp-swift-admin-menu' ), 
		array($this, 'show_sidebar_option_social_media_render'), 
		'pluginPage', 
		'wp_swift_admin_menu_pluginPage_section' 
	);

	add_settings_field( 
		'show_sidebar_options_opening_hours', 
		__( 'Settings Opening Hours', 'wp-swift-admin-menu' ), 
		array($this, 'show_sidebar_options_opening_hours_render'), 
		'pluginPage', 
		'wp_swift_admin_menu_pluginPage_section' 
	);

	add_settings_field( 
		'show_sidebar_options_google_map', 
		__( 'Show Google Map', 'wp-swift-admin-menu' ), 
		array($this, 'show_sidebar_options_google_map_render'), 
		'pluginPage', 
		'wp_swift_admin_menu_pluginPage_section' 
	);

	add_settings_field( 
		'show_sidebar_options_google_map_api_key', 
		__( 'Google Map API key', 'wp-swift-admin-menu' ), 
		array($this, 'show_sidebar_options_google_map_api_key_render'), 
		'pluginPage', 
		'wp_swift_admin_menu_pluginPage_section' 
	);

	add_settings_field( 
		'show_sidebar_options_google_map_style', 
		__( 'Google Map Style', 'wp-swift-admin-menu' ), 
		array($this, 'show_sidebar_options_google_map_style_render'), 
		'pluginPage', 
		'wp_swift_admin_menu_pluginPage_section' 
	);
	// add_settings_field( 
	// 	'wp_swift_admin_menu_checkbox_field_3', 
	// 	__( 'Settings field description', 'wp-swift-admin-menu' ), 
	// 	array($this, 'wp_swift_admin_menu_checkbox_field_3_render'), 
	// 	'pluginPage', 
	// 	'wp_swift_admin_menu_pluginPage_section' 
	// );


}


function show_sidebar_option_contact_details_render(  ) { 

	$options = get_option( 'wp_swift_admin_menu_settings' );
	// if (!array_key_exists("show_sidebar_option_contact_details",$options)) {
	// 	$options['show_sidebar_option_contact_details'] = '';
	// }
	?>
	<input type='checkbox' name='wp_swift_admin_menu_settings[show_sidebar_option_contact_details]' <?php 
		if (isset($options['show_sidebar_option_contact_details'])) {
		 	checked( $options['show_sidebar_option_contact_details'], 1 );
		} 
	?> value='1'>
	<?php

}


function show_sidebar_option_social_media_render(  ) { 

	$options = get_option( 'wp_swift_admin_menu_settings' );
	// if (!array_key_exists("show_sidebar_option_social_media",$options)) {
	// 	$options['show_sidebar_option_social_media'] = '';
	// }
	?>
	<input type='checkbox' name='wp_swift_admin_menu_settings[show_sidebar_option_social_media]' <?php 
		if (isset($options['show_sidebar_option_social_media'])) {
			checked( $options['show_sidebar_option_social_media'], 1 );
		}
	?> value='1'>
	<?php

}


function show_sidebar_options_opening_hours_render(  ) { 

	$options = get_option( 'wp_swift_admin_menu_settings' );
	?>
	<input type='checkbox' name='wp_swift_admin_menu_settings[show_sidebar_options_opening_hours]' <?php 
		if (isset($options['show_sidebar_options_opening_hours'])) {
			checked( $options['show_sidebar_options_opening_hours'], 1 ); 
		}
	?> value='1'>
	<?php
}

function show_sidebar_options_google_map_render(  ) { 

	$options = get_option( 'wp_swift_admin_menu_settings' );
	?>
	<input type='checkbox' name='wp_swift_admin_menu_settings[show_sidebar_options_google_map]' <?php 
		if (isset($options['show_sidebar_options_google_map'])) {
			checked( $options['show_sidebar_options_google_map'], 1 ); 
		}
	?> value='1'>
	<?php
}

function show_sidebar_options_google_map_api_key_render(  ) { 

	$options = get_option( 'wp_swift_admin_menu_settings' );
	$readonly = '';
	if(!$this->show_sidebar_option('show_sidebar_options_google_map')) {
 		$readonly = ' readonly';
	}
	?>
	<input type="text" size="50" name="wp_swift_admin_menu_settings[show_sidebar_options_google_map_api_key]" value="<?php if (isset($options['show_sidebar_options_google_map_api_key'])) echo $options['show_sidebar_options_google_map_api_key']; ?>"<?php echo $readonly; ?>>
	<?php
}

function show_sidebar_options_google_map_style_render(  ) { 

	$options = get_option( 'wp_swift_admin_menu_settings' );
	$readonly = '';
	if(!$this->show_sidebar_option('show_sidebar_options_google_map')) {
 		$readonly = ' readonly';
	}
	?>
	<textarea cols='49' rows='5' name='wp_swift_admin_menu_settings[show_sidebar_options_google_map_style]'<?php echo $readonly; ?>> 
		<?php if (isset($options['show_sidebar_options_google_map_style'])) {
			echo $options['show_sidebar_options_google_map_style'];
		} ?>
 	</textarea>
 	<?php if (!$readonly): ?>
 		<p><small><i>Maps styles are available at </i><a href="https://snazzymaps.com/" target="_blank">Snazzy Maps</a>.</small></p>
 	<?php endif;
}
function wp_swift_admin_menu_checkbox_field_3_render(  ) { 

	$options = get_option( 'wp_swift_admin_menu_settings' );
	if (!array_key_exists("show_sidebar_options_opening_hours",$options)) {
		$options['show_sidebar_options_opening_hours'] = '';
	}
	?>
	<input type='checkbox' name='wp_swift_admin_menu_settings[show_sidebar_options_opening_hours]' <?php checked( $options['show_sidebar_options_opening_hours'], 1 ); ?> value='1'>
	<?php

}



	public function wp_swift_admin_menu_settings_section_callback(  ) { 

		echo __( 'Select the options pages you wish to show below', 'wp-swift-admin-menu' );
		// $options = get_option( 'wp_swift_admin_menu_settings' ); echo "<pre>"; var_dump($options); echo "</pre>";

	}

	public function wp_swift_admin_menu_options_page(  ) { 

		?>
		<div id="wp-swift-admin-menu-options-page" class="wrap">
		<form action='options.php' method='post'>

			<h1><?php echo $this->page_title; ?></h1>
<table class="form-table">
<tbody>
			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>
</tbody>
</table>

		</form>


		
		</div>
		<?php

	}
}
$wp_swift_admin_menu = new WP_Swift_Admin_Menu();
register_activation_hook( __FILE__, array( 'WP_Swift_Admin_Menu', 'install' ) ); 
register_deactivation_hook( __FILE__, array( 'WP_Swift_Admin_Menu', 'wp_swift_admin_menu_plugin_deactivate' ) );        