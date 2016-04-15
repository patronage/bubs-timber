<?php

//
// Hashed assets
// Checks a manifest file for a versioned assets to load
// what the newest version of something is while caching it heavily.
//
function rev( $file, $domain = NULL ) {
    $theme = get_stylesheet_directory_uri();
    $static = 'static';
    $dist = 'dist';
    $manifest = 'rev-manifest.json';
    $jsondata = @file_get_contents( get_stylesheet_directory() . '/' . $static . '/' . $manifest );

    if ( $jsondata == FALSE ) {
        // If manifest file can't be found, forget about it, and load from normal link
        $url = $theme . '/' . $dist . '/' . $file;
    } else {
        // JSON Parsed, look for versioned file...
        $json = json_decode($jsondata, TRUE);

        $rev_check = isset( $json[$file] );
        $file_check = file_exists( get_stylesheet_directory() . "/static/" . $json[ $file ] );

        if ( $rev_check && $file_check ) {
            $url = $theme . '/' . $static . '/' . $json[ $file ];
        } else {
            $url = $theme . '/' . $dist . '/' . $file;
        }
    }

    if (isset($domain)) {
        $url = str_replace( site_url(), $domain, $url );
    }

    return $url;
}

?>
