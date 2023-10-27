<?php

//
// Better calculation of srcset pairs based on aspect ratio.
// //
function bubs_image_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id) {
  // Initialize a new $filtered_sources array
  $filtered_sources = [];

  // Calculate url
  $upload_dir = wp_upload_dir();
  $base_url = $upload_dir['baseurl'];
  // Extract year and month from $image_meta
  $path_parts = pathinfo($image_meta['file']);
  $year_month = dirname($image_meta['file']);

  // Debugging existing sources // Debugging other parameters
  // error_log('Existing sources: ' . print_r($sources, true));
  // error_log('Size array: ' . print_r($size_array, true));
  // error_log('Image meta: ' . print_r($image_meta, true));

  // Calculate the target aspect ratio from the size array
  if (isset($size_array[0]) && isset($size_array[1]) && is_int($size_array[0]) && is_int($size_array[1])) {
    $target_aspect_ratio = $size_array[0] / $size_array[1];
  } else {
    return $sources;
  }

  // Loop through all sizes and compare aspect ratios
  foreach ($image_meta['sizes'] as $size_name => $size_data) {
    $width = $size_data['width'];
    $height = $size_data['height'];
    $aspect_ratio = $width / $height;

    // If the aspect ratio closely matches, add to $filtered_sources
    if (abs($aspect_ratio - $target_aspect_ratio) < 0.01) {
      $url = $base_url . '/' . $year_month . '/' . $size_data['file'];
      $filtered_sources[$width] = ['url' => $url, 'descriptor' => 'w', 'value' => $width];
    }
  }

  // Debugging existing sources
  // error_log('Existing sources: ' . print_r($sources, true));

  // Log or return the filtered sources
  // error_log('Filtered sources: ' . print_r($filtered_sources, true));

  return $filtered_sources;
}
add_filter('wp_calculate_image_srcset', 'bubs_image_srcset', 10, 5);

//
// Don't wrap images attached to WYSIWYG's with links
//

function bubs_imagelink_setup() {
  $image_set = get_option('image_default_link_type');

  if ($image_set !== 'none') {
    update_option('image_default_link_type', 'none');
  }
}
add_action('admin_init', 'bubs_imagelink_setup', 10);
