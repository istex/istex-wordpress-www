<?php
$context = Timber::get_context();
// Set a home page variable
$context['is_home'] = 'true';
Timber::render('index.twig', $context);
// print_r($context);
