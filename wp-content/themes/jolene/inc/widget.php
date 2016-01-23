<?php
/**
 * Add a widget
 */
class jolene_ExtendedWidget extends WP_Widget {

	function jolene_ExtendedWidget() {

		/* Widget settings. */
		$widget_ops = array(
		'classname' => 'jolene_extended',
		'description' => __('Display posts, pages, images, slideshow, news, related posts and more.', 'jolene' ));

		/* Widget control settings. */
		$control_ops = array(
		'width' => 250,
		'height' => 250,
		'id_base' => 'jolene_extended_widget');

		/* Create the widget. */
		parent::__construct( 'jolene_extended_widget', __( 'News, Related, Slideshow', 'jolene' ), $widget_ops, $control_ops );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );
	}
	public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		wp_enqueue_media();
		wp_enqueue_script( 'jolene-upload-image', get_template_directory_uri() . '/js/meta-box-image.js', array('jquery') );

	}
	public function print_scripts() {
	?>
		<script>
			( function( $ ){
					function initColorPicker( widget ) {
							widget.find( '.color-picker' ).wpColorPicker( {
									change: _.throttle( function() { // For Customizer
											$(this).trigger( 'change' );
									}, 3000 )
							});
					}
						function onFormUpdate( event, widget ) {
							initColorPicker( widget );
					}
					$( document ).on( 'widget-added widget-updated', onFormUpdate );

					$( document ).ready( function() {
							$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
									initColorPicker( $( this ) );
							} );
					} );
			}( jQuery ) );
		</script>
	<?php
	}

	function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) );
		$instance = wp_parse_args( (array) $instance, $this->defaults_for_count($instance, $instance['number_of_posts']) ); 
		
		// Widget output
		extract($args);
		$sidebar_id = $args['id'];
		$widget_id = $args['widget_id'];
		$style = $instance['style'];

		$width = $this->getWidth($sidebar_id, $instance['columns'], $instance['padding-right'], $instance['padding-left']);
		$post_thumbnail_size = $this->get_image_width( $width, $style, $instance['image_size'] );
		
		$excludelist = '';
		$catids = '';
		$hidden = '';
		$is_slide_buttons = 0;
		$slide_buttons = '';
		$script = '';
		$on_slide = 0;

		//add special classes to animated widgets
		if($instance['is_animate'] != '' && isset($instance['animate_style'])) {
			$hidden .= ' hidden-widget '.$instance['animate_style'];//is it an animated widget
		}
		else if($instance['is_slider'] != '') {
			$hidden .= ' slider-widget '.$instance['animate_style'].' '.$widget_id;//or is it a slider
			if($instance['text_on_slide'] != '') {
				$hidden .= ' text-on-slide '.$instance['animate_style'];
				$on_slide = 1;
			}
			//add buttons for slider navigation
			$is_slide_buttons = 1;
			$str_id = 0;
			preg_match_all('!\d+!', $widget_id, $matches);
			$str_id = absint(implode(' ', $matches[0]));
			//print global variables for js script
			$script = '<script type="text/javascript">
							if( typeof jolene_animtype == "undefined") {
								var jolene_animtype = [];
								typeof jolene_animtype;
							}
							if( typeof jolene_slidespeed == "undefined") {
								var jolene_slidespeed = [];
								typeof jolene_slidespeed;
							}
							if( typeof jolene_timerinterval == "undefined") {
								var jolene_timerinterval = [];
								typeof jolene_timerinterval;
							}					
							if( typeof jolene_textonslide == "undefined") {
								var jolene_textonslide = [];
								typeof jolene_textonslide;
							}							
							jolene_animtype['.$str_id.'] = '. esc_js($instance['slider_style']).';
							jolene_slidespeed['.$str_id.'] = '. esc_js($instance['slide_effect_speed']).';
							jolene_timerinterval['.$str_id.'] = '. esc_js($instance['slide_speed']).';
							jolene_textonslide['.$str_id.'] = '. esc_js($on_slide).';
							
					   </script>';
		}
		
		$out = '<div class="wrap-list'.esc_attr($hidden).'">';//add classes to .wrap-list in case of animation

		if( $instance['is_show_custom_blocks'] == ''  ) {
			if($instance['is_exclude_current_page_title'] != ''){//exclude current post from the output
				global $post;
				if($post) {
					$excludelist = '&exclude='.$post->ID;
				}
			}
			if($instance['is_use_current_category'] != '') {//posts from the current category only
				global $post;
				if($post) {
					$catids = implode(wp_get_post_categories($post->ID), ',');
				}
			}
			
			if(trim($instance['page_ids']) != '') {//pages ids from user list only
				$posts = get_pages('include='.$instance['page_ids']);
			}
			else if(trim($instance['post_ids']) != '') {//or posts ids from user list only
				$posts = get_posts('has_password=0&include='.($instance['post_ids']));
			}
			else if($catids != '') {//else if we have cat ids, get it
				$posts = get_posts('has_password=0&numberposts='.$instance['number_of_posts'].'&category='.$catids.$excludelist);
			}
			else {//get posts
				$posts = get_posts('has_password=0&numberposts='.$instance['number_of_posts'].'&category='.($instance['cat_id'] == -1 ? '' : $instance['cat_id']).
						'include='.$instance['post_ids'].$excludelist);
			}
			$buttont = '';
			foreach($posts as $currpost) { 
				$content = '';
				$buttont = '';
				$img = '';
				if( $instance['is_use_icon'] != '' && ($style == '0' || $style == '3') ){
					$img = '<img class="icon" src="'.esc_url($instance['icon']).'" width="'.esc_attr($instance['icon_w']).'" height="'.esc_attr($instance['icon_h']).'">';
				}
				if( $instance['is_show_title'] != '') {
					$content = '<a class="w-head" href="'.esc_url(get_permalink($currpost->ID)).'">'.$img.$this->notEmpty(strip_tags($currpost->post_title)).'</a>';
				}
				if( $instance['is_show_content'] != '') {
					$content .= '<br>'.$this->getContent(apply_filters( 'the_content', $currpost->post_content), $instance['content_length']);
				}

				if( $instance['is_use_link_button'] != '' ){//add button
					if( $instance['is_use_link_more_custom_link'] != '' ) {
						$link = esc_url($instance['link_more_custom_link']);
					}
					else {
						$link = esc_url(get_permalink($currpost->ID));
					}
					$buttont = '<br><a class="link-read-more" href="'.$link.'">'.$this->notEmpty(sanitize_text_field($instance['link_more_text']), __('Read more...', 'jolene')).'</a>';
				}

				switch ( $style ) {
				//image on top
					case '0':
						$out .= '<span class="style-'.$style.' header-list"><a href="'.esc_url(get_permalink($currpost->ID)).'">'.get_the_post_thumbnail($currpost->ID, $post_thumbnail_size).'</a>';
						$out .= '<span class="style-'.$style.' footer-list">'.$content.'</span>'.$buttont.'</span>';
					break;
				//image on right
					case '1':	
						$out .= '<span class="style-1 header-list"><a href="'.esc_url(get_permalink($currpost->ID)).'">'.get_the_post_thumbnail($currpost->ID, $post_thumbnail_size).'</a>'.$content.$buttont.'</span>';
					break;
				//image on left
					case '2':
						$out .= '<span class="style-2 header-list"><a href="'.esc_url(get_permalink($currpost->ID)).'">'.get_the_post_thumbnail($currpost->ID, $post_thumbnail_size).'</a>'.$content.$buttont.'</span>';
					break;
				//no image
					case '3':
						$out .= '<span class="style-'.$style.' header-list">';
						$out .= '<span class="style-'.$style.' footer-list">'.$content.'</span>'.$buttont.'</span>';				
					break;
				}
				
				if($is_slide_buttons) {//add one more button for slider
					$slide_buttons .= '<li></li>';
				}
			}
		} else {
		
			for($i = 0; $i < $instance['number_of_posts']; $i++) { 
				$content = '';
				$img = '';
				$buttont = '';
				
				if( $instance['is_show_custom_link'] != '' ) {
					$buttont  = '<br><a class="link-read-more" href="'.esc_url($instance['link_'.$i]).'">'.$this->notEmpty(sanitize_text_field($instance['link_caption_'.$i]), __('Read more...', 'jolene')).'</a>';
				}
				elseif( $instance['is_use_link_button'] != '' ){//add button
					$buttont = esc_url($instance['link_more_custom_link']);
					$buttont = '<br><a class="link-read-more" href="'.$buttont.'">'.$this->notEmpty(sanitize_text_field($instance['link_more_text']), __('Read more...', 'jolene')).'</a>';
				}
				
				if( $instance['is_use_icon'] != '' && ($style == '0' || $style == '3') ){
					$img = '<img class="icon" src="'.esc_url($instance['icon']).'" width="'.esc_attr($instance['icon_w']).'" height="'.esc_attr($instance['icon_h']).'">';
				}
				if( $instance['is_show_custom_title'] != '') {
					$content = '<a class="w-head" href="'.esc_url($instance['link_'.$i]).'">'.esc_html($instance['title_'.$i]).'</a>';
				}
				if( $instance['is_show_custom_content'] != '') {
					$content .= esc_html($instance['text_'.$i]); 
				}
				
				$img = '';
				if( '3' != $style ) {
					if('' == $instance['is_use_image_url'])
						$img = wp_get_attachment_image($instance['image_'.$i], $post_thumbnail_size);
					else
						$img = '<img src='.esc_url($instance['image_url_'.$i]).'>';
				}

				switch ( $style ) {
				//image on top
					case '0':
						$out .= '<span class="style-'.$style.' header-list"><a href="'.esc_url($instance['link_'.$i]).'">'.$img.'</a>';
						$out .= '<span class="style-'.$style.' footer-list">'.$content.'</span>'.$buttont.'</span>';
					break;
				//image on right
					case '1':
						$out .= '<span class="style-1 header-list"><a href="'.esc_url($instance['link_'.$i]).'">'.$img.'</a>'.$content.$buttont.'</span>';
					break;
				//image on left
					case '2':
						$out .= '<span class="style-2 header-list"><a href="'.esc_url(get_permalink($currpost->ID)).'">'.$img.'</a>'.$content.$buttont.'</span>';
					break;
				//no image
					case '3':
						$out .= '<span class="style-'.$style.' header-list">';
						$out .= '<span class="style-'.$style.' footer-list">'.$content.'</span>'.$buttont.'</span>';				
					break;
				}
				
				if($is_slide_buttons) {//add one more button for slider
					$slide_buttons .= '<li></li>';
				}
			}
		}
	
		if($is_slide_buttons) {//for slider
			$out .= '<ul class="slider-buttons">'.$slide_buttons.'</ul>';
		}
		
		$out .= '</div>';	

		//print the widget for the sidebar
		echo ($script);//variables for js script (time and amination type)
		echo $before_widget;
		if(trim($instance['title']) !== '') echo $before_title.esc_html($instance['title']).$after_title;
		echo $out;
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		foreach ( $new_instance as $key => $instance ) {
			$new_instance[$key] = strip_tags($new_instance[$key], '<a><b><i>');
		}
		$new_instance['number_of_posts'] = absint($new_instance['number_of_posts']);
		$new_instance['number_of_posts'] = ( $new_instance['number_of_posts'] == 0 ? 1 : $new_instance['number_of_posts']);
		
		if( isset($new_instance['is_exclude_current_page_title']) )
			$new_instance['is_exclude_current_page_title'] = 1;		
		if( isset($new_instance['is_image_fixed']) )
			$new_instance['is_image_fixed'] = 1;
		if( isset($new_instance['is_use_current_category']) )
			$new_instance['is_use_current_category'] = 1;
		if( isset($new_instance['is_use_background_image']) )
			$new_instance['is_use_background_image'] = 1;
		if( isset($new_instance['is_hide_on_small_screen']) )
			$new_instance['is_hide_on_small_screen'] = 1;
		if( isset($new_instance['is_repeat_x']) )
			$new_instance['is_repeat_x'] = 1;
		if( isset($new_instance['is_repeat_y']) )
			$new_instance['is_repeat_y'] = 1;
		if( isset($new_instance['is_use_background_color']) )
			$new_instance['is_use_background_color'] = 1;
		if( isset($new_instance['is_show_title']) )
			$new_instance['is_show_title'] = 1;
		if( isset($new_instance['is_show_custom_title']) )
			$new_instance['is_show_custom_title'] = 1;
		if( isset($new_instance['is_show_custom_content']) )
			$new_instance['is_show_custom_content'] = 1;
		if( isset($new_instance['is_show_custom_image']) )
			$new_instance['is_show_custom_image'] = 1;
		if( isset($new_instance['is_show_custom_link']) )
			$new_instance['is_show_custom_link'] = 1;
		if( isset($new_instance['is_use_border']) )
			$new_instance['is_use_border'] = 1;
		if( isset($new_instance['is_use_link_button']) ) 
			$new_instance['is_use_link_button'] = 1;
		if( isset($new_instance['is_use_link_more_custom_link']) )
			$new_instance['is_use_link_more_custom_link'] = 1;
		if( isset($new_instance['is_use_icon']) )
			$new_instance['is_use_icon'] = 1;
		if( isset($new_instance['is_animate']) )
			$new_instance['is_animate'] = 1;
		if( isset($new_instance['is_slider']) )
			$new_instance['is_slider'] = 1;
		if( isset($new_instance['text_on_slide']) )
			$new_instance['text_on_slide'] = 1;		
		if( isset($new_instance['is_use_image_url']) )
			$new_instance['is_use_image_url'] = 1;
			
		
		$possible_values = array( '1', '2', '4', '8' );
		$new_instance['columns'] = ( in_array( $new_instance['columns'], $possible_values ) ? $new_instance['columns'] : '4' );
		$new_instance['cat_id'] = absint($new_instance['cat_id']);
		$new_instance['post_ids'] = $this->sanitizeIDs($new_instance['post_ids']);
		$new_instance['page_ids'] = $this->sanitizeIDs($new_instance['page_ids']);
		$possible_values = array( '0', '1', '2', '3' );
		$new_instance['style'] = ( in_array( $new_instance['style'], $possible_values ) ? $new_instance['style'] : '0' );
		$new_instance['image_size'] = absint($new_instance['image_size']);
		$new_instance['background_image'] = esc_url_raw($new_instance['background_image']);
		$new_instance['background_color'] = $this->sanitize_hex_color($new_instance['background_color']);
		$new_instance['background_text_color'] = $this->sanitize_hex_color($new_instance['background_text_color']);
		$new_instance['main_title_color'] = $this->sanitize_hex_color($new_instance['main_title_color']);
		$new_instance['title_color'] = $this->sanitize_hex_color($new_instance['title_color']);
		$new_instance['text_color'] = $this->sanitize_hex_color($new_instance['text_color']);
		$new_instance['link_color'] = $this->sanitize_hex_color($new_instance['link_color']);
		$possible_values = array( 'right', 'left', 'center' );
		$new_instance['pos_x'] = ( in_array( $new_instance['pos_x'], $possible_values ) ? $new_instance['pos_x'] : '0' );
		$possible_values = array( 'top', 'bottom', 'center' );
		$new_instance['pos_y'] = ( in_array( $new_instance['pos_y'], $possible_values ) ? $new_instance['pos_y'] : '0' );
		$new_instance['title_size'] = absint($new_instance['title_size']);
		$new_instance['title_size'] = ($new_instance['title_size'] < 90 ? $new_instance['title_size'] : 90);
		$new_instance['text_size'] = absint($new_instance['text_size']);
		$new_instance['text_size'] = ($new_instance['text_size'] < 90 ? $new_instance['text_size'] : 90);
		$new_instance['link_size'] = absint($new_instance['link_size']);
		$new_instance['link_size'] = ($new_instance['link_size'] < 90 ? $new_instance['link_size'] : 90);
		$new_instance['content_length'] = absint($new_instance['content_length']);
		$new_instance['custom_title'] = esc_html($new_instance['custom_title']);
		$new_instance['custom_content'] = esc_html($new_instance['custom_content']);
		$new_instance['border_color'] = $this->sanitize_hex_color($new_instance['border_color']);
		$new_instance['link_more_background_color'] = $this->sanitize_hex_color($new_instance['link_more_background_color']);
		$new_instance['link_more_text_color'] = $this->sanitize_hex_color($new_instance['link_more_text_color']);
		$new_instance['link_more_border_color'] = $this->sanitize_hex_color($new_instance['link_more_border_color']);
		$new_instance['link_more_custom_link'] = esc_url_raw($new_instance['link_more_custom_link']);
		$possible_values = array( 'dotted', 'dashed', 'solid', 'double', 'groove', 'ridge', 'inset', 'outset' );
		$new_instance['border_style'] = ( in_array( $new_instance['border_style'], $possible_values ) ? $new_instance['border_style'] : 'double');
		$new_instance['link_more_border_style'] = ( in_array( $new_instance['link_more_border_style'], $possible_values ) ? $new_instance['link_more_border_style'] : 'solid');
		$new_instance['link_more_text'] = esc_html($new_instance['link_more_text']);
		$new_instance['border_width'] = absint($new_instance['border_width']);
		$new_instance['border_radius'] = absint($new_instance['border_radius']);
		$new_instance['link_more_text_size'] = absint($new_instance['link_more_text_size']);
		$new_instance['link_more_border_width'] = absint($new_instance['link_more_border_width']);
		$new_instance['link_more_border_radius'] = absint($new_instance['link_more_border_radius']);
		$new_instance['padding-top'] = absint($new_instance['padding-top']);
		$new_instance['padding-right'] = absint($new_instance['padding-right']);
		$new_instance['padding-right'] = ($new_instance['padding-right'] < 1349 ? $new_instance['padding-right'] : 0);
		$new_instance['padding-right'] = absint($new_instance['padding-right']);
		$new_instance['padding-bottom'] = absint($new_instance['padding-bottom']);
		$new_instance['padding-left'] = absint($new_instance['padding-left']);
		$new_instance['padding-left'] = ($new_instance['padding-left'] < 1349 ? $new_instance['padding-left'] : 0);
		$new_instance['icon_h'] = absint($new_instance['icon_h']);
		$new_instance['icon_w'] = absint($new_instance['icon_w']);
		$possible_values = array( 'step', 'all' );
		$new_instance['animate_style'] = ( in_array( $new_instance['animate_style'], $possible_values ) ? $new_instance['animate_style'] : 'step');
		$new_instance['element_margin'] = absint($new_instance['element_margin']);
		$new_instance['element_margin'] = ($new_instance['element_margin'] < 80 ? $new_instance['element_margin'] : 80);
		
		for( $i = 0; $i < $new_instance[$count]; $i++ ) {
			$new_instance['title_'.$i] = esc_html($new_instance['title_'.$i]); 
			$new_instance['text_'.$i] = esc_html($new_instance['text_'.$i]); 
			$new_instance['link_'.$i] = esc_url_raw($new_instance['link_'.$i]);
			$new_instance['image_'.$i] = absint($new_instance['image_'.$i]);
			$new_instance['link_caption_'.$i] = esc_html($new_instance['link_caption_'.$i]); 
			$new_instance['image_url_'.$i] = esc_url_raw($new_instance['image_url_'.$i]); 				
		}
		
		//Slider
		if(array_key_exists('is_slider', $new_instance)) {//force 1 column/image on top/padding 0
			$new_instance['columns'] = 1;
			$new_instance['style'] = 0;
			
			$new_instance['padding-top'] = 0;
			$new_instance['padding-right'] = 0;
			$new_instance['padding-bottom'] = 0;
			$new_instance['padding-left'] = 0;
		}
		
		$possible_values = array( '1', '2', '3', '4' );
		$new_instance['slider_style'] = ( in_array( $new_instance['slider_style'], $possible_values ) ? $new_instance['slider_style'] : '3');
		$new_instance['slide_speed'] = absint($new_instance['slide_speed']);
		$new_instance['slide_effect_speed'] = absint($new_instance['slide_effect_speed']);

		return $new_instance;
	}

	function form( $instance ) {
		// Output admin widget options form
		$isnotsaved = 0;
		if( $instance == null ) {
			$isnotsaved = 1;
		}
		// Set up some default widget settings. 
		$instance = wp_parse_args( (array) $instance, $this->defaults( $instance ) );
		$instance = wp_parse_args( (array) $instance, $this->defaults_for_count($instance, $instance['number_of_posts']) ); 
	
	    $this->echo_input_text('title', $instance, __( 'Title: ', 'jolene' )); ?>
		<p>
		<?php $this->echo_input_text('number_of_posts', $instance, __( 'Number of posts: ', 'jolene'), 0, 2); ?>
		</p>	
		
		<?php $this->echo_input_checkbox('is_show_custom_blocks', $instance, __( 'Display custom blocks', 'jolene')); ?>

		<hr>
		<?php esc_html_e('Number of columns:', 'jolene'); ?>
		<select id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo esc_attr($this->get_field_name('columns')); ?>" style="width:100%;">
		<?php 
			$styles_ids=array('1', '2', '4', '8');

			for ($i=0; $i<4; $i++) {
				echo '<option value="'.esc_attr($styles_ids[$i]).'" ';
				selected( $instance['columns'], $styles_ids[$i] );
				echo '>'.esc_html($styles_ids[$i]).'</option>';
			}
		?>
		</select>
		<hr>
		<p>
		<?php $this->echo_input_text('element_margin', $instance, __( 'Space Between Elements (%): ', 'jolene'), 0, 2); ?>
		</p>

		<?php if($instance['is_show_custom_blocks'] == '') : ?>
			<p>
				<label for="<?php echo $this->get_field_id('cat_id'); ?>"><?php _e('Category ID:', 'jolene'); ?></label>
				<?php wp_dropdown_categories('show_option_all='.__('any', 'jolene').'&hide_empty=0&hierarchical=1&id='.$this->get_field_id('cat_id').'&name='.$this->get_field_name('cat_id').'&selected='.esc_attr($instance['cat_id'])); ?>
			</p>

			<p>
			<?php $this->echo_input_text('post_ids', $instance, __( 'Post Ids(the value for this field must be a list of integers, separated by commas):', 'jolene'), 0, 15); ?>
			</p>
			<p>
			<?php $this->echo_input_text('page_ids', $instance, __( 'Page Ids(The value for this field must be a list of integers, separated by commas):', 'jolene'), 0, 15); ?>
			</p>
			<?php $this->echo_input_checkbox('is_exclude_current_page_title', $instance, __( 'Exclude current post (Yes/No).', 'jolene')); ?>
			<?php $this->echo_input_checkbox('is_use_current_category', $instance, __( 'Display recent posts from current category (Yes/No).', 'jolene')); ?>

			<hr>
		<?php endif; ?>
		
		<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Choose how to display an Image:', 'jolene'); ?></label>
		<hr>
		<select id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>" style="width:100%;">
		<?php 
			$styles=array( __('Top', 'jolene'), __('Right', 'jolene'), __('Left', 'jolene'), __('None', 'jolene'));
			for ($i=0;$i<4;$i++) {
				echo '<option value="'.esc_attr($i).'" ';
				selected( $instance['style'], $i );
				echo '>'.esc_html($styles[$i]).'</option>';
			}
		?>
		</select>
		<hr>
		<?php $this->echo_input_text('image_size', $instance, __( 'Image size (%) for images with left and right alignment: ', 'jolene'), 0, 2); ?>
		<?php $this->echo_input_checkbox('is_use_background_image', $instance, __( 'Display background Image(Yes/No)', 'jolene')); ?>
		<?php $this->echo_input_checkbox('is_image_fixed', $instance, __( 'Fixed', 'jolene')); ?>
		<?php $this->echo_input_checkbox('is_hide_on_small_screen', $instance, __( 'Hide on small screen(Yes/No)', 'jolene')); ?>
		<?php $this->echo_input_upload('background_image', $instance, __( 'Upload background Image:', 'jolene')); ?>
		<hr>
		<p>
		<?php $this->echo_input_checkbox('is_repeat_x', $instance, __( 'Repeat X', 'jolene'), 0); ?>
		<?php $this->echo_input_checkbox('is_repeat_y', $instance, __( 'Repeat Y', 'jolene'), 0); ?>
		</p>
		<hr>
		<?php esc_html_e('Display image on:', 'jolene'); ?>
		<hr>
		<?php esc_html_e('X Position:', 'jolene'); ?>
		<select id="<?php echo $this->get_field_id('pos_x'); ?>" name="<?php echo $this->get_field_name('pos_x'); ?>" style="width:100%;">
		<?php 
			$styles=array( __('Left', 'jolene'), __('Right', 'jolene'), __('Center', 'jolene'));
			$styles_ids=array('left', 'right', 'center');

			for ($i=0; $i<3; $i++) {
				echo '<option value="'.esc_attr($styles_ids[$i]).'" ';
				selected( $instance['pos_x'], $styles_ids[$i] );
				echo '>'.esc_html($styles[$i]).'</option>';
			}
		?>
		</select>
		<hr>
		
		<?php esc_html_e('Y Position:', 'jolene'); ?>
		<select id="<?php echo $this->get_field_id('pos_y'); ?>" name="<?php echo $this->get_field_name('pos_y'); ?>" style="width:100%;">
		<?php 
			$styles=array( __('Top', 'jolene'), __('Bottom', 'jolene'), __('Center', 'jolene'));
			$styles_ids=array('top', 'bottom', 'center');

			for ($i=0; $i<3; $i++) {
				echo '<option value="'.esc_attr($styles_ids[$i]).'" ';
				selected( $instance['pos_y'], $styles_ids[$i] );
				echo '>'.esc_html($styles[$i]).'</option>';
			}
		?>
		</select>
		<hr>
		<?php esc_html_e('Colors:', 'jolene'); ?>
		<hr>
		
		<?php $this->echo_input_checkbox('is_use_background_color', $instance, __( 'Set Custom Colors(Yes/No)', 'jolene')); ?>
		<?php $this->echo_input_color('background_color', $instance, __( 'Background:', 'jolene'), '#ffffff'); ?>
		<?php $this->echo_input_color('main_title_color', $instance, __( 'Widget Title:', 'jolene'), '#000'); ?>
		<?php $this->echo_input_color('title_color', $instance, __( 'Title:', 'jolene'), '#118412'); ?>
		<?php $this->echo_input_color('text_color', $instance, __( 'Text:', 'jolene'), '#757575'); ?>
		<?php $this->echo_input_color('link_color', $instance, __( 'Link:', 'jolene'), '#d57b00'); ?>
		<hr>
		
		<?php esc_html_e('Font size:', 'jolene'); ?>
		
		<hr>
		<p>
		<?php $this->echo_input_text('title_size', $instance, __( 'Title:', 'jolene'), 0, 2); ?>
		<?php $this->echo_input_text('text_size', $instance, __( 'Text:', 'jolene'), 0, 2); ?>
		<?php $this->echo_input_text('link_size', $instance, __( 'Link:', 'jolene'), 0, 2); ?>
		</p>
		
		<?php if($instance['is_show_custom_blocks'] == '') : ?>
			<?php $this->echo_input_checkbox('is_show_title', $instance, __( 'Display the title', 'jolene')); ?>
			
			<?php $this->echo_input_checkbox('is_show_content', $instance, __( 'Display the content', 'jolene')); ?>
			<p>
			<?php $this->echo_input_text('content_length', $instance, __( 'Number of characters: ', 'jolene'), 0, 4); ?>
			</p>
		<?php endif; ?>
		
		<?php if($instance['is_show_custom_blocks'] != '') :
			$this->echo_input_checkbox('is_show_custom_title', $instance, __( 'Display custom title', 'jolene'));
			$this->echo_input_checkbox('is_show_custom_content', $instance, __( 'Display custom content', 'jolene'));
			$this->echo_input_checkbox('is_show_custom_image', $instance, __( 'Display custom Image', 'jolene'));
			$this->echo_input_checkbox('is_show_custom_link', $instance, __( 'Display custom Link', 'jolene'));
			
			for( $i = 0; $i < $instance['number_of_posts']; $i++) {
				?> 
				<hr>
				<hr>
				<p style="font-size: 30px; color: red; "> 
					<?php 
						esc_html_e('Block  ', 'jolene'); 
						echo ($i + 1); 
					?>
				</p>
				<hr>
				<hr>

				<?php 
				if( $instance['is_show_custom_image'])
					$this->echo_input_upload_id('image_'.$i, $instance, __( 'Image: ', 'jolene' ), 0);
				if( $instance['is_show_custom_title'] )
					$this->echo_input_text('title_'.$i, $instance, __( 'Header: ', 'jolene' ), 0);
				if( $instance['is_show_custom_content'] )
					$this->echo_input_textarea('text_'.$i, $instance, __( 'Text: ', 'jolene' ), 2);
				if( $instance['is_show_custom_link'] ) {
					$this->echo_input_text('link_'.$i, $instance, __( 'Link: ', 'jolene' ), 0);
					echo '<br>';
					$this->echo_input_text('link_caption_'.$i, $instance, __( 'Button Caption: ', 'jolene' ), 0);
				}
			} 
		endif; 
		?>
		
		<hr>
		
		<?php esc_html_e('Border:', 'jolene'); ?>
		
		<hr>
		<?php $this->echo_input_checkbox('is_use_border', $instance, __( 'Display an Image Border (Yes/No)', 'jolene')); ?>
		<?php $this->echo_select_border_style('border_style', $instance); ?>
		<?php $this->echo_input_color('border_color', $instance, __( 'Border color:', 'jolene'), '#ffffff'); ?>
		<p>
		<?php $this->echo_input_text('border_width', $instance, __( 'Border width:', 'jolene'), 0, 2); ?>
		<?php $this->echo_input_text('border_radius', $instance, __( 'Border radius', 'jolene'), 0, 2); ?>
		</p>
		<hr>		
		<?php $this->echo_input_checkbox('is_use_link_button', $instance, __( 'Display the "Read More" button (Yes/No)', 'jolene'), '#ffffff'); ?>
		<hr>
		<?php $this->echo_input_color('link_more_background_color', $instance, __( 'Button background:', 'jolene'), '#ffffff'); ?>
		<?php $this->echo_input_color('link_more_text_color', $instance, __( 'Button text color:', 'jolene'), '#000000'); ?>
		<?php $this->echo_input_text('link_more_text_size', $instance, __( 'Button text size:', 'jolene')); ?>
		<?php $this->echo_input_text('link_more_text', $instance, __( 'Button caption text:', 'jolene')); ?>
		<hr>		
		<?php $this->echo_input_checkbox('is_use_link_more_custom_link', $instance, __( 'Display a custom link (Yes/No):', 'jolene')); ?>
		<hr>
		<?php $this->echo_input_text('link_more_custom_link', $instance, __( 'Button URL:', 'jolene')); ?>
		
		<?php $this->echo_select_border_style('link_more_border_style', $instance); ?>
		<?php $this->echo_input_color('link_more_border_color', $instance, __( 'Button border color:', 'jolene'), '#000000'); ?>
		<hr>
		<?php $this->echo_input_text('link_more_border_width', $instance, __( 'Button border width:', 'jolene'),1, 1); ?>
		<?php $this->echo_input_text('link_more_border_radius', $instance, __( 'Button border radius', 'jolene'), 1, 2); ?>
		
		<hr>
		
		<?php esc_html_e('Margins:', 'jolene'); ?>
		
		<p>
		<?php $this->echo_input_text('padding-top', $instance, __( 'Top:', 'jolene'), 0, 2); ?>
		<?php $this->echo_input_text('padding-right', $instance, __( 'Right:', 'jolene'), 0, 2); ?>
		</p>
		<p>
		<?php $this->echo_input_text('padding-bottom', $instance, __( 'Bottom:', 'jolene'), 0, 2); ?>
		<?php $this->echo_input_text('padding-left', $instance, __( 'Left:', 'jolene'), 0, 2); ?>
		</p>
		<hr>
		<hr>		
		<?php $this->echo_input_checkbox('is_use_icon', $instance, __( 'Display an Icon (Yes/No)', 'jolene')); ?>
		<hr>
		<?php $this->echo_input_upload('icon', $instance, __( 'Upload an Image for the Icon:', 'jolene')); ?>
		<p>
		<?php $this->echo_input_text('icon_h', $instance, __( 'Icon Height:', 'jolene'), 0, 2); ?>
		<?php $this->echo_input_text('icon_w', $instance, __( 'Icon Width:', 'jolene'), 0, 2); ?>
		</p>
		<hr>
		<?php esc_html_e('Animate:', 'jolene'); ?>
		<hr>
		<?php $this->echo_input_checkbox('is_animate', $instance, __( '(Yes/No).', 'jolene')); ?>
		<hr>
		
		<select id="<?php echo $this->get_field_id('animate_style'); ?>" name="<?php echo $this->get_field_name('animate_style'); ?>" style="width:100%;">
		<?php 
			$styles=array( __('Step', 'jolene'), __('All', 'jolene'));
			$styles_ids=array('step', 'all');

			for ($i=0; $i<2; $i++) {
				echo '<option value="'.esc_attr($styles_ids[$i]).'" ';
				selected( $instance['animate_style'], $styles_ids[$i] );
				echo '>'.esc_html($styles[$i]).'</option>';
			}
		?>
		</select>
		
		<hr>
		<?php $this->echo_input_checkbox('is_slider', $instance, __( 'Slideshow(This option may override the options given in earlier fields)', 'jolene')); ?>

		<?php $this->echo_input_checkbox('text_on_slide', $instance, __('Place Text over an Image(Yes/No).', 'jolene')); ?>

		
		<select id="<?php echo $this->get_field_id('slider_style'); ?>" name="<?php echo $this->get_field_name('slider_style'); ?>" style="width:100%;">
		<?php 
			$styles=array( __('Fade In', 'jolene'), __('Top', 'jolene'), __('Right', 'jolene'), __('Left', 'jolene'));
			$styles_ids=array('1', '2', '3', '4');

			for ($i=0; $i<4; $i++) {
				echo '<option value="'.esc_attr($styles_ids[$i]).'" ';
				selected( $instance['slider_style'], $styles_ids[$i] );
				echo '>'.esc_html($styles[$i]).'</option>';
			}
		?>
		</select>
		<p>
		<?php $this->echo_input_text('slide_speed', $instance, __( 'Enter the desired transition time in milliseconds:', 'jolene'), 0, 2); ?>
		</p>
		<p>
		<?php $this->echo_input_text('slide_effect_speed', $instance, __( 'Enter the desired effect time in milliseconds:', 'jolene'), 0, 2); ?>
		</p>
		<?php $this->echo_input_color('background_text_color', $instance, __( 'Text Background:', 'jolene'), '#ffffff'); ?>

		<?php 
	}

	function echo_input_upload($name, $instance, $title) { ?>
		<p>
			<?php if(trim($instance[$name]) != '') : ?>
				<img src="<?php echo esc_url(($instance[$name])); ?>" style="max-width:100%;" alt="<?php esc_attr_e('Upload', 'jolene'); ?>" />
			<?php endif; ?>
			<br>
            <label for="<?php echo $this->get_field_id( $name ); ?>"><?php esc_html_e( 'Url:', 'jolene' ); ?></label>
            <input name="<?php echo $this->get_field_name( $name ); ?>" id="<?php echo $this->get_field_id( $name ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $instance[$name] ); ?>" />		
  		    <input id="<?php echo $this->get_field_id( $name ); ?>_b" class="upload_image_button button button-primary" type="button" value="<?php esc_html_e( 'Upload Image', 'jolene'); ?>" />
        </p>
		<?php
	}	
	function echo_input_upload_id($name, $instance, $title) { ?>
		<p>
			<?php echo wp_get_attachment_image($instance[$name]); ?>
			<br>
			
            <label for="<?php echo $this->get_field_id( $name ); ?>"><?php esc_html_e( 'Url:', 'jolene' ); ?></label>
            <input name="<?php echo $this->get_field_name( $name ); ?>" id="<?php echo $this->get_field_id( $name ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr($instance[$name]); ?>" />		
  		    <input id="<?php echo $this->get_field_id( $name ); ?>_b" class="upload_id_button button button-primary" type="button" value="<?php esc_html_e( 'Upload Image', 'jolene'); ?>" />
        </p>
		<?php
	}
	function echo_input_text($name, $instance, $title, $isp = 1, $size = 20) { ?>
		<?php echo ($isp ? '<p>' : '');?>
			<label for="<?php echo $this->get_field_id( $name );?>"><?php echo esc_html($title); ?></label>
			<input size="<?php echo $size;?>" type="text" name="<?php echo $this->get_field_name( $name ) ?>" id="<?php echo $this->get_field_id( $name ); ?>" value="<?php echo esc_html($instance[$name]); ?>" />		
		<?php echo($isp ? '</p>' : '');?>
		<?php
	}	
	function echo_input_textarea($name, $instance, $title, $rows=10, $cols=30) { ?>
		<p>
			<label for="<?php echo $this->get_field_id( $name ); ?>"><?php echo esc_html($title); ?></label>
			<br>
			<textarea name="<?php echo $this->get_field_name( $name ) ?>" cols="<?php echo $cols;?>" rows="<?php echo $rows;?>" id="<?php echo $this->get_field_id( $name ); ?>"><?php echo esc_textarea($instance[$name]); ?></textarea>		
		</p>
		<?php
	}	
	function echo_input_checkbox($name, $instance, $title, $isp = 1) { ?>
		<?php echo ($isp ? '<p>' : '');?>
			<input type="checkbox" name="<?php echo $this->get_field_name( $name ); ?>" id="<?php echo $this->get_field_id( $name ); ?>"  value="1" <?php checked( $instance[$name], '1'); ?> />
			<label for="<?php echo $this->get_field_id( $name ); ?>"><?php echo esc_html($title); ?></label>
		<?php echo($isp ? '</p>' : '');?>
		<?php
	}
	function echo_input_color($name, $instance, $title, $def_color) { ?>
		<p>
			<label for="<?php echo $this->get_field_id( $name ); ?>"><?php echo esc_html($title); ?></label>
			<br>
			<input type="text" name="<?php echo $this->get_field_name( $name );?>" id="<?php echo $this->get_field_id( $name ); ?>" value="<?php echo esc_attr($instance[$name]); ?>" class="color-picker" data-default-color="<?php echo esc_attr($def_color); ?>" />		
		</p>
		<?php
	}	
	function echo_select_border_style($name, $instance) { ?>
			<label for="<?php echo $this->get_field_id($name);?>"><?php esc_html_e('Border style:', 'jolene'); ?></label>
			<hr>
			<select id="<?php echo $this->get_field_id($name);?>" name="<?php echo $this->get_field_name($name);?>" style="width:100%;">
			<?php 
				$border_styles=array('dotted', 'dashed', 'solid', 'double', 'groove', 'ridge', 'inset', 'outset');
				for ($i=0; $i<8; $i++) {
					echo '<option value="'.esc_attr($border_styles[$i]).'" ';
					selected( $instance[$name], $border_styles[$i] );
					echo '>'.esc_html($border_styles[$i]).'</option>';
				}
			?>
			</select>
	<?php
	}
	
	/**
	 * Return array Defaults
	 *
	 * @since jolene 1.0.1
	 */
	function defaults( $instance ){
	
		// Set up some default widget settings. 
		$defaults = array('title'=>'',
						'is_show_custom_blocks' => '',
						'number_of_posts' => '4',
						'columns' => '4',
						'cat_id' => '',
						'post_ids' => '',
						'page_ids' => '',
						'style' => '0',
						'is_exclude_current_page_title' => '',
						'is_use_current_category' => '',
						'image_size' => '50',
						'is_use_background_color' => '',
						'is_use_background_image' => '',
						'background_color' => '#ffffff',
						'background_text_color' => '#fff',
						'background_image' => '',
						'is_image_fixed' => '',
						'is_repeat_x' => '',
						'is_repeat_y' => '',
						'pos_x' => 'left',
						'pos_y' => 'top',
						'main_title_color' => '#1e73be',
						'title_color' => '#1e73be',
						'text_color' => '#757575',
						'link_color' => '#1e73be',
						'title_size' => '28',
						'text_size' => '18',
						'link_size' => '20',
						'is_show_title' => ($instance == null ? 1 : ''),
						'is_show_content' => ($instance == null ? 1 :''),
						'content_length' => '100', 
						'is_show_custom_title' => ($instance == null ? 1 : ''),
						'is_show_custom_content' => ($instance == null ? 1 : ''),
						'is_show_custom_link' => ($instance == null ? 1 : ''),
						'is_show_custom_image' => ($instance == null ? 1 : ''),
						'custom_title' => '',
						'custom_content' => '',
						'is_use_border' => '',
						'border_color' => '#ffffff',
						'border_style' => 'double',
						'border_width' => '3',
						'border_radius' => '20',
						'is_use_link_button' => '',
						'link_more_background_color' => '#3333cc',
						'link_more_text_color' => '#ffffff',
						'link_more_text_size' => '20',
						'link_more_text' => __( 'Read more...', 'jolene'),
						'is_use_link_more_custom_link' => '',
						'link_more_custom_link' => '#',
						'link_more_border_style' => 'solid',
						'link_more_border_color' => '#000000',
						'link_more_border_width' => '1',
						'link_more_border_radius' => '0',
						'is_use_icon' => '',
						'padding-top' => '10',
						'padding-right' => '10',
						'padding-bottom' => '0',
						'padding-left' => '10',
						'icon_h' => '20',
						'icon_w' => '20',
						'icon' => '',
						'is_animate' => '',
						'animate_style' => 'step',
						'element_margin' => '4',
						'is_hide_on_small_screen' => '',
						'is_slider' => '',
						'slider_style' => '3',
						'text_on_slide' => ($instance == null ? 1 : 0),
						'slide_speed' => 8000,
						'slide_effect_speed' => 1000,
						'is_use_image_url' => '',
						);
		
		return $defaults;
	}
	
	/**
	 * Return array Defaults
	 *
	 * @param int $count count of custom fields
	 * @since jolene 1.0.1
	 */
	function defaults_for_count( $instance, $count ){
	
		$defaults = array();
		for( $i = 0; $i < $count; $i++ ) {
			$defaults['title_'.$i] = __('Title', 'jolene'); 
			$defaults['text_'.$i] = __('Description', 'jolene'); 
			$defaults['link_'.$i] = ''; 
			$defaults['link_caption_'.$i] = __('Read More...', 'jolene');
			$defaults['image_'.$i] = ''; 
			$defaults['image_url_'.$i] = ''; 
		}
		
		return $defaults;
	}
	
	/* Sanitize ID list.
	 * @param string ids.
	 * @return string ids or ''.
	 */
	function sanitizeIDs( $ids ) {
		if (preg_match ('|^(([0-9]+[,]?[ ]?)+)$|', $ids))
			return $ids;
		else
			return '';	
	}
	/* Sanitize hex color.
	 * @param string color.
	 * @return string color.
	 */
	function sanitize_hex_color( $color ) {
		if ( '' === $color )
			return '';

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
			return $color;

		return null;
	}
	/* Return string or 'Link' string  */
	function notEmpty( $str, $str2='Link' ) {
		if( '' === $str ) $str = $str2; 
		return $str;
	}
	/* width of widget column in %
	 * @param int $sidebar_id $sidebar id.
	 * @param int $columns number of $columns.
	 * @param int $i1 widget left margin.
	 * @param int $i2 widget right margin.
	 * @return int width.
	 */
	function getWidthRate( $sidebar_id, $columns = 1, $i1 = 0, $i2 = 0, $rate = 4 ) {	
		$columns = ( $columns > 0 ? $columns : 1);
		$width = ( 100 - $columns*$rate + $rate)/$columns;
		return $width;
	}
	/* width of widget column for smaller resolution
	 * @param int $sidebar_id $sidebar id.
	 * @param int $columns number of $columns.
	 * @param int $i1 widget left margin.
	 * @param int $i2 widget right margin.
	 * @return int width.
	 */
	function getWidthRateSmall( $sidebar_id, $columns = 1, $i1 = 0, $i2 = 0, $rate = 4 ) {	
		$columns = ( $columns > 0 ? $columns : 1 );
		if( !$this->isConstantSidebar($sidebar_id) ) {
			$newcolumns = ( $columns > 1 ? $columns/2 : 1 );
		}
		else {
			$newcolumns = $columns;
		}
		
		$width = ( 100 - $newcolumns*$rate + $rate)/$newcolumns;
		return $width;		
	}
	/* width of widget column for smallest resolution
	 * @param int $sidebar_id $sidebar id.
	 * @param int $columns number of $columns.
	 * @param int $i1 widget left margin.
	 * @param int $i2 widget right margin.
	 * @return int width.
	 */
	function getWidthRateSuperSmall( $sidebar_id, $columns = 1, $i1 = 0, $i2 = 0, $rate = 4 ) {	
		$columns = ( $columns > 0 ? $columns : 1 );
		if( !$this->isConstantSidebar($sidebar_id) ) {
			$newcolumns = ( $columns == 8 ? 2 : 1 );
		} 
		else {
			$newcolumns = $columns;
		}
				
		$width = ( 100 - $newcolumns*$rate + $rate)/$newcolumns;

		return $width;		
	}
	/* widget column width
	 * @param int $sidebar_id $sidebar id.
	 * @param int $columns number of $columns.
	 * @param int $i1 widget left margin.
	 * @param int $i2 widget right margin.
	 * @return int width.
	 */
	function getWidth( $sidebar_id, $columns, $i1 = 0, $i2 = 0 ) {	
		if($columns <= 0) $columns = 1;

		$width = (jolene_get_width($sidebar_id) - $i1 - $i2)/$columns;
		return $width;
	}
	/* image size
	 * @param int $width column width.
	 * @param int $style widget style.
	 * @param int $image_size image width.
	 * @return array image size.
	 */
	function get_image_width( $width, $style, $image_size ) {
		$size = array(0, 0);
		if($style == 0) {
			$size[0] = $width;
			$size[1] = $width;
		}
		else {
			$size[0] = $size[1] = $width/100*$image_size;
		}
		return $size;
	}
	/* return content excerpts
	 * @param string $post_content content.
	 * @param int $content_length max length.
	 * @return string image size.
	 */
	function getContent($post_content, $content_length) {
	
		$post_content = $this->truncate($post_content, $content_length, '[...]');
		$post_content = strip_tags($post_content, '<a><b><i>');

		return $post_content;	
	}
	/* prevent 0px 
	 * @param array $instance array of options.
	 * @param string $name array index.
	 * @return Xpx or ' 0'.
	 */
	function getPXCSS($instance, $name) {
		return (is_numeric($instance[$name]) ? ($instance[$name] > 0 ? esc_attr($instance[$name]).'px' : ' 0') : ' 0' );
	}
	/* Check if the sidebar is changing size on smaller screen or not.
	 * @param int $sidebar_id sidebar id.
	 * @return bool true if the sidebar is constant.
	 */
	public function isConstantSidebar($sidebar_id) {
		$possible_values = array( 'sidebar-1',
						   'sidebar-2',
						   'sidebar-3',
						   'sidebar-4',
						   'sidebar-6',
						   'sidebar-8',
						   'sidebar-13',
						   'sidebar-14',
						    );

		return in_array( $sidebar_id,  $possible_values);
	}
	/* Generate css for widget
	 * @param array $instance widget settings.
	 * @param int $widget_id widget id.
	 * @param int $sidebar_id sidebar id.
	 * @return string widget css.
	 */
	public function GetWidgetCss($instance, $widget_id, $sidebar_id) {
		$bc = '';
		$bcimg = '';
		$style = $instance['style'];
		
		$is_hide = ( array_key_exists('is_hide_on_small_screen', $instance) ? true : false);//hide background on small screens
		$element_margin = ( isset($instance['element_margin']) ? $instance['element_margin'] : 4);
		$instance['main_title_color'] = (array_key_exists('main_title_color', $instance) ? $instance['main_title_color'] : '#000');
		$width = $this->getWidthRate($sidebar_id, $instance['columns'], $instance['padding-right'], $instance['padding-left'], $element_margin);
		$widthSmallScreen = $this->getWidthRateSmall($sidebar_id, $instance['columns'], $instance['padding-right'], $instance['padding-left']. $element_margin);
		$columns = $instance['columns'];
		$columnssmall = $columns;
		if (! $this->isConstantSidebar($sidebar_id))
			$columnssmall = ($columns/2 > 1 ? $columns/2 : 1 );
		
		$widthSuperSmallScreen = $this->getWidthRateSuperSmall($sidebar_id, $instance['columns'], $instance['padding-right'], $instance['padding-left'], $element_margin);
		
		$columnssupersmall = $columns;
		if( !$this->isConstantSidebar($sidebar_id) ) {
			$columnssupersmall = ($columns == 8 ? 2 : 1 );
		}

		if(array_key_exists('is_use_background_image', $instance)) {
			$bcimg = 'background-image: url('.esc_url($instance['background_image']).');';
			
			//background repeat style
			if( array_key_exists('is_repeat_x', $instance) && array_key_exists('is_repeat_y', $instance) )
				$rep = 'background-repeat: repeat;';
			else if(array_key_exists('is_repeat_x', $instance))
				$rep = 'background-repeat: repeat-x;';			
			else if(array_key_exists('is_repeat_y', $instance))
				$rep = 'background-repeat: repeat-y;';
			else
				$rep = 'background-repeat: no-repeat;';
				
			if(array_key_exists('is_image_fixed', $instance))
				$rep .= 'background-attachment: fixed;';

			//background position
			$impos = 'background-position:'.esc_attr($instance['pos_y']).' '.esc_attr($instance['pos_x']).';';
			$bcimg .= $rep.$impos;
		}
		if(array_key_exists('is_use_background_color', $instance)) {
			$bc = 'background-color:'.esc_attr(($instance['background_color'])).';';
		}

		$margin = 'padding:'.$this->getPXCSS($instance, 'padding-top').' '.
							  $this->getPXCSS($instance, 'padding-right').' '.
							  $this->getPXCSS($instance, 'padding-bottom').' '.
							  $this->getPXCSS($instance, 'padding-left').';';
		$widget_style = '<style type="text/css">';
		if ($is_hide) {//add background with @media screen > 959px
			if($bcimg != '') {
				$widget_style .= '@media screen and (min-width: 959px) { #'.$widget_id.' {'.$bcimg.'}}';
			}
			if($bc != '') {
				$widget_style .= '#'.$widget_id.' {'.$bc.'}';
			}
		}
		else {
			$widget_style .= '#'.$widget_id.' {'.$bcimg.$bc.'}';
		}
		
		$color = '#fff';//the text background with 70% opacity
			
		if(isset($instance['background_text_color']))
			$color = $instance['background_text_color'];
			
		//widget css
		$widget_style .= '#'.$widget_id.' .header-list {padding-right:'.$element_margin.'%;}'.
		( array_key_exists('is_use_background_color', $instance) ?
					'#'.$widget_id.' .widget-title { color:'.esc_attr($instance['main_title_color']).'}' : '').
		'#'.$widget_id.' .wrap-list { '.$margin.'}
		#'.$widget_id.' .w-head .icon {border:0;max-width:'.esc_attr($instance['icon_w']).'px}
		#'.$widget_id.' .wrap-list.slider-widget .footer-list { background: '.$color.'}
		#'.$widget_id.' .wrap-list.slider-widget .footer-list, 
		#'.$widget_id.' .wrap-list.slider-widget .footer-list a {font-size: 0;}
		#'.$widget_id.' .wrap-list.slider-widget .footer-list a:first-child {font-size: '.esc_attr($instance['title_size']).'px;}
		#'.$widget_id.' .header-list .w-head, 
		#'.$widget_id.' .footer-list .w-head {'
			.( array_key_exists('is_use_background_color', $instance) ? 'color:'.esc_attr($instance['title_color']).';' : '')	
			.'width: 100%; 
			font-size: '.esc_attr($instance['title_size']).'px;
		}
		#'.$widget_id.' .header-list, 
		#'.$widget_id.' .footer-list {'
			.( array_key_exists('is_use_background_color', $instance) ? 'color:'.esc_attr($instance['text_color']).';' : '')	
			.'font-size: '.esc_attr($instance['text_size']).'px;
		}
		#'.$widget_id.' .header-list a, 
		#'.$widget_id.' .footer-list a {'
			.( array_key_exists('is_use_background_color', $instance) ? 'color:'.esc_attr($instance['link_color']).';' : '')	
			.'font-size: '.esc_attr($instance['link_size']).'px;}
	    @media screen and (max-width: 400px) { 
		#'.$widget_id.' .header-list:nth-child('.$columnssupersmall.'n)
		{padding-right: 0%;}}
		@media screen and (max-width: 959px) { 
			#'.$widget_id.' .header-list:nth-child('.$columnssmall.'n) {
				padding-right: 0%;
			}
		}
		@media screen and (min-width: 960px) { 
			#'.$widget_id.' .header-list:nth-child('.$columns.'n) {
				padding-right: 0%;
			}
			#'.$widget_id.' .wrap-list.slider-widget .footer-list, 
			#'.$widget_id.' .wrap-list.slider-widget .footer-list a {
				font-size: '.esc_attr($instance['text_size']).'px;
			}
			#'.$widget_id.' .wrap-list.slider-widget .footer-list a:first-child {
				font-size: '.esc_attr($instance['title_size']).'px;
			}
		}';	
		
		if( array_key_exists('is_use_border', $instance) ){
			$widget_style .= '@media screen and (min-width: 400px) {#'.$widget_id.' .header-list img
			{border:'.esc_attr($instance['border_width']).'px '.esc_attr($instance['border_style']).' '.esc_attr($instance['border_color']).';
			border-radius: '.esc_attr($instance['border_radius']).'px;}}';
		}
		if( array_key_exists('is_use_link_button', $instance) ){
			$widget_style .= '#'.$widget_id.' .link-read-more {
				background: '.esc_attr($instance['link_more_background_color']).'; color: '.esc_attr($instance['link_more_text_color']).';
				border-radius: '.esc_attr($instance['link_more_border_radius']).'px;
				border: '.esc_attr($instance['link_more_border_width']).'px '.esc_attr($instance['link_more_border_style']).' '.esc_attr($instance['link_more_border_color']).';}
				#'.$widget_id.' .footer-list .link-read-more.active-button, #'.$widget_id.' .header-list .link-read-more.active-button {
				background: '.esc_attr($instance['link_more_text_color']).'; color: '.esc_attr($instance['link_more_background_color']).';}
				#'.$widget_id.' .footer-list .link-read-more, #'.$widget_id.' .header-list .link-read-more {text-decoration:none;font-size:'.esc_attr($instance['link_more_text_size']).'px; color: '.esc_attr($instance['link_more_text_color']).';}
				#'.$widget_id.' .link-read-more:hover {background: '.esc_attr($instance['link_more_text_color']).'; color: '.esc_attr($instance['link_more_background_color']).';}';
		}
		if($style == 0 || $style == 3) {//image on top			
			$widget_style .= ' #'.$widget_id.' .header-list {width:'.esc_attr($widthSuperSmallScreen).'%; }
			@media screen and (min-width: 400px) { #'.$widget_id.' .header-list {width:'.esc_attr($widthSmallScreen).'%;} }
			@media screen and (min-width: 960px) { #'.$widget_id.' .header-list {width:'.esc_attr($width).'%;} }
			#'.$widget_id.' .footer-list {height: auto; overflow: hidden;}';
		}
		else if($style == 1) {//image on right				
			$widget_style .= '#'.$widget_id.' .header-list img {'.$bc.'display:block;}
			@media screen and (min-width: 400px) { 
			#'.$widget_id.' .header-list{display:inline-block;width:auto;} #'.$widget_id.' .header-list img{padding:5px;margin-left:10px;float:right; width:'.esc_attr($instance['image_size']).'%;}
			#'.$widget_id.' .header-list {width:'.esc_attr($widthSuperSmallScreen).'%;}}
			@media screen and (min-width: 500px) { #'.$widget_id.' .header-list {width:'.esc_attr($widthSmallScreen).'%;} }
			@media screen and (min-width: 960px) { #'.$widget_id.' .header-list {width:'.esc_attr($width).'%;} }
			#'.$widget_id.' .header-list .w-head {display: inline;}';
		}		
		else if($style == 2) {//image on left				
			$widget_style .= '#'.$widget_id.' .header-list img {'.$bc.'display:block;}
			@media screen and (min-width: 400px) { #'.$widget_id.' .header-list{display:inline-block;width:auto;} #'.$widget_id.' .header-list img{padding:5px;margin-right:10px;float:left; width:'.esc_attr($instance['image_size']).'%;}
			#'.$widget_id.' .header-list {width:'.esc_attr($widthSuperSmallScreen).'%;} }
			@media screen and (min-width: 500px) { #'.$widget_id.' .header-list {width:'.esc_attr($widthSmallScreen).'%;} }
			@media screen and (min-width: 960px) { #'.$widget_id.' .header-list {	width:'.esc_attr($width).'%;} }
			#'.$widget_id.' .header-list .w-head {display: inline;}';
		}
		if(trim($instance['number_of_posts']) === '' || $instance['number_of_posts'] === '0') {
			$widget_style .= '#'.$widget_id.'.widget { padding-bottom: 0; padding-top: 0;} #'.$widget_id.' .wrap-list {display: block;}';
		}
		$widget_style .= '</style>';	
		return $widget_style;
	}
	/* truncate html
	 * @param string $html.
	 * @param int $max_length max length.
	 * @param string $indicator end of return string.
	 * @return string truncated html.
	 */
	function truncate($html, $max_length, $indicator = '[...]') {
		$output_length = 0; 
		$position = 0;      
		$tag_stack = array(); 
		$output = '';
		$truncated = false;

		$unpaired_tags = array( 'doctype', '!doctype',
		'area','base','basefont','bgsound','br','col',
		'embed','frame','hr','img','input','link','meta',
		'param','sound','spacer','wbr');

		while ($output_length < $max_length
		&& preg_match('{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}', $html, $match, PREG_OFFSET_CAPTURE, $position)) {
			list($tag, $tag_position) = $match[0];

			$text = mb_strcut($html, $position, $tag_position - $position);
			if ($output_length + mb_strlen($text) > $max_length) {
				$output .= mb_strcut($text, 0, $max_length - $output_length);
				$truncated = true;
				$output_length = $max_length;
				break;
			}

			$output .= $text;
			$output_length += mb_strlen($text);

			if ($tag[0] == '&') {
			$output .= $tag;
			$output_length++; 
			}
			else {
				$tag_inner = $match[1][0];
				if ($tag[1] == '/') {
					$output .= $tag;
					if ( end($tag_stack) == $tag_inner ) {
						array_pop($tag_stack);
					}
				}
				else if ($tag[mb_strlen($tag) - 2] == '/'
					|| in_array(strtolower($tag_inner),$unpaired_tags) ) {
					$output .= $tag;
					}
					else {
						$output .= $tag;
						$tag_stack[] = $tag_inner; 
					}
				}		
				$position = $tag_position + mb_strlen($tag);
		}

		if ($output_length < $max_length && $position < mb_strlen($html)) {
			$output .= mb_strcut($html, $position, $max_length - $output_length);
		}

		$truncated = mb_strlen($html)-$position > $max_length - $output_length;
		
		if(mb_strlen($output)>$position) {
			$last_word = mb_strrpos($output, ' ', $position);
			if($last_word > 0){
				$output = mb_substr($output, 0, $last_word);
			}
		}

		if ( $truncated )
		$output .= $indicator;

		while (!empty($tag_stack))
		$output .= '</'.array_pop($tag_stack).'>';

		return $output;
	}
}
/* Register widget*/
function jolene_register_widgets() {
	register_widget( 'jolene_ExtendedWidget' );
}
add_action( 'widgets_init', 'jolene_register_widgets' );
/*
* Hook widget css to wp_head
*/
function jolene_hook_into_head_widget_css() {
	$css = '';
	$myWidget = new jolene_ExtendedWidget();
	$widgets = $myWidget->get_settings();
			
	foreach ($widgets as $key => $instance) {
		$widget_id = 'jolene_extended_widget-'.$key;
		$sidebar = is_active_widget( '', $widget_id, 'jolene_extended_widget');
		if ( $sidebar ) {
			if($widgets[$key] != null) {
				$css .= $myWidget->GetWidgetCss($widgets[$key], $widget_id, $sidebar);
			}
		}
	}
	echo $css;
}
add_action('wp_head','jolene_hook_into_head_widget_css');