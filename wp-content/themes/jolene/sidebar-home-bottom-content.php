<?php
/**
 * The sidebar containing the second content widget area for home page
 *
 * If no active widgets are in the sidebar, hide it completely.
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */

if ( ! is_active_sidebar( 'sidebar-12' ) )
	return;
?>
<?php if ( is_active_sidebar( 'sidebar-12' ) ) : ?>
	<div class="home sidebar-content">
		<div class="widget-area">
			<?php dynamic_sidebar( 'sidebar-12' ); ?>
		</div><!-- .widget-area -->
	</div><!-- .sidebar-top -->
<?php endif; ?>
