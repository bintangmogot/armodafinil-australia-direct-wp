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
add_action('acf/init', function() {
    if( function_exists('acf_add_local_field_group') ):
        acf_add_local_field_group(array(
            'key' => 'group_product_notices',
            'title' => 'Product Page Notices',
            'fields' => array(
                array(
                    'key' => 'field_important_usage_note',
                    'label' => 'Important Usage Note',
                    'name' => 'important_usage_note',
                    'type' => 'textarea',
                    'instructions' => 'Use {product_name} to insert the current product name dynamically.',
                    'default_value' => '{product_name} is a Schedule 4 (prescription-only) medicine in Australia. Effects, dosage, and possible side effects can differ from person to person. Taking this medicine without a doctor\'s advice may be harmful. This website does not encourage self-medication. For official Australian prescription-medicine guidance, see the <a href="https://www.tga.gov.au/" target="_blank" rel="noopener" class="text-brand-700 hover:underline">Therapeutic Goods Administration (TGA)</a>.',
                ),
                array(
                    'key' => 'field_medical_disclaimer_text',
                    'label' => 'Medical Disclaimer',
                    'name' => 'medical_disclaimer_text',
                    'type' => 'textarea',
                    'default_value' => 'This website is for informational purposes only and does not constitute medical advice. Always consult a qualified healthcare professional before starting, stopping, or changing any medication. <a href="/medical-disclaimer" class="font-semibold text-brand-800 hover:underline">Read our full medical disclaimer.</a>',
                ),
                array(
                    'key' => 'field_medically_reviewed_by',
                    'label' => 'Medically Reviewed By',
                    'name' => 'medically_reviewed_by',
                    'type' => 'text',
                    'default_value' => 'Dr. Ginni Mansberg',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-general-settings',
                    ),
                ),
            ),
        ));
    endif;
});
