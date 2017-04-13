<h1>IMAGE</h1>
<h3><?php the_title(); ?></h3>
<div class="thumbnail-image">
  <?php the_post_thumbnail('thumbnail'); ?>
</div>
<small>Posted on: <?php the_time('F j, Y'); ?> at <?php the_time(); ?>, in <?php the_category(); ?></small>
<p><?php the_content(); ?></p>
<hr>
