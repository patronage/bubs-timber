<?php

function bubs_get_flex_content($timber_post, $config) {
  $flex = $timber_post->meta($config['flex_field_name']);
  $script_loader = [];

  // filter any items where hide_section is true
  $flex = array_values(
    array_filter($flex, function ($item) {
      return !$item['hide_section'];
    }),
  );

  // prep all flex sections to be rendered
  foreach ($flex as $index => &$content) {
    $layout = $content['acf_fc_layout'];

    // section slug
    $item_slug = $content['section_slug'] ? sanitize_title($content['section_slug']) : 'section-' . ($index + 1);

    // bg color
    $bg_color =
      $content['background_color'] === 'default'
        ? $config['default_background_color']
        : 'bg-' . $content['background_color'];

    // flex id & index
    $flex_index = $index + 1;
    $flex_id = 'flex-' . ($index + 1);

    // set

    // Calculate padding
    $padding_top = true;
    $padding_bottom = true;

    // Determine padding based on the next section
    $next_color =
      $flex[$index + 1]['background_color'] === 'default'
        ? $config['default_background_color']
        : 'bg-' . $flex[$index + 1]['background_color'] ?? null;

    if ($bg_color === $next_color) {
      $padding_bottom = false;
    }

    // allow certain individual flex modules to override padding
    if (array_key_exists($layout, $config['custom_padding'])) {
      $padding_top = $config['custom_padding'][$layout];
      $padding_bottom = $config['custom_padding'][$layout];
    }

    // todo: handle last element, which needs to check footer bg color

    // add to script loader if not yet in array
    if (array_key_exists($layout, $config['script_loader'])) {
      $new_scripts = array_diff($config['script_loader'][$layout], $script_loader);
      $script_loader = array_merge($script_loader, $new_scripts);
    }

    // calculate all classes
    $css_classlist = [];

    // add from sluffified layout
    $layout_slug = str_replace('_', '-', $layout);
    $css_classlist[] = 'flex-' . $layout_slug;

    // add background classes
    if ($bg_color) {
      $css_classlist[] = $bg_color;
    }

    // add classes based on top padding
    if ($padding_top) {
      $css_classlist[] = $config['css']['padding_top'];
    } else {
      $css_classlist[] = $config['css']['padding_top_none'];
    }

    // add classes based on bottom padding
    if ($padding_bottom) {
      $css_classlist[] = $config['css']['padding_bottom'];
    } else {
      $css_classlist[] = $config['css']['padding_bottom_none'];
    }

    // add from space separated list on flex
    // these are added last, so they should override any auto-generated classes
    if ($content['section_classes']) {
      $css_classlist = array_merge($css_classlist, explode(' ', $content['section_classes']));
    }

    // Get dynamic featured content posts
    if ($layout === 'featured_content') {
      if ($content['relationship_method'] == 'dynamic') {
        $args = new WP_Query([
          'posts_per_page' => -1,
          'post_status' => 'publish',
        ]);
        if ($content['post_filter'] == 'category') {
          $args['category__in'] = $content['post_categories'];
        } elseif ($content['post_filter'] == 'tag') {
          $args['tag__in'] = $content['post_tags'];
        }
        $posts = new Timber\PostQuery($args);
        if ($posts) {
          $content['fc_posts'] = $posts;
        }
      }
    }

    $content['css_classlist_arr'] = $css_classlist;
    $content['css_classlist'] = implode(' ', $css_classlist);
    $content['bg_color'] = $bg_color;
    $content['item_slug'] = $item_slug;
    $content['padding_top'] = $padding_top;
    $content['padding_bottom'] = $padding_bottom;
    $content['flex_id'] = $flex_id;
    $content['flex_index'] = $flex_index;
  }

  return (object) [
    'content' => $flex,
    'script_loader' => $script_loader,
  ];
}
