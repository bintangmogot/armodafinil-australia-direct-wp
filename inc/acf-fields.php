<?php
if ( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_page_modules',
	'title' => 'Page Modules',
	'fields' => array(
		array(
			'key' => 'field_page_modules',
			'label' => 'Page Modules',
			'name' => 'page_modules',
			'type' => 'flexible_content',
			'layouts' => array(
				'layout_hero_section' => array(
					'key' => 'layout_hero_section',
					'name' => 'hero_section',
					'label' => 'Hero Section',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_hero_eyebrow',
							'label' => 'Eyebrow',
							'name' => 'eyebrow',
							'type' => 'text',
						),
						array(
							'key' => 'field_hero_title',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
						),
						array(
							'key' => 'field_hero_subtitle',
							'label' => 'Subtitle',
							'name' => 'subtitle',
							'type' => 'textarea',
							'rows' => 3,
						),
						array(
							'key' => 'field_hero_cta_label',
							'label' => 'CTA Label',
							'name' => 'cta_label',
							'type' => 'text',
						),
						array(
							'key' => 'field_hero_cta_url',
							'label' => 'CTA URL',
							'name' => 'cta_url',
							'type' => 'url',
						),
						array(
							'key' => 'field_hero_featured_product',
							'label' => 'Featured Product',
							'name' => 'featured_product',
							'type' => 'post_object',
							'post_type' => array(
								0 => 'product',
							),
							'return_format' => 'object',
						),
					),
				),
				'layout_trust_strip' => array(
					'key' => 'layout_trust_strip',
					'name' => 'trust_strip',
					'label' => 'Trust Strip',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_trust_items',
							'label' => 'Trust Items',
							'name' => 'items',
							'type' => 'repeater',
							'layout' => 'table',
							'button_label' => 'Add Item',
							'sub_fields' => array(
								array(
									'key' => 'field_trust_item_text',
									'label' => 'Text',
									'name' => 'text',
									'type' => 'text',
								),
							),
						),
					),
				),
			),
			'button_label' => 'Add Module',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
	),
));

endif;
