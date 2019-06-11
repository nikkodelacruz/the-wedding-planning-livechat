<?php 
/**
 * Admin Ajax request
 * @package TheWeddingPlanningLivechat
 */

defined( 'ABSPATH' ) || exit;

class AdminAjaxRequests
{

	public function __construct(){

		// var_dump(true);
	    add_action( 'wp_ajax_ajax_requests', array($this,'ajax_requests') );
	    add_action( 'wp_ajax_nopriv_ajax_requests', array($this,'ajax_requests') );
	}

	public function ajax_requests()
	{

		if( ! DOING_AJAX || ! check_ajax_referer('messages-list', 'security') ){
			return wp_send_json_error();
		}

		$customer_id = $_POST['customer_id'];
		$supplier_id = $_POST['supplier_id'];

		$user_id = $_POST['user_id'];


		$posts = get_posts(
			array(
				'post_type' => 'messages-list',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'supplier_id',
						'value' => $supplier_id,
						'compare' => '='
					),
					array(
						'key' => 'customer_id',
						'value' => $customer_id,
						'compare' => '='
					)
				)
			)
		);

		if ( $posts ) {

			$post_id = $posts[0]->ID;
			$conversations = get_field('conversation', $post_id);

			if ($conversations) {
				foreach ($conversations as $conv) {
					$conv_time = $conv['conversation_date_and_time'];
					$conv_id = $conv['conversation_user_id']; //user id of sender
					$conv_message = $conv['conversation_message'];

					$udata = get_user_by( 'id', $conv_id );

					// If selected user is equal to sender id
					if ($user_id == $conv_id) {
						$align = 'right-align';
					}else{
						$align = 'left-align';
					}



					echo '<li class="'.$align.'">';
					echo '<div class="message-container">';
					echo '<h6>'.$udata->first_name.' '.$udata->last_name.': </h6>';
					echo '<p>'.$conv_message.'</p>';
					echo '<small>'.$conv_time.'</small>';
					echo '<div>';
					echo '</li>';

				}
			}else{
				echo '<li><h5>No conversations found</h5></li>';
			}

		}else{
			echo '<li><h5>No conversations found</h5></li>';
		}

		// $return = array(
		// 	'customer' => $customer_id,
		// 	'supplier' => $supplier_id, 
		// 	'status' => true
		// );
		// return wp_send_json( $return );


		wp_die();

	}

}
