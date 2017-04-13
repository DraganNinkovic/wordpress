<?php get_header() ?>

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>
    <h1>About Page</h1>
		<p>page-about-us.php</p>
		<h3><?php the_title(); ?></h3>
    <small>Posted on: <?php the_time('F j, Y'); ?> at <?php the_time(); ?>, in <?php the_category(); ?></small>
    <p><?php the_content(); ?></p>
    <hr>

	<?php endwhile; ?>

		<?php // Navigation ?>

	<?php else : ?>

		<?php // No Posts Found ?>

<?php endif; ?>

<?php get_footer() ?>
