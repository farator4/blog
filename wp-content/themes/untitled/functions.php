<?php
define('THEME_NAME', "untitled");
global $wp_version;
define('WP_VERSION', $wp_version);
define('THEME_NS', 'twentyten');
define('THEME_LANGS_FOLDER', '/languages');
if (class_exists('xili_language')) {
	define('THEME_TEXTDOMAIN', THEME_NS);
} else {
	load_theme_textdomain(THEME_NS, TEMPLATEPATH . THEME_LANGS_FOLDER);
}

if (function_exists('mb_internal_encoding')) {
	mb_internal_encoding(get_bloginfo('charset'));
}
if (function_exists('mb_regex_encoding')) {
	mb_regex_encoding(get_bloginfo('charset'));
}

global $wp_locale;
if (isset($wp_locale)) {
	$wp_locale->text_direction = 'ltr';
}

if (WP_VERSION < 3.0) {
	add_action('admin_notices', 'theme_unsupported_version_notice1');
	add_action('wp_head', 'theme_unsupported_version_notice2');
	function theme_unsupported_version_notice1() {
		?>
		<div id='theme-warning' class='error fade'><p><strong><?php _e('Current theme requires WordPress 3.0 or higher.', THEME_NS); ?></strong>
		<?php
		echo sprintf(__('Please <a href="%s">upgrade WordPress</a>, or <a href="%s">use an earlier version of Artisteer (2.6 - 3.1)</a> to create themes for WordPress 2.6-2.9.', THEME_NS),
			'http://codex.wordpress.org/Upgrading_WordPress', 'http://www.artisteer.com/Default.aspx?p=license_info');
		?>
		</p></div>
		<?php
	}
	function theme_unsupported_version_notice2() {
		?>
		</head>
		<body>
		<strong><?php _e('Current theme requires WordPress 3.0 or higher.', THEME_NS); ?></strong>
		<?php
		echo sprintf(__('Please <a href="%s">upgrade WordPress</a>, or <a href="%s">use an earlier version of Artisteer (2.6 - 3.1)</a> to create themes for WordPress 2.6-2.9.', THEME_NS),
			'http://codex.wordpress.org/Upgrading_WordPress', 'http://www.artisteer.com/Default.aspx?p=license_info');
		?>
		</body>
		</html>
		<?php
		die();
	}
	return;
}

theme_include_lib('defaults.php');
theme_include_lib('misc.php');
theme_include_lib('wrappers.php');
theme_include_lib('sidebars.php');
theme_include_lib('navigation.php');
theme_include_lib('shortcodes.php');
theme_include_lib('widgets.php');

function theme_favicon() {
	if (is_file(TEMPLATEPATH . '/favicon.ico')):
		?><link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" /><?php
	endif;
}

add_action('wp', 'theme_init_layout');
add_action('wp_head', 'theme_favicon');
add_action('wp_enqueue_scripts', 'theme_update_scripts', 1000);
add_action('wp_enqueue_scripts', 'theme_update_styles', 1000);
add_action('wp_print_scripts', 'theme_update_jquery_scripts', 1000);
add_action('wp_head', 'theme_update_posts_styles', 1000);
add_action('wp_head', 'theme_header_image_script');
add_action('admin_head', 'theme_favicon');
add_action('login_head', 'theme_favicon');

add_action('media_upload_image_header', 'wp_media_upload_handler');

function theme_header_rel_link() {
	if (theme_get_option('theme_header_clickable')):
		?><link rel='header_link' href='<?php echo esc_url(theme_get_option('theme_header_link')); ?>' /><?php
	endif;
}
add_action('wp_head', 'theme_header_rel_link');
add_action('login_head', 'theme_header_rel_link');

add_theme_support('post-thumbnails');
add_theme_support('nav-menus');
add_theme_support('automatic-feed-links');
add_theme_support('post-formats', array('aside', 'gallery'));

