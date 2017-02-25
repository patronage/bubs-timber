<?php
//
// Enviroment Helper
//
function env_helper( $data ) {
    if ( defined('WP_ENV') ) {
        $data["environment"] = WP_ENV;
    } else {
        $data["environment"] = "production";
    }

    $theme = get_stylesheet_directory_uri();

    if ( $data["environment"] == "production" ) {
        $data["assets_dir"] = $theme . '/dist';
        $data["img_dir"]    = $theme . '/dist/img';
        $data["css_dir"]    = $theme . '/dist/css';
        $data["js_dir"]     = $theme . '/dist/js';
    } else {
        $data["assets_dir"] = $theme . '/dev';
        $data["img_dir"]    = $theme . '/dev/img';
        $data["css_dir"]    = $theme . '/dev/css';
        $data["js_dir"]     = $theme . '/dev/js';
    }

    return $data;
}
add_filter('timber_context', 'env_helper');

?>
