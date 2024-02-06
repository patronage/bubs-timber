<?php
// Register Custom Post Type
function cpt_component_library() {
  $labels = [
    'name' => _x('Component Library', 'Post Type General Name', 'text_domain'),
    'singular_name' => _x('Component', 'Post Type Singular Name', 'text_domain'),
    'menu_name' => __('Components', 'text_domain'),
    'name_admin_bar' => __('Component Library', 'text_domain'),
    'archives' => __('Item Archives', 'text_domain'),
    'parent_item_colon' => __('Parent Item:', 'text_domain'),
    'all_items' => __('All Items', 'text_domain'),
    'add_new_item' => __('Add New Item', 'text_domain'),
    'add_new' => __('Add New', 'text_domain'),
    'new_item' => __('New Item', 'text_domain'),
    'edit_item' => __('Edit Item', 'text_domain'),
    'update_item' => __('Update Item', 'text_domain'),
    'view_item' => __('View Item', 'text_domain'),
    'search_items' => __('Search Item', 'text_domain'),
    'not_found' => __('Not found', 'text_domain'),
    'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
    'featured_image' => __('Featured Image', 'text_domain'),
    'set_featured_image' => __('Set featured image', 'text_domain'),
    'remove_featured_image' => __('Remove featured image', 'text_domain'),
    'use_featured_image' => __('Use as featured image', 'text_domain'),
    'insert_into_item' => __('Insert into item', 'text_domain'),
    'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
    'items_list' => __('Items list', 'text_domain'),
    'items_list_navigation' => __('Items list navigation', 'text_domain'),
    'filter_items_list' => __('Filter items list', 'text_domain'),
  ];

  $rewrite = [
    'slug' => 'component-library',
    'with_front' => false,
    'pages' => true,
    'feeds' => true,
  ];

  $args = [
    'label' => __('Rooms', 'text_domain'),
    'description' => __('Rooms', 'text_domain'),
    'labels' => $labels,
    'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes'],
    'taxonomies' => [],
    'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_in_rest' => true,
    'rest_base' => '',
    'rest_namespace' => 'wp/v2',
    'show_in_menu' => true,
    'menu_position' => 20,
    'menu_icon' => 'dashicons-media-code',
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => false,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'rewrite' => $rewrite,
    'capability_type' => 'page',
    'show_in_graphql' => true,
    'graphql_single_name' => 'component',
    'graphql_plural_name' => 'components',
  ];

  register_post_type('component-library', $args);
}

add_action('init', 'cpt_component_library', 0);
?>
