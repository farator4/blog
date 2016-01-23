<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */

// Retrieve attachment metadata.
$metadata = wp_get_attachment_metadata();

get_header();
?>

<?php
	while ( have_posts() ) : the_post();
?>
		<div class="content-container">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
				
					<span class="post-date">
						<?php printf(
							 __( '%1$s', 'jolene' ),
							esc_html( get_the_date() )
						);	
						?>
					</span>
				
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						<span class="full-size-link"><a href="<?php echo wp_get_attachment_url(); ?>"><?php echo $metadata['width']; ?> &times; <?php echo $metadata['height']; ?></a></span>
						
				</header><!-- .entry-header -->

				<div class="entry-content">
					<div class="entry-attachment">
						<div class="attachment">
							<?php jolene_the_attached_image(); ?>
						</div><!-- .attachment -->

						<?php if ( has_excerpt() ) : ?>
						<div class="entry-caption">
							<?php the_excerpt(); ?>
						</div><!-- .entry-caption -->
						<?php endif; ?>
					</div><!-- .entry-attachment -->

					<?php
						the_content();
						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'jolene' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
					?>
				</div><!-- .entry-content -->
				<div class="entry-meta">
					<?php edit_post_link( __( 'Edit', 'jolene' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-meta -->
			</article><!-- #post-## -->

		</div><!-- .content-container -->

		<nav id="image-navigation" class="navigation image-navigation">
			<div class="nav-links">
			<?php previous_image_link( false, '<div class="previous-image">&larr; ' . __( 'Previous Image', 'jolene' ) . '</div>' ); ?>
			<?php next_image_link( false, '<div class="next-image">' . __( 'Next Image &rarr;', 'jolene' ) . '</div>' ); ?>
			</div><!-- .nav-links -->
		</nav><!-- #image-navigation -->

		<?php comments_template(); ?>
	<?php endwhile; ?>

<?php
get_footer();
