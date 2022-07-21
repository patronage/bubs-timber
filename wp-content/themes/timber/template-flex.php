<?php

/*
Template Name: Flex
*/

$data = Timber::get_context();
$post = new Timber\Post();

$data['post'] = $post;

Timber::render('template-flex.twig', $data);
