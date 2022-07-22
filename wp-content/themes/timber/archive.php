<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

$templates = ['archive.twig', 'index.twig'];

$data = Timber::get_context();

$data['title'] = 'Archive';
if (is_day()) {
    $data['title'] = 'Archive: ' . get_the_date('D M Y');
} elseif (is_month()) {
    $data['title'] = 'Archive: ' . get_the_date('M Y');
} elseif (is_year()) {
    $data['title'] = 'Archive: ' . get_the_date('Y');
} elseif (is_tag()) {
    $data['title'] = single_tag_title('', false);
} elseif (is_category()) {
    $data['title'] = single_cat_title('', false);
    $data['term'] = new TimberTerm();
    array_unshift($templates, 'archive-' . get_query_var('cat') . '.twig');
} elseif (is_tax()) {
    $data['title'] = single_cat_title('', false);
    $data['term'] = new TimberTerm();
    array_unshift($templates, 'archive-' . get_query_var('cat') . '.twig');
} elseif (is_post_type_archive()) {
    $data['title'] = post_type_archive_title('', false);
    array_unshift($templates, 'archive-' . get_post_type() . '.twig');
}

$data['posts'] = Timber::get_posts();
$data['pagination'] = Timber::get_pagination();

Timber::render($templates, $data);
