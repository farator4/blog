<?php

/**
 *
 * search.php
 *
 * The search results template. Used when a search is performed.
 *
 */
get_header();
?>
			<?php get_sidebar('top'); ?>
			<?php
			if (have_posts()) {
				theme_post_wrapper(
						array('content' => '<h4 class="box-title">' . sprintf(__('Search Results for: %s', THEME_NS), '<span class="search-query-string">' . get_search_query() . '</span>') . '</h4>'
						)
				);
				/* Display navigation to next/previous pages when applicable */
				if (theme_get_option('theme_top_posts_navigation')) {
					theme_page_navigation();
				}
				/* Start the Loop */
				while (have_posts()) {
					the_post();
					get_template_part('content', 'search');
				}
				/* Display navigation to next/previous pages when applicable */
				if (theme_get_option('theme_bottom_posts_navigation')) {
					theme_page_navigation();
				}
			} else {
				theme_404_content(
						array(
							'error_title' => __('Nothing Found', THEME_NS),
							'error_message' => __('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', THEME_NS)
						)
				);
			}
			?>
			<?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>