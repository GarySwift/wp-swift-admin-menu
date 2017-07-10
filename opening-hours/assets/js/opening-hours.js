(function($) {
	// Disable table sorting
	if ($(".acf-field-repeater.disable-sorting")[0]){
		if (typeof acf !== 'undefined') {
			$.extend( acf.fields.repeater, {
				_mouseenter: function( e ){
					if( $( this.$tbody.closest('.acf-field-repeater') ).hasClass('disable-sorting') ){
						return;
					}
				}
			});	
			setTimeout(function(){
				var target = $('.disable-sorting > .acf-input > .acf-repeater > .acf-table > tbody > .acf-row > .acf-row-handle.order');
				target.css( {'cursor':'default', 'background-color':'#767676', 'color':'#feffe5'} ).attr('title', 'Ordering disabled');
			}, 200);	
		}
	} 

})(jQuery);