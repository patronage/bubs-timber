<?php

include_once("custom-control-textarea.php");

function theme_options( $wp_customize ) {

    include_once 'footer.php';
    include_once 'social.php';

}

add_action('customize_register', 'theme_options');
