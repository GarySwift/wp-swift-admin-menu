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
	private $menu_title = 'WP Swift';//'BrightLight';
	private $capability = 'manage_options';
	
    /*
     * Initializes the plugin.
     */
    public function __construct() {

    	# Register the Google API key to use with Advanced Custum Fields
		add_action('acf/init', array($this, 'wp_swift_acf_init'));
			
    	add_action( 'wp_enqueue_scripts', array($this, 'wp_swift_admin_menu_css_file') );
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_javascript') );

		add_action('admin_footer', array($this, 'enqueue_admin_javascript'));


		add_action( 'admin_enqueue_scripts', array($this, 'wp_swift_admin_menu_css_file_admin_style' ));//wp-swift-admin-menu-css-file-admin-style

    	add_action( 'admin_menu', array($this, 'wp_swift_admin_menu_add_admin_menu') );
    	// register_deactivation_hook( __FILE__, 'wp_swift_admin_menu_plugin_deactivate' );
		add_action( 'admin_init', array($this, 'wp_swift_admin_menu_settings_init') );



    	add_action( 'admin_notices', array($this, 'admin_notice_install_acf') );

    	# Register ACF field groups that will appear on the options pages
		add_action( 'init', array($this, 'acf_add_local_field_group_google_map') );
		add_action( 'init', array($this, 'acf_add_local_field_group_social_media') );
		add_action( 'init', array($this, 'acf_add_local_field_group_contact_details') );

		# Shortcodes for rendering the google maps.
        // add_shortcode( 'wp-swift-google-map', array( $this, 'render_google_map' ) );
        add_shortcode( 'google-map', array( $this, 'render_google_map' ) );	

        # enqueue the google maps API in the footer
		add_action( 'init', array($this, 'enqueue_assets_googleapis_maps') );

		# Create the JavaScript variables used in the Google Maps API directly in the footer
		add_action('wp_footer', array($this, 'set_map_js_vars_in_footer'));

		# Allow admin remove the "Add Media" button above the WYSIWYG editor for non admins
		add_action( 'admin_head', array($this, 'wp_swift_admin_menu_maybe_remove_add_media_button') );

		# Allow admins to extend the WYSIWYG
		add_action( 'init', array($this, 'wp_swift_admin_menu_extend_wysiwyg') );
    }

    /*
     * register_activation_hook
     */
    static function wp_swift_admin_menu_plugin_install() {
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
		// if ( get_option( 'wp_swift_admin_menu_settings' ) ) {
		// 	delete_option( 'wp_swift_admin_menu_settings' );
		// }
	}

	/*
	 * Retun the API key if it was set
	 */
	public function get_api_key() {
		// if (get_field('google_api_key', 'option')) {
		// 	return get_field('google_api_key', 'option');
		// } else {
		// 	return false;
		// }
		$options = get_option( 'wp_swift_google_map_settings' );
		if (isset($options['show_sidebar_options_google_map_api_key']) && $options['show_sidebar_options_google_map_api_key'] !== '') {
			return $options['show_sidebar_options_google_map_api_key'];
		}
		return false;		
	}
	/*
	 * It is necessary to register a Google API key in order to allow the Google API to load correctly. 
	 *
	 * Ref: https://www.advancedcustomfields.com/resources/google-map/
	 *
	 */
	public function wp_swift_acf_init() {
		$google_api_key = $this->get_api_key();
		if( $google_api_key ) {
			acf_update_setting('google_api_key', $google_api_key);
		}		
	}

