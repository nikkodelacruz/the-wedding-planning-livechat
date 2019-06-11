(function($){


	$(document).ready(function(){


		var ajax_url = ajax_object.ajax_url;

		// Display error message
		function _err(){
			M.toast({html: 'Ooops, something went wrong, please reload the page and try again!'})
		}


		$(document).on('click', '.modal-trigger', function(){
			// alert();

			var customer_id = $(this).data('customer');
			var supplier_id = $(this).data('supplier');

			var user_id = $('input[name="user_id"]').val();

			var nonce = $('input[name="nonce"]').val();

			$.ajax({

				url : ajax_url,
				type : 'POST',
				dataType : 'html',
				data: {
					customer_id : customer_id,
					supplier_id : supplier_id,
					user_id : user_id,
					security : nonce,
					action : 'ajax_requests'
				},
				beforeSend:function(){
					$('.preloader').removeClass('hidden');
					$('ul.conversation-list').empty();
				},
				success:function(response){
					$('.preloader').addClass('hidden');

					$('ul.conversation-list').append(response);

				},
				error:function(err){
					$('.preloader').addClass('hidden');
					console.log(err);
					_err();
				}


			});
		});




		
	});

})(jQuery);