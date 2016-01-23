<?php
/**
 * The template for displaying all pages
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */

get_header(); ?>

	<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
	?>

<?php
get_footer();
