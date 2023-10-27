<?php

// Make composer installed php libraries available
$autoload_path = get_theme_root() . '/../plugins/composer-libs/autoload.php';
if (file_exists($autoload_path)) {
  require_once $autoload_path;
}

// Initialize Timber.
Timber\Timber::init();

// Custom Timber Filters
include_once 'setup/twig-filters/load-svg.php';
add_filter('timber/twig/functions', function ($functions) {
  $functions['load_svg'] = [
    'callable' => 'load_svg',
  ];

  return $functions;
});

//
// Load WP Config files
//

// Customize these variables per site
$staging_wp_host = 'bubstimberstg.wpengine.com';
$dashboard_cleanup = true; // Optionally will hide all but our custom widget
$docs_link = ''; // set to a path if you have a site/document for editor instructions

// Determine the hosting environment we're in
if (defined('WP_ENV') && WP_ENV == 'development') {
  define('WP_HOST', 'localhost');
} else {
  if (strpos($_SERVER['HTTP_HOST'], $staging_wp_host) !== false) {
    define('WP_HOST', 'staging');
  } else {
    define('WP_HOST', 'production');
  }
}

// Theme Options
function bubs_theme_options($wp_customize) {
  include_once 'setup/theme-options/integrations.php';
  $wp_customize->remove_section('custom_css');
}

add_action('customize_register', 'bubs_theme_options');

// Post Types
include_once 'setup/post-types/component-library.php';

// Taxonomies
// include_once 'setup/taxonomies/featured.php';

// WP Helper Functions

include_once 'setup/helpers/acf-options.php';
include_once 'setup/helpers/acf-wysiwyg.php';
include_once 'setup/helpers/admin.php';
include_once 'setup/helpers/admin-env.php';
include_once 'setup/helpers/dashboard-customize.php';
include_once 'setup/helpers/env.php';
// include_once 'setup/helpers/featured-content.php';
include_once 'setup/helpers/flex.php';
include_once 'setup/helpers/global-variables.php';
include_once 'setup/helpers/gutenberg-disable.php';
include_once 'setup/helpers/images.php';
include_once 'setup/helpers/menus.php';
include_once 'setup/helpers/rev.php';
include_once 'setup/helpers/role-super-editor.php';

// Security Settings
// include_once 'setup/helpers/google-login-force.php';
include_once 'setup/helpers/google-login-cookies.php';
include_once 'setup/helpers/xmlrpc-disable.php';

// Wordpress Theme Support Config
// REMOVAL OF THESE = POTIENTAL LOSS OF DATA
add_theme_support('post-thumbnails');
add_theme_support('menus');

?>
