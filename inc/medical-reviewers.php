<?php

// 1. Register the Custom Post Type
add_action('init', 'aad_register_medical_reviewer_cpt');
function aad_register_medical_reviewer_cpt() {
    register_post_type('medical_reviewer', array(
        'labels' => array(
            'name' => 'Medical Reviewers',
            'singular_name' => 'Medical Reviewer',
            'add_new' => 'Add New Doctor',
            'add_new_item' => 'Add New Doctor',
            'edit_item' => 'Edit Doctor',
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'medical-team'),
    ));
}

// Retire the Dr. Jesse Morton profile without breaking existing links.
// The path check also covers the profile after its post status is changed to
// draft, when WordPress no longer resolves it as a singular post.
add_action('template_redirect', function() {
    if ( is_admin() ) {
        return;
    }

    $request_path = trim((string) wp_parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    $is_jesse_morton_path = (bool) preg_match('#^medical-team/(?:dr-)?jesse-morton/?$#i', $request_path);
    $is_jesse_morton_post = is_singular('medical_reviewer') && strcasecmp(get_the_title(), 'Dr. Jesse Morton') === 0;

    if ( $is_jesse_morton_path || $is_jesse_morton_post ) {
        wp_safe_redirect(home_url('/about/'), 301);
        exit;
    }
});

// 2. Add the ACF Field for linking a reviewer to a product and theme settings
add_action('acf/init', 'aad_register_medical_reviewer_fields');
function aad_register_medical_reviewer_fields() {
    if( function_exists('acf_add_local_field_group') ) {
        
        // Field to assign a doctor to a product
        acf_add_local_field_group(array(
            'key' => 'group_medical_reviewer_selection',
            'title' => 'Assigned Medical Reviewer',
            'fields' => array(
                array(
                    'key' => 'field_medical_reviewer_post',
                    'label' => 'Select Doctor',
                    'name' => 'medical_reviewer_post',
                    'type' => 'post_object',
                    'post_type' => array('medical_reviewer'),
                    'return_format' => 'id',
                    'allow_null' => 1,
                    'instructions' => 'Select the doctor who medically reviewed this product.',
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
        
        // Fields FOR the doctor themselves (Title, etc)
        acf_add_local_field_group(array(
            'key' => 'group_medical_reviewer_details',
            'title' => 'Doctor Details',
            'fields' => array(
                array(
                    'key' => 'field_mr_title',
                    'label' => 'Medical Title / Role',
                    'name' => 'medical_title',
                    'type' => 'text',
                    'default_value' => 'Physician',
                    'instructions' => 'e.g. Physician, Pharmacist, Chief Medical Officer',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'medical_reviewer',
                    ),
                ),
            ),
        ));
    }
}
