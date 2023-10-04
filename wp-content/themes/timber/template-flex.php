<?php

/*
Template Name: Flex
Template Post Type: page, post, component-library
*/

$context = Timber::get_context();
$timber_post = Timber::get_post();
$context['post'] = $timber_post;

// Flex Helper

// This config would be unique per site
// The rest could move to a library
$config = [
  'flex_field_name' => 'flex_content',
  'default_background_color' => 'white',
  'templates' => [
    'blockquote' => 'flex/blockquote.twig',
    'hero' => 'flex/hero.twig',
    'wysiwyg_content' => 'flex/wysiwyg-content.twig',
  ],
  'script_loader' => [
    'blockquote' => ['swiper'],
  ],
  // todo: allow certain individual flex modules to override padding
  // ideally each would have a simple function that returns true or false
  'custom_padding' => [
    'hero' => false,
    // 'blockquote' => blockquotePadding(),
    // 'media' => mediaPadding(),
  ],
  'css' => [
    'padding_top' => 'section-padded-top',
    'padding_bottom' => 'section-padded-bottom',
    'padding_top_none' => 'pt-0',
    'padding_bottom_none' => 'pb-0',
  ],
];

// call our global flex helper function
$flex = bubs_get_flex_content($timber_post, $config);

// add to context
$context['post']->flex_content = $flex->content;
$context['post']->flex_templates = $config['templates'];
$context['script_loader'] = $flex->script_loader;

Timber::render(['page-' . $timber_post->post_name . '.twig', 'template-flex.twig', 'page.twig'], $context);