// Displays a notice if the Advanced Custom Fields plugin is not active.
public function admin_notice_install_acf() {
    if ( isset($_GET["page"]) && $_GET["page"] == "wp-swift-admin-menu"  ) : ?>
	    <?php if (!function_exists( 'acf' )): ?>
	    <div class="error notice">
	        <p><?php _e( 'Please install <b>Advanced Custom Fields Pro</b>. It is required for this plugin to work properly! | <a href="http://www.advancedcustomfields.com/pro/" target="_blank">ACF Pro</a>', 'wp-swift-admin-menu' ); ?></p>
	        <small><i><?php _e( 'Option pages will not show until this is installed', 'wp-swift-admin-menu' ); ?></i></small>
	    </div>
	    <?php endif;    	
   	endif;

}
    /*
     * Add the css file
     */
    public function wp_swift_admin_menu_css_file() {
        // $options = get_option( 'wp_swift_admin_menu_settings' );

        // if (isset($options['wp_swift_admin_menu_checkbox_css'])==false) {
            wp_enqueue_style('wp-swift-admin-menu-style', plugins_url( 'assets/css/wp-swift-admin-menu.css', __FILE__ ) );
        // }

    }

	public function wp_swift_admin_menu_css_file_admin_style() {
	        // wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
	        // wp_enqueue_style( 'custom_wp_admin_css' );
		wp_enqueue_style('wp-swift-admin-menu-style', plugins_url( 'assets/css/wp-swift-admin-menu-css-file-admin-style.css', __FILE__ ) );
	}
    /*
     * Add the JavaScript file
     */
    public function enqueue_javascript () {
        // $options = get_option( 'wp_swift_admin_menu_settings' );
        
        // if (isset($options['wp_swift_admin_menu_checkbox_javascript'])==false) {
           wp_enqueue_script( $handle='wp-swift-admin-menu', $src=plugins_url( '/assets/js/wp-swift-admin-menu.js', __FILE__ ), $deps=null, $ver=null, $in_footer=true );
        // }
    }
    /*
     * Add the JavaScript file
     */
    public function enqueue_admin_javascript () {
        wp_enqueue_script( $handle='wp-swift-admin-menu', $src=plugins_url( '/assets/js/wp-swift-admin-menu-backend.js', __FILE__ ), $deps=null, $ver=null, $in_footer=true );
        // wp_enqueue_script( $handle='wp-swift-syntaxhighlighter', $src=plugins_url( '/libraries/brush-php/brush.js', __FILE__ ), $deps=null, $ver=null, $in_footer=true );
        wp_enqueue_script( $handle='wp-swift-syntax-prettify', 'https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js', $deps=null, $ver=null, $in_footer=true );
    }


    public function wp_swift_admin_menu_maybe_remove_add_media_button() {
		if ( !current_user_can( 'manage_options' ) ) {
		    $options = get_option( 'wp_swift_utilities_settings' );
		    $option = 'remove_add_media_button';
			if (isset($options[$option]) && $options[$option]) {
				remove_action( 'media_buttons', 'media_buttons' );
			}  
	    }
    }


    public function wp_swift_admin_menu_extend_wysiwyg() {
	    $options = get_option( 'wp_swift_utilities_settings' );
	    $option = 'extend_wysiwyg';
		if (isset($options[$option]) && $options[$option]) {
			include "_tiny-mce.php";
		}  
    }





    /**
     * A helper fuction that tests if an option is set
     *
     * @param  string  $option     	The text content for shortcode. Not used.
     *
     * @return boolean				If the option is set   
     */
	private function show_sidebar_option($option) {
		$options = get_option( 'wp_swift_admin_menu_settings' );
		if (isset($options[$option]) && $options[$option]) {
			return true;
		}
		return false;
	}

    /**
     * Create the JavaScript variables used in the Google Maps API.
     * It will create a <script> block in the 'footer.php' that will be use in the 
     * API. 
     *
     * @setting map_zoom_level
     * @setting map_style
     * @setting contentString
     */
    public function set_map_js_vars_in_footer() {
    	include "google-map-function-content/_set_map_js_vars_in_footer.php";
    }
    /**
     * A shortcode for rendering the google map.
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */
	public function render_google_map( $attributes=null, $content = null ) {
		if ( function_exists('get_google_map') )  {
    		return get_google_map( $attributes, $content );
    	}
	}
	/*
	 * Enqueue the google maps API in the footer
	 */
	public function enqueue_assets_googleapis_maps() {
		include "google-map-function-content/_enqueue_assets_googleapis_maps.php";
	}	
	/*
	 * The ACF field group for 'Google Map'
	 */	
	public function acf_add_local_field_group_google_map() {
		include "acf-field-groups/_acf-field-group-google-map.php";
	}

	/*
	 * The ACF field group for 'Contact Details'
	 */	
	public function acf_add_local_field_group_contact_details() {
		include "acf-field-groups/_acf-field-group-contact-page.php";
	}

	/*
	 * The ACF field group for 'Social Media'
	 */	
	public function acf_add_local_field_group_social_media() {
		include "acf-field-groups/_acf-field-group-social-media.php";
	}	

    /*
     * 
     * Create the menu pages that show in the side bar.
     *
     * The top level page is uses the standard WordPress API for showing menus.
     * The submenus use Advanced Custom Fields API to register pages
     */
	public function wp_swift_admin_menu_add_admin_menu() {
		$this->menu_title = "WP Swift";
		$icon = 'assets/images/icon.png';
		$options = get_option( 'wp_swift_admin_menu_settings' );
		if (isset($options['branding_select']) && $options['branding_select']==2) {
			$this->menu_title = "BrightLight";
			$icon = 'assets/images/icon-2.png';
		}
	
		# Create top-level menu item
		add_menu_page( 
			$this->page_title,
		   	$this->menu_title,
		   	$this->capability,
		   	$this->menu_slug, 
		   	array($this, 'wp_swift_admin_menu_options_page_render'), 
		   	plugins_url( $icon, __FILE__ )
		);

    	add_submenu_page($this->menu_slug, $this->page_title, $this->page_title, $this->capability, $this->menu_slug );

		if(function_exists('acf_add_options_page')) { 
			/*
			 * Submenu pages
			 */
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
	                'title' => 'Google Map',
	                'slug' => 'google-map',
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
	        /*
	         * This is a top level page outside the main menu
	         */
	        $show_sidebar_options_test_page=true;
	    	if($show_sidebar_options_test_page || $this->show_sidebar_option('show_sidebar_options_test_page')) {
		    	$test_args = array(
					'page_title' => 'Test Page - For Developent purposes Only!',
					'menu_title' => 'Test Page',
					'menu_slug' => 'wp-swift-admin-menu-test-page',
					'capability' => $this->capability,
					'icon_url' => 'dashicons-hammer',
				);
				acf_add_options_page($test_args);
	        }
	    }
	}

	/*
	 * Register all of the settings that are used on all the tabs
	 *
	 */
	public function wp_swift_admin_menu_settings_init(  ) { 

		/******************************************************************************
		 *
		 * Register the settings for the 'Menu Options' tab 
		 *
		 ******************************************************************************/	

		register_setting( 'menu_options', 'wp_swift_admin_menu_settings' );

		add_settings_section(
			'wp_swift_admin_menu_menu_options_section', 
			__( 'Configuration Page', 'wp-swift-admin-menu' ), 
			array($this, 'wp_swift_admin_menu_settings_section_callback'), 
			'menu_options'
		);

		add_settings_field( 
			'show_sidebar_option_contact_details', 
			__( 'Show Contact Page', 'wp-swift-admin-menu' ), 
			array($this, 'show_sidebar_option_contact_details_render'), 
			'menu_options', 
			'wp_swift_admin_menu_menu_options_section',
			array( 'label_for' => 'myprefix_setting-id' ) 
		);

		add_settings_field( 
			'show_sidebar_option_social_media', 
			__( 'Show Social Media', 'wp-swift-admin-menu' ), 
			array($this, 'show_sidebar_option_social_media_render'), 
			'menu_options', 
			'wp_swift_admin_menu_menu_options_section' 
		);

		add_settings_field( 
			'show_sidebar_options_opening_hours', 
			__( 'Settings Opening Hours', 'wp-swift-admin-menu' ), 
			array($this, 'show_sidebar_options_opening_hours_render'), 
			'menu_options', 
			'wp_swift_admin_menu_menu_options_section' 
		);

		add_settings_field( 
			'show_sidebar_options_google_map', 
			__( 'Show Google Map', 'wp-swift-admin-menu' ), 
			array($this, 'show_sidebar_options_google_map_render'), 
			'menu_options', 
			'wp_swift_admin_menu_menu_options_section' 
		);	

		add_settings_field( 
			'branding_select', 
			__( 'Branding', 'wp-swift-admin-menu' ), 
			array($this, 'branding_select_render'), 
			'menu_options', 
			'wp_swift_admin_menu_menu_options_section' 
		);		

		/******************************************************************************
		 *
		 * Register the settings for the 'Google Maps' tab
		 *
		 ******************************************************************************/	

		register_setting( 'google-map', 'wp_swift_google_map_settings' );

		add_settings_section(
			'wp_swift_admin_menu_google_map_page_section', 
			__( 'Google Map Settings', 'wp-swift-admin-menu' ), 
			array($this, 'wp_swift_admin_menu_google_map_section_callback'), 
			'google-map'
		);

		add_settings_field( 
			'show_sidebar_options_google_map_api_key', 
			__( 'Google Map API key', 'wp-swift-admin-menu' ), 
			array($this, 'show_sidebar_options_google_map_api_key_render'), 
			'google-map', 
			'wp_swift_admin_menu_google_map_page_section',
			array( 'label_for' => 'google-map-api-key' )
		);

		add_settings_field( 
			'show_sidebar_options_google_map_style', 
			__( 'Google Map Style', 'wp-swift-admin-menu' ), 
			array($this, 'show_sidebar_options_google_map_style_render'), 
			'google-map', 
			'wp_swift_admin_menu_google_map_page_section',
			array( 'label_for' => 'google-map-style' ) 
		);


/*
 * ********************
 */
// register_setting( 'contact-form', 'wp_swift_contact_form_settings' );

// add_settings_section(
// 	'wp_swift_admin_menu_contact_form_page_section', 
// 	__( 'Contact Settings', 'wp-swift-admin-menu' ), 
// 	array($this, 'wp_swift_admin_menu_contact_form_section_callback'), 
// 	'contact-form'
// );

// add_settings_field( 
// 	'show_sidebar_options_contact_form_api_key', 
// 	__( 'Contact API key', 'wp-swift-admin-menu' ), 
// 	array($this, 'show_sidebar_options_contact_form_api_key_render'), 
// 	'contact-form', 
// 	'wp_swift_admin_menu_contact_form_page_section'
// );
		/******************************************************************************
		 *
		 * Register the settings for the 'Utilities' tab help
		 *
		 ******************************************************************************/		

		register_setting( 'utilities', 'wp_swift_utilities_settings' );

		add_settings_section(
			'wp_swift_admin_menu_utilities_page_section', 
			__( 'Utility Settings', 'wp-swift-admin-menu' ), 
			array($this, 'wp_swift_admin_menu_utilities_section_callback'), 
			'utilities'
		);
		# Remove the "Add Media" button above the WYSIWYG editor
		add_settings_field( 
			'remove_add_media_button', 
			__( 'Remove Add Media', 'wp-swift-admin-menu' ), 
			array($this, 'wp_swift_admin_menu_utilities_page_remove_media_upload_render'), 
			'utilities', 
			'wp_swift_admin_menu_utilities_page_section'
		);
		add_settings_field( 
			'extend_wysiwyg', 
			__( 'Extend WYSIWYG', 'wp-swift-admin-menu' ), 
			array($this, 'wp_swift_admin_menu_utilities_page_extend_wysiwyg_render'), 
			'utilities', 
			'wp_swift_admin_menu_utilities_page_section'
		);		

		/******************************************************************************
		 *
		 * Register the settings for the 'Help Page' tab
		 *
		 ******************************************************************************/		
		register_setting( 'help-page', 'wp_swift_admin_menu_settings' );

		add_settings_section(
			'wp_swift_admin_menu_help_page_section', 
			__( 'Developer Notes', 'wp-swift-admin-menu' ), 
			array($this, 'wp_swift_admin_menu_help_section_callback'), 
			'help-page'
		);

		add_settings_field( 
			'show_help_google_map', 
			__( 'Google Map', 'wp-swift-admin-menu' ), 
			array($this, 'wp_swift_admin_menu_help_page_google_map_render'), 
			'help-page', 
			'wp_swift_admin_menu_help_page_section'
		);


		add_settings_field( 
			'show_help_contact_page', 
			__( 'Contact Page', 'wp-swift-admin-menu' ), 
			array($this, 'wp_swift_admin_menu_help_page_contact_render'), 
			'help-page', 
			'wp_swift_admin_menu_help_page_section'
		);

		add_settings_field( 
			'show_help_social_media_page', 
			__( 'Social Media Page', 'wp-swift-admin-menu' ), 
			array($this, 'wp_swift_admin_menu_help_page_social_media_render'), 
			'help-page', 
			'wp_swift_admin_menu_help_page_section'
		);		
	}

	/******************************************************************************
	 *
	 * Render the top level menu page tabs. All other items will be rendered undr this
	 *
	 ******************************************************************************/
	public function wp_swift_admin_menu_options_page_render(  ) { 
		include "_tabs.php";
	}

	/******************************************************************************
	 *
	 * Render the description and checkboxes that show on 
	 * the 'Settings' page -> 'Menu Options' tab
	 *
	 ******************************************************************************/

	/*
	 * The description for the 'Menu Options' tab
	 */
	public function wp_swift_admin_menu_settings_section_callback(  ) { 
		echo __( 'Select the options pages you wish to show below', 'wp-swift-admin-menu' );
	}
	/*
	 * Render checkbox that determines if the 'contact page' menu should be shown
	 */
	public function show_sidebar_option_contact_details_render(  ) { 
		$options = get_option( 'wp_swift_admin_menu_settings' );
		?><input type="checkbox" value="1" name="wp_swift_admin_menu_settings[show_sidebar_option_contact_details]" <?php 
			if (isset($options['show_sidebar_option_contact_details'])) {
			 	checked( $options['show_sidebar_option_contact_details'], 1 );
			} 
		?>><?php
	}

	/*
	 * Render checkbox that determines if the 'social_media' menu should be shown
	 */
	public function show_sidebar_option_social_media_render(  ) { 
		$options = get_option( 'wp_swift_admin_menu_settings' );
		?><input type="checkbox" value="1" name="wp_swift_admin_menu_settings[show_sidebar_option_social_media]" <?php 
			if (isset($options['show_sidebar_option_social_media'])) {
				checked( $options['show_sidebar_option_social_media'], 1 );
			}
		?>><?php
	}

	/*
	 * Render checkbox that determines if the 'social_media' menu should be shown
	 */
	public function show_sidebar_options_opening_hours_render(  ) { 
		$options = get_option( 'wp_swift_admin_menu_settings' );
		?><input type="checkbox" value="1" name="wp_swift_admin_menu_settings[show_sidebar_options_opening_hours]" <?php 
			if (isset($options['show_sidebar_options_opening_hours'])) {
				checked( $options['show_sidebar_options_opening_hours'], 1 ); 
			}
		?>><?php
	}

	/*
	 * Render checkbox that determines if the 'google_map' menu should be shown
	 */
	public function show_sidebar_options_google_map_render(  ) { 
		$options = get_option( 'wp_swift_admin_menu_settings' );
		?><input type="checkbox" value="1" id="show-sidebar-options-google-map" name="wp_swift_admin_menu_settings[show_sidebar_options_google_map]" <?php 
			if (isset($options['show_sidebar_options_google_map'])) {
				checked( $options['show_sidebar_options_google_map'], 1 ); 
			}
		?>><?php
	}

