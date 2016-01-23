<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */
?>
<div class="content-container">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<?php if ( ! is_search() ) :

				jolene_post_thumbnail_small();
				
			endif; 
			
			if ( is_single() ) :

				the_title( '<h1 class="entry-title">', '</h1>' );		
				
			else : 
			
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
	
			endif;
			
			jolene_post_thumbnail_big();
			
			?>

			
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __('<div class="meta-nav">Read more... &rarr;</div>', 'jolene' )); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'jolene'), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		<div class="clear"></div>
		<footer class="entry-meta">
			<span class="post-date">
				<?php jolene_posted_on(); ?>
			</span>
			<div class="tags">
				<?php echo get_the_tag_list('', ', ');?>
			</div>
			<?php edit_post_link( __( 'Edit', 'jolene' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
		<?php if ( is_single() ) :
				get_sidebar('content');
			  endif; 
		?>
		
	</article><!-- #post -->
</div><!-- .content-container -->