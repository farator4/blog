<?php
/**
 * The 404 page (Not Found) template file.
 * @package LeatherDiary
 * @since LeatherDiary 1.0.0
*/
get_header(); ?>
  
  <div id="main-content">
    <div class="breadcrumb-navigation-wrapper"><?php leatherdiary_get_breadcrumb(); ?></div>
    <article id="content"> 
      <h1 class="main-headline"><?php _e( 'Nothing Found', 'leatherdiary' ); ?></h1>
      <div class="entry-content">
        <p><?php _e( 'Apologies, but no results were found for your request. Perhaps searching will help you to find a related content.', 'leatherdiary' ); ?></p>
      </div>
    </article> <!-- end of content -->
<?php if ($leatherdiary_options_db['leatherdiary_display_sidebar_pages'] != 'Hide'){ ?> 
<?php get_sidebar(); ?>
<?php } ?>
  </div> <!-- end of main-content -->
<?php get_footer(); ?>