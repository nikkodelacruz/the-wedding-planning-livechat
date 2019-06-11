<?php 
/**
 * Create post type for messages
 * @package TheWeddingPlanningLivechat
 */

defined( 'ABSPATH' ) || exit;

class MessagesPostType
{
	public static function create_post_type()
	{

		// Messages post type
		register_post_type(
			'messages-list',
			[
				'public'=> true,
				'label' => 'Messages',
				'menu_icon' => 'dashicons-format-chat',
				'show_in_rest' => true
			]
		);

	}
}


