<?php

/*
Template Name: Homepage
*/

$data = Timber::get_context();
$home = new TimberPost();

$data['home'] = $home;

Timber::render('template-home.twig', $data);

// To get some posts:
// $context['blogs'] = Timber::get_posts('post_type=post&numberposts=3');
