<?php
/*
 * Declare a new class that will handle opening hors
 * 
 * @class       WP_Swift_Opening_Hours
 *
 */
class WP_Swift_Opening_Hours {
    /*
     * Initializes the class.
     */
    public function __construct() { 
        # Register ACF field groups that will appear on the options pages
        add_action( 'init', array($this, 'acf_add_local_field_group_contact_form') );

        # Create the submenu page that show in the side bar
        add_action( 'admin_menu', array($this, 'wp_swift_admin_menu_add_admin_menu') );

        # Load the JavaScript
        add_action('admin_enqueue_scripts', array($this, 'opening_hours_admin_enqueue_scripts'));

        # Shortcode for rendering the opening-hours table
        add_shortcode( 'opening-hours', array( $this, 'render_opening_hours' ) );

        # Shortcode for rendering the opening-hours table
        add_shortcode( 'opening-hours-custom', array( $this, 'render_opening_hours_custom' ) );

        # Help page
        add_action( 'admin_init', array($this, 'wp_swift_admin_menu_settings_init') );
    }

    /**
     * A shortcode for rendering the opening-hours table
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */
    public function render_opening_hours( $attributes = array(), $content = null ) {
        // echo "<pre>"; var_dump($attributes); echo "</pre>";
        return wp_swift_opening_hours();
    } 

    /**
     * A shortcode for rendering the custom days opening-hours table
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */
    public function render_opening_hours_custom( $attributes = array(), $content = null ) {
        return wp_swift_opening_hours('custom_days');
    }          
    /*
     * The ACF field group for 'Opening Hours'
     */ 
    public function acf_add_local_field_group_contact_form() {
        require_once "acf-field-groups/_opening-hours.php";
    }

    /*
     * 
     * Create the submenu page that show in the side bar
     *
     * The top level page is declared in 'wp-swift-admin-menu.php'
     * The submenu page uses Advanced Custom Fields API to register fields
     */
	public function wp_swift_admin_menu_add_admin_menu() {

		if(function_exists('acf_add_options_page')) { 
			/*
			 * Submenu page
			 */      
		    if($this->show_sidebar_option('show_sidebar_options_opening_hours')) {
	            acf_add_options_sub_page(array(
	                'title' => 'Opening Hours',
	                'slug' => 'opening-hours',
	                'parent' => $this->get_parent_slug(),
	            )); 
	        }
	    }
	}  

    /*
     * This determines the location the menu links
     * They are listed under Settings unless the other plugin 'wp_swift_admin_menu' is activated
     */
    private function get_parent_slug() {
        if ( get_option( 'wp_swift_admin_menu' ) ) {
            return get_option( 'wp_swift_admin_menu' );
        }
        else {
            return 'options-general.php';
        }
    }	

    /**
     * A helper fuction that tests if an option is set
     *
     * @param  string  $option     	The name of the WordPress option field
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
     * Load the JavaScript
     * 
     */
    public function opening_hours_admin_enqueue_scripts() {
        wp_enqueue_script( 'opening-hours-js', $src=plugins_url( 'assets/js/opening-hours.js', __FILE__ ), array(), '1.0.0', true );
    }

    /*
     * Register the settings that are used in the help tab
     *
     */
    public function wp_swift_admin_menu_settings_init(  ) { 

        add_settings_field( 
            'show_help_opening_hours_page', 
            __( 'Opening Hours', 'wp-swift-admin-menu' ), 
            array($this, 'wp_swift_admin_menu_help_page_opening_hours_render'), 
            'help-page', 
            'wp_swift_admin_menu_help_page_section'
        );      
    } 

    /*
     * This will output formatted html
     */
    public function wp_swift_admin_menu_help_page_opening_hours_render() {
?><pre class="prettyprint custom">
// WordPress shortcodes
[opening-hours]
[opening-hours-custom]

// WordPress functions
echo wp_swift_opening_hours();
echo wp_swift_opening_hours('custom_days');
</pre><?php 
    }//@end function wp_swift_admin_menu_help_page_opening_hours_render       
}//@end class WP_Swift_Opening_Hours


// Initialize the class
$wp_swift_opening_hours = new WP_Swift_Opening_Hours();

/*
 * Functions
 */
function wp_swift_opening_hours($repeater='days') {
    $html= '';
    $last_open = '';
    $last_close = '';
    if ( have_rows($repeater, 'option') ) :
        ob_start(); 
        echo PHP_EOL; ?>
        <!-- opening-hours-table -->
        <table class="wp-swift opening-hours-table">
            <thead>
                <tr>
                    <th width="33%">Day</th>
                    <th width="33%">Open</th>
                    <th width="33%">Close</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            echo PHP_EOL;
            while( have_rows($repeater, 'option') ) : the_row();

                $status = get_sub_field('status');
                $day = get_sub_field('day');
                if ( $repeater==='custom_days') {
                    $day = str_replace('/', '-', $day);
                    $day = strtotime($day);
                    $day = date('D d M Y',$day);
                }
                $open = get_sub_field('open');
                $close = get_sub_field('close');

                if ($open) {
                    $last_open = $open;
                }
                if ($close) {
                    $last_close = $close;
                }
                 
                ?>
                <tr>
                    <th><?php echo $day ?></th><?php 
                if ($status): echo PHP_EOL; ?>
                    <td><?php echo $last_open; ?></td>
                    <td><?php echo $last_close; ?></td>
                <?php else:  echo PHP_EOL; ?>
                    <td colspan="2">Closed All Day</td>
                <?php endif;
                ?></tr><?php
                echo PHP_EOL;  
            endwhile; ?>
            </tbody>
        </table>
        <!-- @end opening-hours-table -->
        <?php 
        $html = ob_get_contents();
        ob_end_clean();
    endif;
    return $html; 
}