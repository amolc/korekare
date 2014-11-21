<?php
add_filter( 'gettext', 'theme_change_comment_field_names', 20, 3 );
/**
 * Change comment form default field names.
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 */
function theme_change_comment_field_names( $translated_text, $text, $domain ) {



        switch ( $translated_text ) {

            case 'WooCommerce' :

                $translated_text = 'Commerce Engine';
                break;

            case 'Email' :

                $translated_text = __( 'Email Address', 'theme_text_domain' );
                break;
        }


    return $translated_text;
}

add_filter( 'woocommerce_show_addons_page', 'woocommerce_show_addons_page_remove' );
function woocommerce_show_addons_page_remove(){
	return false;
}