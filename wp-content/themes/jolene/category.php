<?php
/**
 * The template for displaying Category pages
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

	<header class="archive-header">
		<h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'jolene' ), single_cat_title( '', false ) ); ?></h1>
	</header><!-- .archive-header -->

	<?php
			while ( have_posts() ) : the_post();

			get_template_part( 'content', get_post_format() );
			
			endwhile;
			
			jolene_paging_nav();

		else :
		
			get_template_part( 'content', 'none' );

		endif;

get_footer();
