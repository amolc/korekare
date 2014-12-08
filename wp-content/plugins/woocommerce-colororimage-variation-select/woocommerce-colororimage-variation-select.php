<?php
/*
  Plugin Name: Color or Image Variation Select
  Plugin URI: http://phppoet.com
  Description: Convert variable select box into image ,color or text
  Version: 1.1.5
  Author: Parbat Patel
  Author URI: http://phppoet.com
  Requires at least: 3.3
  Tested up to: 4.0
  

*/

     if( !defined( 'wcva_PLUGIN_URL' ) )
          define( 'wcva_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	/*
	 * localization
	 */
    load_plugin_textdomain( 'wcva', false, basename( dirname(__FILE__) ).'/languages' );

 /*
  * include required files to checke weather woocommerce is active or not
  * thanks to @respectyoda implemented after http://codecanyon.net/item/woocommerce-dynamic-discounts/6533113/comments?#comment_6541171
  */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	
 /*
  * check weather woocommerce is active or not
  */

 
 
          require 'classes/class_create_variations_metabox.php';
		  require 'classes/class_override_woocommerce_variable_tamplate.php';
		  require 'classes/class_wcva_register_scripts_styles.php';
		  require 'classes/class_attribute_global_values.php';
		  require 'includes/wcva_common_functions.php';
		  require 'includes/wcva_swatch_form_fields.php';
		  
 
 	 
    /*
	 * Gets absolute path for plugin
	 */
    function wcva_plugin_path() {
  
       return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }
    
	/*
	 * Get woocommerce version 
	 */
	function wcva_get_woo_version_number() {
       
	if ( ! function_exists( 'get_plugins' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
       
	$plugin_folder = get_plugins( '/' . 'woocommerce' );
	$plugin_file = 'woocommerce.php';
	
	
	if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
		return $plugin_folder[$plugin_file]['Version'];

	} else {
	
		return NULL;
	}
    }




?>