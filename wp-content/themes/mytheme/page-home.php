<?php get_header(); ?>

<div class="row">

     <?php
    //  $lastBlog = new WP_Query('type=post&posts_per_page=-1&cat=7');
     //
    //  if ($lastBlog->have_posts()) :
     //
    //    while ($lastBlog->have_posts()) : $lastBlog->the_post();
     //
    //      get_template_part('content', get_post_format());
     //
    //    endwhile;
     //
    //  endif;
     //
    //  wp_reset_postdata();
      ?>

      <div id="my-theme-carousel" class="carousel slide" data-ride="carousel">


        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <?php
            $args_cat = array(
              'include' => '1, 6, 7',
            );

            $categories = get_categories($args_cat);
            $i = 0;
            $bullet = '';
            foreach ($categories as $category):

              $args = array(
                'type' => 'post',
                'posts_per_page' => 1,
                'category__in' => $category->term_id,
                // 'category__not_in' => array()
              );
              $lastBlog = new WP_Query($args);

              if ($lastBlog->have_posts()) :

                while ($lastBlog->have_posts()) : $lastBlog->the_post(); ?>

                    <div class="item <?php if($i == 0): echo 'active'; endif; ?>">
                      <?php the_post_thumbnail('full') ?>
                      <div class="carousel-caption">
                        <?php the_title( sprintf('<h1 class="entry-title"><a href="%s">', esc_url(get_permalink())), '</a></h1>'); ?>
                        <small><?php the_category(', '); ?></small>
                      </div>
                    </div>

              <?php
                    $active = '';
                    if($i == 0):
                    $active = 'active';
                    endif;
                    $bullet .= '<li data-target="#my-theme-carousel" data-slide-to="' . $i . '" class="' . $active . '"></li>';

                endwhile;
              endif;

              wp_reset_postdata();
              $i++;
            endforeach;

           ?>

           <!-- Indicators -->
           <ol class="carousel-indicators">

             <?php echo $bullet; ?>
           </ol>

        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#my-theme-carousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#my-theme-carousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <!-- <hr> -->
</div>

<div class="row">

  <div class="col-xs-12 col-sm-8">

    <?php if (have_posts()) :

            while (have_posts()) : the_post();

              get_template_part('content', get_post_format());

            endwhile;

          endif;

          // $args = array(
          //   'type' => 'post',
          //   'post_per_page' => 2,
          //   'offset' => 1
          // );
          //
          // $lastBlog = new WP_Query($args);
          //
          // if ($lastBlog->have_posts()) :
          //
          //   while ($lastBlog->have_posts()) : $lastBlog->the_post();
          //
          //     get_template_part('content', get_post_format());
          //
          //   endwhile;
          //
          // endif;
          //
          // wp_reset_postdata();

      ?>
  </div>
  <div class="col-xs-12 col-sm-4">
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>
