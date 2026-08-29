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
add_action('wp_footer', function() {
    if ( ! is_shop() && ! is_product_category() && ! is_product_tag() && ! is_product() ) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const syncLoopWishlist = () => {
            document.querySelectorAll('.loop-wishlist-btn').forEach(btn => {
                const pid = btn.dataset.productId;
                const container = document.querySelector( + ".loop-wishlist-plugin-container[data-product-id="$" + "{pid}"]" + );
                if(!container) return;
                
                const yithBtn = container.querySelector('.add_to_wishlist');
                const tiBtn = container.querySelector('.tinvwl_add_to_wishlist_button');
                
                let isAdded = false;
                if (container.querySelector('.yith-wcwl-wishlistaddedbrowse.show, .yith-wcwl-wishlistexistsbrowse.show') || (yithBtn && yithBtn.classList.contains('added'))) {
                    isAdded = true;
                }
                if (tiBtn && (tiBtn.classList.contains('tinvwl-product-in-list') || tiBtn.classList.contains('in-wishlist'))) {
                    isAdded = true;
                }
                
                if (isAdded) {
                    btn.classList.add('text-brand-600');
                    btn.classList.remove('text-ink-400');
                    btn.querySelector('svg').classList.add('fill-brand-600');
                } else {
                    btn.classList.remove('text-brand-600');
                    btn.classList.add('text-ink-400');
                    btn.querySelector('svg').classList.remove('fill-brand-600');
                }
            });
        };

        syncLoopWishlist();
        setInterval(syncLoopWishlist, 500);

        document.querySelectorAll('.loop-wishlist-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const pid = btn.dataset.productId;
                const container = document.querySelector( + ".loop-wishlist-plugin-container[data-product-id="$" + "{pid}"]" + );
                if(!container) return;
                
                const yithBtn = container.querySelector('.add_to_wishlist');
                const tiBtn = container.querySelector('.tinvwl_add_to_wishlist_button');
                
                if (yithBtn) {
                    yithBtn.click();
                } else if (tiBtn) {
                    tiBtn.click();
                } else {
                    alert('Wishlist plugin is not active.');
                }
            });
        });
    });
    </script>
    <?php
});
// Register Review CPT
add_action('init', function() {
    register_post_type('review', array(
        'labels'             => array(
            'name'                  => 'Reviews',
            'singular_name'         => 'Review',
            'menu_name'             => 'Reviews',
            'add_new'               => 'Add New Review',
            'edit_item'             => 'Edit Review',
            'all_items'             => 'All Reviews',
            'search_items'          => 'Search Reviews',
            'not_found'             => 'No reviews found.',
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'capability_type'    => 'post',
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-star-filled',
        'supports'           => array('title', 'editor'),
    ));
});

// ACF Fields for Review
add_action('acf/init', function() {
    if( function_exists('acf_add_local_field_group') ):
        acf_add_local_field_group(array(
            'key' => 'group_review_fields',
            'title' => 'Review Details',
            'fields' => array(
                array(
                    'key' => 'field_review_rating',
                    'label' => 'Rating',
                    'name' => 'rating',
                    'type' => 'number',
                    'min' => 1,
                    'max' => 5,
                    'default_value' => 5,
                ),
                array(
                    'key' => 'field_review_name',
                    'label' => 'Reviewer Name',
                    'name' => 'name',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_review_meta',
                    'label' => 'Reviewer Meta (Job/Location)',
                    'name' => 'reviewer_meta',
                    'type' => 'text',
                    'default_value' => 'Verified Buyer',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'review',
                    ),
                ),
            ),
            'position' => 'normal',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_review_linked_product',
            'title' => 'Linked Product',
            'fields' => array(
                array(
                    'key' => 'field_review_linked_product',
                    'label' => 'Linked Product',
                    'name' => 'linked_product',
                    'type' => 'post_object',
                    'post_type' => array('product'),
                    'return_format' => 'id',
                    'ui' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'review',
                    ),
                ),
            ),
            'position' => 'side',
        ));
    endif;
});

// Admin Columns for Reviews
add_filter('manage_review_posts_columns', function($columns) {
    $new_columns = array();
    foreach($columns as $key => $title) {
        if ($key == 'date') {
            $new_columns['linked_product'] = 'Linked Product';
        }
        $new_columns[$key] = $title;
    }
    return $new_columns;
});

add_action('manage_review_posts_custom_column', function($column, $post_id) {
    if ($column === 'linked_product') {
        $product_id = get_field('linked_product', $post_id);
        if ($product_id) {
            echo '<a href="' . get_edit_post_link($product_id) . '">' . get_the_title($product_id) . '</a>';
        } else {
            echo '—';
        }
    }
}, 10, 2);

require_once get_template_directory() . '/inc/ajax-reviews.php';