register_nav_menus(array('primary-menu' => __('Primary Navigation', THEME_NS)));


function theme_header_image_script() {
	$theme_header_image = theme_get_meta_option(get_queried_object_id(), 'theme_header_image');
	if ($theme_header_image) {
		?>
		<style>
			.art-header {
				background-image : url(<?php echo $theme_header_image; ?>);
				background-position : center center;
			}
		</style>
		<?php
	}
}

function theme_has_header_image() {
	return (bool) theme_get_meta_option(get_queried_object_id(), 'theme_header_image');
}
function theme_show_flash() {
	return (bool) theme_get_meta_option(get_queried_object_id(), 'theme_header_image_with_flash');
}

function theme_init_layout() {
	global $theme_layout;
	$theme_layout = array(
		'left_sidebar' => 1,

		);
		if (is_page()) {
			foreach ($theme_layout as $layout_part_name => $included) {
				$theme_layout[$layout_part_name] = theme_get_meta_option(theme_get_the_ID(), 'theme_layout_template_' . $layout_part_name);
			}
	} elseif(is_attachment()) {
		$theme_layout['left_sidebar'] = 0;
		
	}
}

function theme_has_layout_part($name) {
	global $theme_layout;
	return (bool) theme_get_array_value($theme_layout, $name);
}

if (is_admin()) {
	theme_include_lib('options.php');
	theme_include_lib('admins.php');

	function theme_add_option_page() {
		add_theme_page(__('Theme Options', THEME_NS), __('Theme Options', THEME_NS), 'edit_themes', basename(__FILE__), 'theme_print_options');
	}

	add_action('admin_menu', 'theme_add_option_page');
	add_action('sidebar_admin_setup', 'theme_widget_process_control');
	add_filter('widget_update_callback', 'theme_update_widget_additional');
	add_action('add_meta_boxes', 'theme_add_meta_boxes');
	add_action('save_post', 'theme_save_post');

	if (file_exists(TEMPLATEPATH . '/content/content-importer.php')) {
		include(TEMPLATEPATH . '/content/content-importer.php');
	}
	return;
}

function theme_update_scripts() {
	global $wp_scripts;
	wp_register_script("script.js", get_bloginfo('template_url', 'display') . '/script.js', array('jquery'));
	wp_enqueue_script("script.js");
	wp_register_script("script.responsive.js", get_bloginfo('template_url', 'display') . '/script.responsive.js', array('jquery'));
	wp_enqueue_script("script.responsive.js");

}

function theme_update_jquery_scripts() {
	if(is_admin()) {
		return;
	}
	wp_deregister_script('jquery');
	if (theme_get_option('theme_iclude_scripts_from_cdn')) {
		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
	} else {
		wp_register_script('jquery', get_bloginfo('template_url', 'display') . '/jquery.js');
	}
}

function theme_update_styles() {
	global $wp_styles;
	wp_register_style("style.ie7.css", get_bloginfo('template_url', 'display') . '/style.ie7.css', array(), false, "screen");
	wp_enqueue_style("style.ie7.css");
	$wp_styles->add_data("style.ie7.css", "conditional", "lte IE 7");
	wp_register_style("style.responsive.css", get_bloginfo('template_url', 'display') . '/style.responsive.css', array(), false, "all");
	wp_enqueue_style("style.responsive.css");

}

function theme_update_posts_styles() {
	global $wp_query;
	$res = '';
	if(!is_singular()) {
		$post_id = get_queried_object_id();
		$res .= get_post_meta($post_id, 'theme_head', true);
	}
	while ($wp_query->have_posts()) {
		the_post();
		$post_id = theme_get_the_ID();
		$res .= get_post_meta($post_id, 'theme_head', true);
	}
	if (!empty($res)) {
		echo $res;
	}
	wp_reset_postdata();
}

