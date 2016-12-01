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

$data = Timber::get_context();
$post = new TimberPost( 1744 ); // Set this to the 404 pages ID
$data['post'] = Timber::get_post('pagename=not-found');

Timber::render( array( '404.twig', 'page.twig' ), $data );
