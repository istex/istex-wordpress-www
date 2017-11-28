<?php
$context = Timber::get_context();
$category = get_the_category();
$context['category'] = Timber::get_terms($category);
$context['category'] = new TimberTerm();
Timber::render('category.twig', $context);
 print_r($context);