function theme_get_option($name) {
	global $theme_default_options;
	$result = get_option($name);
	if ($result === false) {
		$result = theme_get_array_value($theme_default_options, $name);
	}
	return $result;
}



function theme_get_widget_meta_option($widget_id, $name) {
	global $theme_default_meta_options;
	if (!preg_match('/^(.*[^-])-([0-9]+)$/', $widget_id, $matches) || !isset($matches[1]) || !isset($matches[2])) {
		return theme_get_array_value($theme_default_meta_options, $name);
	}
	$type = $matches[1];
	$id = $matches[2];
	$wp_widget = get_option('widget_' . $type);
	if (!$wp_widget || !isset($wp_widget[$id])) {
		return theme_get_array_value($theme_default_meta_options, $name);
	}
	if (!isset($wp_widget[$id][$name])) {
		$wp_widget[$id][$name] = theme_get_array_value(get_option($name), $widget_id, theme_get_array_value($theme_default_meta_options, $name));
		update_option('widget_' . $type, $wp_widget);
	}
	return $wp_widget[$id][$name];
}

function theme_set_widget_meta_option($widget_id, $name, $value) {
	if (!preg_match('/^(.*[^-])-([0-9]+)$/', $widget_id, $matches) || !isset($matches[1]) || !isset($matches[2])) {
		return;
	}
	$type = $matches[1];
	$id = $matches[2];
	$wp_widget = get_option('widget_' . $type);
	if (!$wp_widget || !isset($wp_widget[$id])) {
		return;
	}
	$wp_widget[$id][$name] = $value;
	update_option('widget_' . $type, $wp_widget);
}

function theme_get_meta_option($id, $name) {
	global $theme_default_meta_options;
	$value = get_post_meta($id, '_' . $name, true);
	if ('' === $value) {
		$value = theme_get_array_value(get_option($name), $id, theme_get_array_value($theme_default_meta_options, $name));
		theme_set_meta_option($id, $name, $value);
	}
	return $value;
}

function theme_set_meta_option($id, $name, $value) {
	update_post_meta($id, '_' . $name, $value);
}

function theme_get_post_id() {
	$post_id = theme_get_the_ID();
	if ($post_id != '') {
		$post_id = 'post-' . $post_id;
	}
	return $post_id;
}

function theme_get_the_ID() {
	global $post;
	return $post->ID;
}

function theme_get_post_class() {
	return implode(' ', get_post_class());
}

function theme_include_lib($name) {
	locate_template(array('library/' . $name), true);
}

function theme_get_metadata_icons($icons = '', $class = '') {
	global $post;
	if (!is_string($icons) || theme_strlen($icons) == 0)
		return;
	$icons = explode(",", str_replace(' ', '', $icons));
	if (!is_array($icons) || count($icons) == 0)
		return;
	$result = array();
	for ($i = 0; $i < count($icons); $i++) {
		$icon = $icons[$i];
		switch ($icon) {
			case 'date':
				$result[] = '<span class="art-postdateicon">' . sprintf(__('<span class="%1$s">Published</span> %2$s', THEME_NS),
								'date',
								sprintf( '<span class="entry-date" title="%1$s">%2$s</span>',
									esc_attr( get_the_time() ),
									get_the_date()
								)
							) . '</span>';
			break;
			case 'author':
				$result[] = '<span class="art-postauthoricon">' . sprintf(__('<span class="%1$s">By</span> %2$s', THEME_NS),
								'author',
								sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
									get_author_posts_url( get_the_author_meta( 'ID' ) ),
									sprintf( esc_attr(__( 'View all posts by %s', THEME_NS )), get_the_author() ),
									get_the_author()
								)
						) . '</span>';
				break;
			case 'category':
				$categories = get_the_category_list(', ');
				if (theme_strlen($categories) == 0)
					break;
				$result[] = '<span class="art-postcategoryicon">' . sprintf(__('<span class="%1$s">Posted in</span> %2$s', THEME_NS), 'categories', get_the_category_list(', ')) . '</span>';
				break;
			case 'tag':
				$tags_list = get_the_tag_list('', ', ');
				if (!$tags_list)
					break;
				$result[] = '<span class="art-posttagicon">' . sprintf(__('<span class="%1$s">Tagged</span> %2$s', THEME_NS), 'tags', $tags_list) . '</span>';
				break;
			case 'comments':
				if (!comments_open() || !theme_get_option('theme_allow_comments'))
					break;
				theme_ob_start();
				comments_popup_link(__('Leave a comment', THEME_NS), __('1 Comment', THEME_NS), __('% Comments', THEME_NS));
				$result[] = '<span class="art-postcommentsicon">' . theme_ob_get_clean() . '</span>';
				break;
			case 'edit':
				if (!current_user_can('edit_post', $post->ID))
					break;
				theme_ob_start();
				edit_post_link(__('Edit', THEME_NS), '');
				$result[] = '<span class="art-postediticon">' . theme_ob_get_clean() . '</span>';
				break;
		}
	}
	$result = implode(theme_get_option('theme_metadata_separator'), $result);
	if (theme_is_empty_html($result))
		return;
	return "<div class=\"art-post{$class}icons art-metadata-icons\">{$result}</div>";
}

