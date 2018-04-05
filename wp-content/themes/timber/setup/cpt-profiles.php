<?php
    // Register Custom Post Type
    function cpt_profiles() {
        $labels = array(
            'name'                => _x( 'Profiles', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Profile', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Profiles', 'text_domain' ),
            'name_admin_bar'      => __( 'Profiles', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Profile:', 'text_domain' ),
            'all_items'           => __( 'All Profiles', 'text_domain' ),
            'add_new_item'        => __( 'Add New Profile', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'new_item'            => __( 'New Profile', 'text_domain' ),
            'edit_item'           => __( 'Edit Profile', 'text_domain' ),
            'update_item'         => __( 'Update Profile', 'text_domain' ),
            'view_item'           => __( 'Profile', 'text_domain' ),
            'search_items'        => __( 'Search Profiles', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $rewrite = array(
            'slug'                => 'profiles',
            'with_front'          => false,
            'pages'               => true,
            'feeds'               => true,
        );
        $args = array(
            'label'               => __( 'profiles', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 20,
            'menu_icon'           => 'dashicons-universal-access',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => $rewrite,
            'capability_type'     => 'page',
        );
        register_post_type( 'profiles', $args );
    }
    // Hook into the 'init' action
    add_action( 'init', 'cpt_profiles', 0 );
?>
