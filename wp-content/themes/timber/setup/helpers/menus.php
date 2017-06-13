<?php

//
// Add Menus to Timber
//

register_nav_menus(array(
    'header' => 'Header Navigation',
    // 'footer' => 'Footer Navigation'
));

function timber_menus( $data ) {
    $data["header_menu"] = new TimberMenu('header');
    // $data["footer_menus"] = new TimberMenu('footer');
    return $data;
}

add_filter( 'timber_context', 'timber_menus' );

?>
