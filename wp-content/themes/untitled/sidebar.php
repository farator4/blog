
<?php if(theme_has_layout_part("left_sidebar")) : ?>
<?php
$places = theme_get_sidebar_places('default');
$count_widgets = array_sum(array_map('count', $places));
if($count_widgets > 0) {
?>
<div class="art-layout-cell art-sidebar1 clearfix">
<?php
	theme_print_sidebar('default', $places);
?>




                        </div><?php
}
?>
<?php endif; ?>