function theme_get_post_thumbnail($args = array()) {
	global $post;

	$size = theme_get_array_value($args, 'size', array(theme_get_option('theme_metadata_thumbnail_width'), theme_get_option('theme_metadata_thumbnail_height')));
	$auto = theme_get_array_value($args, 'auto', theme_get_option('theme_metadata_thumbnail_auto'));
	$featured = theme_get_array_value($args, 'featured', theme_get_option('theme_metadata_use_featured_image_as_thumbnail'));
	$title = theme_get_array_value($args, 'title', get_the_title());


	$result = '';

	if ($featured && (has_post_thumbnail())) {
		theme_ob_start();
		the_post_thumbnail($size, array('alt' => '', 'title' => $title));
		$result = theme_ob_get_clean();
	} elseif ($auto) {
		$attachments = get_children(array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID'));
		if ($attachments) {
			$attachment = array_shift($attachments);
			$img = wp_get_attachment_image_src($attachment->ID, $size);
			if (isset($img[0])) {
				$result = '<img src="' . $img[0] . '" alt="" width="' . $img[1] . '" height="' . $img[2] . '" title="' . $title . '" class="wp-post-image" />';
			}
		}
	}
	if ($result !== '') {
		$result = '<div class="avatar alignleft"><a href="' . get_permalink($post->ID) . '" title="' . $title . '">' . $result . '</a></div>';
	}
	return $result;
}

function theme_get_content($args = array()) {
	$more_tag = theme_get_array_value($args, 'more_tag', __('Continue reading <span class="meta-nav">&rarr;</span>', THEME_NS));
	theme_ob_start();
	the_content($more_tag);
	$content = theme_ob_get_clean();
	return $content . wp_link_pages(array(
				'before' => '<p><span class="page-navi-outer page-navi-caption"><span class="page-navi-inner">' . __('Pages', THEME_NS) . ': </span></span>',
				'after' => '</p>',
				'link_before' => '<span class="page-navi-outer"><span class="page-navi-inner">',
				'link_after' => '</span></span>',
				'echo' => 0
			));
}

function theme_get_excerpt($args = array()) {
	global $post;
	$more_tag = theme_get_array_value($args, 'more_tag', __('Continue reading <span class="meta-nav">&rarr;</span>', THEME_NS));
	$auto = theme_get_array_value($args, 'auto', theme_get_option('theme_metadata_excerpt_auto'));
	$all_words = theme_get_array_value($args, 'all_words', theme_get_option('theme_metadata_excerpt_words'));
	$min_remainder = theme_get_array_value($args, 'min_remainder', theme_get_option('theme_metadata_excerpt_min_remainder'));
	$allowed_tags = theme_get_array_value($args, 'allowed_tags',
		(theme_get_option('theme_metadata_excerpt_use_tag_filter')
			? explode(',',str_replace(' ', '', theme_get_option('theme_metadata_excerpt_allowed_tags')))
			: null));
	$perma_link = get_permalink($post->ID);
	$more_token = '%%theme_more%%';
	$show_more_tag = false;
	$tag_disbalance = false;
	if (post_password_required($post)) {
		return get_the_excerpt();
	}
	if ($auto && has_excerpt($post->ID)) {
		$excerpt = get_the_excerpt();
		$show_more_tag = theme_strlen($post->post_content) > 0;
	} else {
		$excerpt = get_the_content($more_token);
		// hack for badly written plugins
		theme_ob_start();
		echo apply_filters('the_content', $excerpt);
		$excerpt = theme_ob_get_clean();
		global $multipage;
		if ($multipage && theme_strpos($excerpt, $more_token) === false) {
			$show_more_tag = true;
		}
		if (theme_is_empty_html($excerpt))
			return $excerpt;
		if ($allowed_tags !== null) {
			$allowed_tags = '<' . implode('><', $allowed_tags) . '>';
			$excerpt = strip_tags($excerpt, $allowed_tags);
		}
		if (theme_strpos($excerpt, $more_token) !== false) {
			$excerpt = str_replace($more_token, $more_tag, $excerpt);
		} elseif ($auto && is_numeric($all_words)) {
			$token = "%theme_tag_token%";
			$content_parts = explode($token, str_replace(array('<', '>'), array($token . '<', '>' . $token), $excerpt));
			$content = array();
			$word_count = 0;
			foreach ($content_parts as $part) {
				if (theme_strpos($part, '<') !== false || theme_strpos($part, '>') !== false) {
					$content[] = array('type' => 'tag', 'content' => $part);
				} else {
					$all_chunks = preg_split('/([\s])/u', $part, -1, PREG_SPLIT_DELIM_CAPTURE);
					foreach ($all_chunks as $chunk) {
						if ('' != trim($chunk)) {
							$content[] = array('type' => 'word', 'content' => $chunk);
							$word_count += 1;
						} elseif ($chunk != '') {
							$content[] = array('type' => 'space', 'content' => $chunk);
						}
					}
				}
			}

			if (($all_words < $word_count) && ($all_words + $min_remainder) <= $word_count) {
				$show_more_tag = true;
				$tag_disbalance = true;
				$current_count = 0;
				$excerpt = '';
				foreach ($content as $node) {
					if ($node['type'] == 'word') {
						$current_count++;
					}
					$excerpt .= $node['content'];
					if ($current_count == $all_words) {
						break;
					}
				}
				$excerpt .= '&hellip;'; // ...
			}
		}
	}
	if ($show_more_tag) {
		$excerpt = $excerpt . ' <a class="more-link" href="' . $perma_link . '">' . $more_tag . '</a>';
	}
	if ($tag_disbalance) {
		$excerpt = force_balance_tags($excerpt);
	}
	return $excerpt;
}

function theme_get_search() {
	theme_ob_start();
	get_search_form();
	return theme_ob_get_clean();
}

function theme_is_home() {
	return (is_home() && !is_paged());
}

function theme_404_content($args = '') {
	$args = wp_parse_args($args, array(
		'error_title' => __('Not Found', THEME_NS),
		'error_message' => __('Apologies, but the page you requested could not be found. Perhaps searching will help.', THEME_NS),
		'focus_script' => '<script type="text/javascript">jQuery(\'div.art-content input[name="s"]\').focus();</script>'
			)
	);
	extract($args);
	theme_post_wrapper(
			array(
				'title' => $error_title,
				'content' => '<p class="center">' . $error_message . '</p>' . "\n" . theme_get_search() . $focus_script
			)
	);

	if (theme_get_option('theme_show_random_posts_on_404_page')) {
		theme_ob_start();
		echo '<h4 class="box-title">' . theme_get_option('theme_show_random_posts_title_on_404_page') . '</h4>';
		?>
		<ul>
		<?php
		global $post;
		$rand_posts = get_posts('numberposts=5&orderby=rand');
		foreach ($rand_posts as $post) :
			?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		<?php endforeach; ?>
		</ul>
		<?php
		theme_post_wrapper(array('content' => theme_ob_get_clean()));
	}
	if (theme_get_option('theme_show_tags_on_404_page')) {
		theme_ob_start();
		echo '<h4 class="box-title">' . theme_get_option('theme_show_tags_title_on_404_page') . '</h4>';
		wp_tag_cloud('smallest=9&largest=22&unit=pt&number=200&format=flat&orderby=name&order=ASC');
		theme_post_wrapper(array('content' => theme_ob_get_clean()));
	}
}

function theme_page_navigation($args = '') {
	$args = wp_parse_args($args, array('wrap' => true, 'prev_link' => false, 'next_link' => false));
	$prev_link = $args['prev_link'];
	$next_link = $args['next_link'];
	$wrap = $args['wrap'];
	if (!$prev_link && !$next_link) {
		if (function_exists('wp_page_numbers')) { // http://wordpress.org/extend/plugins/wp-page-numbers/
			theme_ob_start();
			wp_page_numbers();
			theme_post_wrapper(array('content' => theme_ob_get_clean()));
			return;
		}
		if (function_exists('wp_pagenavi')) { // http://wordpress.org/extend/plugins/wp-pagenavi/
			theme_ob_start();
			wp_pagenavi();
			theme_post_wrapper(array('content' => theme_ob_get_clean()));
			return;
		}
		//posts
		$prev_link = get_previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', THEME_NS));
		$next_link = get_next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', THEME_NS));
	}
	$content = '';
	$prev_align = 'left';
	$next_align = 'right';
	if (is_rtl()) {
		$prev_align = 'right';
		$next_align = 'left';
	}
	if ($prev_link || $next_link) {
		$content = <<<EOL
<div class="navigation">
	<div class="align{$prev_align}">{$prev_link}</div>
	<div class="align{$next_align}">{$next_link}</div>
 </div>
EOL;
	}
	if ($wrap) {
		theme_post_wrapper(array('content' => $content));
	} else {
		echo $content;
	}
}

function theme_get_previous_post_link($format = '&laquo; %link', $link = '%title', $in_same_cat = false, $excluded_categories = '') {
	return theme_get_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true);
}

