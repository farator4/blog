<?php
/**
 * The archive template file.
 * @package LeatherDiary
 * @since LeatherDiary 1.0.0
*/
get_header(); ?>
  
  <div id="main-content">
    <div class="breadcrumb-navigation-wrapper"><?php leatherdiary_get_breadcrumb(); ?></div>
    <div id="content"> 
<?php if ( have_posts() ) : ?>     
      <h1 class="entry-headline"><?php
					if ( is_day() ) :
						printf( __( 'Daily Archive: %s', 'leatherdiary' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archive: %s', 'leatherdiary' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'leatherdiary' ) ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archive: %s', 'leatherdiary' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'leatherdiary' ) ) . '</span>' );
					else :
						_e( 'Archive', 'leatherdiary' );
					endif;
				?></h1>
<?php while (have_posts()) : the_post(); ?>      
<?php get_template_part( 'content', 'archives' ); ?>
<?php endwhile; endif; ?>
<?php leatherdiary_content_nav( 'nav-below' ); ?> 
    </div> <!-- end of content -->
<?php if ($leatherdiary_options_db['leatherdiary_display_sidebar_archive'] == 'Display'){ ?> 
<?php get_sidebar(); ?>
<?php } ?>
  </div> <!-- end of main-content -->
<?php get_footer(); ?>