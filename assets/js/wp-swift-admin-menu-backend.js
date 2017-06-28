jQuery(document).ready(function($){
	'use strict';
	console.log("wp-swift-admin-menu-backend.js");
	var $showSidebarOptionsGoogleMap = $('#show-sidebar-options-google-map');
	var $googleMapToggleReadonlyClass = $('.google-map-toggle-readonly');
	var $googleMapToggleShowClass = $('.google-map-toggle-show');

	$showSidebarOptionsGoogleMap.change(function() {
        if($(this).is(":checked")) {

            // console.log('this is checked');

            $googleMapToggleReadonlyClass.prop("readonly", false);
            $googleMapToggleShowClass.show();

            // $('label[for="google-map-api-key"]').removeClass('disabled');
            // $('label[for="google-map-style"]').removeClass('disabled');
            $('#table-wrapper').removeClass('map-disabled');
        }
        else {
        	
        	$googleMapToggleReadonlyClass.prop("readonly", true);
        	$googleMapToggleShowClass.hide();
        	// $('label[for="google-map-api-key"]').addClass('disabled');
        	// $('label[for="google-map-style"]').addClass('disabled');
            $('#table-wrapper').addClass('map-disabled');
        	// console.log('unchecked');
        }
   
    });
});