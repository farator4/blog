<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */
?>
<?php if ( is_page_template( 'page-templates/full-width.php' ) 
			|| is_page_template( 'page-templates/full-width-wide.php' ) 
			|| is_page_template( 'page-templates/left-sidebar.php' ) ) : return; 
	  endif; ?>
	  
<?php
	global $jolene_sidebars;
	if ( 1 != $jolene_sidebars['right'] ) return; 

	$defaults = jolene_get_defaults();
	
?>

<?php if ( is_page_template( 'page-templates/front-page.php' ) || is_front_page() ) : ?>
	
	<?php if ( is_active_sidebar( 'sidebar-14' ) ) : ?>
	
		<div class="sidebar-right">
			<div id="sidebar-8" class="right column">
				<h3 class="sidebar-toggle"><?php _e( 'Sidebar', 'jolene' ); ?></h3>
				<div class="widget-area">
					<?php dynamic_sidebar( 'sidebar-14' ); ?>
				</div><!-- .widget-area -->
			</div><!-- .column -->
		</div><!-- .sidebar-right -->
	
	<?php endif; ?>
	
<?php elseif ( (function_exists('is_woocommerce') && is_woocommerce()) ) :
		if( get_theme_mod( 'is_has_shop_sidebar', $defaults['is_has_shop_sidebar'] ) ) :

			if ( is_active_sidebar( 'sidebar-19' ) ) : ?>
		
			<div class="sidebar-right">
				<div id="sidebar-8" class="right column">
					<h3 class="sidebar-toggle"><?php _e( 'Sidebar', 'jolene' ); ?></h3>
					<div class="widget-area">
						<?php dynamic_sidebar( 'sidebar-19' ); ?>
					</div><!-- .widget-area -->
				</div><!-- .column -->
			</div><!-- .sidebar-right -->
	
		<?php endif;
		endif;

 elseif ( is_page() ) : ?>

	<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
		
		<div class="sidebar-right">
			<div id="sidebar-10" class="right column">		
				<h3 class="sidebar-toggle"><?php _e( 'Sidebar', 'jolene' ); ?></h3>
				<div class="widget-area">
					<?php dynamic_sidebar( 'sidebar-4' ); ?>
				</div><!-- .widget-area -->
			</div><!-- .column -->
		</div><!-- .sidebar-right -->
		
	<?php endif; ?>
<?php else: ?>

	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	
		<div class="sidebar-right">
			<div id="sidebar-11" class="right column">		
				<h3 class="sidebar-toggle"><?php _e( 'Sidebar', 'jolene' ); ?></h3>
				<div class="widget-area">
					<?php dynamic_sidebar( 'sidebar-2' ); ?>
				</div><!-- .widget-area -->
			</div><!-- .column -->
		</div><!-- .sidebar-right -->
		
	<?php endif; ?>
	
<?php endif; ?>
