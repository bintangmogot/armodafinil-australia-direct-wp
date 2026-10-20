<?php
/**
 * Custom Navigation Walkers for Armodafinil Australia Direct
 * Provides elegant botanical mega-dropdown for desktop and clean mobile drawer submenus.
 * Fully dynamic: Admin can customize titles, perks, badges, and menu items via WP Admin & ACF.
 *
 * @package Armodafinil_Australia_Direct
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Resolve product metadata for rich navigation micro-cards dynamically.
 *
 * @param WP_Post|object $item Nav menu item object
 * @return array
 */
function armodafinil_get_product_menu_meta($item) {
    $title  = !empty($item->title) ? $item->title : '';
    $url    = !empty($item->url) ? $item->url : '';
    $obj_id = !empty($item->object_id) ? (int)$item->object_id : 0;

    $product_id = 0;
    if ($obj_id && get_post_type($obj_id) === 'product') {
        $product_id = $obj_id;
    } elseif (!empty($url)) {
        $parsed_id = url_to_postid($url);
        if ($parsed_id && get_post_type($parsed_id) === 'product') {
            $product_id = $parsed_id;
        }
    }

    // If still not identified, try title match
    if (!$product_id && !empty($title)) {
        $found = get_page_by_title($title, OBJECT, 'product');
        if ($found) {
            $product_id = $found->ID;
        }
    }

    $product = $product_id && function_exists('wc_get_product') ? wc_get_product($product_id) : null;

    // Image resolution
    $img_url = '';
    if ($product_id) {
        $img_url = get_the_post_thumbnail_url($product_id, 'woocommerce_thumbnail') ?: get_the_post_thumbnail_url($product_id, 'thumbnail');
    }

    // Price resolution
    $price_html = '';
    if ($product) {
        if ($product->is_type('variable')) {
            $min_price = $product->get_variation_price('min');
            $price_html = $min_price ? 'From ' . wc_price($min_price) : $product->get_price_html();
        } else {
            $price = $product->get_price();
            $price_html = $price ? wc_price($price) : $product->get_price_html();
        }
    } else {
        // Dynamic fallback price from title
        $lower = strtolower($title);
        if (strpos($lower, 'waklert 150') !== false || strpos($lower, 'modalert 200') !== false) {
            $price_html = 'From $150';
        } elseif (strpos($lower, '50') !== false || strpos($lower, '100') !== false) {
            $price_html = 'From $95';
        } else {
            $price_html = 'In Stock';
        }
    }

    // Category / Brand subtitle
    $brand = '';
    if ($product_id) {
        $terms = get_the_terms($product_id, 'product_cat');
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $t) {
                if (strtolower($t->name) !== 'uncategorized') {
                    $brand = $t->name;
                    break;
                }
            }
        }
    }
    if (empty($brand)) {
        $lower = strtolower($title);
        if (strpos($lower, 'sun pharma') !== false || strpos($lower, 'modalert') !== false || strpos($lower, 'waklert') !== false) {
            $brand = 'Sun Pharma • Genuine';
        } elseif (strpos($lower, 'hab') !== false || strpos($lower, 'artvigil') !== false || strpos($lower, 'modvigil') !== false) {
            $brand = 'HAB Pharma • Genuine';
        } elseif (strpos($lower, 'centurion') !== false || strpos($lower, 'modawake') !== false) {
            $brand = 'Centurion Labs';
        } else {
            $brand = 'Pharmaceutical Grade';
        }
    }

    // Best seller status - 100% dynamic!
    $is_best_seller = false;
    $badge_label    = 'Best Seller';

    // 1. Check if menu item has CSS class 'best-seller' in Appearance > Menus
    $classes = !empty($item->classes) ? (array) $item->classes : array();
    if (in_array('best-seller', $classes) || in_array('is-best-seller', $classes)) {
        $is_best_seller = true;
    }

    // 2. Check if product is chosen in Theme Settings > Dropdown Best Seller Products
    if (!$is_best_seller && $product_id) {
        $theme_best_sellers = get_field('nav_best_seller_products', 'option');
        if (!empty($theme_best_sellers)) {
            $selected_ids = array_map(function($p) {
                return is_object($p) ? (int)$p->ID : (int)$p;
            }, (array) $theme_best_sellers);

            if (in_array((int)$product_id, $selected_ids, true)) {
                $is_best_seller = true;
            }
        }
    }

    // 3. Check if marked on the individual product edit screen (ACF 'is_best_seller')
    if (!$is_best_seller && $product_id) {
        if (get_field('is_best_seller', $product_id)) {
            $is_best_seller = true;
        }
    }

    // 4. Check WooCommerce native Featured product status (Star in Products list)
    if (!$is_best_seller && $product && method_exists($product, 'is_featured') && $product->is_featured()) {
        $is_best_seller = true;
    }

    // Dynamic custom badge text if admin customized it
    if ($product_id) {
        $custom_text = get_field('custom_badge_text', $product_id);
        if (!empty($custom_text)) {
            $badge_label = $custom_text;
        }
    }

    $shop_title = '';
    if ($product_id) {
        $shop_title = get_field('shop_page_title', $product_id);
    }

    return array(
        'product_id'     => $product_id,
        'img_url'        => $img_url,
        'price_html'     => $price_html,
        'brand'          => $brand,
        'is_best_seller' => $is_best_seller,
        'badge_label'    => $badge_label,
        'shop_title'     => $shop_title,
    );
}

