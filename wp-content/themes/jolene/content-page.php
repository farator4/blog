<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */
?>
<div class="content-container">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<?php jolene_post_thumbnail_small();?>

			<?php the_title( '<h1 class="entry-title">', '</h1>' );	?>
			
			<?php jolene_post_thumbnail_big();?>
										
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
				the_content();
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'jolene' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
			?>
			<div class="clear"></div>
			<footer class="entry-meta">
				<?php edit_post_link( __( 'Edit', 'jolene' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-meta -->
		</div><!-- .entry-content -->
	</article><!-- #post-## -->
</div><!-- .content-container -->