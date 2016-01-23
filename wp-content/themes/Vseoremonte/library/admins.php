<?php

function theme_print_options() {
	global $theme_options;
	?>
	<div class="wrap">
		<div id="icon-themes" class="icon32"><br /></div>
		<h2><?php _e('Theme Options', THEME_NS); ?></h2>
		<?php
		if (isset($_REQUEST['Submit'])) {
			foreach ($theme_options as $value) {
				$id = theme_get_array_value($value, 'id');
				$val = stripslashes(theme_get_array_value($_REQUEST, $id));
				$type = theme_get_array_value($value, 'type');
				switch ($type) {
					case 'checkbox':
						$val = ($val ? 1 : 0);
						break;
					case 'numeric':
						$val = (int) $val;
						break;
				}
				update_option($id, $val);
			}
			echo '<div id="message" class="updated fade"><p><strong>' . __('Settings saved.', THEME_NS) . '</strong></p></div>' . "\n";
		}
		if (isset($_REQUEST['Reset'])) {
			foreach ($theme_options as $value) {
				delete_option(theme_get_array_value($value, 'id'));
			}
			echo '<div id="message" class="updated fade"><p><strong>' . __('Settings restored.', THEME_NS) . '</strong></p></div>' . "\n";
		}
		echo '<form method="post" id="theme_options_form">' . "\n";
		$in_form_table = false;
		$dependent_fields = array();
		foreach ($theme_options as $op) {
			$id = theme_get_array_value($op, 'id');
			$type = theme_get_array_value($op, 'type');
			$name = theme_get_array_value($op, 'name');
			$desc = theme_get_array_value($op, 'desc');
			$script = theme_get_array_value($op, 'script');
			$depend = theme_get_array_value($op, 'depend');
			if($depend) {
				$dependent_fields[] = array($depend, $id);
			}
			if ($type == 'heading') {
				if ($in_form_table) {
					echo '</table>' . "\n";
					$in_form_table = false;
				}
				echo '<h3>' . $name . '</h3>' . "\n";
				if ($desc) {
					echo "\n" . '<p class="description">' . $desc . '</p>' . "\n";
				}
			} else {
				if (!$in_form_table) {
					echo '<table class="form-table">' . "\n";
					$in_form_table = true;
				}
				echo '<tr valign="top">' . "\n";
				echo '<th scope="row">' . $name . '</th>' . "\n";
				echo '<td>' . "\n";
				$val = theme_get_option($id);
				theme_print_option_control($op, $val);
				if ($desc) {
					echo '<span class="description">' . $desc . '</span>' . "\n";
				}
				if ($script) {
					echo '<script>' . $script . '</script>' . "\n";
				}
				echo '</td>' . "\n";
				echo '</tr>' . "\n";
			}
		}
		if ($in_form_table) {
			echo '</table>' . "\n";
		}
		echo "<script>\r\n";
		for($i = 0; $i < count($dependent_fields); $i++) {
			echo "makeDependentField('{$dependent_fields[$i][0]}', '{$dependent_fields[$i][1]}');" . PHP_EOL;
		}
		echo "jQuery('#theme_options_form').bind('submit', function() {" . PHP_EOL .
			"    jQuery('input, textarea', this).each(function() {" . PHP_EOL .
			"        jQuery(this).removeAttr('disabled').removeClass('disabled');" . PHP_EOL .
			"    });" . PHP_EOL .
			"});" . PHP_EOL;
		echo "</script>" . PHP_EOL;
		?>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php echo esc_attr(__('Save Changes', THEME_NS)) ?>" />
			<input name="Reset" type="submit" class="button-secondary" value="<?php echo esc_attr(__('Reset to Default', THEME_NS)) ?>" />
		</p>
	</form>
	</div>
	<?php
}

