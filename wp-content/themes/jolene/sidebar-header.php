<?php
/**
 * The sidebar containing the header right widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */
?>
	
<?php if ( is_active_sidebar( 'sidebar-8' ) ) : ?>

	<div class="sidebar-header-right">
		<div class="widget-area">
			<?php dynamic_sidebar( 'sidebar-8' ); ?>
		</div><!-- .widget-area -->
	</div><!-- .sidebar-header-right -->
	
	<?php else :
		$defaults = jolene_get_defaults();
		if ( get_theme_mod( 'is_empty_8_on', $defaults['is_empty_8_on'] ) == 1 ) : ?>
		<div class="sidebar-header-right">
			<div class="widget-area">
				<?php do_action('jolene_empty_sidebar_8');  ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-header-right -->
	<?php endif;
endif; ?>
	
