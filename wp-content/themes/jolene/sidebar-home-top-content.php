<?php
/**
 * The sidebar containing the content widget area for home page
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */

if ( ! is_active_sidebar( 'sidebar-11' ) )
	return;
?>
<?php if ( is_active_sidebar( 'sidebar-11' ) ) : ?>
	<div class="home sidebar-content">
		<div class="widget-area">
			<?php dynamic_sidebar( 'sidebar-11' ); ?>
		</div><!-- .widget-area -->
	</div><!-- .sidebar-top -->
<?php endif; ?>
