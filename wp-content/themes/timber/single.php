<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$data = Timber::get_context();
$post = Timber::query_post();
$data['post'] = $post;
$data['wp_title'] .= ' - ' . $post->title();
$data['comment_form'] = TimberHelper::get_comment_form();

if (post_password_required($post->ID)) {
    Timber::render('single-password.twig', $context);
} else {
    Timber::render(
        [
            'single-' . $post->ID . '.twig',
            'single-' . $post->post_type . '.twig',
            'single.twig',
        ],
        $data,
    );
}
