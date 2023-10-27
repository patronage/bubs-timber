<?php
//
// Enviroment Helper
//
function env_helper($context) {
  if (defined('WP_ENV')) {
    $context['environment'] = WP_ENV;
  } else {
    $context['environment'] = 'production';
  }

  $theme = get_stylesheet_directory_uri();
  $context['theme_dir'] = $theme;

  if ($context['environment'] == 'production') {
    $context['assets_dir'] = $theme . '/dist';
    $context['img_dir'] = $theme . '/dist/img';
    $context['css_dir'] = $theme . '/dist/css';
    $context['js_dir'] = $theme . '/dist/js';
  } else {
    $context['assets_dir'] = $theme . '/dev';
    $context['img_dir'] = $theme . '/dev/img';
    $context['css_dir'] = $theme . '/dev/css';
    $context['js_dir'] = $theme . '/dev/js';
  }

  return $context;
}
add_filter('timber/context', 'env_helper');

?>
