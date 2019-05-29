<?php 
 /**
 * Register Rest API routes
 * @package TheWeddingPlanningLivechat
 */
defined( 'ABSPATH' ) || exit;

 class RegisterSocketAPI{
	
 	public function __construct(){

		$route = 'livechat/v1';

		// Data types:
		// array
		// boolean
		// integer
		// number
		// string

	 	// Send message to another user with user ID
		register_rest_route( $route, '/send_message', array(
			'methods' => 'POST',
			'callback' => array($this,'send_message'),
			'args' => array(
				'supplier_id' => array(
					'required' => true,
					'type' => 'number'
				),
				'customer_id' => array(
					'required' => true,
					'type' => 'number'
				),
				'id' => array( //ID of sender
					'required' => true,
					'type' => 'number'
				),
				'message' => array(
					'required' => true,
					'type' => 'string'
				)
			)
		) );

		// Get messages of 2 users
		register_rest_route( $route, '/get_all_messages', array(
			'methods' => 'GET',
			'callback' => array($this,'get_all_messages'),
			'args' => array(
				'supplier_id' => array(
					'required' => true,
					'type' => 'number'
				),
				'customer_id' => array(
					'required' => true,
					'type' => 'number'
				)
			)
		) );
 	}



	/* Save sent message from user */
	public function send_message( $request ){
		$supplier_id = $request->get_param('supplier_id');
		$customer_id = $request->get_param('customer_id');
		$id = $request->get_param('id');
		$message = $request->get_param('message');

		date_default_timezone_set('Asia/Manila');
		$date = date('F j, Y g:i a');

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

		// If conversation aleady exist
		if ( $posts ) {
			$post_id = $posts[0]->ID;
		}else{
			$title = 'customer '.$customer_id.' - '.'supplier '.$supplier_id;
			$post_id = wp_insert_post( array(
				'post_title' => $title,
				'post_status' => 'publish',
				'post_type' => 'messages-list'
			) );
			update_field('supplier_id', $supplier_id, $post_id);
			update_field('customer_id', $customer_id, $post_id);
		}

		$rows = array(
			'conversation_date_and_time' => $date,
			'conversation_user_id' => $id,
			'conversation_message' => $message
		);
		$add_row = add_row('conversation', $rows, $post_id);
		if( $add_row ){
			$response = wp_send_json_success( 
				array(
					'id' => $id,
					'date_time' => $date,
					'message' => $message
				) 
			);
		}else{
			$response = wp_send_json_error();
		}

		return $response;

	}

	/* Get conversation of 2 users */
	public function get_all_messages( $request ){
		$supplier_id = $request->get_param('supplier_id');
		$customer_id = $request->get_param('customer_id');

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

		if ($posts) {
			$post_id = $posts[0];
			$conversations = get_field('conversation', $post_id);
			$messages = array();
			if ($conversations) {
				foreach ($conversations as $conv) {
					$user_id = $conv['conversation_user_id'];
					$udata = get_userdata($user_id);
					$name = $udata->first_name.' '.$udata->last_name;

					$profile = get_field('profile_picture', 'user_'.$user_id);
			        $profile = ($profile) ? $profile : get_field('no_profile_placeholder','option') ;

					$messages[] = array(
						'date_time' => $conv['conversation_date_and_time'],
						'user_id' => $conv['conversation_user_id'],
						'message' => $conv['conversation_message'],
						'name' => $name,
						'profile' => $profile
					);
				}
			}
			$response = wp_send_json_success( $messages );
		} else {
			$response = wp_send_json_error();
		}

		return $response;

	}


}












