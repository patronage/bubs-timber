<?php

//
// Integrations
//

$wp_customize->add_section('integrations', [
    'title' => 'Integrations',
    'priority' => 99,
]);

// Fields
$wp_customize->add_setting('ga_id', [
    'default' => '',
]);

$wp_customize->add_control('ga_id', [
    'label' => 'Google Analytics ID',
    'section' => 'integrations',
    'settings' => 'ga_id',
    'type' => 'text',
]);

$wp_customize->add_setting('gtm_id', [
    'default' => '',
]);

$wp_customize->add_control('gtm_id', [
    'label' => 'Google Tag Manager ID',
    'section' => 'integrations',
    'settings' => 'gtm_id',
    'type' => 'text',
]);
