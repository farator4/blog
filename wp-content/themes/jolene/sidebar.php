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
			|| is_page_template( 'page-templates/right-sidebar.php' ) ) : return; 
	  endif; ?>
	  
<?php
	global $jolene_sidebars;
	if ( 1 != $jolene_sidebars['left'] ) return; 
	
	$defaults = jolene_get_defaults();
?>

<?php if ( is_front_page() || is_page_template( 'page-templates/front-page.php' ) ) : ?>
	
	<?php if ( is_active_sidebar( 'sidebar-13' ) ) : ?>
		<div class="sidebar-left">
			<div id="sidebar-5" class="column">
				<h3 class="sidebar-toggle"><?php _e( 'Sidebar', 'jolene' ); ?></h3>
				<div class="widget-area">
					<?php dynamic_sidebar( 'sidebar-13' ); ?>
				</div><!-- .widget-area -->
			</div><!-- .column -->
		</div><!-- .sidebar-left -->
	
	<?php endif; ?>
	
<?php elseif ( (function_exists('is_woocommerce') && is_woocommerce()) ) : 
	
	if(get_theme_mod( 'is_has_shop_sidebar', $defaults['is_has_shop_sidebar']) ) :

		 if ( is_active_sidebar( 'sidebar-20' ) ) : ?>
			<div class="sidebar-left">
				<div id="sidebar-5" class="column">
					<h3 class="sidebar-toggle"><?php _e( 'Sidebar', 'jolene' ); ?></h3>
					<div class="widget-area">
						<?php dynamic_sidebar( 'sidebar-20' ); ?>
					</div><!-- .widget-area -->
				</div><!-- .column -->
			</div><!-- .sidebar-left -->
	
		<?php endif;
		endif;
	?>

<?php elseif ( is_page() ) : ?>

	<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
	
		<div class="sidebar-left">
			<div id="sidebar-6" class="column">
				<h3 class="sidebar-toggle"><?php _e( 'Sidebar', 'jolene' ); ?></h3>
				<div class="widget-area">
					<?php dynamic_sidebar( 'sidebar-3' ); ?>
				</div><!-- .widget-area -->
			</div><!-- .column -->
		</div><!-- .sidebar-left -->
		
	<?php endif; ?>

<?php else: ?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	
		<div class="sidebar-left">
			<div id="sidebar-7" class="column">		
				<h3 class="sidebar-toggle"><?php _e( 'Sidebar', 'jolene' ); ?></h3>
				<div class="widget-area">
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
				</div><!-- .widget-area -->
			</div><!-- .column -->
		</div><!-- .sidebar-left -->
		
	<?php endif; ?>
	
<?php endif; ?>
