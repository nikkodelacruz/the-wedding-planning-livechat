<?php 
 /**
 * Add admin pages and subpages in the backend
 * @package SocketLiveChat
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
// add_submenu_page(
// 	'conversations-page', 
// 	'Message Settings', 
// 	'Settings', 
// 	'manage_options', 
// 	'conversation-settings',
// 	function() { include_once $this->dirname.'/templates/conversation_settings.php'; }
// );

// ACF subpage
acf_add_options_sub_page(
    array(
        'page_title' => 'Message Settings',
        'menu_title' => 'Message Settings',
        'parent_slug' => 'edit.php?post_type=messages-list'
    )
);

