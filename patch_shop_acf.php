<?php
$code = <<<PHP

    // Shop Page Header Settings
    acf_add_local_field_group(array(
        'key' => 'group_shop_header_settings',
        'title' => 'Shop Page Header Settings',
        'fields' => array(
            array(
                'key' => 'field_shop_badge_text',
                'label' => 'Badge Text',
                'name' => 'shop_badge_text',
                'type' => 'text',
                'default_value' => 'Full catalogue',
            ),
            array(
                'key' => 'field_shop_description',
                'label' => 'Shop Description',
                'name' => 'shop_description',
                'type' => 'textarea',
                'default_value' => 'Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps &mdash; shipped discreetly across Australia.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => wc_get_page_id('shop'),
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Settings for the WooCommerce Shop page header.',
    ));
PHP;

$file = 'inc/acf-fields.php';
$content = file_get_contents($file);
$content = str_replace("add_action('acf/init', function() {", "add_action('acf/init', function() {\n" . $code, $content);
file_put_contents($file, $content);
echo "Added ACF fields for Shop Page Header.\n";
