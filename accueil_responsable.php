<?php
/*Template Name: Accueil_Responsable*/
$context = Timber::get_context();
$context['postsservices'] = Timber::get_posts(array('category_name' => 'services_institutions' ));
$context['termservices'] = new TimberTerm(4);
$context['postsresponsables'] = Timber::get_posts(array('category_name' => 'responsables' ));
$context['termresponsables'] = new TimberTerm(10);
$context['postssoutenez'] = Timber::get_posts(array('category_name' => 'soutenez_istex' ));
$context['termsoutenez'] = new TimberTerm(11);
$context['is_home_profil'] = 'true';
Timber::render('accueil_responsable.twig', $context);
//print_r($context);
