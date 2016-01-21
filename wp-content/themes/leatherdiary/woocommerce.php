<?php
/**
 * The WooCommerce pages template file.
 * @package LeatherDiary
 * @since LeatherDiary 1.2.0
*/
get_header(); ?>
  
  <div id="main-content">
    <div class="breadcrumb-navigation-wrapper"><?php leatherdiary_get_breadcrumb(); ?></div>
    <article id="content"> 
      <h1 class="main-headline"><?php if ( !is_product() ) { woocommerce_page_title(); } else { the_title(); } ?></h1>
      <div class="entry-content">
<?php woocommerce_content(); ?>
      </div>
    </article> <!-- end of content -->
<?php if ($leatherdiary_options_db['leatherdiary_display_sidebar_pages'] != 'Hide'){ ?> 
<?php get_sidebar(); ?>
<?php } ?>
  </div> <!-- end of main-content -->
<?php get_footer(); ?>