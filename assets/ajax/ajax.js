( function($){
	'use strict';

	$(document).on('click', '.btn.test', function(e){
		// alert();

		var nonce = $('input[name="nonce"]').val();

		$.ajax({
			url: ajax_object.ajax_url,
			type: 'POST',
			dataType: 'json',
			data: {
				nonce : nonce,
				'action' : 'ajax_requests'
			},
			beforeSend: function(){

			},
			success: function(response){
				// alert(response)
				console.log(response);

			},
			error: function(response){
				console.log(response);
				alert('Something went wrong, Please try again')
			}
		});

	});

})(jQuery);