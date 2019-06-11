<?php 
 /**
 * Shortcode
 * @package TheWeddingPlanningLivechat
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

// Get all messages
function socket_chat_message(){
    ob_start();

    if ( !is_user_logged_in() || current_user_can('administrator') ) {
    	return false;
    	// wp_die( 'Please login your account' );
    }

    /**
     * Logged in user details
     */    
    $udata = wp_get_current_user();
	$user_id = $udata->ID;
	$role = $udata->roles[0];

    if( isset($_GET['key']) && ($role == 'customer' || $role == 'supplier') ){
    	$key = $_GET['key'];
    	$key = urldecode($key);
    	$key = base64_decode($key);
    	$key = json_decode($key);

    	$auth = $key->auth;

    	if( $auth == 'the-wedding' ){
	    	$supplier_id = $key->supplier_id;
	    	$customer_id = $key->customer_id;

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
						'value' => $customer_id,
						'compare' => '=',
					)
				)
			) );

			// Create new post if conversation doesn't exist (new conversation)
			if ( !$posts ){
				$title = 'customer '.$customer_id.' - '.'supplier '.$supplier_id;
				$post_id = wp_insert_post( array(
					'post_title' => $title,
					'post_status' => 'publish',
					'post_type' => 'messages-list'
				) );
				update_field('supplier_id', $supplier_id, $post_id);
				update_field('customer_id', $customer_id, $post_id);
				update_field('supplier_message_seen', true, $post_id);
				update_field('customer_message_seen', true, $post_id);

			}else{
				if ($role == 'supplier') {
					update_field('supplier_message_seen', true, $posts[0]->ID);
				}
				if ($role == 'customer') {
					update_field('customer_message_seen', true, $posts[0]->ID);
				}
			}

    	}else{ //invalid key
	    	return false;
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

	$message_posts = get_posts( array(
		'post_type' => 'messages-list',
		'meta_query' => array( $meta )
	) );


	$dark_mode = get_field('dark_mode','option');
	$color = '';
	if( $dark_mode ){
		$color = 'dark-mode';
	}

	?>

	<div class="container-fluid m-4">
		<div class="messenger-container <?php echo $color; ?>">
			<div class="row">

				<div class="col-md-3 p-0 ">
					<ul class="messenger-container__users">
					<?php
					if($message_posts){
						foreach ($message_posts as $post) {
							$pid = $post->ID;
							$title = get_the_title( $pid );
							$conversations = get_field('conversation', $pid);
							
							if ($conversations) {
								$conversations = end($conversations); // get latest message
								$conversation_message = $conversations['conversation_message'];
								$conversation_date_time = $conversations['conversation_date_and_time'];
								$conversation_userid = $conversations['conversation_user_id'];
							}

							// Role of current user
							if($role == 'supplier'){
								$id = get_field('customer_id', $pid);
						        $active = ( $customer_id == $id ) ? 'active' : '' ;
							}elseif($role == 'customer'){
								$id = get_field('supplier_id', $pid);
						        $active = ( $supplier_id == $id ) ? 'active' : '' ;
							}
							
							$u_data = get_userdata($id);
							$name = $u_data->first_name.' '.$u_data->last_name;
					        $profile = get_field('user_profile_picture', 'user_'.$id);
					        $profile = ($profile) ? $profile : get_field('no_profile_placeholder','option');

							if(
								$role == 'customer' && !$conversations || 
								$role == 'customer' && $conversations || 
								$role == 'supplier' && $conversations 
							){

							?>

							<li class="media <?php echo $active; ?>">
								<a href="#" class="socket-open-message media">
									<input type="hidden" name="receiver_id" value="<?php echo $id; ?>">
									<input type="hidden" name="room" value="<?php echo $pid; ?>">
									<img src="<?php echo $profile; ?>" />
									<div class="media-body ml-2">
										<span class="message--receiver-name"><?php echo $name; ?></span>
										<small class="message--date_time"><?php echo $conversation_date_time; ?></small>
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

					        }

						}
					}else{
						echo '<h3 class="d-flex m-0 align-items-center justify-content-center h-100 pt-5 pb-5 px-4">No Conversations Found</h3>';
					}

					?>
					</ul>
				</div>

				<div class="col-md-9 p-0">
					<ul class="messenger-container__conversation">
						<li class="start-conversation-label"><h3>Start your conversation today</h3></li>
					</ul>
					<div class="send-message-container d-none">
						<input type="hidden" name="socket_receiver_id" data-id="<?php echo $user_id; ?>"> <!-- person to receive the message -->
						<input type="hidden" name="socket_room"> <!-- room to join -->
						<input type="text" class="form-control send-message-txt" placeholder="Type a message...">
		    			<div class="d-block text-right mt-2">
			    			<button class="btn send-message-btn">Send</button>
		    			</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<?php

    return ob_get_clean();

}
add_shortcode( 'socket_chat_message', 'socket_chat_message' );

