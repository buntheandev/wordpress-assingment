(function( $ ) {

	'use strict';

	$(function() {

		var data = {};
		data.mts_plugins_list = 'yes';
		$.ajax({
			url: document.URL,
			cache: false,
			type: "get",
			data: data,
			success: function(response) {

				if( $( response ).find('.mts-addons-list').length > 0 ) {

					$('.mts-addons-list').replaceWith( $( response ).find('.mts-addons-list') );
				}
			}
		});
	});

})( jQuery );