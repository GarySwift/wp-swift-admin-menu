<?php
$options = get_option( 'wp_swift_google_map_settings' );
$map_zoom_level=14;
$map_style = false;/* Go to https://snazzymaps.com/ [Snazzy Maps] for map styles */

if (isset($options['show_sidebar_options_google_map_style'])) {
	$map_style = trim($options['show_sidebar_options_google_map_style']);
} 
// contentString is used to make the Info windows in the google map 
// More: https://developers.google.com/maps/documentation/javascript/examples/infowindow-simple
ob_start();
?>
<div id="content" class="google-content-pane">
	<div id="siteNotice"></div>
	<h5 id="firstHeading"><?php echo get_bloginfo('name') ?></h5>
	<h6 id="secondHeading"><?php echo get_bloginfo('description') ?></h6>
</div>
<?php
	$contentString = ob_get_contents();
	ob_end_clean();
	ob_start();
?>
<script>
    var map_zoom_level = <?php echo json_encode($map_zoom_level); ?>;
    map_zoom_level = parseInt(map_zoom_level);
    var map_style = <?php echo json_encode($map_style); ?>;
    map_style = JSON.parse(map_style);
    var contentString = <?php echo json_encode($contentString); ?>;
</script>
<?php 

$javascript = ob_get_contents();
ob_end_clean();
echo $javascript;