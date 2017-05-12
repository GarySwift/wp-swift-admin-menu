<?php
/*
 * Hook into the user profile page and add an option that allows the users 
 * save an option for toolbar postition
 */
add_action( 'profile_personal_options', 'show_admin_bar_position_option' );
function show_admin_bar_position_option( $user ) {
    // get the value of admin_bar_position meta key
    $admin_bar_position_meta_value = get_user_meta( $user->ID, 'admin_bar_position', true ); // $user contains WP_User object
    ?>
	<table class="form-table">
		<tr class="show-admin-bar user-admin-bar-front-wrap">
			<th scope="row">Toolbar Position</th>
			<td>
			<fieldset>
				<legend class="screen-reader-text">
					<span>Toolbar Position</span>
				</legend>
				<label for="admin_bar_position">
					<input name="admin_bar_position" type="checkbox" id="admin_bar_position" value="1" <?php 
						if (isset($admin_bar_position_meta_value) && $admin_bar_position_meta_value) {
						 	checked( $admin_bar_position_meta_value, 1 );
						} 
					?>>
					Show admin toolbar on bottom on page when viewing site
				</label>
				<br>
			</fieldset>
			</td>
		</tr>
	</table>
    <?php
}
/*
 * Save the option for toolbar postition
 */
add_action( 'personal_options_update', 'save_admin_bar_position_option' );
function save_admin_bar_position_option( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
    	return false; 
    }
    else{
        if(isset($_POST['admin_bar_position'])){
            update_user_meta( $user_id, 'admin_bar_position', $_POST['admin_bar_position'] );
        }
        else {
        	update_user_meta( $user_id, 'admin_bar_position', '' );
        }
    }
}

/*
 * Inject the CSS style that postions WP admin bar on bottom of page
 */
function admin_bar_bottom() {
	$admin_bar_position_meta_value = get_user_meta( get_current_user_id(), 'admin_bar_position', true );
	// Check if admin bar is enabled for the current user
	if ( is_admin_bar_showing() && $admin_bar_position_meta_value ):
		// Inject styling into the <head>
		ob_start();
		?><style type="text/css" media="screen">
		#wpadminbar{top:auto;bottom:0}@media screen and (max-width: 600px){#wpadminbar{position:fixed}}#wpadminbar .menupop .ab-sub-wrapper,#wpadminbar .shortlink-input{bottom:32px}@media screen and (max-width: 782px){#wpadminbar .menupop .ab-sub-wrapper,#wpadminbar .shortlink-input{bottom:46px}}@media screen and (min-width: 783px){.admin-bar.masthead-fixed .site-header{top:0}}
		</style><?php
		$style = ob_get_contents();
		ob_end_clean();
		echo $style;
	endif;
}
add_action( 'wp_head', 'admin_bar_bottom', 9999 );