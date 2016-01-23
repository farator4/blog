<?php
/**
 * The sidebar containing the before footer widget area.
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */
	$defaults = jolene_get_defaults();
?>

<?php if( get_theme_mod( 'is_has_mobile_sidebar', $defaults['is_has_mobile_sidebar'] ) == '1' ) : 
	$sidebar_id = jolene_get_mobile_sidebar_id();
	
	if ( is_active_sidebar( $sidebar_id ) ) : 
?>
		<div class="sidebar-before-footer column mobile">
			<div class="widget-area">
				<?php dynamic_sidebar( $sidebar_id ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-before-footer -->	
		
	<?php endif; ?>

<?php endif; ?>

<?php if ( is_front_page() || is_page_template( 'page-templates/front-page.php' ) ) : ?>
	
	<?php if ( is_active_sidebar( 'sidebar-15' ) ) : ?>

		<div class="sidebar-before-footer">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-15' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-before-footer -->
		
	<?php else :
	
		do_action('jolene_empty_sidebar_15');
		
	endif; ?>
	
<?php endif; ?>