/*
	 * Render select box that determines branding used
	 */
	public function branding_select_render(  ) { 

		$options = get_option( 'wp_swift_admin_menu_settings' );
		// if (isset($options['branding_select'])) {
		// 	$options['branding_select']=1;
		// }
		?><select id="branding_select" name="wp_swift_admin_menu_settings[branding_select]">
			<option value='1' <?php selected( $options['branding_select'], 1 ); ?>>WP Swift</option>
			<option value='2' <?php selected( $options['branding_select'], 2 ); ?>>BrightLight</option>
		</select><?php

	}

	# @end Render 'Settings' page -> 'Menu Options' tab

	/******************************************************************************
	 *
	 * Render the description and inputs that show on 
	 * the 'Settings' page -> 'Google Map' tab
	 *
	 ******************************************************************************/

	/*
	 * The description for the 'Google Map' tab
	 */
	public function wp_swift_admin_menu_google_map_section_callback(  ) { 
		echo __( 'Use the fields below to set additional settings for Google Maps.', 'wp-swift-admin-menu' );
	}

	/*
	 * Render input field that allows the user to add a Google Maps API key
	 */
	public function show_sidebar_options_google_map_api_key_render(  ) { 
		$options = get_option( 'wp_swift_google_map_settings' );
		$readonly = '';
		if(!$this->show_sidebar_option('show_sidebar_options_google_map')) {
	 		$readonly = ' readonly';
		}
		?><input type="text" size="50" id="google-map-api-key" class="google-map-toggle-readonly" name="wp_swift_google_map_settings[show_sidebar_options_google_map_api_key]" value="<?php if (isset($options['show_sidebar_options_google_map_api_key'])) echo $options['show_sidebar_options_google_map_api_key']; ?>"<?php echo $readonly; ?>>
		<p><i><small>This is required and maps will not render without it.</small></i></p><?php
	}
	
	/*
	 * Render textarea that allows the user to add a snazzy map json config
	 */
	public function show_sidebar_options_google_map_style_render(  ) { 
		$options = get_option( 'wp_swift_google_map_settings' );
		$readonly = '';
		if(!$this->show_sidebar_option('show_sidebar_options_google_map')) {
	 		$readonly = ' readonly';
		}
		?><textarea cols="49" rows="5" wrap="soft" id="google-map-style" class="google-map-toggle-readonly" name="wp_swift_google_map_settings[show_sidebar_options_google_map_style]"<?php echo $readonly; ?>><?php 
			if (isset($options['show_sidebar_options_google_map_style'])) {
				echo trim($options['show_sidebar_options_google_map_style']);
			} 
		?></textarea>
	 	<?php if (!$readonly): ?>
	 		<p class="google-map-toggle-show"><small><i>Maps styles are available at </i><a href="https://snazzymaps.com/" target="_blank">Snazzy Maps</a>.</small></p>
	 	<?php endif;
	}

	# @end Render 'Settings' page -> 'Google Map' tab




	/******************************************************************************
	 *
	 * Render the description and checkboxes that show on 
	 * the 'Settings' page -> 'Utilities' tab
	 *
	 ******************************************************************************/

	/*
	 * The description for the 'Utilities' tab
	 */
	public function wp_swift_admin_menu_utilities_section_callback(  ) { 
		echo __( 'Select the options below as see fit.', 'wp-swift-admin-menu' );
	}
	/*
	 * Render checkbox that determines if "Add Media" button above the WYSIWYG editor is shown
	 */
	public function wp_swift_admin_menu_utilities_page_remove_media_upload_render(  ) { 
		$options = get_option( 'wp_swift_utilities_settings' );
		?><input type="checkbox" value="1" name="wp_swift_utilities_settings[remove_add_media_button]" <?php 
			if (isset($options['remove_add_media_button'])) {
			 	checked( $options['remove_add_media_button'], 1 );
			} 
		?>><p>Remove the <b>"Add Media"</b> button above the WYSIWYG editor.</p><?php
	}

	/*
	 * Render checkbox that determines if "Add Media" button above the WYSIWYG editor is shown
	 */
	public function wp_swift_admin_menu_utilities_page_extend_wysiwyg_render(  ) { 
		$options = get_option( 'wp_swift_utilities_settings' );
		?><input type="checkbox" value="1" name="wp_swift_utilities_settings[extend_wysiwyg]" <?php 
			if (isset($options['extend_wysiwyg'])) {
			 	checked( $options['extend_wysiwyg'], 1 );
			} 
		?>><p class="desc">Creates a format select dropdown in the second row of the TinyMCE editor for handling <b>Zurb Foundation</b> CSS classes and container components.</p><?php
	}

	/******************************************************************************
	 *
	 * Render the description and help content that show on 
	 * the 'Settings' page -> 'Help Page' tab
	 *
	 ******************************************************************************/

	/*
	 * The description for the 'Help Page' tab
	 */
	public function wp_swift_admin_menu_help_section_callback(  ) { 
		echo __( 'These are developer notes that are made to help with the theme development and be a reference page for trouble shooting.', 'wp-swift-admin-menu' );
	}

	/*
	 * Render help content for contact page
	 */
	public function wp_swift_admin_menu_help_page_contact_render () {
		include "help-page-partials/_contact-page.php";
	}

	/*
	 * Render help content for google map page
	 */
	public function wp_swift_admin_menu_help_page_google_map_render() {
		include "help-page-partials/_google-map.php";
	}

	public function wp_swift_admin_menu_help_page_social_media_render() {
		include "help-page-partials/_social-media.php";
	}

	# @end Render 'Settings' page -> 'Help Page'
}
$wp_swift_admin_menu = new WP_Swift_Admin_Menu();
register_activation_hook( __FILE__, array( 'WP_Swift_Admin_Menu', 'wp_swift_admin_menu_plugin_install' ) ); 
register_deactivation_hook( __FILE__, array( 'WP_Swift_Admin_Menu', 'wp_swift_admin_menu_plugin_deactivate' ) );    
/*
 * Include the function that will render the google map
 */    
include "wp-swift-google-map.php";

/*
 * Include the functions that render shortcodes
 */  
include "_shortcodes.php";
include "utilities/_featured-image.php";
include "utilities/_admin-bar-position.php";