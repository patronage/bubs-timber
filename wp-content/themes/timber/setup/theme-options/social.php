<?php

//
// Social Section
//

$wp_customize->add_section('social', [
    'title' => 'Social Networks',
    'priority' => 10,
]);

// Fields

$wp_customize->add_setting('facebook_link', [
    'default' => '',
]);
$wp_customize->add_control('facebook_link', [
    'label' => 'Facebook Link',
    'section' => 'social',
    'settings' => 'facebook_link',
    'type' => 'text',
]);

$wp_customize->add_setting('twitter_link', [
    'default' => '',
]);
$wp_customize->add_control('twitter_link', [
    'label' => 'Twitter Link',
    'section' => 'social',
    'settings' => 'twitter_link',
    'type' => 'text',
]);

$wp_customize->add_setting('twitter_user', [
    'default' => '',
]);
$wp_customize->add_control('twitter_user', [
    'label' => 'Twitter User',
    'section' => 'social',
    'settings' => 'twitter_user',
    'type' => 'text',
]);

$wp_customize->add_setting('instagram_link', [
    'default' => '',
]);
$wp_customize->add_control('instagram_link', [
    'label' => 'Instagram Link',
    'section' => 'social',
    'settings' => 'instagram_link',
    'type' => 'text',
]);

$wp_customize->add_setting('youtube_link', [
    'default' => '',
]);
$wp_customize->add_control('youtube_link', [
    'label' => 'YouTube Link',
    'section' => 'social',
    'settings' => 'youtube_link',
    'type' => 'text',
]);

$wp_customize->add_setting('linkedin_link', [
    'default' => '',
]);
$wp_customize->add_control('linkedin_link', [
    'label' => 'Linked In Link',
    'section' => 'social',
    'settings' => 'linkedin_link',
    'type' => 'text',
]);
