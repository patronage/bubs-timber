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
    $next_color = null;
    if (isset($flex[$index + 1])) {
      $next_color =
        $flex[$index + 1]['background_color'] === 'default'
          ? $config['default_background_color']
          : 'bg-' . $flex[$index + 1]['background_color'];
    }

    if ($bg_color === $next_color) {
      $padding_bottom = false;
    }

    // allow certain individual flex modules to override padding
    // it will either be a callable function, or the value to use
    if (array_key_exists($layout, $config['custom_padding'])) {
      if (is_callable($config['custom_padding'][$layout])) {
        // If the value is a function, call it
        $padding_top = call_user_func($config['custom_padding'][$layout], $content);
        $padding_bottom = call_user_func($config['custom_padding'][$layout], $content);
      } else {
        // If the value is not a function, use it as is
        $padding_top = $config['custom_padding'][$layout];
        $padding_bottom = $config['custom_padding'][$layout];
      }
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
      if (function_exists('processFeaturedContent')) {
        [$fc_posts, $fc_args] = processFeaturedContent($content);
        $content['fc_posts'] = $fc_posts;
        $content['fc_args'] = $fc_args;
      } else {
        $content['fc_posts'] = [];
        // error_log('processFeaturedContent function not found');
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
