<?php

/*
Template Name: Homepage
*/

$data = Timber::get_context();
$post = new Timber\Post();
$data['post'] = $post;

Timber::render('template-home.twig', $data);

// To get some posts:
// $context['blogs'] = Timber::get_posts('post_type=post&numberposts=3');
