<?php
/**
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$templates = ['search.twig', 'archive.twig', 'index.twig'];
$data = Timber::get_context();

$data['title'] = 'Search results for ' . get_search_query();
$data['post_parent'] = Timber::get_post(10);
$data['posts'] = Timber::get_posts();

Timber::render($templates, $data);
