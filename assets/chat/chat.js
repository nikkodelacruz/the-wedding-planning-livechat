( function( $ ) {

	'use strict';

	// emit -> send data to read by on
	// socket.emit('current user id', {
	// 	socket_id : user_id
	// }); // pass user id

	// socket.on('display user id', function(data){
	// 	// alert(data.socket_id);
	// 	console.log(data.clients);
	// });

	/*==========*/
	/* Chat box */
	/*==========*/
  //   $(document).on('keypress', '.chat-message', function(){
		// var message = $(".chat-message").val();
		// var rid = $('.chat-container').attr('data-id');
		// // Don't send if no message
		// if( event.which == 13 && !message ){
  //           return false; 
		// }else{
		// 	if ( event.which == 13 ) {     
	 //        	send_message(message,rid,'chatbox');
	 //        	$(".chat-message").val('');
	 //            return false; 
	 //        }
		// }
  //   });
  //   $(document).on('click', '.chat-send', function(){
		// var message = $(".chat-message").val();
		// var rid = $('.chat-container').attr('data-id');
		// $(".chat-message").focus();
		// if(message){
		// 	send_message(message,rid,'chatbox');
	 //        $(".chat-message").val('');
		// }else{
		// 	return false;
		// }
  //   });


	// unused, changed to AJAX
	// socket.on('display messages', function(data){
	// 	// console.log(data.data);
	// 	var uid = $('.chat-container').data('uid');
	// 	if(uid == data.user_id){
	// 		var chat = data.data;
	// 		if(chat){
	// 			$(".chat-container-list").empty();
	// 			for(var x in chat){
	// 				var date = chat[x].date_time;
	// 				var id = chat[x].user_id;
	// 				var profile = chat[x].profile;
	// 				var name = chat[x].name;
	// 				var message = chat[x].message;
	// 				$(".chat-container-list").append(
	// 				`<li class='media'>
	// 					<img src="`+profile+`" />
	// 					<div class="media-body ml-2">
	// 						<span>`+date+`</span>
	// 						<strong>`+name+`</strong>
	// 						`+message+`
	// 				    </div>
	// 				</li>`); 
	// 			}
	// 			$('.chat-container__body').animate({scrollTop: $('.chat-container__body').get(0).scrollHeight},1);
	// 			$('.chat-slide').toggleClass('loader');
	// 		}
	// 	}
	// });

	/*=====================================*/
	// Chatbox(unsused, message page instead)
	/*=====================================*/

	// Toggle chatbox slide
	// $('.chat-container__minimize').click(function(){
	// 	$('.chat-container .chat-slide').slideToggle();
	// });

	// Close chatbox
	// $('.chat-container__close').click(function(){
	// 	$('.chat-container').hide();
	// });

	// On click, load conversations
	// $(document).on('click','.socket-send-message',function(){
	// 	$('.chat-container').show();
	// 	$('.chat-container').removeClass('d-none');
	// 	$('.chat-container .chat-slide').slideDown();
	// 	$('.no-conversation').remove();

	// 	// $(".chat-message").focus();
	// 	$('.chat-slide').toggleClass('loader'); //preloader while getting messages
	// 	var id = $(this).data('id');
	// 	var name = $(this).data('name');
	// 	$('.chat-container').attr('data-id',id);
	// 	$('.chat-receiver__name').text(name);

	// 	var sup_id = 0;
	// 	var cus_id = 0;

	// 	if ( user_role == 'customer' ) {
	// 		sup_id = id;
	// 		cus_id = user_id;
	// 	} else if ( user_role == 'supplier' )  {
	// 		sup_id = user_id;
	// 		cus_id = id;
	// 	}

	// 	$.ajax({
	// 		url : get_all_messages_api,
	// 		method : 'GET',
	// 		dataType : 'json',
	// 		data : {
	// 			supplier_id : sup_id,
	// 	      	customer_id : cus_id,
	// 		},
	// 		beforeSend: function(response){
	// 			$(".chat-container-list").empty();
	// 		},
	// 		success: function(response){
	// 			console.log(response);
	// 			if (response.success) {
	// 				var data = response.data;
	// 				for(var x in data){
	// 					var date = data[x].date_time;
	// 					var id = data[x].user_id;
	// 					var profile = data[x].profile;
	// 					var name = data[x].name;
	// 					var message = data[x].message;
	// 					$(".chat-container-list").append(
	// 						`<li class='media'>
	// 							<img src="`+profile+`" />
	// 							<div class="media-body ml-2">
	// 								<span>`+date+`</span>
	// 								<strong>`+name+`</strong>
	// 								`+message+`
	// 						    </div>
	// 						</li>`
	// 					); 
	// 				}
	// 				$('.chat-container__body').animate({scrollTop: $('.chat-container__body').get(0).scrollHeight},1);
	// 			}else{
	// 				// If no conversation yet
	// 				$(".chat-slide").append(
	// 					`<div class="no-conversation">
	// 					No conversation yet.</br>
	// 					Start a new one!
	// 					<button class="btn btn-primary mt-2 start-conversation">Start a conversation</button>
	// 					</div>`
	// 				);
	// 			}
	// 			$('.chat-slide').toggleClass('loader');
	// 		},
	// 		error: function(response){
	// 			console.log(response)
	// 			alert('Something went wrong, Please try again');
	// 		}
	// 	});

	// });

	// $(document).on('click', '.start-conversation', function(){
	// 	$('.no-conversation').remove();
	// });

	// socket.on('get messagesd', function(data){
	// 	// Scroll down container for every new message
	// 	var sup_id = data.supplier_id;
	// 	var cus_id = data.customer_id;
	// 	var role = data.role;
	// 	var profile = data.profile;
	// 	var name = data.name;
	// 	var date = data.date;
	// 	var message = data.message;
	// 	var id = data.id; //ID of sender
	// 	var type = data.type;

	// 	// Add notification sound
	// 	if ( role == 'supplier' ) {
	// 		if ( user_id == cus_id ) {
	// 			// audio.play();
	// 		}
	// 	}else if( role == 'customer' ){
	// 		if ( user_id == sup_id ) {
	// 			// audio.play();
	// 		}
	// 	}

	// 	// Id of container
	// 	var data_id = $('.send-message-container').attr('data-id');

	// 	// Append message to list
	// 	if( user_id == cus_id || user_id == sup_id ){

	// 		if( type == 'chatbox' ){
	// 			$(".chat-container__body").animate({scrollTop: $(".chat-container__body").get(0).scrollHeight},1);
	// 			$(".chat-container-list").append(
	// 				`<li class='media'>
	// 					<img src="`+profile+`" />
	// 					<div class="media-body ml-2">
	// 						<span>`+date+`</span>
	// 						<strong>`+name+`</strong>
	// 						`+message+`
	// 				    </div>
	// 				</li>`
	// 			); 
	// 		}else{

	// 			// Add You if sender
	// 			if(user_id == id){
	// 				var you = 'You: ';
	// 			}else{
	// 				var you = '';
	// 			}
	// 			$("ul.messenger-container__users li a[data-id='"+sup_id+"']").find('.message--recent_message').html('<strong>'+you+message+'</strong>');
	// 			$("ul.messenger-container__users li a[data-id='"+cus_id+"']").find('.message--recent_message').html('<strong>'+you+message+'</strong>');

	// 			// Send message to container if receiver is open
	// 			if ( data_id && sup_id == data_id || cus_id == data_id ) {

	// 				if(user_id == id){
	// 					align="text-right";
	// 				}else{
	// 					align="text-left";
	// 				}
	// 				$(".messenger-container__conversation").animate({scrollTop: $(".messenger-container__conversation").get(0).scrollHeight},1);
	// 				$(".messenger-container__conversation").append(
	// 					`<li class="`+align+`">
	// 						<div class="message-aligner">`+message+`</div>
	// 					</li>`
	// 				);
	// 			}
				
	// 		}

	// 	}
	// });

    /* Get conversations of 2 users */
  //   function get_all_messages(id,uid){
  //   	var sup_id = 0;
		// var cus_id = 0;

		// if ( user_role == 'customer' ) {
		// 	sup_id = id;
		// 	cus_id = user_id;
		// } else if ( user_role == 'supplier' )  {
		// 	sup_id = user_id;
		// 	cus_id = id;
		// }

  //   	var data = {
  //   		supplier_id : parseInt(sup_id), // supplier ID
  //   		customer_id : parseInt(cus_id), // customer ID
  //   		user_id : user_id,
  //   		api : get_all_messages_api
  //       };
  //   	socket.emit('get all messages', data);
  //   }

  	/**
  	 * Global variables
  	 */
  	

  	var audio = $(".sound-notif")[0]; // Chat notification sound

	// Data from localize script (logged in user data)
	var user_id = udata.id; // user id
	var user_role = udata.role; // user role
	var user_profile = udata.profile // user profile picture
	var user_name = udata.name;
	var send_message_api = udata.send_message_api;
	var get_all_messages_api = udata.get_all_messages_api;
	var seen_message_api = udata.seen_message_api;

	/*==============*/
    /* Message Page */
    /*==============*/
    $(document).on('keypress', '.send-message-txt', function(){
		var receiver_id = $('input[name="socket_receiver_id"]').val();
		var room = $('input[name="socket_room"]').val(); //name of room to join
		var message = $(".send-message-txt").val();
		// Don't send if no message
		if( event.which == 13 && !message ){
            return false; 
		}else{
			if ( event.which == 13 ) {     
	        	send_message( room, receiver_id, message );
		        $(".send-message-txt").val('');
		        $(".send-message-txt").focus();
	            return false; 
	        }
		}
    });
    $(document).on('click', '.send-message-btn', function(){
		var receiver_id = $('input[name="socket_receiver_id"]').val();
		var room = $('input[name="socket_room"]').val(); //name of room to join
		var message = $(".send-message-txt").val();
		if( room && message ){
			send_message( room, receiver_id, message );
	  		$(".send-message-txt").val('');
	  		$(".send-message-txt").focus();
		}else{
			return false;
		}
    });

	// Load conversations upon selecting of user in the list
	$(document).on('click', '.socket-open-message', function(){
		event.preventDefault();

		$('.start-conversation-label').remove();
		$('.send-message-container').removeClass('d-none');

		$('.socket-open-message').parent('li').removeClass('active');
		$(this).parent('li').addClass('active');

		var room = $(this).find('input[name="room"]').val();
		var receiver_id = $(this).find('input[name="receiver_id"]').val();

		// Join to room name
		join_room(room);

		var sup_id = 0;
		var cus_id = 0;

		if ( user_role == 'customer' ) {
			sup_id = receiver_id;
			cus_id = user_id;
		} else if ( user_role == 'supplier' )  {
			sup_id = user_id;
			cus_id = receiver_id;
		}

		$.ajax({
			url : get_all_messages_api,
			method : 'GET',
			dataType : 'json',
			data : {
				user_role : user_role,
				supplier_id : sup_id,
		      	customer_id : cus_id,
			},
			beforeSend: function(response){
				$('input[name="socket_room"]').val(room);
				$('input[name="socket_receiver_id"]').val(receiver_id);
				$(".messenger-container__conversation").addClass('loader');
				$(".messenger-container__conversation").empty();
			},
			success: function(response){
				// console.log(response);
				if (response.success) {
					var data = response.data;
					for(var x in data){
						var date = data[x].date_time;
						var id = data[x].user_id;
						var profile = data[x].profile;
						var name = data[x].name;
						var message = data[x].message;
						var align = ""
						if(user_id == id){
							align = "text-right";
						}else{
							align = "text-left";
						}
						$(".messenger-container__conversation").append(
							`<li class="`+align+`">
								<div class="message-aligner">`+message+`</div>
							</li>`
						); 
					}
					$('.messenger-container__conversation').animate({scrollTop: $('.messenger-container__conversation').get(0).scrollHeight},1);
				}
				$('.messenger-container__conversation').removeClass('loader');
			},
			error: function(response){
				console.log(response);
				$('.messenger-container__conversation').removeClass('loader');
				alert('Something went wrong, Please try again');
			}
		});

	});


	$(document).ready( function(){
		$('ul.messenger-container__users li.active a').trigger('click');

		var user_list = $('ul.messenger-container__users').has("li").length;
		var h3 = $('ul.messenger-container__users').has("h3").length;
		if( !user_list && !h3 ){
			$('ul.messenger-container__users').append('<h3 class="d-flex m-0 align-items-center justify-content-center h-100 pt-5 pb-5 px-4">No Conversations Found</h3>');
		}

		var motif_list = $('ul.message-notification__list').has("li").length;
		if( !motif_list ){
			$('ul.message-notification__list').append('<li class="text-center">No messages found</li>');
		}

	});

	

	/**
	 *
	 * Socket emit and om
	 *
	 */

	/* Join room name */
	function join_room( room_name ) {
		socket.emit('join room', {
			room : room_name
		});
	}

	/* Send message to receiver and save throuh WP API */
    function send_message( room, receiver_id, message ) {
		var sup_id = 0;
		var cus_id = 0;

		if ( user_role == 'customer' ) {
			sup_id = receiver_id;
			cus_id = user_id;
		} else if ( user_role == 'supplier' ) {
			sup_id = user_id;
			cus_id = receiver_id;
		}

    	var data = {
    		supplier_id : parseInt(sup_id),
    		customer_id : parseInt(cus_id),
    		sender_id : parseInt(user_id), // loggedin user
    		room : room, //room name to join
    		message : message,
    		api : send_message_api //global js value
        };

        socket.emit('send message', data); //function to call in the server (node)
    }

    /* Append message to container for customer and supplier */
    socket.on('display message',function(data){

	    // console.log(data);
		var customer_id = data.customer_id;
    	var supplier_id = data.supplier_id;
		var message = data.message;
    	var sender_id = data.sender_id;

		if( user_id == supplier_id || user_id == customer_id ){

			if(user_id == sender_id){
				var you = 'You: ';
			}else{
				var you = '';
			}

			// Trim message and add ellipsis
			var str = message.substring(0, 10); // cut string
			var n = message.length; //count string
			var el = '';
			if ( n >= 10 ) {
				el = '...';
			}
			$(".message--recent_message[data-id='"+customer_id+"']").html('<strong>'+you+str+el+'</strong>');
			$(".message--recent_message[data-id='"+supplier_id+"']").html('<strong>'+you+str+el+'</strong>');

			if(data){
				var receiver_id = $('input[name="socket_receiver_id"]').val();
				var post_id = $('input[name="socket_room"]').val();
				var seen_by = '';
				if ( user_role == 'customer' && receiver_id == supplier_id) {
					// alert('customer seen');
					setTimeout(function(){
						socket.emit('seen message', {
							api : seen_message_api+'/'+post_id+'/customer'
						});
					},1000);
				}
				if ( user_role == 'supplier' && receiver_id == customer_id) {
					// alert('supplier seen');
					setTimeout(function(){
						socket.emit('seen message', {
							api : seen_message_api+'/'+post_id+'/supplier'
						});
					},1000);

				}
			}


		}

    });

    /* Get message for every send of user */
    socket.on('get message', function(data){

    	var customer_id = data.customer_id;
    	var supplier_id = data.supplier_id;
		var message = data.message;
		var sender_id = data.sender_id;
		var receiver_id = $('input[name="socket_receiver_id"]').val();

		// Send message between 2 users only
		if( receiver_id == supplier_id || receiver_id == customer_id ){

			// Check if sender is the loggedin user
			var align = "";
			if( user_id == sender_id ){
				align="text-right";
			}else{
				align="text-left";
				audio.play();
			}
			$(".messenger-container__conversation").animate({scrollTop: $(".messenger-container__conversation").get(0).scrollHeight},1);
			$(".messenger-container__conversation").append(
				`<li class="`+align+`">
					<div class="message-aligner">`+message+`</div>
				</li>`
			);

		}
	});




	

} )( jQuery );


