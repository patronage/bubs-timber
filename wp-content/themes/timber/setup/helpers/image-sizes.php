<?php

//
// Default Thumbnail Size
//

// We want to use a social friendly ratio for preview
// This image is also used as the SEO default
// If you need a different size image for a post, add it as an option below
// And add it via an ACF image field

// Default thumb in social ratio
set_post_thumbnail_size(320, 168, true);

//
// Image Resizing
//

// custom image sizes (used to provide thumnail sizes for ACF)
// Width only crops
add_image_size('300 wide', 300, 9999, false);
add_image_size('600 wide', 600, 9999, false);
add_image_size('1600 wide', 1600, 9999, false);

// Forced Aspect Ratio width/height cropping
// Be careful relying on these, WordPress won't enlarge (zoom) by default
// if an uploaded dimension is smaller than the target.
// Theia Smart Thumbnails has an option to enlarge which we typically use to fix this.

// Social is our default thumb, and gives us a single image size that can be used both for social embeds and on site
add_image_size('Social', 1536, 810, true);
add_image_size('Social Large', 1280, 672, true);
add_image_size('Social Medium', 768, 403, true);
// for smaller, we also have the default thumb

// Square optional
// add_image_size('Square', 1200, 1200, true);
// add_image_size('Square Medium', 768, 768, true);
// add_image_size('Square Thumb', 320, 320, true);

//
// Remove the WP additional sizes in favor of ours
//

// https://bloggerpilot.com/en/disable-wordpress-image-sizes/

add_filter('intermediate_image_sizes', function ($sizes) {
  return array_diff($sizes, ['medium_large']); // Medium Large (768 x 0)
});

add_action('init', 'bubs_remove_large_image_sizes');

function bubs_remove_large_image_sizes() {
  remove_image_size('1536x1536'); // 2 x Medium Large (1536 x 1536)
  remove_image_size('2048x2048'); // 2 x Large (2048 x 2048)
}