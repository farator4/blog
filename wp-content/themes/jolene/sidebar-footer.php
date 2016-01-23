<?php
/**
 * The sidebar containing the footer widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 */
?>

<?php if ( is_active_sidebar( 'sidebar-6' ) ) : ?>

	<div class="sidebar-footer">
		<div class="widget-area">
			<?php dynamic_sidebar( 'sidebar-6' ); ?>
			<div class="clear"></div>
		</div><!-- .widget-area -->
	</div><!-- .sidebar-footer -->
	
	<?php else :
		$defaults = jolene_get_defaults();
		if ( get_theme_mod( 'is_empty_6_on', $defaults['is_empty_6_on'] ) == 1 ) : ?>
		<div class="sidebar-footer">
			<div class="widget-area">
				<?php do_action('jolene_empty_sidebar_6'); ?>
			<div class="clear"></div>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-footer -->
	<?php endif;
	
endif; ?>
	