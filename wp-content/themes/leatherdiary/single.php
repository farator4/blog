<?php
/**
 * The post template file.
 * @package LeatherDiary
 * @since LeatherDiary 1.0.0
*/
get_header(); ?>
  
  <div id="main-content">
    <div class="breadcrumb-navigation-wrapper"><?php leatherdiary_get_breadcrumb(); ?></div>
    <article id="content"> 
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1 class="main-headline"><?php the_title(); ?></h1>
<?php if ( $leatherdiary_options_db['leatherdiary_display_meta_post'] != 'Hide' ) { ?>
      <p class="post-info"><span class="post-info-author"><?php the_author_posts_link(); ?></span><span class="post-info-date"><a href="<?php echo get_permalink(); ?>"><?php echo get_the_date(); ?></a></span><span class="post-info-category"><?php the_category(', '); ?></span><?php the_tags( '<span class="post-info-tags">', ', ', '</span>' ); ?></p>
<?php } ?>
      <div class="entry-content">
<?php leatherdiary_get_display_image_post(); ?>
<?php the_content(); ?>
<?php edit_post_link( __( '(Edit)', 'leatherdiary' ), '<p>', '</p>' ); ?>
      </div>
<?php wp_link_pages( array( 'before' => '<p class="page-link"><span>' . __( 'Pages:', 'leatherdiary' ) . '</span>', 'after' => '</p>' ) ); ?>
<?php endwhile; endif; ?>
<?php if (($leatherdiary_options_db['leatherdiary_next_preview_post'] == '') || ($leatherdiary_options_db['leatherdiary_next_preview_post'] == 'Display')) :  leatherdiary_prev_next('leatherdiary-post-nav');  endif; ?>    
<?php comments_template( '', true ); ?>
    </article> <!-- end of content -->
<?php if ($leatherdiary_options_db['leatherdiary_display_sidebar_posts'] != 'Hide'){ ?> 
<?php get_sidebar(); ?>
<?php } ?>
  </div> <!-- end of main-content -->
<?php get_footer(); ?>