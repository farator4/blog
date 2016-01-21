<?php 
/**
 * Library of Theme options functions.
 * @package LeatherDiary
 * @since LeatherDiary 1.0.0
*/

// Display Breadcrumb navigation
function leatherdiary_get_breadcrumb() { 
global $leatherdiary_options_db;
		if ($leatherdiary_options_db['leatherdiary_display_breadcrumb'] != 'Hide') { ?>
		<?php if(function_exists( 'bcn_display' ) && !is_front_page()){ _e('<p class="breadcrumb-navigation">', 'leatherdiary'); ?><?php bcn_display(); ?><?php _e('</p>', 'leatherdiary');} ?>
<?php } 
} 

// Display featured images on single posts
function leatherdiary_get_display_image_post() { 
global $leatherdiary_options_db;
		if ($leatherdiary_options_db['leatherdiary_display_image_post'] == '' || $leatherdiary_options_db['leatherdiary_display_image_post'] == 'Display') { ?>
		<?php if ( has_post_thumbnail() ) : ?>
      <?php the_post_thumbnail(); ?>
    <?php endif; ?>
<?php } 
}

// Display featured images on pages
function leatherdiary_get_display_image_page() { 
global $leatherdiary_options_db;
		if ($leatherdiary_options_db['leatherdiary_display_image_page'] == '' || $leatherdiary_options_db['leatherdiary_display_image_page'] == 'Display') { ?>
		<?php if ( has_post_thumbnail() ) : ?>
      <?php the_post_thumbnail(); ?>
    <?php endif; ?>
<?php } 
} ?>