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
add_theme_support('html5', array('search-form'));

/* Sidebar function */
function my_theme_widget_setup(){
  register_sidebar(
    array(
      'name'        => 'Sidebar',
      'id'          => 'sidebar-1',
      'class'       => 'custom',
      'description' => 'Standard sidebar',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>'
  ));
}
add_action('widgets_init', 'my_theme_widget_setup');

/* Include Walker file */
require get_template_directory() . '/inc/walker.php';

/* Head Function */
function my_theme_remove_wp_version(){
  return '';
}
add_filter('the_generator', 'my_theme_remove_wp_version');

/* Custom Post Types */
function my_theme_post_type(){
  $labels = array(
    'name' => 'Portfolio',
    'singular_name' => 'Protfolio',
    'add_new' => 'Add Portfolio',
    'all_items' => 'All Items',
    'add_new_item' => 'Add Item',
    'edit_item' => 'Edit Item',
    'new_item' => 'New Item',
    'view_item' => 'View Item',
    'search_item' => 'Search Portfolio',
    'not_found' => 'No items found',
    'not_fpund_in_trash' => 'No items found in trash',
    'parent_item_colon' => 'Parent Item'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'has_archive' => true,
    'publicly_queryable' =>true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'supports' => array(
                  'title',
                  'editor',
                  'excerpt',
                  'thumbnail',
                  'revisions',
                ),
    // 'taxonomies' => array('category', 'post_tag'),
    'menu_position' => 5,
    'exclude_from_search' => false
  );
  register_post_type('portfolio', $args);
}
add_action('init', 'my_theme_post_type');

function my_theme_custom_taxonomies(){
  //add new taxonomy hierarchical
  $labels = array(
    'name' => 'Types',
    'singular_name' => 'Type',
    'search_items' => 'Search Types',
    'all_items' => 'All Types',
    'parent_item' => 'Parent Type',
    'parent_item_colon' => 'Parent Type:',
    'edit_item' => 'Edit Type',
    'update_item' => 'Update Type',
    'add_new_item' => 'Add New Type',
    'new_item_name' => 'New Type Name',
    'menu_name' => 'Type'
  );

  $args = array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'mytype'),
  );

  register_taxonomy('mytype', array('portfolio'), $args);

  //add new taxonomy NOT hierarchical
  register_taxonomy('software', 'portfolio', array(
    'label' => 'Software',
    'rewrite' => array('slug' => 'software'),
    'hierarchical' => false,
  ));

}
add_action( 'init', 'my_theme_custom_taxonomies');

/* Custom Term Function */
/**
 * Get custom taxsonomies
 * @param  int $id   [description]
 * @param  string $term [description]
 * @return string       [description]
 */
function my_theme_get_terms($id, $term){
  $terms_list = wp_get_post_terms($id, $term);
  $retVal = '';
  $i = 0;
  foreach ($terms_list as $term){
    $i++;
    if($i > 1){
      $output .= ", ";
    }
    $output .= $term->name;
  }
  return $output;
}
