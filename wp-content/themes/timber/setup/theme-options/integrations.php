<?php

//
// Integrations
//

$wp_customize->add_section( 'integrations', array(
    'title'     =>  'Integrations',
    'priority'  =>  99
));

// Fields
$wp_customize->add_setting( 'ga_id', array(
    'default' => ''
));

$wp_customize->add_control('ga_id', array(
    'label'     => 'Google Analytics ID',
    'section'   => 'integrations',
    'settings'  => 'ga_id',
));


$wp_customize->add_setting( 'gtm_id', array(
    'default' => ''
));

$wp_customize->add_control('gtm_id', array(
    'label'     => 'Google Tag Manager ID',
    'section'   => 'integrations',
    'settings'  => 'gtm_id',
));


$wp_customize->add_setting( 'fb_app_id', array(
    'default' => ''
));

$wp_customize->add_control('fb_app_id', array(
    'label'     => 'Facebook App ID',
    'section'   => 'integrations',
    'settings'  => 'fb_app_id',
));
