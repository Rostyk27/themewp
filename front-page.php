<?php get_header(); ?>

<section class="top_panel primary_panel" style="<?php echo (has_post_thumbnail() ? image_src( get_post_thumbnail_id( $post->ID ), 'full', true ) : 'background-image: url('. theme('images/top_primary.jpg') .')'); ?>">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<?php if (have_posts()) : while (have_posts()) : the_post(); if ( get_the_content() ) : ?>
    <section class="content container">
		<?php the_content(); ?>
    </section>
<?php endif; endwhile; endif; ?>

<?php get_footer(); ?>
