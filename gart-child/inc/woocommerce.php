<?php
/**
 * WooCommerce overrides – Gart Child
 * Author: Cozma Calin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Remove default WooCommerce wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Remove default WooCommerce breadcrumb (since it is rendered in the banner manually)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// Render ACF Page Builder sections on the Shop Page
add_action( 'woocommerce_before_main_content', 'gart_child_woo_page_builder', 5 );
function gart_child_woo_page_builder() {
    if ( is_shop() ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id && have_rows( 'page_builder', $shop_page_id ) ) {
            while ( have_rows( 'page_builder', $shop_page_id ) ) {
                the_row();
                $layout = get_row_layout();
                if ( $layout ) {
                    get_template_part( 'sections/' . $layout ); 
                }
            }
        }
    }
}