// Create new message for supplier(redirect to message page)
function socket_supplier_id( $atts ){
	ob_Start();

	// customer id
	$udata = wp_get_current_user();
	$user_id = $udata->ID;
	
	// supplier id
	$id = $atts['id'];
	$text = $atts['button_text'];

	$url = array(
		'supplier_id' => $id,
		'customer_id' => $user_id,
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

// Message notification
function socket_message_notification(){
	ob_start();

	$udata = wp_get_current_user();
	$user_id = $udata->ID;
    $role = $udata->roles[0];
    $display_notif = true;

    if ($role == 'customer') {
    	$meta_query = array(
			'key' => 'customer_id',
			'value' => $user_id,
			'compare' => '=',
		);

		$notif_query = array(
			'key' => 'customer_message_seen',
			'value' => false,
			'compare' => '='
		);

    }elseif ($role == 'supplier') {
    	$meta_query = array(
			'key' => 'supplier_id',
			'value' => $user_id,
			'compare' => '=',
		);

		$notif_query = array(
			'key' => 'supplier_message_seen',
			'value' => false,
			'compare' => '='
		);
    }else{
    	$display_notif = false;
    }

    $notifs = get_posts( array(
		'post_type' => 'messages-list',
		'meta_query' => array( 
			'relation' => 'AND',
			$meta_query,
			$notif_query
		)
	) );

	$posts = get_posts( array(
		'post_type' => 'messages-list',
		'meta_query' => array( $meta_query )
	) );


	?>

	<?php if ( $display_notif ): ?>

		<ul class="notifications <?php echo $dnone; ?>">
			<li>	
				<a href="<?php echo home_url( 'messages' ); ?>">
					<i class="far fa-envelope"></i>
					<?php if($notifs): ?>
						<span class="notif-count"><?php echo count($notifs); ?></span>
					<?php endif; ?>
				</a>

				<div class="message-notification-container">
					<div class="notif-arrow"></div>
					<div class="notif-header">Messages</div>
					<ul class="message-notification__list">

						<?php 

						if ($posts) {
							
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
									$seen = get_field('supplier_message_seen', $pid);
								}elseif($role == 'customer'){
									$id = get_field('supplier_id', $pid);
									$seen = get_field('customer_message_seen', $pid);
								}
								
								$u_data = get_userdata($id);
								$name = $u_data->first_name.' '.$u_data->last_name;
						        $profile = get_field('user_profile_picture', 'user_'.$id);
						        $profile = ($profile) ? $profile : get_field('no_profile_placeholder','option');

								$unread = (!$seen) ? 'unread' : '' ;

								$url = array(
									'supplier_id' => get_field('supplier_id', $pid),
									'customer_id' => get_field('customer_id', $pid),
									'auth' => 'the-wedding'
								);
								$url = wp_json_encode( $url);
								$url =base64_encode($url);
								$url = urlencode($url);
								$link = home_url( 'message' ).'?key='.$url;


								$conversations = get_field('conversation', $pid);
								if(
									$role == 'customer' && !$conversations || 
									$role == 'customer' && $conversations || 
									$role == 'supplier' && $conversations 
								){
									echo '<li class="'.$unread.'"><a href="'.$link.'" class="media">';
									echo '<img src="'.$profile.'" />';
									echo '<div class="media-body ml-2">';
									echo '<span class="d-block font-weight-bold">'.$name.'</span>';
									echo '<small class="d-block">'.$conversation_date_time.'</small>';

									// Trim message and add ellipsis
									$length = strlen($conversation_message);
									if( $length <= 10 ){
										echo $conversation_message;
									}else{
										echo substr( $conversation_message, 0, 10 ).'...'; 
									}
									echo '</div>';
									echo '</a></li>';
								}

							}
						}else{
							echo '<li class="text-center">No messages found</li>';
						}

						?>

					</ul>
					<div class="notif-footer"><a href="<?php echo home_url( 'messages' ); ?>">See all</a></div>
				</div>

			</li>
		</ul>

	<?php endif; ?>

	<?php
	
	return ob_get_clean();
}
add_shortcode( 'socket_message_notification', 'socket_message_notification' );