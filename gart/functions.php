<?php
/**
 * Gart – Clean WooCommerce Parent Theme
 * Author: Cozma Calin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Theme setup
add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-list',
        'comment-form',
        'gallery',
        'caption',
        'style',
        'script'
    ) );

    // Register menu
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'gart' ),
    ) );
} );

// Enqueue main stylesheet
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'gart-style', get_stylesheet_uri(), array(), '1.0' );
} );