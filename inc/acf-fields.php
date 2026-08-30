<?php
add_action('acf/init', function() {

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
		'layout_faq' => array(
			'key' => 'layout_faq',
			'name' => 'faq',
			'label' => 'FAQ Block',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_faq_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
				array('key' => 'field_faq_subtitle', 'label' => 'Subtitle', 'name' => 'subtitle', 'type' => 'text'),
				array(
					'key' => 'field_faq_items',
					'label' => 'FAQs',
					'name' => 'faqs',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Add FAQ',
					'sub_fields' => array(
						array('key' => 'field_faq_item_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text'),
						array('key' => 'field_faq_item_a', 'label' => 'Answer', 'name' => 'answer', 'type' => 'textarea', 'rows' => 3),
					),
				),
			),
		),
		'layout_conditions_grid' => array(
			'key' => 'layout_conditions_grid',
			'name' => 'conditions_grid',
			'label' => 'Conditions Grid',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_cond_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
				array('key' => 'field_cond_subtitle', 'label' => 'Subtitle', 'name' => 'subtitle', 'type' => 'text'),
				array('key' => 'field_cond_link_text', 'label' => 'View All Text', 'name' => 'view_all_text', 'type' => 'text'),
				array('key' => 'field_cond_link_url', 'label' => 'View All URL', 'name' => 'view_all_url', 'type' => 'url'),
				array(
					'key' => 'field_cond_posts',
					'label' => 'Posts',
					'name' => 'posts',
					'type' => 'relationship',
					'post_type' => array('post'),
					'filters' => array('search'),
					'return_format' => 'object',
				),
			),
		),
		'layout_blog_grid' => array(
			'key' => 'layout_blog_grid',
			'name' => 'blog_grid',
			'label' => 'Blog Grid',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_blog_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
				array('key' => 'field_blog_subtitle', 'label' => 'Subtitle', 'name' => 'subtitle', 'type' => 'text'),
				array('key' => 'field_blog_link_text', 'label' => 'View All Text', 'name' => 'view_all_text', 'type' => 'text'),
				array('key' => 'field_blog_link_url', 'label' => 'View All URL', 'name' => 'view_all_url', 'type' => 'url'),
				array(
					'key' => 'field_blog_posts',
					'label' => 'Posts',
					'name' => 'posts',
					'type' => 'relationship',
					'post_type' => array('post'),
					'filters' => array('search'),
					'return_format' => 'object',
				),
			),
		),
		'layout_newsletter' => array(
			'key' => 'layout_newsletter',
			'name' => 'newsletter',
			'label' => 'Newsletter CTA',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_news_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
				array('key' => 'field_news_subtitle', 'label' => 'Subtitle', 'name' => 'subtitle', 'type' => 'textarea', 'rows' => 2),
				array('key' => 'field_news_shortcode', 'label' => 'Form Shortcode', 'name' => 'shortcode', 'type' => 'text', 'instructions' => 'e.g. [contact-form-7 id="123"]'),
			),
		),
		'layout_simple_hero' => array(
			'key' => 'layout_simple_hero',
			'name' => 'simple_hero',
			'label' => 'Simple Hero',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_sh_tag', 'label' => 'Tag', 'name' => 'tag', 'type' => 'text'),
				array('key' => 'field_sh_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
				array('key' => 'field_sh_desc', 'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 3),
			),
		),
		'layout_blog_archive' => array(
			'key' => 'layout_blog_archive',
			'name' => 'blog_archive',
			'label' => 'Blog Archive Grid',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_ba_info', 'label' => 'Info', 'name' => 'info', 'type' => 'message', 'message' => 'This module automatically displays paginated blog posts with a featured post at the top.'),
			),
		),
		'layout_conditions_archive' => array(
			'key' => 'layout_conditions_archive',
			'name' => 'conditions_archive',
			'label' => 'Conditions Archive Grid',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_ca_info', 'label' => 'Info', 'name' => 'info', 'type' => 'message', 'message' => 'This module automatically displays paginated condition guides.'),
			),
		),
		'layout_order_cta' => array(
			'key' => 'layout_order_cta',
			'name' => 'order_cta',
			'label' => 'Order CTA',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_octa_tag', 'label' => 'Tag', 'name' => 'tag', 'type' => 'text', 'default_value' => 'Get started'),
				array('key' => 'field_octa_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text', 'default_value' => 'Ready to order with confidence?'),
				array('key' => 'field_octa_desc', 'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Pick your pack size, complete a secure checkout in minutes, and track your discreet parcel anywhere in Australia.'),
			),
		),
		'layout_important_notes' => array(
			'key' => 'layout_important_notes',
			'name' => 'important_notes',
			'label' => 'Important Usage & Disclaimer',
			'display' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_mod_important_usage_note',
					'label' => 'Important Usage Note',
					'name' => 'important_usage_note',
					'type' => 'textarea',
					'instructions' => 'Use {product_name} to insert the current product name dynamically.',
					'default_value' => '{product_name} is a Schedule 4 (prescription-only) medicine in Australia. Effects, dosage, and possible side effects can differ from person to person. Taking this medicine without a doctor\'s advice may be harmful. This website does not encourage self-medication. For official Australian prescription-medicine guidance, see the <a href="https://www.tga.gov.au/" target="_blank" rel="noopener" class="text-brand-700 hover:underline">Therapeutic Goods Administration (TGA)</a>.',
				),
				array(
					'key' => 'field_mod_medical_disclaimer_text',
					'label' => 'Medical Disclaimer',
					'name' => 'medical_disclaimer_text',
					'type' => 'textarea',
					'default_value' => 'This website is for informational purposes only and does not constitute medical advice. Always consult a qualified healthcare professional before starting, stopping, or changing any medication. <a href="/medical-disclaimer" class="font-semibold text-brand-800 hover:underline">Read our full medical disclaimer.</a>',
				),
				array(
					'key' => 'field_mod_medically_reviewed_by',
					'label' => 'Medically Reviewed By',
					'name' => 'medically_reviewed_by',
					'type' => 'text',
					'default_value' => 'Dr. Ginni Mansberg',
				),
			),
		),
		'layout_category_showcase' => array(
			'key' => 'layout_category_showcase',
			'name' => 'category_showcase',
			'label' => 'Category Showcase',
			'display' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_cs_sections',
					'label' => 'Showcase Sections',
					'name' => 'sections',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Add Section',
					'sub_fields' => array(
						array('key' => 'field_cs_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
						array('key' => 'field_cs_subtitle', 'label' => 'Subtitle', 'name' => 'subtitle', 'type' => 'textarea', 'rows' => 2),
						array('key' => 'field_cs_icon', 'label' => 'Icon (Image)', 'name' => 'icon', 'type' => 'image', 'return_format' => 'url'),
						array('key' => 'field_cs_link_text', 'label' => 'Button Text', 'name' => 'link_text', 'type' => 'text', 'default_value' => 'Browse category'),
						array('key' => 'field_cs_link_url', 'label' => 'Button Link', 'name' => 'link_url', 'type' => 'url', 'instructions' => 'Optional link for the button'),
						array(
							'key' => 'field_cs_categories',
							'label' => 'Select Sub-categories',
							'name' => 'categories',
							'type' => 'taxonomy',
							'taxonomy' => 'product_cat',
							'field_type' => 'multi_select',
							'return_format' => 'object',
							'instructions' => 'Select the sub-categories to display as cards in this section.',
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
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
));

acf_add_local_field_group(array(
	'key' => 'group_product_specs',
	'title' => 'Product Specs',
	'fields' => array(
		array(
			'key' => 'field_product_specs',
			'label' => 'Product Specs',
			'name' => 'custom_product_specs',
			'type' => 'repeater',
			'instructions' => 'Add additional product specifications here (e.g. Active Ingredient, Manufacturer). These will appear alongside the WooCommerce attributes.',
			'layout' => 'table',
			'button_label' => 'Add Spec',
			'sub_fields' => array(
				array(
					'key' => 'field_spec_name',
					'label' => 'Spec Name',
					'name' => 'spec_name',
					'type' => 'text',
				),
				array(
					'key' => 'field_spec_value',
					'label' => 'Spec Value',
					'name' => 'spec_value',
					'type' => 'text',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
));

});
