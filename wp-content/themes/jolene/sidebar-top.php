<?php
/**
 * The sidebar containing the top widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 */
?>

<?php if ( is_page_template( 'page-templates/front-page.php' ) || is_front_page() ) : ?>

	<?php if ( is_active_sidebar( 'sidebar-10' ) ) : ?>
		
		<div id="sidebar-1" class="sidebar-top-full">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-10' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-top-full -->
	
	<?php endif; ?>
	
	
<?php else: ?>

	<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
	
		<div id="sidebar-3" class="sidebar-top-full">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-5' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-top-full -->
	<?php endif; ?>
	
<?php endif; ?>