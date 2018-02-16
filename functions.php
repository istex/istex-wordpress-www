<?php
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
}
/*menus*/
register_nav_menus( array(
  'principal'=> __( 'Principal' ),
  'social'   => __( 'Liens sociaux' ),
  'footer'   => __( 'Footer' ),
) );
add_filter( 'timber_context', 'add_to_context' );

function add_to_context ($context){
	$context['principal'] = new TimberMenu( 'principal' );
  $context['social'] = new TimberMenu( 'social' );
  $context['footer'] = new TimberMenu( 'footer' );
	return $context;
}
/*widgets*/
function istexinfo_widgets_init() {
  register_sidebar( array(
      'name'          => 'Voir Soutenir Istex',
      'id'            => 'soutenir_istex',
      'description'   => 'faire le lien de la page chercheur vers la page responsable',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '<h2>',
      'after_title'   => '</h2>',
  ) );
  register_sidebar( array(
      'name'          => 'Voir profil chercheur',
      'id'            => 'voir_page_chercheur',
      'description'   => 'faire le lien de la page responsable vers la page chercheur',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '<h2>',
      'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'istexinfo_widgets_init' );

/* Autoriser le telechargement de  .SVG */
function wpc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'wpc_mime_types');
/*make functions available in Twig (https://timber.github.io/docs/guides/functions/)*/
/**
