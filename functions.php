<?php

add_action('acf/init', function() {
    if( function_exists('acf_add_options_page') ) {

        acf_add_options_page(array(
            'page_title' => 'Theme General Settings', 
            'menu_title' => 'Theme Settings', 
            'menu_slug'  => 'theme-general-settings', 
            'capability' => 'manage_options', 
            'redirect'   => false,
            'position'   => 3,
            'icon_url'   => 'dashicons-admin-generic'
        ));
    }
});



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
    // Enable WordPress Menus
    add_theme_support('menus');
    register_nav_menus(array(
        'primary' => __('Primary Navigation (Desktop)', 'armodafinil-australia-direct'),
        'mobile'  => __('Mobile Navigation', 'armodafinil-australia-direct'),
        'footer_1'  => __('Footer Column 1', 'armodafinil-australia-direct'),
        'footer_2'  => __('Footer Column 2', 'armodafinil-australia-direct'),
        'footer_3'  => __('Footer Column 3', 'armodafinil-australia-direct'),
    ));

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'editor-style.css' );
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'armodafinil_australia_setup' );

add_filter( 'loop_shop_per_page', function() { return 20; }, 20 );

require get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/cpt.php';
require_once get_template_directory() . '/inc/acf-options.php';
require_once get_template_directory() . '/inc/ajax-auth.php';
require_once get_template_directory() . '/inc/ajax-reviews.php';
require_once get_template_directory() . '/inc/ajax-search.php';
require_once get_template_directory() . '/inc/medical-reviewers.php';

add_filter('nav_menu_css_class', function($classes, $item, $args) {
    if(in_array($args->theme_location, ['footer_1', 'footer_2', 'footer_3'])) {
        // li classes for footer
        // No specific classes needed for li since space-y-2 is on ul
    }
    return $classes;
}, 10, 3);

add_filter('nav_menu_link_attributes', function($atts, $item, $args) {
    if(in_array($args->theme_location, ['footer_1', 'footer_2', 'footer_3'])) {
        $atts['class'] = 'hover:text-brand-300';
    }
    return $atts;
}, 10, 3);

