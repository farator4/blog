<?php

/**
 *
 * single.php
 *
 * The single post template. Used when a single post is queried.
 * 
 */
get_header();
?>
			<?php get_sidebar('top'); ?>
			<?php
			if (have_posts()) {
				/* Display navigation to next/previous posts when applicable */
				if (theme_get_option('theme_top_single_navigation')) {
					theme_page_navigation(
							array(
								'next_link' => theme_get_previous_post_link('&laquo; %link'),
								'prev_link' => theme_get_next_post_link('%link &raquo;')
							)
					);
				}
				while (have_posts()) {
					the_post();
					get_template_part('content', 'single');
					/* Display comments */
					if (theme_get_option('theme_allow_comments')) {
						comments_template();
					}
				}
				/* Display navigation to next/previous posts when applicable */
				if (theme_get_option('theme_bottom_single_navigation')) {
					theme_page_navigation(
							array(
								'next_link' => theme_get_previous_post_link('&laquo; %link'),
								'prev_link' => theme_get_next_post_link('%link &raquo;')
							)
					);
				}
			} else {
				theme_404_content();
			}
			?>
			<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>