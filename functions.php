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
      'name'          => 'Soutenir Istex',
      'id'            => 'soutenir_istex',
      'description'   => 'faire le lien de la page chercheur vers la page responsable',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '<h2>',
      'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'istexinfo_widgets_init' );
