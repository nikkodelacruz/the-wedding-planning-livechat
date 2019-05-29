<?php 
/**
 * Create post type
 * @package TheWeddingPlanningLivechat
 */

defined( 'ABSPATH' ) || exit;

// final class CreatePostType
// {
// 	public static function create_post_type()
// 	{

		// Mesaages post type
		register_post_type(
			'messages-list',
			[
				'public'=> true,
				'label' => 'Messages',
				'menu_icon' => 'dashicons-format-chat',
				'show_in_rest' => true
			]
		);


// 	}
// }


