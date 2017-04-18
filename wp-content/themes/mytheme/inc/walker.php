<?php

/* Collection of Walker classes */

/*
   wp_nav_menu();
   <div class="menu-container">
    <ul> //start level (start_lvl())

      <li><a href="#">Link</a><span> // start element (start_el())

      </span></li> // end element (end_el())

      <li><a href="#">Link</a></li>
      <li><a href="#">Link</a></li>
      <li><a href="#">Link</a></li>

    </ul> // end level (end_lvl())
   </div>
 */

/**
 *
 */
class Walker_Nav_Primary extends Walker_Nav_Menu
{
  function start_lvl(&$output, $depth){ // ul
    $indent = str_repeat("\t", $depth);
    $submenu = ($depth > 0) ? 'sub-menu' : '';
    $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0){ // li a span
    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $li_attribute = '';
    $class_names = $value = '';

    $classes = empty($item->classes) ? array() : (array)$item->classes;

    $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
    $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
    $classes[] = 'menu-item-' . $item->ID;
    if($depth && $args->has_children){
      $classes[] = 'dopdown-submenu';
    }

    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
    $class_names = ' class="' . esc_attr($class_names). '"';

    $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->id, $item, $args);
    $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names . $li_atrributes . '>';
    // 30:00 minut 15. lekcije
  }

  // function end_el(){ // closing li a span
    //end element
  // }

  // function end_lvl(){ // closing ul
    // end level
  // }


}