/**
 * Desktop Navigation Walker for Armodafinil Australia Direct
 */
class Armodafinil_Desktop_Nav_Walker extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            // Dynamic settings from ACF options with clean botanical defaults
            $title = get_field('nav_dropdown_title', 'option') ?: 'Genuine Armodafinil Catalogue';
            $badge = get_field('nav_dropdown_badge', 'option') ?: 'AU Express 7-10 Days';

            $output .= '<div class="sub-menu-dropdown-wrapper absolute top-full left-0 right-auto pt-2 w-[580px] max-w-[92vw] opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0 transition-all duration-200 z-50 pointer-events-none group-hover:pointer-events-auto filter drop-shadow-xl">';
            $output .= '<div class="rounded-2xl border border-ink-200/90 bg-white shadow-2xl overflow-hidden">';

            // Dropdown Header Strip: Botanical Deep Teal
            $output .= '<div class="bg-gradient-to-r from-brand-900 via-brand-800 to-brand-700 px-4 py-2.5 flex items-center justify-between border-b border-brand-700/40 text-white">';
            $output .= '<div class="flex items-center gap-2">';
            $output .= '<span class="flex h-5 w-5 items-center justify-center rounded-md bg-white/15 text-brand-100 text-xs font-bold leading-none">★</span>';
            $output .= '<span class="text-xs font-bold uppercase tracking-wider text-white">' . esc_html($title) . '</span>';
            $output .= '</div>';
            if (!empty($badge)) {
                $output .= '<span class="text-[11px] font-semibold text-brand-100 bg-white/10 px-2.5 py-0.5 rounded-full border border-white/20">' . esc_html($badge) . '</span>';
            }
            $output .= '</div>';

            // 2-Column Product Grid
            $output .= '<ul class="sub-menu grid grid-cols-2 gap-2.5 p-3.5 bg-ink-50/50">';
        } else {
            $output .= '<ul class="sub-menu pl-4 space-y-1.5">';
        }
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '</ul>';

            // Dropdown Footer Strip
            $perk       = get_field('nav_dropdown_footer_perk', 'option') ?: 'Free Express Delivery on Orders Over $299';
            $shop_label = get_field('nav_dropdown_shop_label', 'option') ?: 'Explore All Products';
            $shop_url   = get_field('nav_dropdown_shop_url', 'option');
            if (empty($shop_url)) {
                $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
                if (empty($shop_url)) {
                    $shop_url = home_url('/shop/');
                }
            }

            $output .= '<div class="bg-white px-4 py-3 border-t border-ink-200 flex items-center justify-between text-xs">';
            $output .= '<div class="flex items-center gap-1.5 font-semibold text-ink-700">';
            $output .= '<svg class="w-4 h-4 text-brand-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 13l4 4L19 7"/></svg>';
            $output .= '<span>' . esc_html($perk) . '</span>';
            $output .= '</div>';
            $output .= '<a href="' . esc_url($shop_url) . '" class="inline-flex items-center gap-1.5 font-bold text-brand-700 hover:text-brand-900 bg-brand-50 hover:bg-brand-100/70 px-3 py-1.5 rounded-full border border-brand-200/90 shadow-2xs transition-all hover:scale-105">';
            $output .= '<span>' . esc_html($shop_label) . '</span>';
            $output .= '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>';
            $output .= '</a>';
            $output .= '</div>';

            $output .= '</div></div>';
        } else {
            $output .= '</ul>';
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        $url   = !empty($item->url) ? esc_url($item->url) : '#';
        $title = esc_html($item->title);

        $is_shop_link = (strpos($url, '/shop') !== false);
        $is_shop_active = $is_shop_link && (function_exists('is_shop') && is_shop() || function_exists('is_product') && is_product());

        $is_active = in_array('current-menu-item', $classes)
                  || in_array('current-menu-ancestor', $classes)
                  || in_array('current-page-ancestor', $classes)
                  || !empty($item->current)
                  || $is_shop_active;

        if ($depth === 0) {
            $li_classes = 'list-none relative group ' . implode(' ', $classes);
            $output .= '<li class="' . esc_attr($li_classes) . '">';

            if ($is_active) {
                // Active link style
                $link_class = 'inline-flex items-center gap-1.5 px-3.5 py-1.5 text-[14.5px] xl:text-[15.5px] font-semibold rounded-full bg-brand-50 text-brand-800 border border-brand-200/90 shadow-2xs transition-all';
                $chev_color = 'text-brand-700';
            } else {
                // Inactive link style
                $link_class = 'inline-flex items-center gap-1.5 px-3.5 py-1.5 text-[14.5px] xl:text-[15.5px] font-medium rounded-full text-ink-700 hover:text-brand-800 hover:bg-brand-50/60 transition-all';
                $chev_color = 'text-ink-400 group-hover:text-brand-700';
            }

            $chevron = '';
            if ($has_children) {
                $chevron = '<svg class="w-3.5 h-3.5 ' . $chev_color . ' transition-transform duration-200 group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>';
            }

            $output .= '<a href="' . $url . '" class="' . $link_class . '">';
            $output .= '<span>' . $title . '</span>' . $chevron;
            $output .= '</a>';
        } else {
            // Submenu Item (Product Micro-Card inside 2-column dropdown)
            $meta = armodafinil_get_product_menu_meta($item);

            $output .= '<li class="list-none">';
            $output .= '<a href="' . $url . '" class="group/pcard flex items-center gap-3 p-2.5 rounded-xl border border-ink-200/80 hover:border-brand-600 bg-white hover:bg-brand-50/40 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xs">';

            // Image box with clean zoom hover
            $output .= '<div class="w-12 h-12 rounded-xl bg-white border border-ink-200/80 p-1 flex items-center justify-center shrink-0 group-hover/pcard:scale-105 group-hover/pcard:border-brand-600 transition-all overflow-hidden">';
            if (!empty($meta['img_url'])) {
                $output .= '<img src="' . esc_url($meta['img_url']) . '" alt="' . esc_attr($title) . '" class="w-full h-full object-contain transition-transform duration-300 group-hover/pcard:scale-110" loading="lazy" />';
            } else {
                // Botanical clean capsule SVG icon
                $output .= '<svg class="w-6 h-6 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">';
                $output .= '<rect x="3" y="7" width="18" height="10" rx="5" class="fill-brand-50 stroke-brand-600"/>';
                $output .= '<line x1="12" y1="7" x2="12" y2="17" class="stroke-brand-400" stroke-dasharray="2 2"/>';
                $output .= '</svg>';
            }
            $output .= '</div>';

            $display_card_title = !empty($meta['shop_title']) ? $meta['shop_title'] : $title;

            // Text Info
            $output .= '<div class="min-w-0 flex-1">';
            $output .= '<div class="flex items-center justify-between gap-1">';
            $output .= '<h4 class="text-[13px] font-bold text-ink-900 truncate group-hover/pcard:text-brand-800">' . esc_html($display_card_title) . '</h4>';
            if (!empty($meta['is_best_seller'])) {
                $output .= '<span class="inline-flex items-center px-1.5 py-0.5 rounded-full bg-amber-50 text-amber-900 border border-amber-200 text-[10px] font-semibold shrink-0">' . esc_html($meta['badge_label']) . '</span>';
            }
            $output .= '</div>';

            if (!empty($meta['brand'])) {
                $output .= '<p class="text-[11px] text-ink-500 font-medium truncate">' . esc_html($meta['brand']) . '</p>';
            }

            $output .= '<div class="mt-1 flex items-center justify-between">';
            if (!empty($meta['price_html'])) {
                $output .= '<span class="text-[10.5px] font-bold text-brand-800 bg-brand-50 px-2 py-0.5 rounded border border-brand-200">' . wp_kses_post($meta['price_html']) . '</span>';
            } else {
                $output .= '<span></span>';
            }
            $output .= '<span class="text-[11px] font-bold text-ink-400 group-hover/pcard:text-brand-700 group-hover/pcard:translate-x-0.5 transition-all">→</span>';
            $output .= '</div>';
            $output .= '</div>';

            $output .= '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}

/**
 * Mobile Navigation Walker for Armodafinil Australia Direct
 */
class Armodafinil_Mobile_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="sub-menu pl-2 pr-1 pt-2 pb-2.5 space-y-2">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        $url   = !empty($item->url) ? esc_url($item->url) : '#';
        $title = esc_html($item->title);

        if ($depth === 0) {
            $output .= '<li class="list-none w-full py-1 ' . implode(' ', $classes) . '">';
            $output .= '<div class="flex items-center justify-between gap-1.5 w-full">';
            $output .= '<a href="' . $url . '" class="flex-1 px-4 py-2.5 rounded-xl text-ink-900 hover:text-brand-800 hover:bg-brand-50/60 font-medium text-[15px] transition-colors">' . $title . '</a>';
            $output .= '</div>';
        } else {
            $meta = armodafinil_get_product_menu_meta($item);
            $output .= '<li class="list-none w-full">';
            $output .= '<a href="' . $url . '" class="flex items-center gap-2.5 p-2 rounded-xl border border-ink-200/80 bg-white hover:bg-brand-50/40 transition-colors">';
            if (!empty($meta['img_url'])) {
                $output .= '<div class="w-10 h-10 rounded-lg bg-white border border-ink-200/80 p-0.5 shrink-0 overflow-hidden"><img src="' . esc_url($meta['img_url']) . '" alt="' . esc_attr($title) . '" class="w-full h-full object-contain" /></div>';
            }
            $display_card_title = !empty($meta['shop_title']) ? $meta['shop_title'] : $title;
            $output .= '<div class="min-w-0 flex-1">';
            $output .= '<div class="flex items-center justify-between gap-1"><span class="text-xs font-bold text-ink-900 truncate">' . esc_html($display_card_title) . '</span>';
            if (!empty($meta['is_best_seller'])) {
                $output .= '<span class="px-1.5 py-0.5 rounded-full bg-amber-50 text-amber-900 border border-amber-200 text-[9px] font-semibold">' . esc_html($meta['badge_label']) . '</span>';
            }
            $output .= '</div>';
            $output .= '<div class="flex items-center justify-between text-[10px] text-ink-500">';
            $output .= '<span class="truncate">' . esc_html($meta['brand']) . '</span>';
            if (!empty($meta['price_html'])) {
                $output .= '<span class="font-bold text-brand-800 bg-brand-50 px-1 rounded">' . wp_kses_post($meta['price_html']) . '</span>';
            }
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}
