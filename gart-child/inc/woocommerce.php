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

// Add our own clean wrapper
add_action( 'woocommerce_before_main_content', 'gart_child_woo_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'gart_child_woo_wrapper_end', 10 );

function gart_child_woo_wrapper_start() {
    echo '<div class="site-main"><div class="woocommerce-content">';
}

function gart_child_woo_wrapper_end() {
    echo '</div></div>';
}