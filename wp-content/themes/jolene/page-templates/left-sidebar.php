<?php
/**
 * Template Name: Left Sidebar
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */
 __( 'Left Sidebar', 'jolene' );
 
get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'page' ); ?>

	<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>