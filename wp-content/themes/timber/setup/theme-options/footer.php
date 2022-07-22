<?php

//
// Footer Section
//

$wp_customize->add_section('footer', [
    'title' => 'Footer',
    'priority' => 20,
]);

// Fields

$wp_customize->add_setting('footer_copyright', [
    'default' => '',
]);
$wp_customize->add_control('footer_copyright', [
    'label' => 'Footer Copyright (do not need copyright or year)',
    'section' => 'footer',
    'settings' => 'footer_copyright',
    'type' => 'text',
]);
