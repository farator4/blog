<?php
/**
 * The author archive template file.
 * @package LeatherDiary
 * @since LeatherDiary 1.0.0
*/
get_header(); ?>
  
  <div id="main-content">
    <div class="breadcrumb-navigation-wrapper"><?php leatherdiary_get_breadcrumb(); ?></div>
    <div id="content">
<?php if ( have_posts() ) : ?>
<?php the_post(); ?>      
      <h1 class="entry-headline"><?php printf( __( 'Author Archive: %s', 'leatherdiary' ), '<span class="vcard">' . get_the_author() . '</span>' ); ?></h1>

<?php rewind_posts(); ?>        
<?php if ( get_the_author_meta( 'description' ) ) : ?>
		<div class="author-info">
		<div class="author-description">
			<h2><?php printf( __( 'About %s', 'leatherdiary' ), get_the_author() ); ?></h2>
      <div class="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'leatherdiary_author_bio_avatar_size', 60 ) ); ?>
		  </div>
			<p><?php the_author_meta( 'description' ); ?></p>
		</div>
		</div>
<?php endif; ?>

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