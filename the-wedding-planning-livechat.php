<?php
/**
 * Plugin Name: The Wedding Planning Livachat App
 * Plugin URI: https://nikkodelacruz.github.io
 * Description: Wordpress live chat with nodejs and socket.io integration
 * Version: 1.0.0
 * Author: Nikko Dela Cruz
 * Author URI: https://nikkodelacruz.github.io
 * Text Domain: the-wedding-planning-livechat
 *
 * @package TheWeddingPlanningLivechat
 */


if ( ! defined('ABSPATH') ) {
	die();  // Exit if accessed directly.
}

if ( !class_exists('TheWeddingPlanningLivechat') ) {	
	/**
	 * Main Class
	 */
	class TheWeddingPlanningLivechat
	{

		public $dirname;
		public $basename;
		// public $route;

		// define('DIRNAME',dirname(__FILE__);

	    public function __construct()
	    {
	    	$this->dirname = dirname(__FILE__); // starts from root
	    	$this->basename = plugin_basename(__FILE__); // starts from current

			// $this->$route = 'livechat/v1';
	    	
	    	// Call hooks
	    	$this->register();

	    }

	    private function register(){

	    	add_action( 'wp_enqueue_scripts', array($this,'enqueue_frontend') ); // frontend styles and scripts
	    	add_action( 'admin_enqueue_scripts', array($this,'enqueue_backend') ); // backend styles and scripts
	        add_action( 'admin_menu', array($this,'add_admin_pages') ); // create menus
	        add_filter( "plugin_action_links_$this->basename", array($this,'settings_link') );
	    	add_action( 'init', array($this,'create_post_type') ); // create post type
	        add_action( 'admin_init', array($this,'register_custom_fields') ); // register custom fields
	        add_action( 'init', array($this,'shortcodes') ); // shortcodes

	        // Ajax action
	        // add_action( 'admin_init', array($this,'ajax_requests') );
	         // add_action( 'wp_ajax_my_action', array($this,'my_action') );

	        // add_action( 'wp_ajax_nopriv_my_action', array($this,'my_action') );
			add_action( 'wp_print_scripts', array($this,'global_js_var') ); // declare global script

			add_action( 'rest_api_init', array($this,'register_api_routes') ); // initialize Rest API

	    }


	    // Add additional info in the plugin
	    public function settings_link( $links ){
	    	$view_link = '<a href="edit.php?post_type=transaction-history">Edit</a>';
	    	$settings_link = '<a href="edit.php?post_type=transaction-history&page=paypal-settings">Settings</a>';
	    	array_push( $links, $view_link, $settings_link );
	    	return $links;
	    }

	    public function add_admin_pages()
	    {
	    	include_once $this->dirname.'/includes/add_admin_pages.php';	
	    }

	    public function global_js_var(){
	    	include_once $this->dirname.'/includes/global_js.php';
	    }

	    public function shortcodes(){
	    	include_once $this->dirname.'/includes/shortcodes.php';
	    }

	    public function enqueue_frontend()
	    {
	    	
	    	wp_enqueue_style( 'frontend-style', plugins_url( '/assets/frontend/style.css',__FILE__ ) );
	    	// wp_enqueue_script( 'frontend-script', plugins_url( '/assets/frontend/script.js',__FILE__ ) );


	    	// Pass user data to parameter
    	  	$user_data = wp_get_current_user();
		    $uid = $user_data->ID;
		    $ufname = $user_data->first_name;
		    $ulname = $user_data->last_name;
			$role = $user_data->roles[0];

	        $profile = get_field('profile_picture', 'user_'.$uid);
	        $profile = ($profile) ? $profile : get_field('no_profile_placeholder','option') ;

		    $data = array(
	            'id' => $uid,
	            'role' => $role,
	            'profile' => $profile,
	            'name' => $ufname.' '.$ulname,
	            'send_message_api' => home_url('/wp-json/livechat/v1/send_message'),
	            'get_all_messages_api' => home_url('/wp-json/livechat/v1/get_all_messages')
	        );
			wp_enqueue_script('jquery');
	    	wp_enqueue_script( 'chat-js', plugins_url( '/assets/chat/chat.js',__FILE__ ) );
	    	wp_localize_script( 'chat-js', 'udata', $data ); //pass data to parameter

	    }

	    public function enqueue_backend()
	    {
	    	wp_enqueue_style( 'backend-style', plugins_url( '/assets/backend/styles.css',__FILE__ ) );
	    	wp_enqueue_script( 'backend-script', plugins_url( '/assets/backend/script.js',__FILE__ ) );

	    	// AJAX
	    	wp_enqueue_script( 'ajax-script', plugins_url( '/assets/ajax/ajax.js',__FILE__ ) );
	    	wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	    }

	    public function create_post_type(){
	    	include_once $this->dirname.'/includes/create_post_type.php';
	    	// CreatePostType::create_post_type(); //call static method w/o initialize
	    }

	   	public function register_custom_fields()
	   	{
	    	// include_once $this->dirname.'/includes/register_custom_fields.php';
	    	// RegisterCustomFelds::register_custom_fields();
	   	}

	   	private function ajax_requests()
	   	{
	   		// include_once $this->dirname.'/assets/ajax/ajax.php';
	   		// new AjaxRequests();
	   	}

	   	public function register_api_routes(){
			include_once $this->dirname.'/includes/register_api.php';
			// RegisterSocketAPI::register_api();
			$api = new RegisterSocketAPI();
			// $api->register_api();


	

	   	}

	    public function activate()
	    {
	    	// $this->create_post_type();
	    	flush_rewrite_rules();
	    }

	    public function deactivate()
	    {
	    	flush_rewrite_rules();
	    }

	    public function uninstall()
	    {

	    }
	
	}


	// Instantiate
	$theWeddingPlanningLivechat = new TheWeddingPlanningLivechat();
	// $theWeddingPlanningLivechat->register(); //call method inside class

	// Activate Plugin
	register_activation_hook( __FILE__, array($theWeddingPlanningLivechat,'activate') );

	// Deactivate Plugin
	register_deactivation_hook( __FILE__, array($theWeddingPlanningLivechat,'deactivate') );

	// Uninstall
	register_uninstall_hook( __FILE__, array($theWeddingPlanningLivechat,'uninstall') );

}



// Methods: 
// Public = accessed everywhere
// Private = acccessed within class itself class{} or extensions of that clas
// Protected = accessed within class itself but not on extensions 
// static = use method directly w/o initialize the class -> className::register(); 
// call static method = instead of $this, use array('classname','methodname'); -> methodname must be static too
// class anotherClass extends PaypalParallelPayment
// {
// 	function register_post_type
// 	{
// 		$this->create_post_type(); // can call protedted function but not private
// 	}
// }
// $anotherClass = new anotherClass();
// $anotherClass->register_post_type();




?>