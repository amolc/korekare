<?php
/**
 * Checkout login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) return;

//$info_message  = apply_filters( 'woocommerce_checkout_login_message', __( 'Have Account?', 'woocommerce' ) );
//$info_message .= ' <a href="#" class="showlogin">' . __( 'Click here to login', 'woocommerce' ) . '</a>';
//wc_print_notice( $info_message, 'notice' );
?>

<?php
	woocommerce_login_form(
		array(
			'message'  => __( '<h3>Login</h3>', 'woocommerce' ),
			'redirect' => get_permalink( wc_get_page_id( 'checkout' ) ),
			'hidden'   => false
		)
	);
	
?>