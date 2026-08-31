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
					'key' => 'field_faq_categories',
					'label' => 'FAQ Categories',
					'name' => 'faq_categories',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Add Category',
					'sub_fields' => array(
						array('key' => 'field_faq_cat_name', 'label' => 'Category Name', 'name' => 'cat_name', 'type' => 'text', 'required' => 1),
						array('key' => 'field_faq_cat_icon', 'label' => 'Lucide Icon Name', 'name' => 'cat_icon', 'type' => 'text', 'default_value' => 'help-circle', 'instructions' => 'e.g., package, credit-card, truck, user'),
						array(
							'key' => 'field_faq_items',
							'label' => 'Questions',
							'name' => 'faqs',
							'type' => 'repeater',
							'layout' => 'row',
							'button_label' => 'Add Question',
							'sub_fields' => array(
								array('key' => 'field_faq_item_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text'),
								array('key' => 'field_faq_item_a', 'label' => 'Answer', 'name' => 'answer', 'type' => 'textarea', 'rows' => 3),
							),
						),
					),
				),
			),
		),
		'layout_contact' => array(
			'key' => 'layout_contact',
			'name' => 'contact',
			'label' => 'Contact Block',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_contact_form_title', 'label' => 'Form Title', 'name' => 'form_title', 'type' => 'text', 'default_value' => 'Send us a message'),
				array('key' => 'field_contact_form_shortcode', 'label' => 'Form Shortcode', 'name' => 'form_shortcode', 'type' => 'text', 'instructions' => 'Paste a Gravity Forms shortcode here, e.g. [gravityform id="1" title="false" description="false" ajax="true"]. If left blank, a demo form will be shown.'),
				array(
					'key' => 'field_contact_methods',
					'label' => 'Contact Methods',
					'name' => 'methods',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Add Method',
					'sub_fields' => array(
						array('key' => 'field_cm_icon', 'label' => 'Lucide Icon', 'name' => 'icon', 'type' => 'text', 'default_value' => 'mail'),
						array('key' => 'field_cm_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text'),
						array('key' => 'field_cm_value', 'label' => 'Value', 'name' => 'value', 'type' => 'text'),
						array('key' => 'field_cm_link', 'label' => 'Link', 'name' => 'link', 'type' => 'text', 'instructions' => 'e.g. mailto:..., tel:...'),
					),
				),
			),
		),
				'layout_advanced_hero' => array(
			'key' => 'layout_advanced_hero',
			'name' => 'advanced_hero',
			'label' => 'Advanced Hero',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_ah_badge', 'label' => 'Badge', 'name' => 'badge', 'type' => 'text'),
				array('key' => 'field_ah_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
				array('key' => 'field_ah_desc', 'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 3),
				array(
					'key' => 'field_ah_buttons',
					'label' => 'Buttons',
					'name' => 'buttons',
					'type' => 'repeater',
					'layout' => 'table',
					'button_label' => 'Add Button',
					'sub_fields' => array(
						array('key' => 'field_ah_btn_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text'),
						array('key' => 'field_ah_btn_link', 'label' => 'Link', 'name' => 'link', 'type' => 'text'),
						array('key' => 'field_ah_btn_style', 'label' => 'Style', 'name' => 'style', 'type' => 'select', 'choices' => array('primary' => 'Primary', 'outline' => 'Outline')),
					),
				),
			),
		),
		'layout_timeline' => array(
			'key' => 'layout_timeline',
			'name' => 'timeline',
			'label' => 'Timeline Steps',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_tl_badge', 'label' => 'Badge', 'name' => 'badge', 'type' => 'text'),
				array('key' => 'field_tl_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
				array(
					'key' => 'field_tl_steps',
					'label' => 'Steps',
					'name' => 'steps',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Add Step',
					'sub_fields' => array(
						array('key' => 'field_tl_step_n', 'label' => 'Step Number (e.g. 01)', 'name' => 'number', 'type' => 'text'),
						array('key' => 'field_tl_step_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
						array('key' => 'field_tl_step_desc', 'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 3),
						array('key' => 'field_tl_step_icon', 'label' => 'Lucide Icon', 'name' => 'icon', 'type' => 'text', 'default_value' => 'check'),
					),
				),
			),
		),
		'layout_features_grid' => array(
			'key' => 'layout_features_grid',
			'name' => 'features_grid',
			'label' => 'Features Grid',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_fg_title', 'label' => 'Section Title', 'name' => 'title', 'type' => 'text'),
				array(
					'key' => 'field_fg_features',
					'label' => 'Features',
					'name' => 'features',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Add Feature',
					'sub_fields' => array(
						array('key' => 'field_fg_feat_icon', 'label' => 'Lucide Icon', 'name' => 'icon', 'type' => 'text'),
						array('key' => 'field_fg_feat_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
						array('key' => 'field_fg_feat_desc', 'label' => 'Description', 'name' => 'desc', 'type' => 'textarea', 'rows' => 3),
					),
				),
			),
		),
				'layout_trust_signals' => array(
			'key' => 'layout_trust_signals',
			'name' => 'trust_signals',
			'label' => 'Trust Signals',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_ts_note', 'label' => 'Note', 'name' => 'note', 'type' => 'message', 'message' => 'Displays 3 trust icons (Verified, Secure, AU-wide).'),
			),
		),
		'layout_support_cta' => array(
			'key' => 'layout_support_cta',
			'name' => 'support_cta',
			'label' => 'Support CTA Inline',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_sc_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
				array('key' => 'field_sc_desc', 'label' => 'Description', 'name' => 'desc', 'type' => 'text'),
			),
		),
				'layout_policy_page' => array(
			'key' => 'layout_policy_page',
			'name' => 'policy_page',
			'label' => 'Policy Page (TOC)',
			'display' => 'block',
			'sub_fields' => array(
				array('key' => 'field_pp_eyebrow', 'label' => 'Eyebrow', 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'Legal'),
				array('key' => 'field_pp_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
				array('key' => 'field_pp_intro', 'label' => 'Intro', 'name' => 'intro', 'type' => 'textarea', 'rows' => 3),
				array('key' => 'field_pp_updated', 'label' => 'Last Updated', 'name' => 'updated', 'type' => 'text'),
				array(
					'key' => 'field_pp_sections',
					'label' => 'Sections',
					'name' => 'sections',
					'type' => 'repeater',
					'layout' => 'block',
					'button_label' => 'Add Section',
					'sub_fields' => array(
						array('key' => 'field_pps_title', 'label' => 'Section Title', 'name' => 'title', 'type' => 'text'),
						array('key' => 'field_pps_content', 'label' => 'Content', 'name' => 'content', 'type' => 'wysiwyg', 'media_upload' => 0, 'tabs' => 'all', 'toolbar' => 'full'),
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
				'layout_rich_text' => array(
			'key' => 'layout_rich_text',
			'name' => 'rich_text',
			'label' => 'Rich Text (Top/Bottom Content)',
			'display' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_rt_content',
					'label' => 'Content',
					'name' => 'content',
					'type' => 'wysiwyg',
				),
				array(
					'key' => 'field_rt_width',
					'label' => 'Container Width',
					'name' => 'width',
					'type' => 'select',
					'choices' => array(
						'default' => 'Default (Content width)',
						'full' => 'Full width',
						'narrow' => 'Narrow (Reading width)',
					),
					'default_value' => 'default',
				),
			),
		),
				'layout_archive_products' => array(
			'key' => 'layout_archive_products',
			'name' => 'archive_products',
			'label' => 'Archive Product Grid',
			'display' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_ap_instructions',
					'label' => 'Instructions',
					'name' => '',
					'type' => 'message',
					'message' => 'This module will automatically output the WooCommerce product grid (with sorting and pagination) for the current category or shop page.',
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
						array(
							'key' => 'field_cs_parent_category',
							'label' => 'Select Parent Category',
							'name' => 'parent_category',
							'type' => 'taxonomy',
							'taxonomy' => 'product_cat',
							'field_type' => 'select',
							'return_format' => 'object',
							'instructions' => 'Select a parent category. The module will automatically pull its name, description, image, and display its sub-categories.',
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
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'product_cat',
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