function theme_get_next_post_link($format = '%link &raquo;', $link = '%title', $in_same_cat = false, $excluded_categories = '') {
	return theme_get_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false);
}

function theme_get_adjacent_image_link($prev = true, $size = 'thumbnail', $text = false) {
	global $post;
	$post = get_post($post);
	$attachments = array_values(get_children(array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID')));

	foreach ($attachments as $k => $attachment)
		if ($attachment->ID == $post->ID)
			break;

	$k = $prev ? $k - 1 : $k + 1;

	if (isset($attachments[$k]))
		return wp_get_attachment_link($attachments[$k]->ID, $size, true, false, $text);
}

function theme_get_previous_image_link($size = 'thumbnail', $text = false) {
	$result = theme_get_adjacent_image_link(true, $size, $text);
	if ($result)
		$result = '&laquo; ' . $result;
	return $result;
}

function theme_get_next_image_link($size = 'thumbnail', $text = false) {
	$result = theme_get_adjacent_image_link(false, $size, $text);
	if ($result)
		$result .= ' &raquo;';
	return $result;
}

function theme_get_adjacent_post_link($format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true) {
	if ($previous && is_attachment())
		$post = & get_post($GLOBALS['post']->post_parent);
	else
		$post = get_adjacent_post($in_same_cat, $excluded_categories, $previous);

	if (!$post)
		return;

	$title = strip_tags($post->post_title);

	if (empty($post->post_title))
		$title = $previous ? __('Previous Post', THEME_NS) : __('Next Post', THEME_NS);

	$title = apply_filters('the_title', $title, $post->ID);
	$short_title = $title;
	if (theme_get_option('theme_single_navigation_trim_title')) {
		$short_title = theme_trim_long_str($title, theme_get_option('theme_single_navigation_trim_len'));
	}
	$date = mysql2date(get_option('date_format'), $post->post_date);
	$rel = $previous ? 'prev' : 'next';

	$string = '<a href="' . get_permalink($post) . '" title="' . esc_attr($title) . '" rel="' . $rel . '">';
	$link = str_replace('%title', $short_title, $link);
	$link = str_replace('%date', $date, $link);
	$link = $string . $link . '</a>';

	$format = str_replace('%link', $link, $format);

	$adjacent = $previous ? 'previous' : 'next';
	return apply_filters("{$adjacent}_post_link", $format, $link);
}

function theme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;


	switch ($comment->comment_type) :

		case '' :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<?php theme_ob_start(); ?>
				<div class="comment-author vcard">
				<?php echo theme_get_avatar(array('id' => $comment, 'size' => 48)); ?>
				<?php printf(__('%s <span class="says">says:</span>', THEME_NS), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
				</div>
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php _e('Your comment is awaiting moderation.', THEME_NS); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
				<?php printf(__('%1$s at %2$s', THEME_NS), get_comment_date(), get_comment_time()); ?></a><?php edit_comment_link(__('(Edit)', THEME_NS), ' '); ?>
				</div>

				<div class="comment-body"><?php comment_text(); ?></div>

				<div class="reply">
				<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
				</div>
				<?php theme_post_wrapper(array('content' => theme_ob_get_clean(), 'id' => 'comment-' . get_comment_ID())); ?>


				<?php
				break;
			case 'pingback' :
			case 'trackback' :
				?>
			<li class="post pingback">
			<?php theme_ob_start(); ?>
				<p><?php _e('Pingback:', THEME_NS); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', THEME_NS), ' '); ?></p>
			<?php
			theme_post_wrapper(array('content' => theme_ob_get_clean(), 'class' => $comment->comment_type));
			break;
	endswitch;
}

function theme_get_avatar($args = '') {
	$args = wp_parse_args($args, array('id' => false, 'size' => 96, 'default' => '', 'alt' => false, 'url' => false));
	extract($args);
	$result = get_avatar($id, $size, $default, $alt);
	if ($result) {
		if ($url) {
			$result = '<a href="' . esc_url($url) . '">' . $result . '</a>';
		}
		$result = '<div class="avatar">' . $result . '</div>';
	}
	return $result;
}

if (!function_exists('get_post_format')) {//for WP 3.0
	function get_post_format() {
		return null;
	}
}


if (!function_exists('get_queried_object_id')) {//for WP 3.0
	function get_queried_object_id() {
		global $wp_query;
		return $wp_query->get_queried_object_id();
	}
}

function theme_get_next_post() {
	static $ended = false;
	if (!$ended) {
		if (have_posts()) {
			the_post();
			get_template_part('content', get_post_format());
		} else {
			$ended = true;
		}
	}
}

$theme_ob_stack = array();

function theme_ob_handler($str) {
	global $theme_ob_stack;
	end($theme_ob_stack);
	$theme_ob_stack[key($theme_ob_stack)] .= $str;
	return '';
}

function theme_ob_start() {
	global $theme_ob_stack;
	array_push($theme_ob_stack, '');
	ob_start('theme_ob_handler');
}

function theme_ob_get_clean() {
	global $theme_ob_stack;
	ob_end_flush();
	return array_pop($theme_ob_stack);
}