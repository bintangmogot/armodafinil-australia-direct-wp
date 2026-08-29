<?php
/**
 * Theme functions and definitions
 *
 * @package Armodafinil_Australia_Direct
 */

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

function armodafinil_australia_scripts() {
	wp_enqueue_style( 'armodafinil-australia-style', get_stylesheet_uri(), array(), _S_VERSION );
}
add_action( 'wp_enqueue_scripts', 'armodafinil_australia_scripts' );

// Add theme support
function armodafinil_australia_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'armodafinil_australia_setup' );
require get_template_directory() . '/inc/acf-fields.php';  
 
require_once get_template_directory() . '/inc/cpt.php';


add_action('acf/init', function() {
    if( function_exists('acf_add_options_page') ) { 
        acf_add_options_page(array(
            'page_title' => 'Theme General Settings', 
            'menu_title' => 'Theme Settings', 
            'menu_slug'  => 'theme-general-settings', 
            'capability' => 'edit_posts', 
            'redirect'   => false
        )); 
    }
});


require_once get_template_directory() . '/inc/acf-options.php';


add_filter( 'loop_shop_per_page', function() { return 20; }, 20 );


// Hide default wishlist buttons
add_action('wp_head', function() {
    echo '<style>.yith-wcwl-add-to-wishlist, .tinv-wraper { display: none !important; }</style>';
});
