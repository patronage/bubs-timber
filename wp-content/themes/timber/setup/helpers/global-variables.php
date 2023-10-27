<?php

//
// Global Variables added to timber
//

function global_variables($context) {
  // Merge theme mods and acf options to base array
  $theme_mods = get_theme_mods();

  if (function_exists('acf_add_options_page')) {
    $theme_options = get_fields('options') ? get_fields('options') : [];
    $base_variables = array_merge($theme_mods, $theme_options);
    $context['gv'] = $base_variables;
  } else {
    $context['gv'] = $theme_mods;
  }

  // Add any others that we want in version control
  // $context["gv"]["ga_id"] = "";
  // $context["gv"]["fb_app_id"] = "";
  // $context["gv"]["gtm_id"] = "";

  return $context;
}

add_filter('timber/context', 'global_variables');

?>
