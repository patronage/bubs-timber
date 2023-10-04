<?php

//
// WP Admin Customization
//

// Show pages list in DESC order by edit date, not alphabetical
function set_post_order_in_admin($wp_query) {
  global $pagenow;
  if (is_admin() && 'edit.php' == $pagenow && !isset($_GET['orderby'])) {
    $wp_query->set('orderby', 'modified');
    $wp_query->set('order', 'DSC');
  }
}
add_filter('pre_get_posts', 'set_post_order_in_admin');

//
// Yoast
//

// Don't show WP SEO stuff in post list
add_filter('wpseo_use_page_analysis', '__return_false');

// Lower WP SEO Priority so it's at the bottom of single posts:
function lower_wpseo_priority() {
  return 'low';
}
add_filter('wpseo_metabox_prio', 'lower_wpseo_priority');

//
// ACF
//

// custom image sizes (used to provide thumnail sizes for ACF)
add_image_size('Three By One', 375, 125, true);
add_image_size('Three By Two', 180, 120, true);
add_image_size('Hero Image', 400, 179, true);

// Allows upload to Media Library with these file types
function custom_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');

// Hide ACF in production to ensure version controlled JSON is truth
// http://awesomeacf.com/snippets/hide-the-acf-admin-menu-item-on-selected-sites/
function awesome_acf_hide_acf_admin() {
  // check if the current env is dev
  if (defined('WP_ENV') && WP_ENV == 'development') {
    // show the acf menu item
    return true;
  } else {
    // hide the acf menu item
    return false;
  }
}
add_filter('acf/settings/show_admin', 'awesome_acf_hide_acf_admin');

?>
