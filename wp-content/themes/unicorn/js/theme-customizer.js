( function( $ ) {
//change color scheme
	var api = parent.wp.customize;
	function SetColor(cname, newColor) {
		//update colors in picker
	    var control = api.control(cname); 
		if(control){
			control.setting.set(newColor);	
			picker = control.container.find('.color-picker-hex');
			if(picker)
				if(newColor == '')
					picker.val( control.setting() ).wpColorPicker().trigger( 'clear' );
				else
					picker.val( control.setting() ).wpColorPicker().trigger( 'change' );
		}
		return;
	}
	function SetControlVal(name, newVal) {
	    var control = api.control(name); 
		if( control ){
			control.setting.set( newVal );
		}
		return;
	}	

	function unicorn_refresh_colors( color_scheme ) {
	
		if (color_scheme == 'unicorn') {
		
			SetColor('site_name_back', '#fff');
			SetColor('widget_back', '#fff');
			SetColor('header_textcolor', '#999');
			
			SetColor('link_color', '#1e73be');
			SetColor('heading_color', '#000');
			
			SetColor('menu1_color', '#fff');
			SetColor('menu1_link', '#1e73be');
			SetColor('menu1_hover', '#fff');
			SetColor('menu1_hover_back', '#1e73be');
			
			SetColor('menu2_color', '#1e73be');
			SetColor('menu2_link', '#fff');
			SetColor('menu2_hover', '#1e73be');
			SetColor('menu2_hover_back', '#eee');
			
			SetColor('menu3_color', '#1e73be');
			SetColor('menu3_link', '#fff');
			SetColor('menu3_hover', '#1e73be');
			SetColor('menu3_hover_back', '#eee');
			
			SetColor('sidebar1_color', '#eee');
			SetColor('sidebar1_link', '#1e73be');
			SetColor('sidebar1_hover', '#000');
			SetColor('sidebar1_text', '#333');
			
			SetColor('sidebar2_color', '#fff');
			SetColor('sidebar2_link', '#1e73be');
			SetColor('sidebar2_hover', '#000');
			SetColor('sidebar2_text', '#828282');
			
			//columns
			SetColor('sidebar3_color', '#eee');
			SetColor('sidebar3_link', '#1e73be');
			SetColor('sidebar3_hover', '#000066');
			SetColor('sidebar3_text', '#999');
			
			SetColor('column_header_color', '#eee');
			SetColor('column_header_text', '#000');
			
			SetColor('border_color', '#fff');
			SetColor('shadow_color', '#bfbfbf');
			SetControlVal('column_background_url', '');
			
		}
	}
			
	parent.wp.customize( 'color_scheme', function( value ) {
		value.bind( function( to ) {
		
			unicorn_refresh_colors(to);

			});
		});
	
} )( jQuery );
