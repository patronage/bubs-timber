<?php
    // Register Custom Post Type
    function cpt_testimonials() {
        $labels = array(
            'name'                => _x( 'Testimonials', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Testimonials', 'text_domain' ),
            'name_admin_bar'      => __( 'Testimonials', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Testimonial:', 'text_domain' ),
            'all_items'           => __( 'All Testimonials', 'text_domain' ),
            'add_new_item'        => __( 'Add New Testimonial', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'new_item'            => __( 'New Testimonial', 'text_domain' ),
            'edit_item'           => __( 'Edit Testimonial', 'text_domain' ),
            'update_item'         => __( 'Update Testimonial', 'text_domain' ),
            'view_item'           => __( 'Testimonial', 'text_domain' ),
            'search_items'        => __( 'Search Testimonials', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $rewrite = array(
            'slug'                => 'testimonials',
            'with_front'          => false,
            'pages'               => true,
            'feeds'               => true,
        );
        $args = array(
            'label'               => __( 'testimonials', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 20,
            'menu_icon'           => 'dashicons-megaphone',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => $rewrite,
            'capability_type'     => 'page',
        );
        register_post_type( 'testimonials', $args );
    }
    // Hook into the 'init' action
    add_action( 'init', 'cpt_testimonials', 0 );
?>
