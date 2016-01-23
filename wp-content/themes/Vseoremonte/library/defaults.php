<?php

global $theme_default_options;
$theme_default_options = array(

	'theme_header_show_headline' => 1,
	'theme_header_show_slogan' => 1,
	'theme_header_clickable' => 0,
	'theme_header_link' => trailingslashit( get_option( 'home' ) ),
	
	'theme_menu_showHome' => 1,
	'theme_menu_highlight_active_categories' => 1,
	'theme_menu_homeCaption' => <<<EOL
Home
EOL
,
	
	'theme_menu_trim_title' => 1,
	'theme_menu_trim_len' => 45,
	'theme_submenu_trim_len' => 40,

	'theme_menu_depth' => 0,
	'theme_menu_source' => 'Pages',
	
	'theme_vmenu_depth' => 1,
	
	'theme_sidebars_style_default' => 'block',
	'theme_sidebars_style_secondary' => 'block',
	'theme_sidebars_style_top' => 'post',
	'theme_sidebars_style_bottom' => 'post',
	'theme_sidebars_style_header' => 'simple',
	'theme_sidebars_style_footer' => 'simple',
	
	'theme_metadata_use_featured_image_as_thumbnail' => 1,
	'theme_metadata_thumbnail_auto' => 0,
	'theme_metadata_thumbnail_width' => 128,
	'theme_metadata_thumbnail_height' => 128,

	'theme_metadata_separator' => ' | ',
	'theme_metadata_excerpt_auto' => 0,
	'theme_metadata_excerpt_min_remainder' => 5,
	'theme_metadata_excerpt_words' => 40,
	'theme_show_tags_on_404_page' => 0,
	'theme_show_tags_title_on_404_page' => __('Tag Cloud', THEME_NS),
	'theme_show_random_posts_on_404_page' => 0,
	'theme_show_random_posts_title_on_404_page' => __('Random posts', THEME_NS),
	'theme_comment_use_smilies' => 0,
	'theme_allow_comments' => 1,

	'theme_metadata_excerpt_use_tag_filter' => 0,
	'theme_metadata_excerpt_allowed_tags' => 'a, abbr, blockquote, b, cite, pre, code, em, label, i, p, strong, ul, ol, li, h1, h2, h3, h4, h5, h6, object, param, embed',

	'theme_top_single_navigation' => 1,
	'theme_bottom_single_navigation' => 0,
	'theme_single_navigation_trim_title' => 1,
	'theme_single_navigation_trim_len' => 80,
	
	'theme_home_top_posts_navigation' => 0,
	'theme_top_posts_navigation' => 1,
	'theme_bottom_posts_navigation' => 1,
	'theme_attachment_size' => 600,
	'theme_override_default_footer_content' => 0,
	'theme_footer_content' => <<<EOL

<p><a href="#">Link1</a> | <a href="#">Link2</a> | <a href="#">Link3</a></p>
<p>Copyright © 2016. All Rights Reserved.</p>
    

EOL
,
	'theme_posts_headline_tag' => 'h1',
	'theme_posts_slogan_tag' => 'h2',
	'theme_posts_article_title_tag' => 'h2',
	'theme_posts_widget_title_tag' => 'h3',

	'theme_single_headline_tag' => 'div',
	'theme_single_slogan_tag' => 'div',
	'theme_single_article_title_tag' => 'h1',
	'theme_single_widget_title_tag' => 'div',
	
	'theme_iclude_scripts_from_cdn' => 0
);

global $theme_default_meta_options;
$theme_default_meta_options = array(
	'theme_show_in_menu' => 1,
	'theme_show_as_separator' => 0,
	'theme_title_in_menu' => '',
	'theme_show_page_title' => 1,
	'theme_show_post_title' => 1,
	'theme_widget_styles' => 'default',
	'theme_widget_show_on' => 'all',
	'theme_widget_front_page' => 0,
	'theme_widget_single_post' => 0,
	'theme_widget_single_page' => 0,
	'theme_widget_posts_page' => 0,
	'theme_widget_page_ids' => 0,
	'theme_widget_page_ids_list' => '',
	'theme_widget_styling' => '',
	'theme_header_image' => '',
	'theme_header_image_with_flash' => 1,
		'theme_layout_template_header' => 1,
	'theme_layout_template_left_sidebar' => 1,

);
