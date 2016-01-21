<?php
/**
 * Template Name: Page without Comments
 * The template file for pages without the comments section.
 * @package LeatherDiary
 * @since LeatherDiary 1.1.4
*/
get_header(); ?>
  
  <div id="main-content">
    <div class="breadcrumb-navigation-wrapper"><?php leatherdiary_get_breadcrumb(); ?></div>
    <article id="content"> 
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1 class="main-headline"><?php the_title(); ?></h1>
      <div class="entry-content">
<?php leatherdiary_get_display_image_page(); ?>
<?php the_content(); ?>
<?php edit_post_link( __( '(Edit)', 'leatherdiary' ), '<p>', '</p>' ); ?>
<?php wp_link_pages( array( 'before' => '<p class="page-link"><span>' . __( 'Pages:', 'leatherdiary' ) . '</span>', 'after' => '</p>' ) ); ?>
      </div>
<?php endwhile; endif; ?>
    </article> <!-- end of content -->
<?php if ($leatherdiary_options_db['leatherdiary_display_sidebar_pages'] != 'Hide'){ ?> 
<?php get_sidebar(); ?>
<?php } ?>
  </div> <!-- end of main-content -->
<?php get_footer(); ?>