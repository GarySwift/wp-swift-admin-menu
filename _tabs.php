<?php $options = get_option( 'wp_swift_admin_menu_settings' ); ?>
<div id="wp-swift-admin-menu-options-page" class="wrap">

	<h1><?php echo $this->page_title; ?></h1>

	<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'menu-options'; ?>

	<h2 class="nav-tab-wrapper">
	    <a href="?page=<?php echo $this->menu_slug ?>&tab=menu-options" class="nav-tab <?php echo $active_tab == 'menu-options' ? 'nav-tab-active' : ''; ?>">Menu Options</a>

	    <?php if ($this->show_sidebar_option('show_sidebar_options_google_map')): ?>
	    	<a href="?page=<?php echo $this->menu_slug ?>&tab=google-map" class="nav-tab <?php echo $active_tab == 'google-map' ? 'nav-tab-active' : ''; ?>">Google Map</a>
	    <?php endif ?>

	    <a href="?page=<?php echo $this->menu_slug ?>&tab=utilities" class="nav-tab <?php echo $active_tab == 'utilities' ? 'nav-tab-active' : ''; ?>">Utilities</a>

	    <a href="?page=<?php echo $this->menu_slug ?>&tab=help-page" class="nav-tab <?php echo $active_tab == 'help-page' ? 'nav-tab-active' : ''; ?>">Help Page</a>
	</h2>
			
	<form action='options.php' method='post'>

		<div id="table-wrapper">
			<?php
				if (function_exists( 'acf' )) {
					if ($active_tab == 'menu-options') {
						settings_fields( 'menu_options' );
						do_settings_sections( 'menu_options' );
						submit_button();
					}
					elseif ($active_tab == 'google-map' && $this->show_sidebar_option('show_sidebar_options_google_map')){
						settings_fields( 'google-map' );
						do_settings_sections( 'google-map' );
						submit_button();
					}
					elseif ($active_tab == 'utilities'){
						settings_fields( 'utilities' );
						do_settings_sections( 'utilities' );
						submit_button();
					}	
					elseif ($active_tab == 'help-page'){
						settings_fields( 'help-page' );
						do_settings_sections( 'help-page' );
					}
				}
			?>
		</div>

	</form>

</div><!-- @end #wp-swift-admin-menu-options-page -->