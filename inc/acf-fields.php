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
				'layout_popular_products' => array(
					'key' => 'layout_popular_products',
					'name' => 'popular_products',
					'label' => 'Popular Products',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_popular_title',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
						),
						array(
							'key' => 'field_popular_subtitle',
							'label' => 'Subtitle',
							'name' => 'subtitle',
							'type' => 'text',
						),
						array(
							'key' => 'field_popular_link_text',
							'label' => 'View All Link Text',
							'name' => 'view_all_text',
							'type' => 'text',
						),
						array(
							'key' => 'field_popular_link_url',
							'label' => 'View All Link URL',
							'name' => 'view_all_url',
							'type' => 'url',
						),
						array(
							'key' => 'field_popular_products_list',
							'label' => 'Products',
							'name' => 'products',
							'type' => 'relationship',
							'post_type' => array(
								0 => 'product',
							),
							'filters' => array(
								0 => 'search',
							),
							'return_format' => 'object',
						),
					),
				),
				'layout_testimonials' => array(
					'key' => 'layout_testimonials',
					'name' => 'testimonials',
					'label' => 'Testimonials',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_testi_title',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
						),
						array(
							'key' => 'field_testi_subtitle',
							'label' => 'Subtitle',
							'name' => 'subtitle',
							'type' => 'text',
						),
						array(
							'key' => 'field_testi_reviews',
							'label' => 'Reviews',
							'name' => 'reviews',
							'type' => 'repeater',
							'layout' => 'block',
							'button_label' => 'Add Review',
							'sub_fields' => array(
								array(
									'key' => 'field_testi_rev_title',
									'label' => 'Review Title',
									'name' => 'title',
									'type' => 'text',
								),
								array(
									'key' => 'field_testi_rev_body',
									'label' => 'Review Body',
									'name' => 'body',
									'type' => 'textarea',
								),
								array(
									'key' => 'field_testi_rev_name',
									'label' => 'Customer Name',
									'name' => 'name',
									'type' => 'text',
								),
								array(
									'key' => 'field_testi_rev_city',
									'label' => 'City/Location',
									'name' => 'city',
									'type' => 'text',
								),
							),
						),
					),
				),
				'layout_shipping_features' => array(
					'key' => 'layout_shipping_features',
					'name' => 'shipping_features',
					'label' => 'Shipping Features',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_shipping_title',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
						),
						array(
							'key' => 'field_shipping_subtitle',
							'label' => 'Subtitle',
							'name' => 'subtitle',
							'type' => 'text',
						),
						array(
							'key' => 'field_shipping_features',
							'label' => 'Features',
							'name' => 'features',
							'type' => 'repeater',
							'layout' => 'block',
							'button_label' => 'Add Feature',
							'sub_fields' => array(
								array(
									'key' => 'field_shipping_feat_icon',
									'label' => 'Icon Name',
									'name' => 'icon',
									'type' => 'text',
									'instructions' => 'e.g. Package, Shield, Truck, Zap',
								),
								array(
									'key' => 'field_shipping_feat_title',
									'label' => 'Title',
									'name' => 'title',
									'type' => 'text',
								),
								array(
									'key' => 'field_shipping_feat_desc',
									'label' => 'Description',
									'name' => 'desc',
									'type' => 'textarea',
									'rows' => 3,
								),
							),
						),
					),
				),
				'layout_why_choose' => array(
					'key' => 'layout_why_choose',
					'name' => 'why_choose',
					'label' => 'Why Choose',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_why_title',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
						),
						array(
							'key' => 'field_why_features',
							'label' => 'Features',
							'name' => 'features',
							'type' => 'repeater',
							'layout' => 'block',
							'button_label' => 'Add Feature',
							'sub_fields' => array(
								array(
									'key' => 'field_why_feat_icon',
									'label' => 'Icon Name',
									'name' => 'icon',
									'type' => 'text',
								),
								array(
									'key' => 'field_why_feat_title',
									'label' => 'Title',
									'name' => 'title',
									'type' => 'text',
								),
								array(
									'key' => 'field_why_feat_desc',
									'label' => 'Description',
									'name' => 'desc',
									'type' => 'textarea',
									'rows' => 3,
								),
								array(
							'key' => 'field_why_feat_tag',
							'label' => 'Tag',
							'name' => 'tag',
							'type' => 'text',
						),
					),
				),
			),
		),
		'layout_audience_grid' => array(
			'key' => 'layout_audience_grid',
			'name' => 'audience_grid',
			'label' => 'Audience Grid',
			'display' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_audience_title',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
				),
				array(
					'key' => 'field_audience_subtitle',
					'label' => 'Subtitle',
					'name' => 'subtitle',
					'type' => 'text',
				),
				array(
					'key' => 'field_audience_items',
					'label' => 'Audiences',
					'name' => 'audiences',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Add Audience',
					'sub_fields' => array(
						array('key' => 'field_audience_icon', 'label' => 'Icon', 'name' => 'icon', 'type' => 'text'),
						array('key' => 'field_audience_item_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
						array('key' => 'field_audience_desc', 'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 3),
						array('key' => 'field_audience_badge', 'label' => 'Badge', 'name' => 'badge', 'type' => 'text'),
						array('key' => 'field_audience_cta_text', 'label' => 'CTA Text', 'name' => 'cta_text', 'type' => 'text'),
						array('key' => 'field_audience_cta_url', 'label' => 'CTA URL', 'name' => 'cta_url', 'type' => 'url'),
					),
				),
			),
		),
		'layout_how_it_works' => array(
			'key' => 'layout_how_it_works',
			'name' => 'how_it_works',
			'label' => 'How It Works',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_how_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
				array('key' => 'field_how_subtitle', 'label' => 'Subtitle', 'name' => 'subtitle', 'type' => 'text'),
				array(
					'key' => 'field_how_steps',
					'label' => 'Steps',
					'name' => 'steps',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Add Step',
					'sub_fields' => array(
						array('key' => 'field_how_step_num', 'label' => 'Step Number', 'name' => 'step_number', 'type' => 'number'),
						array('key' => 'field_how_step_time', 'label' => 'Time', 'name' => 'time', 'type' => 'text'),
						array('key' => 'field_how_step_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
						array('key' => 'field_how_step_desc', 'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 3),
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
