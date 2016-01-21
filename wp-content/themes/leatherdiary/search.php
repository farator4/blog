<?php
/**
 * The search results template file.
 * @package LeatherDiary
 * @since LeatherDiary 1.0.0
*/
get_header(); ?>
  
  <div id="main-content">
    <div class="breadcrumb-navigation-wrapper"><?php leatherdiary_get_breadcrumb(); ?></div>
    <div id="content"> 
<?php if ( have_posts() ) : ?>     
      <h1 class="entry-headline"><?php printf( __( 'Search Results for: %s', 'leatherdiary' ), '<span>' . get_search_query() . '</span>' ); ?><span class="headline-underline"></span></h1>
      <p class="number-of-results"><?php _e( '<strong>Number of Results</strong>: ', 'leatherdiary' ); ?><?php echo $wp_query->found_posts; ?></p>
<?php while (have_posts()) : the_post(); ?>      
<?php get_template_part( 'content', 'archives' ); ?>
<?php endwhile; ?>

<?php if ( $wp_query->max_num_pages > 1 ) : ?>
		<div class="navigation" role="navigation">
			<h2 class="navigation-headline section-heading"><?php _e( 'Search results navigation', 'leatherdiary' ); ?></h2>
      <p class="navigation-links">
<?php $big = 999999999;
echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
  'prev_text' => __( '&larr; Previous', 'leatherdiary' ),
	'next_text' => __( 'Next &rarr;', 'leatherdiary' ),
	'total' => $wp_query->max_num_pages,
	'add_args' => false
) );
?>
      </p>
		</div>
<?php endif; ?>
 
<?php else : ?>
    <h1 class="entry-headline"><?php _e( 'Nothing Found', 'leatherdiary' ); ?><span class="headline-underline"></span></h1>
    <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'leatherdiary' ); ?></p>
<?php endif; ?>
    </div> <!-- end of content -->
<?php if ($leatherdiary_options_db['leatherdiary_display_sidebar_archive'] == 'Display'){ ?>
<?php get_sidebar(); ?>
<?php } ?>
  </div> <!-- end of main-content -->
<?php get_footer(); ?>