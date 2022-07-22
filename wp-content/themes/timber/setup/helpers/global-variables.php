<?php

//
// Global Variables added to timber
//

function global_variables($data) {
    // First load from theme options
    $data['gv'] = get_theme_mods();
    // Add any others that we want in version control
    // $data["gv"]["ga_id"] = "";
    // $data["gv"]["fb_app_id"] = "";
    // $data["gv"]["gtm_id"] = "";

    return $data;
}

add_filter('timber_context', 'global_variables');

?>
