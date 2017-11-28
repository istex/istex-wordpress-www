<?php
/*Template Name: Accueil_Chercheur*/
$context = Timber::get_context();
$context['postschercheurs'] = Timber::get_posts(array('category_name' => 'services_chercheurs' ));
$context['postsusages'] = Timber::get_posts(array('category_name' => 'chantiers_usage' ));
$context['termservices'] = new TimberTerm(3);
$context['termusages'] = new TimberTerm(6);
$context['is_home_profil'] = 'true';
$context['dynamic_sidebar'] = Timber::get_widgets('soutenir_istex');
Timber::render('accueil_chercheur.twig', $context);
//print_r($context);
