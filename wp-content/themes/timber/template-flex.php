<?php

/*
Template Name: Flex
Template Post Type: page, post
*/

$data = Timber::get_context();
$post = new Timber\Post();

$data['post'] = $post;

Timber::render('template-flex.twig', $data);
