<?php 
 /**
 * Add admin pages and subpages in the backend
 * @package TheWeddingPlanningLivechat
 */


// add_menu_page(
// 	'Conversations', //page title
// 	'Conversations', //menu title
// 	'manage_options', //capability
// 	'conversations-page', //slug
// 	function() { include_once $this->dirname.'/templates/conversations_page.php'; }, 
// 	'dashicons-admin-generic', //icon
// 	80 //position
// );

// Add menu to settings
// add_options_page( 
// 	'Settings', 
// 	'Settings', 
// 	'manage_options', 
// 	'-settings', 
// 	array($this,'admin_settings') 
// );

// Add submenu to post type
add_submenu_page(
	'edit.php?post_type=messages-list', 
	'Conversations', 
	'Conversations', 
	'manage_options', 
	'conversation-list',
	function() { include_once $this->dirname.'/templates/conversation-list.php'; }
);

// add_submenu_page(
// 	'edit.php?post_type=messages-list', 
// 	'Supplier Conversations', 
// 	'Supplier Conversations', 
// 	'manage_options', 
// 	'supplier-conversation-settings',
// 	function() { include_once $this->dirname.'/templates/supplier_conversations.php'; }
// );

// ACF subpage
acf_add_options_sub_page(
    array(
        'page_title' => 'Message Settings',
        'menu_title' => 'Message Settings',
        'parent_slug' => 'edit.php?post_type=messages-list'
    )
);