add_action('wp_footer', function() {
?>
    <script>
    function toggleReadMore(e, btn) {
        e.preventDefault();
        e.stopPropagation();
        const text = btn.previousElementSibling;
        if (text.classList.contains('line-clamp-2')) {
            text.classList.remove('line-clamp-2');
            btn.innerHTML = 'Read less &gt;&gt;';
        } else {
            text.classList.add('line-clamp-2');
            btn.innerHTML = 'Read more &gt;&gt;';
        }
    }
    </script>
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

                // Removed inner toggle
            const text = btn.previousElementSibling;
            if (text.classList.contains('line-clamp-2')) {
                text.classList.remove('line-clamp-2');
                btn.innerHTML = 'Read less &gt;&gt;';
            } else {
                text.classList.add('line-clamp-2');
                btn.innerHTML = 'Read more &gt;&gt;';
            }
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

// Add Tailwind classes to dynamic menu
add_filter("nav_menu_css_class", function($classes, $item, $args) { 
    if($args->theme_location === "primary") { 
        $classes[] = "flex items-center"; 
    } elseif($args->theme_location === "mobile") {
        $classes[] = "border-b border-ink-100 last:border-0";
    }
    return $classes; 
}, 10, 3);

add_filter("nav_menu_link_attributes", function($atts, $item, $args) { 
    if($args->theme_location === "primary") { 
        $atts["class"] = "px-3 py-2 rounded-md text-sm font-medium transition-colors text-ink-700 hover:text-brand-700 hover:bg-brand-50/60"; 
    } elseif($args->theme_location === "mobile") { 
        $atts["class"] = "block w-full text-left px-6 py-4 text-base font-medium text-ink-900 hover:bg-brand-50 transition-colors"; 
    } 
    return $atts; 
}, 10, 3);


add_filter('nav_menu_css_class', function($classes, $item, $args) {
    if(in_array($args->theme_location, ['footer_1', 'footer_2', 'footer_3'])) {
        // li classes for footer
        // No specific classes needed for li since space-y-2 is on ul
    }
    return $classes;
}, 10, 3);

add_filter('nav_menu_link_attributes', function($atts, $item, $args) {
    if(in_array($args->theme_location, ['footer_1', 'footer_2', 'footer_3'])) {
        $atts['class'] = 'hover:text-brand-300';
    }
    return $atts;
}, 10, 3);

?>

<?php

/**
 * Sticky Add to Cart Bar for Single Products
 */
add_action( 'wp_footer', 'aad_sticky_add_to_cart_bar' );
function aad_sticky_add_to_cart_bar() {
    if ( ! is_product() ) return;
    global $product;
    if ( ! $product ) return;
    ?>
    <style>
        .aad-sticky-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            box-shadow: 0 -10px 40px rgba(0,0,0,0.08);
            z-index: 9999;
            transform: translateY(100%);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            padding-bottom: env(safe-area-inset-bottom);
        }
        .aad-sticky-bar-inner {
            max-width: 80rem;
            margin: 0 auto;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        @media (min-width: 640px) {
            .aad-sticky-bar-inner { padding: 16px 24px; }
        }
        @media (min-width: 1024px) {
            .aad-sticky-bar-inner { padding: 16px 32px; }
        }
        .aad-sticky-bar.is-visible {
            transform: translateY(0);
        }
                /* Mobile UX Fixes */
        @media (max-width: 767px) { .aad-sticky-bar-inner { padding-right: 80px !important; } }
        @media (max-width: 767px) {
            .aad-sticky-bar-left {
                display: none !important; /* Hide image and title on mobile to save space */
            }
            .aad-sticky-bar-right {
                width: 100% !important;
                justify-content: flex-start !important;
                gap: 12px !important;
                
            }
            .aad-sticky-price {
                font-size: 1.15rem !important; /* Smaller price on mobile to prevent wrapping */
                text-align: left !important;
                margin-right: auto;
            }
            .aad-sticky-btn {
                padding: 0 14px !important;
                height: 40px !important;
                font-size: 0.8rem !important;
            }
            .aad-sticky-btn svg {
                width: 16px !important;
                height: 16px !important;
            }
            .aad-sticky-btn span {
                display: none; /* Hide "Add to cart" text if needed, or keep it. Let's keep it but it might be tight. Actually let's keep it. */
            }
        }
        .aad-sticky-bar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 33%;
        }
        .aad-sticky-bar-img {
            width: 72px;
            height: 72px;
            min-width: 72px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            object-fit: cover;
        }
        .aad-sticky-bar-right {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            gap: 16px;
        }
        @media (min-width: 768px) {
            .aad-sticky-bar-right {
                justify-content: flex-end;
                width: 66%;
            }
        }
        .aad-sticky-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a4f48;
            text-align: right;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        @media (min-width: 640px) {
            .aad-sticky-price { font-size: 1.75rem; }
        }
        .aad-sticky-price del {
            color: #94a3b8;
            font-size: 0.65em;
            font-weight: 500;
            text-decoration: line-through;
        }
        .aad-sticky-price ins {
            text-decoration: none;
            color: #1a4f48;
        }
        .aad-sticky-btn {
            height: 44px;
            padding: 0 24px;
            border-radius: 12px;
            background-color: #0f766e;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
            white-space: nowrap;
        }
        @media (min-width: 640px) {
            .aad-sticky-btn {
                height: 48px;
                padding: 0 32px;
                font-size: 1rem;
            }
        }
        .aad-sticky-btn:hover {
            background-color: #115e59;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(15, 118, 110, 0.3);
        }
        .aad-sticky-btn:active {
            transform: scale(0.96);
        }
        
        body.has-sticky-bar-visible .whatsapp-float {
            transform: translateY(-70px) !important;
        }
    </style>

    <div id="sticky-add-to-cart" class="aad-sticky-bar">
        <div class="aad-sticky-bar-inner">
            <div class="aad-sticky-bar-left">
            <?php echo $product->get_image('thumbnail', ['class' => 'aad-sticky-bar-img']); ?>
            <div style="min-width:0;">
                <div style="font-family:serif; font-weight:700; color:#0f172a; line-height:1.2; font-size:15px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo esc_html($product->get_name()); ?></div>
                <div style="font-size:11px; color:#64748b; margin-top:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo esc_html(wp_strip_all_tags($product->get_short_description())); ?></div>
            </div>
        </div>
        
        <div class="aad-sticky-bar-right">
            <div class="aad-sticky-price sticky-price-target">
                <?php echo $product->get_price_html(); ?>
            </div>
            <button id="sticky-add-to-cart-btn" class="aad-sticky-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                <span>Add to Cart</span>
            </button>
        </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stickyBar = document.getElementById('sticky-add-to-cart');
        const stickyBtn = document.getElementById('sticky-add-to-cart-btn');
        // Find the main add to cart button. Using the correct selector based on the theme HTML
        const mainAddToCartBtn = document.querySelector('button[name="add-to-cart"]');

        if (!stickyBar || !mainAddToCartBtn) {
            console.log('Sticky bar or main add to cart button not found', {stickyBar, mainAddToCartBtn});
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    stickyBar.classList.remove('is-visible');
                    document.body.classList.remove('has-sticky-bar-visible');
                } else {
                    if (entry.boundingClientRect.top < 0) {
                        stickyBar.classList.add('is-visible');
                        document.body.classList.add('has-sticky-bar-visible');
                    }
                }
            });
        }, { threshold: 0 });

        observer.observe(mainAddToCartBtn);

        stickyBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const mainForm = mainAddToCartBtn.closest('form.cart');
            
            if (mainAddToCartBtn.classList.contains('disabled')) {
                if(mainForm) mainForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Note: table.variations might not exist if they use custom variant buttons
                const variantButtons = document.getElementById('variant-buttons');
                if(variantButtons) {
                    variantButtons.style.transition = 'transform 0.1s';
                    variantButtons.style.transform = 'scale(1.02)';
                    setTimeout(() => { variantButtons.style.transform = 'scale(1)'; }, 150);
                }
            } else {
                mainAddToCartBtn.click();
            }
        });
        
        // Listen to WooCommerce variation changes to update the sticky bar price dynamically
        if (typeof jQuery !== 'undefined') {
            jQuery('.variations_form').on('show_variation', function(event, variation) {
                if (variation.price_html) {
                    jQuery('.sticky-price-target').html(variation.price_html);
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Polyfill for _.pluck and _.contains which were removed in Underscore.js 1.8+
 * but are still used by WordPress core's wp-backbone and media-views scripts.
 * Needed when a plugin loads a newer Underscore.js that overwrites WP's bundled version.
 */



// Force default WooCommerce variable price range format (fixes From overrides from plugins)
add_filter( 'woocommerce_variable_price_html', 'aad_force_default_variable_price_range', 9999, 2 );
function aad_force_default_variable_price_range( $price, $product ) {
    $min_price = $product->get_variation_price( 'min', true );
    $max_price = $product->get_variation_price( 'max', true );
    if ( $min_price !== $max_price ) {
        $price = wc_format_price_range( $min_price, $max_price );
    } else {
        $price = wc_price( $min_price );
    }
    return $price;
}

// Add 'A' before '$' to make it clear it's AUD
add_filter('woocommerce_currency_symbol', 'aad_change_currency_symbol', 10, 2);
function aad_change_currency_symbol( $currency_symbol, $currency ) {
    if ( $currency === 'AUD' ) {
        return 'A$';
    }
    return $currency_symbol;
}
// Fix ACF WYSIWYG bookmark bug on backend


// Clean them out just in case before saving to DB
add_filter('acf/update_value/type=wysiwyg', 'aad_clean_acf_wysiwyg_bookmarks', 10, 3);
// add_filter('content_save_pre', 'aad_clean_acf_wysiwyg_bookmarks', 10, 1);
function aad_clean_acf_wysiwyg_bookmarks($value, $post_id = null, $field = null) {
    if (!empty($value) && is_string($value)) {
        // Selection bookmarks are TinyMCE's temporary cursor markers. They must
        // never be stored in ACF content; accept both quote styles because pasted
        // HTML and older editor versions may use either one.
        $value = preg_replace('/<span\b[^>]*\bdata-mce-type\s*=\s*(["\'])bookmark\1[^>]*>(?:.*?<\/span>|)/is', '', $value);
    }
    return $value;
}
// Robust Underscore.js Polyfill for older plugins causing Media Uploader / Editor crashes
add_action('admin_enqueue_scripts', function() {
    $script = "
        if (typeof _ !== 'undefined') {
            if (typeof _.pluck !== 'function') {
                _.pluck = function(obj, key) { return _.map(obj, _.property(key)); };
            }
            if (typeof _.contains !== 'function') {
                _.contains = _.includes || function(obj, item) { return _.indexOf(obj, item) >= 0; };
            }
            if (typeof _.object !== 'function') {
                _.object = function(keys, vals) {
                    var result = {};
                    for (var i = 0, l = keys.length; i < l; i++) {
                        if (vals) { result[keys[i]] = vals[i]; } else { result[keys[i][0]] = keys[i][1]; }
                    }
                    return result;
                };
            }
        }
    ";
    wp_add_inline_script('underscore', $script, 'after');
});
// Register ACF fields for Product Medical Disclaimers
add_action('acf/init', 'aad_register_product_disclaimer_fields');
function aad_register_product_disclaimer_fields() {
    if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_product_disclaimers',
        'title' => 'Product Medical Disclaimers',
        'fields' => array(
            array(
                'key' => 'field_usage_title',
                'label' => 'Important Usage Note Title',
                'name' => 'usage_note_title',
                'type' => 'text',
                'default_value' => 'Important Usage Note',
            ),
            array(
                'key' => 'field_usage_text',
                'label' => 'Important Usage Note Text',
                'name' => 'usage_note_text',
                'type' => 'textarea',
                'instructions' => 'Use {product_name} to dynamically insert the current product title.',
                'default_value' => '{product_name} is a Schedule 4 (prescription-only) medicine in Australia. Effects, dosage, and possible side effects can differ from person to person. Taking this medicine without a doctor\'s advice may be harmful. This website does not encourage self-medication. For official Australian prescription-medicine guidance, see the <a href="https://www.tga.gov.au/" target="_blank" rel="noopener">Therapeutic Goods Administration (TGA)</a>.',
                'new_lines' => 'br',
            ),
            array(
                'key' => 'field_info_text',
                'label' => 'Informational Warning Text',
                'name' => 'informational_warning_text',
                'type' => 'textarea',
                'default_value' => 'This website is for informational purposes only and does not constitute medical advice. Always consult a qualified healthcare professional before starting, stopping, or changing any medication. <a href="/medical-disclaimer/">Read our full medical disclaimer</a>.',
                'new_lines' => 'br',
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
}






// Hide default wishlist buttons on single product pages because we use a custom inline button
add_action('wp_head', function() {
    if (is_product()) {
        echo '<style>.single-product .yith-wcwl-add-to-wishlist, .single-product .tinv-wraper, .single-product .tinv-wishlist { display: none !important; }</style>';
    }
});


// Safe Underscore Polyfill for Media Uploader
add_action('admin_enqueue_scripts', function() {
    $script = "
        if (typeof window._ !== 'undefined') {
            window._.pluck = window._.pluck || function(obj, key) {
                return window._.map(obj, function(val) { return val[key]; });
            };
            window._.contains = window._.contains || window._.includes || function(obj, item) {
                return window._.indexOf(obj, item) >= 0;
            };
        }
    ";
    wp_add_inline_script('underscore', $script, 'after');
});



// Fix white text in ACF WYSIWYG editors by injecting inline body styles
add_filter('tiny_mce_before_init', 'aad_fix_tinymce_text_color');
function aad_fix_tinymce_text_color($init) {
    $styles = 'body { color: #334155 !important; background: #fff !important; font-size: 14px; line-height: 1.6; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; padding: 10px !important; }';
    if (isset($init['content_style'])) {
        $init['content_style'] .= ' ' . $styles;
    } else {
        $init['content_style'] = $styles;
    }
    return $init;
}

/**
 * Keep the native editor stable while this site has Advanced Editor Tools 5.x
 * installed.
 *
 * Version 5.9.2 ships TinyMCE 4-era plugins (including its table and code
 * extensions). WordPress 7.1 loads a newer TinyMCE API, so those extensions
 * throw a JavaScript error as soon as an editor switches to Visual mode. ACF
 * WYSIWYG fields and WooCommerce's product description both use that same
 * editor instance, which is why they fail together.
 *
 * This is deliberately conditional: once Advanced Editor Tools is upgraded to
 * a compatible 6.x release, its integration is left alone. Until then,
 * WordPress's own maintained editor handles rich text, pasted HTML, lists,
 * links, and tables without the incompatible add-ons.
 */
function aad_disable_legacy_advanced_editor_tools() {
    if ( ! class_exists( 'Advanced_Editor_Tools' ) ) {
        return;
    }

    $plugin_file = WP_PLUGIN_DIR . '/tinymce-advanced/tinymce-advanced.php';
    $plugin_data = get_file_data( $plugin_file, array( 'Version' => 'Version' ) );

    if ( empty( $plugin_data['Version'] ) || ! version_compare( $plugin_data['Version'], '6.0.0', '<' ) ) {
        return;
    }

    global $wp_filter;

    foreach ( array( 'wp_editor_settings', 'mce_buttons', 'mce_buttons_2', 'mce_buttons_3', 'mce_buttons_4', 'tiny_mce_before_init', 'mce_external_plugins', 'tiny_mce_plugins' ) as $hook_name ) {
        if ( empty( $wp_filter[ $hook_name ] ) || empty( $wp_filter[ $hook_name ]->callbacks ) ) {
            continue;
        }

        foreach ( $wp_filter[ $hook_name ]->callbacks as $priority => $callbacks ) {
            foreach ( $callbacks as $callback ) {
                $function = $callback['function'];

                if ( is_array( $function ) && isset( $function[0] ) && $function[0] instanceof Advanced_Editor_Tools ) {
                    remove_filter( $hook_name, $function, $priority );
                }
            }
        }
    }
}
add_action( 'admin_init', 'aad_disable_legacy_advanced_editor_tools', 1 );




