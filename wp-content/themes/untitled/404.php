<?php
/**
 *
 * 404.php
 *
 * The template for displaying 404 pages (Not Found).
 * Used when WordPress cannot find a post or page that matches the query.
 *
 * To change the error message:
 * 1. Open functions.php file
 * 2. Find the theme_404_content() function
 * 3. Change the error_message variable value
 *
 * Additional settings are available under the Appearance -> Theme Options -> Pages.
 *
 */
get_header(); ?>
			<?php get_sidebar('top'); ?>
			<?php theme_404_content(); ?>
			<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>