<?php

//
// Add Menus to Timber
//

register_nav_menus([
  'header' => 'Header Navigation',
  'footer' => 'Footer Navigation',
  'footer_secondary' => 'Footer Secondary Navigation',
  // 'footer_social' => 'Social', using theme options instead
]);

function timber_menus($data) {
  $data['header_menu'] = Timber::get_menu('header');
  $data['footer_menu'] = Timber::get_menu('footer');
  $data['footer_menu_secondary'] = Timber::get_menu('footer_menu_secondary');
  return $data;
}

add_filter('timber/context', 'timber_menus');

?>
