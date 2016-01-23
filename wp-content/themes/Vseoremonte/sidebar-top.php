<?php
$places = theme_get_sidebar_places('top');
$count_widgets = array_sum(array_map('count', $places));
if($count_widgets > 0) {
	theme_print_sidebar('top', $places);
}
?>