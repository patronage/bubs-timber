<?php

//
// Social Section
//

$wp_customize->add_section( 'social', array(
    'title'     =>  'Social Networks',
    'priority'  =>  10
));

// Fields

$wp_customize->add_setting( 'facebook_link', array(
    'default' => ''
));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'facebook_link', array(
    'label'     => 'Facebook Link',
    'section'   => 'social',
    'settings'  => 'facebook_link',
)));

$wp_customize->add_setting( 'twitter_link', array(
    'default' => ''
));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'twitter_link', array(
    'label'     => 'Twitter Link',
    'section'   => 'social',
    'settings'  => 'twitter_link',
)));

$wp_customize->add_setting( 'twitter_user', array(
    'default' => ''
));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'twitter_user', array(
    'label'     => 'Twitter User',
    'section'   => 'social',
    'settings'  => 'twitter_user',
)));

$wp_customize->add_setting( 'instagram_link', array(
    'default' => ''
));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'instagram_link', array(
    'label'     => 'Instagram Link',
    'section'   => 'social',
    'settings'  => 'instagram_link',
)));

$wp_customize->add_setting( 'linkedin_link', array(
    'default' => ''
));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'linkedin_link', array(
    'label'     => 'Linked In Link',
    'section'   => 'social',
    'settings'  => 'linkedin_link',
)));
