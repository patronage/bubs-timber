<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();
$args = [
  'name' => 'not-found',
  'post_type' => 'page',
  'post_status' => 'publish',
  'numberposts' => 1,
];
$timber_post = Timber::get_post($args);

if ($timber_post) {
  $context['post'] = $timber_post;
} else {
  $context['post']['title'] = '404 - Page Not Found';
  $context['post']['post_title'] = '404 - Page Not Found';
  $context['post']['content'] = 'The page you are looking for does not exist.';
}

Timber::render(['404.twig', 'page.twig'], $context);