function theme_print_option_control($op, $val) {
	$id = theme_get_array_value($op, 'id');
	$type = theme_get_array_value($op, 'type');
	$options = theme_get_array_value($op, 'options');
	switch ($type) {
		case "numeric":
			echo '<input	name="' . $id . '" id="' . $id . '" type="text" value="' . absint($val) . '" class="small-text" />' . "\n";
			break;
		case "select":
			echo '<select name="' . $id . '" id="' . $id . '">' . "\n";
			foreach ($op['options'] as $key => $option) {
				$selected = ($val == $key ? ' selected="selected"' : '');
				echo '<option' . $selected . ' value="' . $key . '">' . esc_html($option) . '</option>' . "\n";
			}
			echo '</select>' . "\n";
			break;
		case "textarea":
			echo '<textarea name="' . $id . '" id="' . $id . '" rows="10" cols="50" class="large-text code">' . esc_html($val) . '</textarea><br />' . "\n";
			break;
		case "radio":
			foreach ($op['options'] as $key => $option) {
				$checked = ( $key == $val ? 'checked="checked"' : '');
				echo '<input type="radio" name="' . $id . '" id="' . $id . '" value="' . esc_attr($key) . '" ' . $checked . '/>' . esc_html($option) . '<br />' . "\n";
			}
			break;
		case "checkbox":
			$checked = ($val ? 'checked="checked" ' : '');
			echo '<input type="checkbox" name="' . $id . '" id="' . $id . '" value="1" ' . $checked . '/>' . "\n";
			break;
		default:
			if ($type == 'text') {
				$class = 'regular-text';
			} else {
				$class = 'large-text';
			}
			echo '<input	name="' . $id . '" id="' . $id . '" type="text" value="' . esc_attr($val) . '" class="' . $class . '" />' . "\n";
			break;
	}
}

function theme_add_meta_boxes() {
	add_meta_box( 'theme_meta_box',
		__('Theme Options', THEME_NS),
		'theme_print_page_meta_box',
		'page',
		'side',
		'low'
	);
	add_meta_box( 'theme_meta_box',
		__('Theme Options', THEME_NS),
		'theme_print_post_meta_box',
		'post',
		'side',
		'low'
	);
	add_meta_box( 'theme_header_image_meta_box',
		__('Page Header Image', THEME_NS),
		'theme_print_page_header_image_meta_box',
		'page',
		'side',
		'low'
	);
	add_meta_box( 'theme_header_image_meta_box',
		__('Post Header Image', THEME_NS),
		'theme_print_page_header_image_meta_box',
		'post',
		'side',
		'low'
	);
}

/* Prints meta box content */

function theme_print_page_meta_box($post) {
	global $theme_page_meta_options;
	theme_print_meta_box($post->ID, $theme_page_meta_options);
}

function theme_print_post_meta_box($post) {
	global $theme_post_meta_options;
	theme_print_meta_box($post->ID, $theme_post_meta_options);
}

function theme_print_meta_box($post_id, $meta_options) {
	// Use nonce for verification
	wp_nonce_field('theme_meta_options', 'theme_meta_noncename');
	if (!isset($post_id))
		return;
	foreach ($meta_options as $option) {
		$id = theme_get_array_value($option, 'id');
		$name = theme_get_array_value($option, 'name');
		$desc = theme_get_array_value($option, 'desc');
		if(strpos($post_id, '-') === false) {
			$value = theme_get_meta_option($post_id, $id);
		} else {
			$value = theme_get_widget_meta_option($post_id, $id);
		}
		$necessary = theme_get_array_value($option, 'necessary');
		if ($necessary && !current_user_can($necessary))
			continue;
		echo '<p class="meta-options' . ($name ? ' named' : '') . '"><label class="selectit" for="' . $id . '"><strong>' . $name . '</strong></label><br />';
		theme_print_option_control($option, $value);
		if ($desc) {
			echo '<em>' . $desc . '</em>';
		}
		echo'</p>';
	}
}

