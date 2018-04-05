<?php
    // Register Custom Post Type
    function cpt_destinations() {
        $labels = array(
            'name'                => _x( 'Destinations', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Destination', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Destinations', 'text_domain' ),
            'name_admin_bar'      => __( 'Destinations', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Destination:', 'text_domain' ),
            'all_items'           => __( 'All Destinations', 'text_domain' ),
            'add_new_item'        => __( 'Add New Destination', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'new_item'            => __( 'New Destination', 'text_domain' ),
            'edit_item'           => __( 'Edit Destination', 'text_domain' ),
            'update_item'         => __( 'Update Destination', 'text_domain' ),
            'view_item'           => __( 'Destination', 'text_domain' ),
            'search_items'        => __( 'Search Destinations', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $rewrite = array(
            'slug'                => 'destinations',
            'with_front'          => false,
            'pages'               => true,
            'feeds'               => true,
        );
        $args = array(
            'label'               => __( 'destinations', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 20,
            'menu_icon'           => 'dashicons-admin-site',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => $rewrite,
            'capability_type'     => 'page',
        );
        register_post_type( 'destinations', $args );
    }
    // Hook into the 'init' action
    add_action( 'init', 'cpt_destinations', 0 );
?>
