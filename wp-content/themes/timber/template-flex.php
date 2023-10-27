<?php

/*
Template Name: Flex
Template Post Type: page, post, component-library
*/

$context = Timber::context();
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
  // By default, all flex sections have padding and look to next module to prevent doubling up
  // But some modules need to override this
  'custom_padding' => [
    'hero' => false,
    // 'hero' => function ($content) {
    //   // if text-overlay, no padding
    //   return $content['variant'] !== 'text-overlay';
    // },
    'blockquote' => false,
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

// optional, apply custom rules
// foreach ($flex->content as &$section) {
//   if (isset($section['section_apply_triangle'])) {
//     if (isset($section['css_classlist'])) {
//       $section['css_classlist'] .= ' ' . $section['section_triangle'];
//     }
//   }

//   if (isset($section['acf_fc_layout']) && $section['acf_fc_layout'] == 'hero') {
//     $section['css_classlist'] .= ' triangle-frame';
//   }
// }

// add to context
$context['post']->flex_content = $flex->content;
$context['post']->flex_templates = $config['templates'];
$context['script_loader'] = $flex->script_loader;

Timber::render(['page-' . $timber_post->post_name . '.twig', 'template-flex.twig', 'page.twig'], $context);
