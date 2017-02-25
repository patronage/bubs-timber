<?php

//
// WP Admin Customization
//

// Show pages list in DESC order by edit date, not alphabetical
function set_post_order_in_admin( $wp_query ) {
    global $pagenow;
    if ( is_admin() && 'edit.php' == $pagenow && !isset($_GET['orderby'])) {
        $wp_query->set( 'orderby', 'modified' );
        $wp_query->set( 'order', 'DSC' );
    }
}
add_filter('pre_get_posts', 'set_post_order_in_admin' );


// Don't show WP SEO stuff in post list
add_filter( 'wpseo_use_page_analysis', '__return_false' );


// Lower WP SEO Priority so it's at the bottom of single posts:
function lower_wpseo_priority() {
    return 'low';
}
add_filter( 'wpseo_metabox_prio', 'lower_wpseo_priority' );


// Allows upload to Media Library with these file types
function custom_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');



?>
