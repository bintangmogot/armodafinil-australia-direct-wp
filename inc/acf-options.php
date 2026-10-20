<?php
/**
 * ACF Options Page & Field Group Definitions for Theme Settings
 *
 * @package Armodafinil_Australia_Direct
 */

add_action('acf/init', function() {
    if( ! function_exists('acf_add_local_field_group') ) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_theme_settings',
        'title' => 'Theme Settings',
        'fields' => array(
            // Tab: Header & Top Bar
            array(
                'key' => 'field_tab_header',
                'label' => 'Header & Top Bar',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_site_logo',
                'label' => 'Site Logo',
                'name' => 'site_logo',
                'type' => 'image',
                'return_format' => 'id',
                'instructions' => 'Upload or choose the primary website logo. If empty, the WordPress Customizer logo will be used.',
            ),
            array(
                'key' => 'field_topbar_left',
                'label' => 'Top Bar Left Text',
                'name' => 'topbar_left',
                'type' => 'text',
                'default_value' => 'Premium cognitive support — Australia-wide dispatch',
            ),
            array(
                'key' => 'field_topbar_center',
                'label' => 'Top Bar Center Text',
                'name' => 'topbar_center',
                'type' => 'text',
                'default_value' => '6–12 business days — discreet packaging',
            ),
            array(
                'key' => 'field_topbar_right',
                'label' => 'Top Bar Right Text',
                'name' => 'topbar_right',
                'type' => 'text',
                'default_value' => 'Support',
            ),
            array(
                'key' => 'field_whatsapp_button_text',
                'label' => 'Header WhatsApp Button Text',
                'name' => 'whatsapp_button_text',
                'type' => 'text',
                'default_value' => 'WhatsApp',
                'instructions' => 'Label displayed next to the WhatsApp icon in the header (e.g. "WhatsApp", "Order on WhatsApp", or leave blank to show only phone number).',
            ),
            array(
                'key' => 'field_nav_dropdown_title',
                'label' => 'Nav Submenu Catalogue Title',
                'name' => 'nav_dropdown_title',
                'type' => 'text',
                'default_value' => 'Genuine Armodafinil Catalogue',
                'instructions' => 'Header title shown at the top of the product mega-dropdown.',
            ),
            array(
                'key' => 'field_nav_dropdown_badge',
                'label' => 'Nav Submenu Badge Text',
                'name' => 'nav_dropdown_badge',
                'type' => 'text',
                'default_value' => 'AU Express 7-10 Days',
                'instructions' => 'Badge text displayed in the header strip of the mega-dropdown.',
            ),
            array(
                'key' => 'field_nav_dropdown_footer_perk',
                'label' => 'Nav Submenu Footer Perk Text',
                'name' => 'nav_dropdown_footer_perk',
                'type' => 'text',
                'default_value' => 'Free Express Delivery on Orders Over $299',
                'instructions' => 'Delivery guarantee or perk text shown in the mega-dropdown footer strip.',
            ),
            array(
                'key' => 'field_nav_dropdown_shop_label',
                'label' => 'Nav Submenu Footer Button Label',
                'name' => 'nav_dropdown_shop_label',
                'type' => 'text',
                'default_value' => 'Explore All Products',
                'instructions' => 'Label for the CTA button in the mega-dropdown footer.',
            ),
            array(
                'key' => 'field_nav_dropdown_shop_url',
                'label' => 'Nav Submenu Footer Button URL',
                'name' => 'nav_dropdown_shop_url',
                'type' => 'text',
                'default_value' => '',
                'instructions' => 'Custom URL for the footer button. If empty, defaults to the WooCommerce Shop page.',
            ),
            array(
                'key' => 'field_nav_best_seller_products',
                'label' => 'Dropdown Best Seller Products',
                'name' => 'nav_best_seller_products',
                'type' => 'post_object',
                'post_type' => array('product'),
                'taxonomy' => array(),
                'allow_null' => 1,
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
                'instructions' => 'Choose which products display the "Best Seller" badge in the navigation dropdown catalogue. Admin can select or remove products at any time.',
            ),

            // Tab: Social Media
            array(
                'key' => 'field_tab_social',
                'label' => 'Social Media',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_facebook_link',
                'label' => 'Facebook Link',
                'name' => 'facebook_link',
                'type' => 'url',
            ),
            array(
                'key' => 'field_instagram_link',
                'label' => 'Instagram Link',
                'name' => 'instagram_link',
                'type' => 'url',
            ),
            array(
                'key' => 'field_twitter_link',
                'label' => 'Twitter Link',
                'name' => 'twitter_link',
                'type' => 'url',
            ),

            // Tab: Contact Info
            array(
                'key' => 'field_tab_contact',
                'label' => 'Contact Info',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_support_email',
                'label' => 'Support Email',
                'name' => 'support_email',
                'type' => 'email',
                'default_value' => 'support@armodafinil-australia-direct.com',
                'instructions' => 'Used for support contact address in the footer.',
            ),
            array(
                'key' => 'field_whatsapp_number',
                'label' => 'Support Phone / WhatsApp Number',
                'name' => 'whatsapp_number',
                'type' => 'text',
                'default_value' => '+61 4 8999 5839',
                'instructions' => 'Used by the top bar and footer WhatsApp links.',
            ),
            array(
                'key' => 'field_whatsapp_button_url',
                'label' => 'WhatsApp Chat Live Link',
                'name' => 'whatsapp_button_url',
                'type' => 'url',
                'instructions' => 'Direct link for WhatsApp Chat button. If left empty, wa.me link with phone number will be used.',
            ),
            array(
                'key' => 'field_location_text',
                'label' => 'Address / Location Text',
                'name' => 'location_text',
                'type' => 'text',
                'default_value' => '50 Holt Street, Surry Hills, 2010',
                'instructions' => 'Physical or dispatch address displayed in footer contact block.',
            ),
            array(
                'key' => 'field_working_days',
                'label' => 'Working Days',
                'name' => 'working_days',
                'type' => 'text',
                'default_value' => 'Monday to Sunday',
                'instructions' => 'Displayed in the footer contact section.',
            ),
            array(
                'key' => 'field_office_hours',
                'label' => 'Office Hours',
                'name' => 'office_hours',
                'type' => 'text',
                'default_value' => '24/7',
                'instructions' => 'Displayed in the footer contact section.',
            ),

            // Tab: Single Product
            array(
                'key' => 'field_tab_single_product',
                'label' => 'Single Product',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_product_trust_badges_info',
                'label' => 'Product Trust Badges',
                'name' => '',
                'type' => 'message',
                'message' => 'Customize the 3 trust badges displayed below the "Buy now" button on all single product pages. Leave fields empty to use the default values.',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
            array(
                'key' => 'field_product_trust_badge_1_text',
                'label' => 'Badge 1 Text',
                'name' => 'product_trust_badge_1_text',
                'type' => 'text',
                'default_value' => 'AU-wide dispatch',
                'placeholder' => 'e.g. AU-wide dispatch',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_product_trust_badge_1_icon',
                'label' => 'Badge 1 Icon',
                'name' => 'product_trust_badge_1_icon',
                'type' => 'select',
                'choices' => array(
                    'truck' => 'Truck (AU-Wide Dispatch / Delivery)',
                    'lock' => 'Lock (Encrypted Checkout / Security)',
                    'shield-check' => 'Shield Check (Quality Verified)',
                    'package' => 'Package (Discreet Packaging)',
                    'clock' => 'Clock (Same-Day / Fast Dispatch)',
                    'check-circle' => 'Check Circle (100% Guarantee)',
                    'zap' => 'Lightning (Fast Effect / Energy)',
                    'award' => 'Award (Premium Quality)',
                    'heart-handshake' => 'Handshake (Trusted Service)',
                ),
                'default_value' => 'truck',
                'allow_null' => 0,
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_product_trust_badge_2_text',
                'label' => 'Badge 2 Text',
                'name' => 'product_trust_badge_2_text',
                'type' => 'text',
                'default_value' => 'Encrypted checkout',
                'placeholder' => 'e.g. Encrypted checkout',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_product_trust_badge_2_icon',
                'label' => 'Badge 2 Icon',
                'name' => 'product_trust_badge_2_icon',
                'type' => 'select',
                'choices' => array(
                    'truck' => 'Truck (AU-Wide Dispatch / Delivery)',
                    'lock' => 'Lock (Encrypted Checkout / Security)',
                    'shield-check' => 'Shield Check (Quality Verified)',
                    'package' => 'Package (Discreet Packaging)',
                    'clock' => 'Clock (Same-Day / Fast Dispatch)',
                    'check-circle' => 'Check Circle (100% Guarantee)',
                    'zap' => 'Lightning (Fast Effect / Energy)',
                    'award' => 'Award (Premium Quality)',
                    'heart-handshake' => 'Handshake (Trusted Service)',
                ),
                'default_value' => 'lock',
                'allow_null' => 0,
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_product_trust_badge_3_text',
                'label' => 'Badge 3 Text',
                'name' => 'product_trust_badge_3_text',
                'type' => 'text',
                'default_value' => 'Quality verified',
                'placeholder' => 'e.g. Quality verified',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_product_trust_badge_3_icon',
                'label' => 'Badge 3 Icon',
                'name' => 'product_trust_badge_3_icon',
                'type' => 'select',
                'choices' => array(
                    'truck' => 'Truck (AU-Wide Dispatch / Delivery)',
                    'lock' => 'Lock (Encrypted Checkout / Security)',
                    'shield-check' => 'Shield Check (Quality Verified)',
                    'package' => 'Package (Discreet Packaging)',
                    'clock' => 'Clock (Same-Day / Fast Dispatch)',
                    'check-circle' => 'Check Circle (100% Guarantee)',
                    'zap' => 'Lightning (Fast Effect / Energy)',
                    'award' => 'Award (Premium Quality)',
                    'heart-handshake' => 'Handshake (Trusted Service)',
                ),
                'default_value' => 'shield-check',
                'allow_null' => 0,
                'wrapper' => array('width' => '50'),
            ),

            // Tab: Footer
            array(
                'key' => 'field_tab_footer',
                'label' => 'Footer',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_footer_logo',
                'label' => 'Footer Logo',
                'name' => 'footer_logo',
                'type' => 'image',
                'return_format' => 'id',
                'instructions' => 'Optional footer logo. If empty, the primary site logo will be used.',
            ),
            array(
                'key' => 'field_footer_description',
                'label' => 'Footer Description',
                'name' => 'footer_description',
                'type' => 'textarea',
                'default_value' => 'Steady focus, cleaner clarity, and dependable dispatch — built for Australian customers who take their day seriously.',
            ),
            array(
                'key' => 'field_footer_contact_heading',
                'label' => 'Contact Section Heading',
                'name' => 'footer_contact_heading',
                'type' => 'text',
                'default_value' => 'Get in Touch with Us',
                'instructions' => 'Heading displayed above contact information in footer.',
            ),
            array(
                'key' => 'field_footer_payments_heading',
                'label' => 'Payment Accepted Heading',
                'name' => 'footer_payments_heading',
                'type' => 'text',
                'default_value' => 'Payment Accepted',
                'instructions' => 'Heading displayed above payment method logos in footer.',
            ),
            array(
                'key' => 'field_footer_payment_images',
                'label' => 'Payment Accepted Logos',
                'name' => 'footer_payment_images',
                'type' => 'repeater',
                'instructions' => 'Upload accepted payment logos (e.g. Commonwealth Bank, Osko, PayID). If left empty, default Australian bank and payment logos are displayed.',
                'layout' => 'table',
                'button_label' => 'Add Payment Method',
                'sub_fields' => array(
                    array(
                        'key' => 'field_payment_img',
                        'label' => 'Logo Image',
                        'name' => 'image',
                        'type' => 'image',
                        'required' => 1,
                        'return_format' => 'array',
                    ),
                    array(
                        'key' => 'field_payment_alt',
                        'label' => 'Label / Alt Text',
                        'name' => 'alt_text',
                        'type' => 'text',
                        'instructions' => 'Alt text or name (e.g. "Commonwealth Bank", "Osko", "PayID").',
                    ),
                ),
            ),
            array(
                'key' => 'field_footer_shipping_heading',
                'label' => 'Shipping Partner Heading',
                'name' => 'footer_shipping_heading',
                'type' => 'text',
                'default_value' => 'Shipping Partner',
                'instructions' => 'Heading displayed above shipping partner logos in footer.',
            ),
            array(
                'key' => 'field_footer_shipping_images',
                'label' => 'Shipping Partner Logos',
                'name' => 'footer_shipping_images',
                'type' => 'repeater',
                'instructions' => 'Upload shipping partner logos (e.g. Australia Post). If left empty, default Australia Post logo is displayed.',
                'layout' => 'table',
                'button_label' => 'Add Shipping Partner',
                'sub_fields' => array(
                    array(
                        'key' => 'field_shipping_img',
                        'label' => 'Logo Image',
                        'name' => 'image',
                        'type' => 'image',
                        'required' => 1,
                        'return_format' => 'array',
                    ),
                    array(
                        'key' => 'field_shipping_alt',
                        'label' => 'Label / Alt Text',
                        'name' => 'alt_text',
                        'type' => 'text',
                        'instructions' => 'Alt text or name (e.g. "Australia Post").',
                    ),
                ),
            ),
            array(
                'key' => 'field_copyright_text',
                'label' => 'Copyright Text',
                'name' => 'copyright_text',
                'type' => 'text',
                'default_value' => '© 2026 Armodafinil. Information only — not medical advice.',
            ),
            array(
                'key' => 'field_disclaimer_en',
                'label' => 'Medical / Website Disclaimer',
                'name' => 'disclaimer_en',
                'type' => 'textarea',
                'default_value' => 'This website provides general information only and is not a substitute for advice from a qualified health professional.',
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
});

/**
 * Render SVG icon for product trust badges
 *
 * @param string $icon_key The identifier for the icon.
 * @return string Inline SVG HTML.
 */
function aad_get_trust_badge_icon_svg( $icon_key = 'shield-check' ) {
    switch ( $icon_key ) {
        case 'truck':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck w-4 h-4 text-brand-600 shrink-0"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>';

        case 'lock':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock w-4 h-4 text-brand-600 shrink-0"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>';

        case 'package':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package w-4 h-4 text-brand-600 shrink-0"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>';

        case 'clock':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-4 h-4 text-brand-600 shrink-0"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';

        case 'check-circle':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle w-4 h-4 text-brand-600 shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';

        case 'zap':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-brand-600 shrink-0"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>';

        case 'award':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-award w-4 h-4 text-brand-600 shrink-0"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>';

        case 'heart-handshake':
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart-handshake w-4 h-4 text-brand-600 shrink-0"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/><path d="M12 5 9.04 7.96a2.17 2.17 0 0 0 0 3.08c.82.82 2.13.85 3 .07l2.07-1.9a2.82 2.82 0 0 1 3.18 0l1.8 1.53"/></svg>';

        case 'shield-check':
        default:
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-4 h-4 text-brand-600 shrink-0"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>';
    }
}
