<?php

class WP_Swift_Admin_Menu {
	private $menu_slug = 'wp-swift-admin-menu';
	private $page_title = 'BrightLight Configuration Page';
	private $menu_title = 'BrightLight';
	private $capability = 'manage_options';
	
    /*
     * Initializes the plugin.
     */
    public function __construct() {
    	add_action( 'admin_menu', array($this, 'wp_swift_admin_menu') );
    	register_deactivation_hook( __FILE__, 'wp_swift_admin_menu_plugin_deactivate' );
    }

	public function wp_swift_admin_menu() {
	
		# Create top-level menu item
		add_menu_page( 
			$this->page_title,
		   	$this->menu_title,
		   	$this->capability,
		   	$this->menu_slug, 
		   	array($this, 'admin_complex_main'), 
		   	plugins_url( 'icon.png', __FILE__ )
		);
}

/** 
  * Admin sidebar options
  *
  * Adds menu items to backend sidebar
  */

# Choose what sidebar fields to show - these are ACF input fields that can be used globally
$show_sidebar_options=true;
$show_sidebar_option_contact_details=false;
$show_sidebar_option_social_media=true;
$show_sidebar_option_company_details=false;
$show_sidebar_option_contact_numbers=false;
$show_sidebar_options_opening_hours=false;
$show_sidebar_option_location=false;
$show_sidebar_option_global_contact_form=false;

		/** Adds menu items to backend sidebar */
		# ref: https://www.advancedcustomfields.com/add-ons/options-page/
		if(function_exists('acf_add_options_page')) { 
		    $user = wp_get_current_user();
		    // if (user_can( $user->ID, 'administrator' ) || user_can( $user->ID, 'editor' )) { // Editor and below
		        if($show_sidebar_options) {
		            // acf_add_options_page(array(
		            //     'page_title'    => 'Custom Settings',
		            //     'menu_slug'     => 'custom_settings',
		            //     'icon_url'      => 'dashicons-forms',
		            //     'capability'    => 'manage_options',
		            //     // 'position' => 2,
		            // )); 
		            if($show_sidebar_option_social_media) {
		                acf_add_options_sub_page(array(
		                    'title' => 'Social Media',
		                    'slug' => 'social_media',
		                    'parent' => $this->menu_slug,
		                ));
		            }
		            if($show_sidebar_option_contact_details) {
		                acf_add_options_sub_page(array(
		                    'title' => 'Contact Details',
		                    'slug' => 'contact_details',
		                    'parent' => $this->menu_slug,
		                ));        
		            }
		            if($show_sidebar_option_company_details) {
		                acf_add_options_sub_page(array(
		                    'title' => 'Company Details',
		                    'slug' => 'company_details',
		                    'parent' => $this->menu_slug,
		                )); 
		            }
		            if($show_sidebar_option_contact_numbers) {
		                acf_add_options_sub_page(array(
		                    'title' => 'Contact Numbers',
		                    'slug' => 'contact_numbers',
		                    'parent' => $this->menu_slug,
		                )); 
		            }   
		            if($show_sidebar_options_opening_hours) {
		                acf_add_options_sub_page(array(
		                    'title' => 'Opening Hours',
		                    'slug' => 'opening-hours',
		                    'parent' => $this->menu_slug,
		                )); 
		            }  
		            // if($show_sidebar_option_location) {   
		            //     acf_add_options_sub_page(array(
		            //         'title' => 'Location',
		            //         'slug' => 'location',
		            //         'parent' => $this->menu_slug,
		            //     )); 
		            // }
		            // if($show_sidebar_option_global_contact_form) {   
		            //     acf_add_options_sub_page(array(
		            //         'title' => 'Service Form Fields',
		            //         'slug' => 'form-fields',
		            //         'parent' => $this->menu_slug,
		            //     )); 
		            // }  
		            // acf_add_options_sub_page(array(
		            //     'title' => 'Sign Up Form',
		            //     'slug' => 'sign-up-form',
		            //     'parent' => $this->menu_slug,
		            // ));   
		            // acf_add_options_sub_page(array(
		            //     'title' => 'Google API Key',
		            //     'slug' => 'google-api-key',
		            //     'parent' => 'custom_settings',
		            // ));
		            // acf_add_options_sub_page(array(
		            //     'title' => 'Header Banner',
		            //     'slug' => 'header-banner',
		            //     'parent' => 'custom_settings',
		            // )); 

		        }        
		    // }   
		}		
	}
	public function admin_complex_main() {
		/*<div class="wrap"><h1><?php echo $this->page_title  ?></h1></div>*/
		// if ( get_option( 'wp_swift_admin_menu' ) ) {
		// 	$wp_swift_admin_menu = get_option( 'wp_swift_admin_menu' );
		// 	echo "<pre>"; var_dump($wp_swift_admin_menu); echo "</pre>";
		// }
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
}
function wp_swift_admin_menu_plugin_deactivate() {
	// Check if options exist and delete them if present
	if ( get_option( 'wp_swift_admin_menu' ) ) {
		delete_option( 'wp_swift_admin_menu' );
	}
}
$wp_swift_admin_menu = new WP_Swift_Admin_Menu();
register_activation_hook( __FILE__, array( 'WP_Swift_Admin_Menu', 'install' ) );

acf_add_options_sub_page(array(
    'title' => 'Contact Details',
    'slug' => 'contact-details',
    'parent' => get_option( 'wp_swift_admin_menu' ),
));

// if ( get_option( 'wp_swift_admin_menu' )) {
// 	echo "1 <pre>wp_swift_admin_menu 1 "; var_dump(get_option( 'wp_swift_admin_menu' )); echo "</pre>";
// }
// echo "2 <pre>wp_swift_admin_menu 2 "; var_dump(get_option( 'wp_swift_admin_menu' )); echo "</pre>";
// acf_add_options_page(array(
//     'page_title'    => 'Custom Settings',
//     'menu_slug'     => get_option( 'wp_swift_admin_menu' ),
//     'icon_url'      => 'dashicons-forms',
//     'capability'    => 'manage_options',
//     'position' => 2,
// )); 
// acf_add_options_sub_page(array(
//     'title' => 'Google Map',
//     'slug' => 'google-map',
//     'parent' => get_option( 'wp_swift_admin_menu' ),
// ));               