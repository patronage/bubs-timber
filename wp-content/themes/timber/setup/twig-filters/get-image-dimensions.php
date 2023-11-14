<?php
function get_image_dimensions($attachment_id, $size_name) {
  // todo: instead of filter, we should extend timbner
  // https://timber.github.io/docs/v2/guides/extending-timber/#extending-timber-classes

  $image_meta = wp_get_attachment_metadata($attachment_id);
  $meta_key = 'theiaSmartThumbnails_position'; // the meta key used in the PostOptions class
  $focus_point = get_post_meta($attachment_id, $meta_key, true);

  if ($focus_point) {
    $focusPointX = round($focus_point[0], 4);
    $focusPointY = round($focus_point[1], 4);
  }
  // error_log('focus_point: ' . print_r($focus_point, true));
  // error_log('image_meta: ' . print_r($image_meta, true));

  if (isset($image_meta['sizes'][$size_name])) {
    if ($focus_point) {
      $focusPointX = round($focus_point[0], 4);
      $focusPointY = round($focus_point[1], 4);
      $focalPercentX = round($focusPointX * 100, 2);
      $focalPercentY = round($focusPointY * 100, 2);
      $image_meta['sizes'][$size_name]['focal'] = [
        'x' => isset($focusPointX) ? $focusPointX : null,
        'y' => isset($focusPointY) ? $focusPointY : null,
        'tailwind_class' => "[$focalPercentX%_$focalPercentY%]",
      ];
    }

    return $image_meta['sizes'][$size_name];
  } else {
    // Check if image meta width and height exist. If so, return, else null
    if (isset($image_meta['width']) && isset($image_meta['height'])) {
      return [
        'width' => $image_meta['width'],
        'height' => $image_meta['height'],
      ];
    } else {
      return null;
    }
  }
}
?>