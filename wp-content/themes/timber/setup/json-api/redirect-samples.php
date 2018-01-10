<?php
// inspired from: https://github.com/postlight/headless-wp-starter/blob/master/wordpress/wp-content/themes/postlight-headless-wp/index.php
// Redirect individual post and pages to the REST API endpoint

// To auto redirect pages and posts to the their json data
// in page.php (or a page template), to redirect, for example, from /sample-page to it's json   for example:
// add to the bottom of page.php:
// header( 'Location: /wp-json/wp/v2/pages/' . get_queried_object()->ID );

// Similarly in single.php to redirect from /posts/some-post to  the json for it
//  header( 'Location: /wp-json/wp/v2/posts/' . get_post()->ID );
