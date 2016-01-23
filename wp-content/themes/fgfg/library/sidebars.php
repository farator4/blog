<?php
global $theme_sidebars;
$theme_sidebars = array(
	'default' => array(
		'name' => __('Primary Widget Area', THEME_NS),
		'id' => 'primary-widget-area',
		'description' => __("This is the default sidebar, visible on 2 or 3 column layouts. If no widgets are active, the default theme widgets will be displayed instead.", THEME_NS)
	),
	'secondary' => array(
		'name' => __('Secondary Widget Area', THEME_NS),
		'id' => 'secondary-widget-area',
		'description' => __("This sidebar is active only on a 3 column setup.", THEME_NS)
	),
	'header' => array(
		'name' => __('Header Widget Area', THEME_NS),
		'id' => 'header-widget-area',
		'description' => __("The header widget area. Use the unique widget ids to control the design and position of individual widgets with CSS code.", THEME_NS)
	),
	'top' => array(
		'name' => __('First Top Widget Area', THEME_NS),
		'id' => 'first-top-widget-area',
		'description' => __("This sidebar is displayed above the main content.", THEME_NS)
	),
	'top2' => array(
		'name' => __('Second Top Widget Area', THEME_NS),
		'id' => 'second-top-widget-area',
		'description' => __("This sidebar is displayed above the main content.", THEME_NS)
	),
	'bottom' => array(
		'name' => __('First Bottom Widget Area', THEME_NS),
		'id' => 'first-bottom-widget-area',
		'description' => __("This sidebar is displayed below the main content.", THEME_NS)
	),
	'bottom2' => array(
		'name' => __('Second Bottom Widget Area', THEME_NS),
		'id' => 'second-bottom-widget-area',
		'description' => __("This sidebar is displayed below the main content.", THEME_NS)
	),
	'footer' => array(
		'name' => __('First Footer Widget Area', THEME_NS),
		'id' => 'first-footer-widget-area',
		'description' => __("The first footer widget area. You can add a text widget for custom footer text.", THEME_NS)
	),
	'footer2' => array(
		'name' => __('Second Footer Widget Area', THEME_NS),
		'id' => 'second-footer-widget-area',
		'description' => __("The second footer widget area.", THEME_NS)
	),
	'footer3' => array(
		'name' => __('Third Footer Widget Area', THEME_NS),
		'id' => 'third-footer-widget-area',
		'description' => __("The third footer widget area.", THEME_NS)
	),
	'footer4' => array(
		'name' => __('Fourth Footer Widget Area', THEME_NS),
		'id' => 'fourth-footer-widget-area',
		'description' => __("The fourth footer widget area.", THEME_NS)
	),
);

global $theme_widget_args;

$theme_widget_args = array(
	'before_widget' => '<widget id="%1$s" name="%1$s" class="widget %2$s">',
	'before_title' => '<title>',
	'after_title' => '</title>',
	'after_widget' => '</widget>'
);

foreach ($theme_sidebars as $sidebar) {
	register_sidebar(array_merge($sidebar, $theme_widget_args));
}

function theme_get_dynamic_sidebar_data($name) {
	global $theme_widget_args, $theme_sidebars;
	theme_ob_start();
	$success = dynamic_sidebar($theme_sidebars[$name]['id']);
	$content = theme_ob_get_clean();
	if (!$success)
		return false;
	extract($theme_widget_args);
	$data = explode($after_widget, $content);
	$widgets = array();
	$heading = theme_get_option('theme_' . (is_home() ? 'posts' : 'single') . '_widget_title_tag');
	for ($i = 0; $i < count($data); $i++) {
		$widget = $data[$i];
		if (theme_is_empty_html($widget))
			continue;

		$id = null;
		$name = null;
		$class = null;
		$title = null;

		if (preg_match('/<widget(.*?)>/', $widget, $matches)) {
			if (preg_match('/id="(.*?)"/', $matches[1], $ids)) {
				$id = $ids[1];
			}
			if (preg_match('/name="(.*?)"/', $matches[1], $names)) {
				$name = $names[1];
			}
			if (preg_match('/class="(.*?)"/', $matches[1], $classes)) {
				$class = $classes[1];
			}
			$widget = preg_replace('/<widget[^>]+>/', '', $widget);

			if (preg_match('/<title>(.*)<\/title>/', $widget, $matches)) {
				$title = $matches[1];
				$widget = preg_replace('/<title>.*?<\/title>/', '', $widget);
			}
		}

		$widgets[] = array(
			'id' => $id,
			'name' => $name,
			'class' => $class,
			'title' => $title,
			'heading' => $heading,
			'content' => $widget
		);
	}
	return $widgets;
}

function theme_print_widgets($widgets, $style) {
	if (!is_array($widgets) || count($widgets) < 1)
		return false;
	foreach($widgets as $widget) {
		echo theme_get_widget_meta_option($widget['name'], 'theme_widget_styling');
		if ($widget['name']) {
			$widget_style = theme_get_widget_style($widget['name'], $style);
			theme_wrapper($widget_style, $widget);
		} else {
			echo $widget['content'];
		}
	}
	return true;
}

function theme_is_displayed_widget($widget) {
	$id = $widget['name'];
	$show_on = theme_get_widget_meta_option($id, 'theme_widget_show_on');
	
	$page_ids = explode(',', theme_get_widget_meta_option($id, 'theme_widget_page_ids_list'));
	$page_ids = array_map('trim', $page_ids);
	$page_ids = array_filter($page_ids, 'is_numeric');
	$page_ids = array_map('intval', $page_ids);
	if('all' != $show_on) {
		$selected = (theme_get_widget_meta_option($id, 'theme_widget_front_page') && is_front_page()) ||
			(theme_get_widget_meta_option($id, 'theme_widget_single_post') && is_single()) ||
			(theme_get_widget_meta_option($id, 'theme_widget_single_page') && is_page()) ||
			(theme_get_widget_meta_option($id, 'theme_widget_posts_page') && is_home()) ||
			(theme_get_widget_meta_option($id, 'theme_widget_page_ids') && !empty($page_ids) && is_page($page_ids));
		if( (!$selected && 'selected' == $show_on) ||
			($selected && 'none_selected' == $show_on) ) {
			return false;
		}
	}
	return true;
}

function theme_get_sidebar_places($name) {
	global $theme_sidebars;
	$places = array();
	foreach ($theme_sidebars as $key => $sidebar) {
		if (strpos($key, $name) !== false) {
			$widgets = theme_get_dynamic_sidebar_data($key);
			if (is_array($widgets)) {
				$widgets = array_filter($widgets, 'theme_is_displayed_widget');
				if(count($widgets) > 0) {
					$places[$key] = $widgets;
				}
			}
		}
	}
	return $places;
}

function theme_print_sidebar($name, $places) {
	$style = theme_get_option('theme_sidebars_style_' . $name);
	$place_count = count($places);
	if ($name != 'footer' && $place_count < 2) {
		theme_print_widgets(reset($places), $style);
		return;
	}
	?>
<div class="art-content-layout">
  <div class="art-content-layout-row">
	<?php
	
	foreach ($places as $place) {
		?>
	<div class="clearfix art-layout-cell art-layout-cell-size<?php echo $place_count; ?>">
	<?php if ($name == 'footer'): ?>
		<div class="art-center-wrapper">
		<div class="art-center-inner">
	<?php endif; ?>
		<?php
		theme_print_widgets($place, $style);
		?>
	<?php if ($name == 'footer'): ?>
		</div>
		</div>
	<?php endif; ?>
	</div>
	<?php
	}
	?>
  </div>
</div>
<?php
}
