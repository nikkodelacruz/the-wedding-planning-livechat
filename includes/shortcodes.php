<?php 
 /**
 * Shortcode
 * @package SocketLiveChat
 */

// Chatbox popup
function socket_chat_box(){ 
    ob_start();

    if (is_user_logged_in()) {

        $udata = wp_get_current_user();
        $role = $udata->roles[0];
        ?>
    	<!-- Chat container -->
    	<div class="chat-container d-none" data-uid="<?php echo $udata->ID; ?>" data-id="">
    		<div class="chat-container__header">
    			<label class="chat-receiver__name m-0"></label>
    			<a href="#" class="chat-container__close">×</a>
    			<a href="#" class="chat-container__minimize">−</a>
    			<div class="clearfix"></div>
    		</div>
    		<div class="chat-slide">
	    		<div class="chat-container__body">
	               	<!-- Read and Append messages -->
	    			<ul class="chat-container-list"></ul>
	    		</div>
	    		<div class="chat-container__footer">
	    			<!-- <label class="chat-sender__name">John</label> -->
	    			<input type="text" class="form-control chat-message" placeholder="Enter message here">
	    			<div class="d-block text-right mt-2">
		    			<button class="btn chat-send">Send</button>
	    			</div>
	    		</div>
    		</div>
    	</div>
        <?php
    }

    return ob_get_clean();

}
add_shortcode( 'socket_chat_box', 'socket_chat_box' );

// Chat message
function socket_chat_message(){
    ob_start();

    if (!is_user_logged_in()) {
    	wp_die( 'Please login your account' );
    }

    /**
     * Logged in user details
     */    
    $udata = wp_get_current_user();
	$user_id = $udata->ID;
	$role = $udata->roles[0];

    if( isset($_GET['key']) && $role == 'customer' || $role == 'supplier' ){
    	$supplier = $_GET['key'];
    	$supplier = urldecode($supplier);
    	$supplier = base64_decode($supplier);
    	$supplier = json_decode($supplier);

    	$auth = $supplier->auth;

    	if( $auth == 'the-wedding' ){
	    	$supplier_id = $supplier->id;
	    	// var_dump($supplier_id);

	    	$posts = get_posts( array(
				'post_type' => 'messages-list',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'supplier_id',
						'value' => $supplier_id,
						'compare' => '=',
					),
					array(
						'key' => 'customer_id',
						'value' => $user_id,
						'compare' => '=',
					)
				)
			) );

			// Create new post if conversation doesn't exist
			if ( !$posts ){
				$title = 'customer '.$user_id.' - '.'supplier '.$supplier_id;
				$post_id = wp_insert_post( array(
					'post_title' => $title,
					'post_status' => 'publish',
					'post_type' => 'messages-list'
				) );
				update_field('supplier_id', $supplier_id, $post_id);
				update_field('customer_id', $user_id, $post_id);
			}

    	}

    }


    /**
     * Get user messages depending on logged in user
     */
	$meta = array();
	if($role == 'customer'){
		$meta = array(
			'key' => 'customer_id',
			'value' => $user_id,
			'compare' => '=',
		);
	}elseif($role == 'supplier'){
		$meta = array(
			'key' => 'supplier_id',
			'value' => $user_id,
			'compare' => '=',
		);
	}

	$posts = get_posts( array(
		'post_type' => 'messages-list',
		'meta_query' => array( $meta )
	) );

	?>

	<div class="container-fluid mt-5 mb-5">
		<div class="messenger-container">
			<div class="row">

				<div class="col-md-3 pr-sm-0 ">
					<ul class="messenger-container__users">
					<?php
					foreach ($posts as $post) {
						$pid = $post->ID;
						$title = get_the_title( $pid );
						$conversations = get_field('conversation', $pid);
						
						if ($conversations) {
							$conversations = end($conversations); // get latest message
							$conversation_message = $conversations['conversation_message'];
							$conversation_date_time = $conversations['conversation_date_and_time'];
							$conversation_userid = $conversations['conversation_user_id'];
						}

						if($role == 'supplier'){
							$id = get_field('customer_id', $pid);
						}elseif($role == 'customer'){
							$id = get_field('supplier_id', $pid);
						}
						
						$u_data = get_userdata($id);
						$name = $u_data->first_name.' '.$u_data->last_name;
				        $profile = get_field('profile_picture', 'user_'.$id);
				        $profile = ($profile) ? $profile : get_field('no_profile_placeholder','option');

				        $active = ( $supplier_id == $id ) ? 'active' : '' ;

						?>

						<li class="media <?php echo $active; ?>">
							<a href="#" class="socket-open-message media">
								<input type="hidden" name="receiver_id" value="<?php echo $id; ?>">
								<input type="hidden" name="room" value="<?php echo $title; ?>">
								<img src="<?php echo $profile; ?>" />
								<div class="media-body ml-2">
									<span class="message--date_time float-right">10:30 AM</span>
									<span class="message--receiver-name"><?php echo $name; ?></span>
									<span class="message--recent_message" data-id="<?php echo $id; ?>">
										<?php 
										if($user_id == $conversation_userid){
											echo 'You: ';
										}
										// Trim message and add ellipsis
										$length = strlen($conversation_message);
										if( $length <= 10 ){
											echo $conversation_message;
										}else{
											echo substr( $conversation_message, 0, 10 ).'...'; 
										}
										?>
									</span>
							    </div>
							</a>
						</li>

						<?php
						// var_dump($sup);
					}
					?>
					</ul>
				</div>

				<div class="col-md-6 pl-sm-0">
					<ul class="messenger-container__conversation">
						<li class="start-conversation-label"><h3>Start your conversation today</h3></li>
					</ul>
					<div class="send-message-container d-none">
						<input type="hidden" name="socket_receiver_id"> <!-- person to receive the message -->
						<input type="hidden" name="socket_room"> <!-- room to join -->
						<input type="text" class="form-control send-message-txt" placeholder="Type a message...">
		    			<div class="d-block text-right mt-2">
			    			<button class="btn send-message-btn">Send</button>
		    			</div>
					</div>
				</div>

				<div class="col-md-3"></div>

			</div>
		</div>
	</div>
	<?php

    return ob_get_clean();

}
add_shortcode( 'socket_chat_message', 'socket_chat_message' );

function socket_supplier_id( $atts ){
	ob_Start();
	$id = $atts['id'];
	$text = $atts['button_text'];

	$url = array(
		'id' => $id,
		'auth' => 'the-wedding'
	);
	$url = wp_json_encode( $url);
	$url =base64_encode($url);
	$url = urlencode($url);
	$link = home_url( 'message' ).'?key='.$url;
	?>
	<a href="<?php echo $link; ?>"><?php echo $text; ?></a>
	<?php

	return ob_get_clean();
}
add_shortcode( 'socket_supplier_id', 'socket_supplier_id' );


function socket_message_notification(){
	ob_start();
	?>

	<a href="">
		<i class="far fa-envelope"></i>
	</a>

	
	<?php
	return ob_get_clean();
}

add_shortcode( 'socket_message_notification', 'socket_message_notification' );