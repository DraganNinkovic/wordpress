<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>My First Theme</title>
    <?php wp_head(); ?>
  </head>
  <?php
    if (is_home()) {
        $myClasses = array('my-class', 'theme-class');
    } else {
        $myClasses = array('not-blog-page');
    }
   ?>
  <body <?php body_class($myClasses); ?>>

    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <nav class="navbar navbar-default">
            <div class="container-fluid">
              <div class="navbar-header">
                <a class="navbar-brand" href="#">My Theme</a>
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <?php
                  wp_nav_menu(array(
                    'theme_location' => 'header',
                    'container' => false,
                    'menu_class' => 'nav navbar-nav navbar-right',
                    'walker' => new Walker_Nav_Primary()
                    )
                   );
                 ?>
              </div>
            </nav>
          </div>
          <div class="search-form-container">
            <?php get_search_form(); ?>
          </div>
        </div>

    <img src="<?php header_image(); ?>" height="<?php get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="">
