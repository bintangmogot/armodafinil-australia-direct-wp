<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_theme_settings',
	'title' => 'Theme Settings',
	'fields' => array(
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
			'key' => 'field_support_email',
			'label' => 'Support Email',
			'name' => 'support_email',
			'type' => 'email',
			'default_value' => 'support@armodafinil-australia-direct.com',
		),
        array(
			'key' => 'field_whatsapp_number',
			'label' => 'WhatsApp Number',
			'name' => 'whatsapp_number',
			'type' => 'text',
			'default_value' => '+61 4 8999 5839',
            'instructions' => 'Include country code, e.g. +61 4 8999 5839',
		),
        array(
			'key' => 'field_promo_code',
			'label' => 'Promo Code',
			'name' => 'promo_code',
			'type' => 'text',
			'default_value' => 'ARMD10',
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
