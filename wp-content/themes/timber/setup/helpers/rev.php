<?php

//
// Hashed assets
// Checks a manifest file for a versioned asset to load
//

function rev( $file, $domain = NULL ) {
    $theme = get_stylesheet_directory_uri();
    $static = 'static';
    $dist = 'dist';
    $dev = 'assets';
    $manifest = 'rev-manifest.json';
    $jsondata = @file_get_contents( get_stylesheet_directory() . '/' . $static . '/' . $manifest );

    if ( defined('WP_ENV') ) {
        $env = WP_ENV;
    } else {
        $env = "production";
    }

    if ( $env == "production" ) {
        $folder = $dist;
    } else {
        $folder = $dev;
    }

    // JS in prod is special, because vendor files get rewritten
    $ext = pathinfo($file, PATHINFO_EXTENSION);

    if ( $jsondata == FALSE ) {
        // If manifest file can't be found, forget about it, and load from normal link
        if ( $ext == "js" && $env == "production" ) {
            $url = $theme . '/' . $folder . '/js/' . basename($file);
        } else {
            $url = $theme . '/' . $folder . '/' . $file;
        }
    } else {
        // Parse JSON, then look for versioned file...
        $json = json_decode($jsondata, TRUE);

        // first check exact folder
        $rev_check = isset( $json[$file] );
        $file_check = file_exists( get_stylesheet_directory() . "/static/" . $json[ $file ] );

        if ( $rev_check && $file_check ) {
            $url = $theme . '/' . $static . '/' . $json[ $file ];
        } else {
            // js gets flattened, check there as well
            $file = 'js/' . basename($file);
            $file_check = file_exists( get_stylesheet_directory() . "/static/" . $json[ $file ] );
            if ( $file_check ) {
                $url = $theme . '/' . $static . '/' . $json[ $file ];
            } else {
                $url = $theme . '/' . $folder . '/' . $file;
            }
        }
    }

    if (isset($domain)) {
        $url = str_replace( site_url(), $domain, $url );
    }

    return $url;
}

//
// Block Rev Replace
//

function revBlock ($files, $domain = NULL ) {

    // return "$files" from block;
    preg_match_all('/<script[^>]+>/i',$files, $scripts_raw);
    preg_match_all('/<link[^>]+>/i',$files, $styles_raw);

    // Extract each script and stylesheet

    $scripts = array();
    foreach( $scripts_raw[0] as $script_tag) {
        preg_match( '/src="(.*?)"/i', $script_tag, $src ) ;
        $scripts[] = $src[1];
    }

    $styles = array();
    foreach( $styles_raw[0] as $style_tag) {
        preg_match( '/href="(.*?)"/i', $style_tag, $href ) ;
        $styles[] = $href[1];
    }

    // Loop through all, running rev function, then return

    $html = "";

    if (!empty($scripts)) {
        foreach( $scripts as $script) {
            $html .= '<script src="'. rev($script) .'"></script>';
            $html .= "\n";
        }
    }

    if (!empty($styles)) {
        foreach( $styles as $style) {
            $html .= '<link rel="stylesheet" href="' . rev($style) .'" />';
            $html .= "\n";
        }
    }

    return $html;
}


?>
