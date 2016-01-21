<?php
/**
 * The main template file.
 * @package LeatherDiary
 * @since LeatherDiary 1.0.0
*/
get_header(); ?>
  
  <div id="main-content">
    <div id="content">
<?php if ($leatherdiary_options_db['leatherdiary_display_latest_posts'] != 'Hide'){ ?> 
    <section class="home-latest-posts">     
      <h2 class="entry-headline"><?php if($leatherdiary_options_db['leatherdiary_latest_posts_headline'] == '') { ?><?php _e( 'Latest Posts' , 'leatherdiary' ); ?><?php } else { echo $leatherdiary_options_db['leatherdiary_latest_posts_headline']; } ?></h2>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>      
<?php get_template_part( 'content', 'archives' ); ?>
<?php endwhile; endif; ?>
<?php leatherdiary_content_nav( 'nav-below' ); ?>
    </section>
<?php } ?>
<?php if ( dynamic_sidebar( 'sidebar-7' ) ) : else : ?>
<?php endif; ?>   
    </div> <!-- end of content -->
<?php if ($leatherdiary_options_db['leatherdiary_display_sidebar_archive'] == 'Display'){ ?> 
<?php get_sidebar(); ?>
<?php } ?>
  </div> <!-- end of main-content -->
<?php get_footer(); ?>