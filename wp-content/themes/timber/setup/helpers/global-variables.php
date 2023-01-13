<?php

//
// Global Variables added to timber
//

function global_variables($data) {
    // Merge theme mods and acf options to base array
    $theme_mods = get_theme_mods();

    if (function_exists('acf_add_options_page')) {
        $theme_options = get_fields('options') ? get_fields('options') : [];
        $base_variables = array_merge($theme_mods, $theme_options);
        $data['gv'] = $base_variables;
    } else {
        $data['gv'] = $theme_mods;
    }

    // Add any others that we want in version control
    // $data["gv"]["ga_id"] = "";
    // $data["gv"]["fb_app_id"] = "";
    // $data["gv"]["gtm_id"] = "";

    return $data;
}

add_filter('timber_context', 'global_variables');

?>