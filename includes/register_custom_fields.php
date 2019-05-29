<?php 
/**
 * Register custom fields for paypal API
 * @package TheWeddingPlanningLivechat
 */

defined( 'ABSPATH' ) || exit;

// class RegisterCustomFelds
// {

// 	public static function register_custom_fields()
// 	{

//    		$option_group = 'paypal_option_group';
// 		$option_name = 'paypal_option_name';

//    		register_setting(
// 			$option_group, // Option Group 
// 			$option_name // Option Name
// 			,array('RegisterCustomFelds','sanitize_fields') // Sanitize
// 		);

// 		$page = $option_group;

// 		$settings_section = 'paypal_settings_section';

//    		add_settings_section(
// 			$settings_section, // ID
// 			'<h1>Paypal API Settings</h1>', // Title
// 			false, // function() { echo '<h1>Test</h1>'; } Callback
// 			$page // Page
// 		);

// 		add_settings_field(
// 			'adaptive_paypal_url', // ID
// 			'Adaptive Paypal URL', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section, // Section
// 			array( 'name' => 'adaptive_paypal_url', 'field'=>'url' )
// 		);

// 		add_settings_field(
// 			'paypal_url', // ID
// 			'Paypal URL', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section, // Section
// 			array('name' => 'paypal_url', 'field'=>'url')
// 		);

// 		add_settings_field(
// 			'api_user', // ID
// 			'API USER', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section, // Section
// 			array('name' => 'api_user', 'field'=>'text')
// 		);

// 		add_settings_field(
// 			'api_pass', // ID
// 			'API PASS', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section, // Section
// 			array('name' => 'api_pass', 'field'=>'text')
// 		);

// 		add_settings_field(
// 			'api_signature', // ID
// 			'API SIGNATURE', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section, // Section
// 			array('name' => 'api_signature', 'field'=>'text')
// 		);

// 		add_settings_field(
// 			'return_url', // ID
// 			'Return URL', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section, // Section
// 			array('name' => 'return_url', 'field'=>'select')
// 		);

// 		add_settings_field(
// 			'cancel_url', // ID
// 			'Cancel URL', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section, // Section
// 			array('name' => 'cancel_url', 'field'=>'select')
// 		);

// 		// Second section
// 		$settings_section2 = 'paypal_settings_section2';
//    		add_settings_section(
// 			$settings_section2, // ID
// 			'<h1>Payment Receivers</h1>', // Title
// 			function() { echo '<h3>Admin</h3>'; }, //Callback
// 			$page // Page
// 		);
// 		add_settings_field(
// 			'admin_receiver_email', // ID
// 			'Receiver Email', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section2, // Section
// 			array('name' => 'admin_receiver_email', 'field'=>'email')
// 		);
// 		add_settings_field(
// 			'admin_receiver_percentage', // ID
// 			'Receiver Percentage', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section2, // Section
// 			array('name' => 'admin_receiver_percentage', 'field'=>'number')
// 		);

// 		// Third section
// 		$settings_section3 = 'paypal_settings_section3';
// 		add_settings_section(
// 			$settings_section3, // ID
// 			'', // Title
// 			function() { echo '<h3>Supplier</h3>'; }, //Callback
// 			$page // Page
// 		);
// 		add_settings_field(
// 			'supplier_receiver_email', // ID
// 			'Receiver Email', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section3, // Section
// 			array('name' => 'supplier_receiver_email', 'field'=>'email')
// 		);
// 		add_settings_field(
// 			'supplier_receiver_percentage', // ID
// 			'Receiver Percentage', // Title
// 			array('RegisterCustomFelds','create_field'), // Callback
// 			$page, // Page
// 			$settings_section3, // Section
// 			array('name' => 'supplier_receiver_percentage', 'field'=>'number')
// 		);

// 	}

// 	/**
// 	 * Generate new custom fields
// 	 */
// 	public function create_field( $args )
// 	{
// 		$options = get_option('paypal_option_name');
// 		$name = $args['name'];
// 		$field = $args['field'];
// 		$value = $options[$name];
// 		if($field == 'select'){
// 			$pages = get_pages();
// 			echo '<select name="paypal_option_name['.$name.']" id="'.$name.'">';
// 			echo '<option>Select Page</option>';
// 			foreach ($pages as $page) {
// 				$selected = ($value == $page->ID) ? 'selected' : '' ;
// 				echo '<option value="'.$page->ID.'" '.$selected.'>';
// 				echo ($page->post_title) ? $page->post_title : 'No Title'; 
// 				echo '</option>';
// 			}
// 			echo '</select>';
// 		}else{
// 			echo '<input type="'.$field.'" name="paypal_option_name['.$name.']" id="'.$name.'" value="'.$value.'" />';
// 		}
// 	}

// 	// Sanitize every inputs
// 	public function sanitize_fields( $inputs )
// 	{
// 		$validated = array();
// 		foreach ($inputs as $key => $value) {
// 			$validated[$key] = sanitize_text_field($value);
// 		}
// 		return $validated;
// 	}

// }


