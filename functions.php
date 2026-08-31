<?php
/**
 * Theme functions and definitions
 *
 * @package Armodafinil_Australia_Direct
 */

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );
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
            echo 'â€”';
        }
    }
}, 10, 2);

require_once get_template_directory() . '/inc/ajax-reviews.php';
// Magic Link Login Logic
add_action( 'wp_ajax_nopriv_request_magic_link', 'armodafinil_request_magic_link' );
function armodafinil_request_magic_link() {
    check_ajax_referer( 'magic_link_nonce', 'security' );

    $email = sanitize_email( $_POST['email'] );
    if ( ! is_email( $email ) ) {
        wp_send_json_error( 'Invalid email address.' );
    }

    $user = get_user_by( 'email', $email );
    
    // If user doesn't exist, create one!
    if ( ! $user ) {
        $password = wp_generate_password( 12, false );
        $user_id = wp_create_user( $email, $password, $email );
        if ( is_wp_error( $user_id ) ) {
            wp_send_json_error( 'Could not create account.' );
        }
        $user = get_user_by( 'id', $user_id );
    }

    // Generate token
    $token = wp_generate_password( 32, false );
    update_user_meta( $user->ID, '_magic_link_token', wp_hash( $token ) );
    update_user_meta( $user->ID, '_magic_link_expiry', time() + HOUR_IN_SECONDS );

    // Send Email
    $login_url = add_query_arg( array(
        'magic_token' => $token,
        'email'       => rawurlencode( $email )
    ), wc_get_page_permalink( 'myaccount' ) );

    $subject = 'Your secure sign-in link';
    
    // Use WooCommerce mailer so it looks like the branded emails
    $mailer = WC()->mailer();
    
    // Build custom email content
    ob_start();
    ?>
    <div style="text-align: center; padding: 40px 0;">
        <h1 style="font-size: 24px; color: #09152b; margin-bottom: 10px;">Your secure sign-in link</h1>
        <p style="color: #64748b; font-size: 16px; margin-bottom: 30px;">
            You requested a magic link to sign in to your <strong>Armodafinil Australia</strong> account.<br>
            Click the button below to log in instantly. No password required.
        </p>
        <a href="<?php echo esc_url( $login_url ); ?>" style="display: inline-block; background-color: #0d9488; color: #ffffff; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 16px;">Log in to my account &rarr;</a>
        <p style="color: #94a3b8; font-size: 13px; margin-top: 30px;">
            This link expires in <strong>1 hour</strong> and can only be used once.
        </p>
    </div>
    <?php
    $content = ob_get_clean();
    $wrapped_content = $mailer->wrap_message( $subject, $content );
    
    $mailer->send( $email, $subject, $wrapped_content );

    wp_send_json_success( 'Magic link sent!' );
}

add_action( 'template_redirect', 'armodafinil_process_magic_link' );
function armodafinil_process_magic_link() {
    if ( isset( $_GET['magic_token'] ) && isset( $_GET['email'] ) && ! is_user_logged_in() ) {
        $email = sanitize_email( $_GET['email'] );
        $token = $_GET['magic_token'];
        
        $user = get_user_by( 'email', $email );
        if ( $user ) {
            $saved_token = get_user_meta( $user->ID, '_magic_link_token', true );
            $expiry      = get_user_meta( $user->ID, '_magic_link_expiry', true );
            
            if ( $saved_token === wp_hash( $token ) && $expiry > time() ) {
                // Success!
                delete_user_meta( $user->ID, '_magic_link_token' );
                delete_user_meta( $user->ID, '_magic_link_expiry' );
                
                wp_set_auth_cookie( $user->ID, true );
                wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
                exit;
            } else {
                wc_add_notice( 'This magic link has expired or is invalid. Please request a new one.', 'error' );
                wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
                exit;
            }
        }
    }
}

<?php
// Custom AJAX Product Search
add_action( 'wp_ajax_nopriv_armodafinil_search', 'armodafinil_ajax_search' );
add_action( 'wp_ajax_armodafinil_search', 'armodafinil_ajax_search' );
function armodafinil_ajax_search() {
    $query = isset( $_GET['q'] ) ? sanitize_text_field( $_GET['q'] ) : '';
    
    if ( empty( $query ) ) {
        wp_send_json_success( array() );
    }

    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        's'              => $query,
    );

    $products = new WP_Query( $args );
    $results = array();

    if ( $products->have_posts() ) {
        while ( $products->have_posts() ) {
            $products->the_post();
            $product = wc_get_product( get_the_ID() );
            $results[] = array(
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'price' => $product->get_price_html(),
                'image' => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) ?: wc_placeholder_img_src( 'thumbnail' ),
            );
        }
    }
    wp_reset_postdata();

    wp_send_json_success( $results );
}
