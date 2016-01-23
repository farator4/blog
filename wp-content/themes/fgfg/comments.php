<?php
/**
 *
 * comments.php
 *
 * The comments template. Used to display post or page comments and comment form.
 * 
 * Additional settings are available under the Appearance -> Theme Options -> Comments.
 *
 */
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die('Please do not load this page directly. Thanks!');

if (post_password_required()) {
	theme_post_wrapper(array('content' => '<p class="nocomments">' . __('This post is password protected. Enter the password to view any comments.', THEME_NS) . '</p>'));
	return;
}

if (have_comments()) {
	theme_ob_start();
	printf(_n('One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), THEME_NS), number_format_i18n(get_comments_number()), '<em>' . get_the_title() . '</em>');
	theme_post_wrapper(array('content' => '<h4 id="comments">' . theme_ob_get_clean() . '</h4>'));
	$prev_link = get_previous_comments_link(__('<span class="meta-nav">&larr;</span> Older Comments', THEME_NS));
	$next_link = get_next_comments_link(__('Newer Comments <span class="meta-nav">&rarr;</span>', THEME_NS));
	theme_page_navigation(array('prev_link' => $prev_link, 'next_link' => $next_link));
	echo '<ul id="comments-list">';
	wp_list_comments('type=all&callback=theme_comment');
	echo '</ul>';
	theme_page_navigation(array('prev_link' => $prev_link, 'next_link' => $next_link));
}
theme_ob_start();
$args = array();
if (theme_get_option('theme_comment_use_smilies')) {

	function theme_comment_form_field_comment($form_field) {
		theme_include_lib('smiley.php');
		return theme_get_smilies_js() . '<p class="smilies">' . theme_get_smilies() . '</p>' . $form_field;
	}

	add_filter('comment_form_field_comment', 'theme_comment_form_field_comment');
}
comment_form();
theme_post_wrapper(array('content' => str_replace(array(' id="respond"', 'type="submit"'), array('', 'class="art-button" type="submit"'), theme_ob_get_clean()), 'id' => 'respond'));
