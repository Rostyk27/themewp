<?php

// ajax posts load
function load_posts_ajax($paged = 1) {
	extract($_POST);

	global $post;

	$tax_query = array();

	if( $category != "*" && $category != null ) :
		$tax_query = array_merge($tax_query,array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => array($category)
			),
		));
	endif;

	$args = array(
		'posts_per_page'  => 10,
		'post_type'       => 'post',
		'post_status'     => 'publish',
		'paged'           => $paged,
		'tax_query'       => $tax_query
	);

	$posts_query = new WP_Query( $args );

	$num_pages = $posts_query->max_num_pages;

	if($posts_query->have_posts()) : while ( $posts_query->have_posts() ) : $posts_query->the_post();

		get_template_part('tpl-parts/post-item');

	endwhile;

		if ($num_pages != $paged) :
			echo '<div class="load_more_holder">
                      <a class="button load_more_posts" data-href="'. wp_kses_post(($paged + 1)) .'" data-cat="'. esc_html($category) .'">Load More</a>
                  </div>
                  <div class="loader_holder">'. wp_kses(get_loader(), $GLOBALS['allowed_loader']) .'</div>';
		endif;

	else :
		echo '<div><h5 class="custom_coming_soon">Ooops! Nothing found.</h5></div>';
	endif;

	if (wp_doing_ajax()) :
		wp_die();
	endif;

}
add_action( 'wp_ajax_load_posts_ajax', 'load_posts_ajax');
add_action( 'wp_ajax_nopriv_load_posts_ajax', 'load_posts_ajax');