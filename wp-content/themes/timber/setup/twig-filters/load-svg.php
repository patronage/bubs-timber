<?php
function load_svg($filename, $args = []) {
  // Define a unique transient key based on filename and args
  $transient_key = 'svg_' . md5($filename . serialize($args));

  // Try to get the SVG content from transient
  $svg_content = get_transient($transient_key);

  // If the SVG content is not in the transient, load it from file
  if (false === $svg_content) {
    error_log('generating new svg: ' . $transient_key);
    $file_path = get_template_directory() . '/assets/img/' . $filename . '.svg';
    $svg_content = file_exists($file_path) ? file_get_contents($file_path) : '';

    if (empty($svg_content)) {
      return null;
    }

    // Create a DOMDocument instance and load SVG content
    $doc = new DOMDocument();
    $doc->loadXML($svg_content);

    // Get the SVG root element
    $svg = $doc->getElementsByTagName('svg')->item(0);

    // Set attributes based on provided args
    if (isset($args['class'])) {
      $svg->setAttribute('class', $args['class']);
    }
    if (isset($args['width'])) {
      $svg->setAttribute('width', $args['width']);
    }
    if (isset($args['height'])) {
      $svg->setAttribute('height', $args['height']);
    }
    if (isset($args['fill'])) {
      // Assuming all paths inside SVG should get this fill
      foreach ($doc->getElementsByTagName('path') as $path) {
        $path->setAttribute('fill', $args['fill']);
      }
    }

    // Save the modified SVG content to transient
    $svg_content = $doc->saveXML($svg);
    set_transient($transient_key, $svg_content, HOUR_IN_SECONDS);
  }

  // Return the SVG content
  return $svg_content;
}
?>
