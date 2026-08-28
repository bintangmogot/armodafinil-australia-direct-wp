<?php
// Register Custom Post Types

function armd_register_cpts() {
    // Conditions
    $labels = array(
        'name'                  => 'Conditions',
        'singular_name'         => 'Condition',
        'menu_name'             => 'Conditions',
        'name_admin_bar'        => 'Condition',
        'archives'              => 'Condition Archives',
        'all_items'             => 'All Conditions',
        'add_new_item'          => 'Add New Condition',
        'add_new'               => 'Add New',
        'new_item'              => 'New Condition',
        'edit_item'             => 'Edit Condition',
        'update_item'           => 'Update Condition',
        'view_item'             => 'View Condition',
        'search_items'          => 'Search Condition',
    );
    $args = array(
        'label'                 => 'Condition',
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-book-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
        'rewrite'               => array('slug' => 'conditions'),
    );
    register_post_type( 'condition', $args );
}
add_action( 'init', 'armd_register_cpts', 0 );
