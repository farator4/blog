<?php
/**
 * The template for displaying content of search/archives.
 * @package LeatherDiary
 * @since LeatherDiary 1.0.0
*/
?>
<?php global $leatherdiary_options_db; ?>
      <article <?php post_class('post-entry'); ?>>
        <h2 class="post-entry-headline"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if ( $leatherdiary_options_db['leatherdiary_display_meta_post'] != 'Hide' ) { ?>
        <p class="post-info"><span class="post-info-author"><?php the_author_posts_link(); ?></span><?php if ( $leatherdiary_options_db['leatherdiary_display_fixed_menu'] == 'Hide' || $leatherdiary_options_db['leatherdiary_display_sidebar_archive'] == 'Display' ) { ?><span class="post-info-date"><a href="<?php echo get_permalink(); ?>"><?php echo get_the_date(); ?></a></span><?php } ?><?php if ( comments_open() ) : ?><span class="post-info-comments"><a href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%' ); ?></a></span><?php endif; ?></p>
<?php } ?>
        <div class="post-content">
<?php if ( has_post_thumbnail() ) : ?>
          <a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
<?php endif; ?>
          <div class="post-entry-content"><?php if ( $leatherdiary_options_db['leatherdiary_content_archives'] != 'Excerpt' ) { ?><?php global $more; $more = 0; ?><?php the_content(); ?><?php } else { the_excerpt(); } ?></div>
        </div>
<?php if ( has_category() )  { ?>
        <div class="post-meta"> 
            <p class="post-info post-category"><span class="post-info-category"><?php the_category(', '); ?></span></p>
            <p class="post-info post-tags"><?php the_tags( '<span class="post-info-tags">', ', ', '</span>' ); ?></p>
        </div>
<?php } ?>
<?php if ( $leatherdiary_options_db['leatherdiary_display_sidebar_archive'] != 'Display' )  { ?>
<?php if ( $leatherdiary_options_db['leatherdiary_display_meta_post'] != 'Hide' )  { ?>
        <div class="date-arrow">
          <p class="date-day"><a href="<?php echo get_permalink(); ?>"><?php the_time( 'd' ); ?></a></p>
          <p class="date-month"><a href="<?php echo get_permalink(); ?>"><?php the_time( 'M' ); ?></a></p>
          <p class="date-year"><a href="<?php echo get_permalink(); ?>"><?php the_time( 'Y' ); ?></a></p>
          <div class="bookmark"></div>
          <div class="shadow"></div>
        </div>
<?php }} ?>
      </article>