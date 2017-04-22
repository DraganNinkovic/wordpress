<?php

/*
 Plugin Name: Featured Pages
 Description: Select pages that you want to be displayed
 Author: Extraordinary
 */

class MyPlugin extends WP_Widget {
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'featured-page-widget',
			'description' => 'Select pages that you want to be displayed on home page',
		);
		parent::__construct( 'featured_page', 'Featured Pages', $widget_ops );
	}

	// backend view
	public function form( $instance ) {
		$promotional_page = isset( $instance['promotional_page'] ) ? $instance['promotional_page'] : '';

		$pages = get_pages();
		?>
      <p>
          <label for="<?php echo $this->get_field_id( 'promotional_page' ); ?>"><?php _e( 'Select Promotional Page:' ); ?></label>
          <select id="<?php echo $this->get_field_id( 'promotional_page' ); ?>"
                  name="<?php echo $this->get_field_name( 'promotional_page' ); ?>">
              <option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
						<?php foreach ( $pages as $page ) : ?>
                <option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $promotional_page, $page->ID ); ?>>
									<?php echo esc_html( $page->post_title ); ?>
                </option>
						<?php endforeach; ?>
          </select>
      </p>
      <p>
          <label for="<?php echo $this->get_field_id( 'page_ids' ); ?>"><?php _e( 'Select Featured Pages:' ); ?></label>
          <small>Max number of pages is 4</small>
				<?php
				printf(
					'<select multiple="multiple" name="%s[]" id="%s" class="widefat" size="15" style="margin-bottom:10px">',
					$this->get_field_name( 'page_ids' ),
					$this->get_field_id( 'page_ids' )
				);
				?>
				<?php
				foreach ( $pages as $page ) :
					if ($page->post_title != get_the_title( get_option('page_for_posts', true))):
						printf(
							'<option value="%s" %s style="margin-bottom:3px;">%s</option>',
							$page->ID,
							in_array( $page->ID, $instance['page_ids'] ) ? 'selected="selected"' : '',
                            $page->post_title
						);
					endif;
				endforeach;
				?>
          </select>
      </p>
		<?php

	}

	// frontend view
	public function widget( $args, $instance ) {
	    $promotional_page = isset( $instance['promotional_page'] ) ? $instance['promotional_page'] : '';
		$page_ids         = isset( $instance['page_ids'] ) ? $instance['page_ids'] : '';

		$query = array(
			'type'    => 'page',
			'page_id' => $promotional_page,
		);
		$page  = new WP_Query( $query );

		if ( $page->have_posts() ):
			while ( $page->have_posts() ): $page->the_post();
		?>
                <p>Promotional page:</p>
          <li>
						<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
              <a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail( 'full' ) ?></a>
          </li>
				<?php

			endwhile;

		endif;
		wp_reset_postdata();
		?>
      <p>Featured pages:</p>
		<?php
		foreach ( $page_ids as $id ) {
			$query = array(
                'type'    => 'page',
				'page_id' => $id,
				// 'category__not_in' => array()
			);
			$pages = new WP_Query( $query );
			if ( $pages->have_posts() ):
				while ( $pages->have_posts() ): $pages->the_post();
			?>
            <li>
				<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
                <?php
                if(getFeaturedVideo(get_the_ID())):
	                echo getFeaturedVideo(get_the_ID());
                else:
                  ?>
                    <a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail( 'full' ) ?></a>
                <?php
                endif;
                ?>
            </li>
			<?php
			    endwhile;
			endif;
			wp_reset_postdata();
		}
		?>
		<?php
	}
}

function featuredVideo_add_custom_box() {
	add_meta_box(
        'featuredVideo_sectionid',
        'Featured Video',
        'featuredVideo_inner_custom_box',
        'page',
        'side'
    );
}

function featuredVideo_inner_custom_box($post) {
	wp_nonce_field( plugin_basename(__FILE__), 'featuredVideo_noncename');

	// show featured video if it exists
	echo getFeaturedVideo( $post->ID, 260, 120);

	echo '<h4 style="margin: 10px 0 0 0;">URL [YouTube Only]</h4>';
	echo '<input type="text" id="featuredVideoURL_field" name="featuredVideoURL_field" value="'.get_post_meta($post->ID, 'featuredVideoURL', true).'" style="width: 100%;" />';
}

function featuredVideo_save_postdata($post_id) {

	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	// check authorizations
	if ( !wp_verify_nonce( $_POST['featuredVideo_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	// update meta/custom field
	update_post_meta( $post_id, 'featuredVideoURL', $_POST['featuredVideoURL_field'] );
}

/**
 * @param $post_id
 * @param int $width
 * @param int $height
 *
 * @return null
 */
function getFeaturedVideo($post_id, $width = 680, $height = 360) {
	$featuredVideoURL = get_post_meta($post_id, 'featuredVideoURL', true);


	preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $featuredVideoURL, $youTubeMatch);

	if ($youTubeMatch[1])
		return '<iframe width="'.$width.'" height="'.$height.'" src="http://ww'.
		       'w.youtube.com/embed/'.$youTubeMatch[1].'?rel=0&controls=1&showinfo=1&cont'.
		       'rols=0&autoplay=0&modestbranding=1" frameborder="0" allowfulls'.
		       'creen ></iframe>';
	else
		return null;
}

add_action( 'add_meta_boxes', 'featuredVideo_add_custom_box' );
add_action( 'save_post', 'featuredVideo_save_postdata' );

add_action( 'widgets_init', function () {
	register_widget( 'MyPlugin' );
});
