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