add_action('wp_default_scripts', 'theme_custom_header_L10n');
add_action('admin_head', 'theme_header_image_script_control');
function theme_custom_header_L10n(&$scripts) {
	global $pagenow;
	if (('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow) && isset($_GET['type']) && 'image_header' === $_GET['type']) {
		$scripts->localize( 'common', 'themeL10n', array(
			'changeHeaderImage' => __('Change Header Image', THEME_NS)
		));
	}
}

function theme_custom_header_form_url($form_action_url, $type) {
	return str_replace('type=' . $type . '&', 'type=image_header&', $form_action_url);
}

function theme_header_image_script_control() {
	global $pagenow;
	if (('media-upload.php' != $pagenow && 'async-upload.php' != $pagenow) || 'image_header' !== $_GET['type']) {
		return;
	}
	add_filter('media_upload_form_url', 'theme_custom_header_form_url', 10, 2);
	?>
	<script>
		jQuery(function($){
			$('#image-form').live('submit', function() {
				$('.image-size-item input[value="full"]').attr('checked', true);
				return true;
			});
			$('.savesend input[type=submit], #insertonlybutton').val(themeL10n.changeHeaderImage);
			uploader.bind('FileUploaded', function(up, file, response) {
				var interval = setInterval(function() {
					var button = $('#media-item-' + file.id).find('.savesend input[type=submit], #insertonlybutton');
					var error = $('#media-item-' + file.id).find('.error-div');
					if(error.length || button.length) {
						button.val(themeL10n.changeHeaderImage);
						clearInterval(interval);
					}
				}, 10);
			});
		});
	</script>
	<style>
		body#media-upload #tab-type_url,
		body#media-upload #tab-nextgen,
		body#media-upload p.ml-submit,
		body#media-upload p.savebutton.ml-submit,
		#media-upload tr.post_excerpt,
		#media-upload tr.post_title,
		#media-upload tr.url,
		#media-upload tr.align,
		#media-upload tr.image-size,
		#media-upload tr.image_alt,
		#media-upload tr.post_content,
		#media-upload a.del-link ,
		#media-upload a.wp-post-thumbnail
			display:none !important;
		}
	</style>
	<?php
}

function theme_print_page_header_image_meta_box($post) {
	$theme_header_image = theme_get_meta_option($post->ID, 'theme_header_image');
	$theme_header_image_with_flash = theme_get_meta_option($post->ID, 'theme_header_image_with_flash') ? 'checked="checked" ' : '';
	?>
	<input id="upload_image_input" type="hidden" size="20" tabindex="6"  name="theme_header_image" value="<?php echo $theme_header_image; ?>" autocomplete="off" />
	<p class="hide-if-no-js image_control">
		<a href="#" class="upload_image">
			<img id="upload_image_image" src="<?php echo $theme_header_image; ?>" width="260" alt="Header Image" />
		</a>
		<br>
		
		<a href="#" id="remove_image_button"><?php echo __("Remove header image", THEME_NS); ?></a>
	</p>
	<p class="hide-if-no-js">
		<a href="#" class="upload_image" id="upload_image_button" ><?php echo __("Set header image", THEME_NS); ?></a>
	</p>
	<style>
	</style>
	<script>
		if(jQuery("#upload_image_input").val() == ""){
			jQuery('.image_control').hide();
		} else {
			jQuery("#upload_image_button").hide();
		}
		jQuery(document).ready(function($) {
			jQuery(".upload_image").click(function() {
				window.send_to_editor_default = window.send_to_editor;
				window.send_to_editor = function(html) {
					imgurl = jQuery("img", html).attr("src");
					jQuery("#upload_image_image").attr("src", imgurl);
					jQuery("#upload_image_input").val(imgurl);
					jQuery("#upload_image_button").hide();
					jQuery('.image_control').show();
					tb_remove();
				};
				tb_show("", "media-upload.php?type=image_header&post_id=<?php echo $post->ID; ?>&TB_iframe=true");
				return false;
			});
			jQuery("#remove_image_button").click(function() {
				jQuery("#upload_image_image").attr("src", "");
				jQuery("#upload_image_input").val("");
				jQuery('.image_control').hide();
				jQuery("#upload_image_button").show();
				return false;
			});
			jQuery("#TB_window").live("tb_unload", function(){
				if (window.send_to_editor_default)
					window.send_to_editor = window.send_to_editor_default;
			});
		});
	</script>
	<?php
}

