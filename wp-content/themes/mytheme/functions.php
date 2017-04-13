<?php

/* Include scripts */
function my_first_theme_script_enqueue(){    //naziv funckije mora biti jedinstven
  //css
  wp_enqueue_style('bootstrap' ,'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), '1.0.0', 'all');
  wp_enqueue_style( 'mystyle', get_template_directory_uri() . '/css/main.css', array(), '1.0.0', 'all');
  /* poslednji argument za import java scripta sluzi za brikaz u footer-u (true) ili header-u (false) */
  // wp_enqueue_script('jquery');
  /* wordpress-ov native jquery se dodaje u header sto sajt cini sporijim */
  /* ovaj nacin je bolji */
  //js
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js', false, null, true );
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script('bootstrap' ,'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', false, null, true);
  wp_enqueue_script( 'myjavascript', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'my_first_theme_script_enqueue');

/* Adding theme support */
function my_theme_setup(){

  add_theme_support('menus');

  register_nav_menu('header', 'Header Menu');
  register_nav_menu('footer', 'Footer Menu');
}
/* mora da se zakaci ili na init ili na afyer_setup_theme */
add_action( 'init', 'my_theme_setup');

add_theme_support('custom-background');
add_theme_support('custom-header');
add_theme_support('post-thumbnails');
add_theme_support('post-formats', array('aside', 'image', 'video'));

//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js
//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js
