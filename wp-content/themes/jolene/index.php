<?php
/**
 * The template for displaying all pages
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */

get_header(); 
		
		if ( have_posts() ) : 
		
			while ( have_posts() ) : the_post();

				get_template_part( 'content', get_post_format() );
				
			endwhile; 

			jolene_paging_nav();
			
			 else : 

				get_template_part( 'content', 'none' );

		endif;

get_footer();