// post metadata
/* When the post is saved, saves our data */
function theme_save_post($post_id) {
	global $theme_post_meta_options, $theme_page_meta_options, $theme_page_header_image_meta_options;
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if (!isset($_POST['theme_meta_noncename']) || !wp_verify_nonce($_POST['theme_meta_noncename'], 'theme_meta_options')) {
		return $post_id;
	}

	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
	// to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;

	$meta_options = null; //posts
	if ('page' == $_POST['post_type']) {
		// Check permissions
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
		$meta_options = $theme_page_meta_options;
	}

	if ('post' == $_POST['post_type']) {
		$meta_options = $theme_post_meta_options;
	}

	$meta_options = array_merge($meta_options, $theme_page_header_image_meta_options);

	if (!$meta_options)
		return $post_id;
	// OK, we're authenticated: we need to find and save the data
	foreach ($meta_options as $value) {
		$id = theme_get_array_value($value, 'id');
		$val = stripslashes(theme_get_array_value($_REQUEST, $id));
		$type = theme_get_array_value($value, 'type');
		$necessary = theme_get_array_value($value, 'necessary');
		if ($necessary && !current_user_can($necessary))
			continue;
		switch ($type) {
			case 'checkbox':
				$val = ($val ? 1 : 0);
				break;
			case 'numeric':
				$val = (int) $val;
				break;
		}
		theme_set_meta_option($post_id, $id, $val);
	}
	return $post_id;
}

add_action('admin_head-widgets.php', 'admin_head_widgets_style');
function admin_head_widgets_style() {
	echo <<<EOL
<style>
.widget .widget-inside p.meta-options {
	margin: 0px;
	line-height: 6px;
}
.widget .widget-inside p.meta-options.named {
	line-height: 20px;
}
label.selectit {
	padding: 6px 0px;
}
</style>
EOL;
}

add_action('admin_print_scripts-appearance_page_functions', 'theme_dependent_field_scripts');
function theme_dependent_field_scripts() {
	?>
<script>
function makeDependentField(master, slave) {
    var $ = jQuery;
    master = $('#' + master);
    slave = $('#' + slave);
    master.bind('click', switchDependentField);
    switchDependentField.call(master);
    function switchDependentField() {
        if($(this).attr('checked')) {
            slave.removeAttr('disabled').removeClass('disabled');
        } else {
            slave.attr('disabled', 'disabled').addClass('disabled');
        }
    }
}
</script>
<?php
}

add_action('admin_head-widgets.php', 'theme_dependent_widget_field_scripts');
function theme_dependent_widget_field_scripts() {
	global $theme_widget_meta_options;
	?>
<script>
function makeDependentField(masters, slave) {
    var $ = jQuery, master_value;
    var context = $('script').last().parents('form');
    masters = parseMastersOption(masters);
    $('form').each(function(){
        switchDependentField.call($(this).children()[0]);
    });
    $('body').ajaxComplete(function() {
        $('form').each(function(){
            switchDependentField.call($(this).children()[0]);
        });
    });
    function switchDependentField() {
        var context = $(this).parents('form');
        var slave_element = $('#' + slave, context).parents('p.meta-options');
        for (var i = 0; i < masters.length; i++) {
            var master = $(masters[i].element, context);
            if (!(masters[i].values && $.inArray(master.val(), masters[i].values) !== -1 || master.attr('checked'))) {
                slave_element.hide();
                return;
            }
        }
        slave_element.show();
    }
    function parseMastersOption(masters) {
        masters = $.map(masters.split(';'), function (el) {
            el = el.split(':');
            el[0] = '#' + el[0];
            $(el[0]).live('click', switchDependentField);
            if (el[1]) {
                el[1] = el[1].split(',');
            }
            return {element: el[0], values: el[1]};
        });
        return masters;
    }
}
</script>
<?php
	echo "<script>" . PHP_EOL;
	echo "jQuery(function() {" . PHP_EOL;
	foreach ($theme_widget_meta_options as $op) {
		$id = theme_get_array_value($op, 'id');
		$depend = theme_get_array_value($op, 'depend');
		if($depend) {
			echo "makeDependentField('{$depend}', '{$id}');" . PHP_EOL;
		}
	}
	echo "});" . PHP_EOL;
	echo "</script>" . PHP_EOL;
}