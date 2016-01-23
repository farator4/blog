<?php
/**
 * The template for displaying Author archive pages
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */
 
 get_header(); ?>

	<?php if ( have_posts() ) : ?>

	<header class="archive-header">
		<h1 class="archive-title">
					<?php
						the_post();

						printf( __( 'All posts by %s', 'jolene' ), get_the_author() );
					?>
				</h1>
				<?php if ( get_the_author_meta( 'description' ) ) : ?>
				<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
				<?php endif; ?>
	</header><!-- .archive-header -->

	<?php
			rewind_posts();

			while ( have_posts() ) : the_post();

			get_template_part( 'content', get_post_format() );
			
			endwhile;
			
			jolene_paging_nav();

		else :
		
			get_template_part( 'content', 'none' );

		endif;

get_footer();
