<?php
/**
 * The template for displaying Comments
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
	
	<h2 class="comments-title">

		<?php
			printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'jolene' ),
				number_format_i18n( get_comments_number() ), get_the_title() );
		?>
	</h2>

	<ol class="comment-list">
		<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 34,
			) );
		?>
	</ol><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'jolene' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'jolene' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'jolene' ) ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; ?>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.', 'jolene' ); ?></p>
	<?php endif; ?>

	<?php endif; ?>


	<?php comment_form(); ?>

</div><!-- #comments -->
