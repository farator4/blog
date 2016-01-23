( function( $ ) {
	// Site title and description.	
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	
	wp.customize( 'reset_fonts', function( value ) {
		value.bind( function( to ) {
			alert('ssss');
		} );
	} );
	
	// Header text color
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );	
				$( '.site-title, .site-title a' ).css( {
					'color': to,
				} );
			}
		} );
	} );
	
//link
	wp.customize( 'link_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-navigation a' ).css( 'color', to);
			$( '.image-and-cats a' ).css( 'color', to);
			$( '.post-date a' ).css( 'color', to);
			$( '.column .widget a' ).css( 'color', to);
			$( '.entry-header .entry-title a' ).css( 'color', to);
			$( '.content a' ).css( 'color', to);	
		} );
	} );
//headers
	wp.customize( 'heading_color', function( value ) {
		value.bind( function( to ) {
			$( '.content h1' ).css( 'color', to);
			$( '.content h2' ).css( 'color', to);
			$( '.content h3' ).css( 'color', to);
			$( '.content h4' ).css( 'color', to);
			$( '.content h5' ).css( 'color', to);
			$( '.content h6' ).css( 'color', to);	
		} );
	} );
	
//description
	wp.customize( 'description_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-description ' ).css( 'color', to);	
		} );
	} );

//header text background
	wp.customize( 'site_name_back', function( value ) {
		value.bind( function( to ) {
			$( '.header-text-is-on.header-is-on .site-info-text' ).css( 'background-color', to);	
		} );
	} );
//menu background		
	wp.customize( 'menu1_color', function( value ) {
		value.bind( function( to ) {
			$( '#top-1-navigation' ).css( 'background-color', to);
			$( '.site-info-text-top' ).css( 'background-color', to);
		} );
	} );

//menu background		
	wp.customize( 'menu2_color', function( value ) {
		value.bind( function( to ) {
			$( '#top-navigation' ).css( 'background-color', to);
		} );
	} );
	
//menu background		
	wp.customize( 'menu3_color', function( value ) {
		value.bind( function( to ) {
			$( '#footer-navigation' ).css( 'background-color', to);
			$( '.site-info' ).css( 'background-color', to);
		} );
	} );

//footer sidebar background		
	wp.customize( 'sidebar2_color', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-footer' ).css( 'background-color', to);
		} );
	} );
//footer sidebar text
	wp.customize( 'sidebar2_text', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-footer .widget-wrap .widget' ).css( 'color', to);
		} );
	} );
	
//footer sidebar link
	wp.customize( 'sidebar2_link', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-footer .widget-wrap .widget a' ).css( 'color', to);
		} );
	} );
	
//top sidebar background		
	wp.customize( 'sidebar1_color', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top' ).css( 'background-color', to);
			$( '.sidebar-top-full' ).css( 'background-color', to);
		} );
	} );
//top sidebar text
	wp.customize( 'sidebar1_text', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top .widget-wrap .widget' ).css( 'color', to);
			$( '.sidebar-top-full .widget' ).css( 'color', to);
		} );
	} );
	
//top sidebar link
	wp.customize( 'sidebar1_link', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top .widget-wrap .widget a' ).css( 'color', to);
			$( '.sidebar-top-full .widget a' ).css( 'color', to);
		} );
	} );
	
//sidebars background		
	wp.customize( 'sidebar3_color', function( value ) {
		value.bind( function( to ) {
			$( '.site' ).css( 'background-color', to);
		} );
	} );
	
//sidebars background		
	wp.customize( 'column_background_url', function( value ) {
		value.bind( function( to ) {
			$( '.site' ).css( 'backgroundImage', 'url(' + to + ')');
		} );
	} );
	
//column sidebar link
	wp.customize( 'sidebar3_link', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-left .widget a' ).css( 'color', to);
			$( '.sidebar-right .widget a' ).css( 'color', to);
		} );
	} );
	
//column sidebar text
	wp.customize( 'sidebar3_text', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-left .widget' ).css( 'color', to);
			$( '.sidebar-right .widget' ).css( 'color', to);
		} );
	} );
	
//column header background color
	wp.customize( 'column_header_color', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget .widget-title' ).css( 'background', to);
		} );
	} );
	
//column header text color
	wp.customize( 'column_header_text', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget .widget-title' ).css( 'color', to);
		} );
	} );
		
//column widget border
	wp.customize( 'border_color', function( value ) {
		value.bind( function( to ) {
			$( '.column .widget' ).css( 'border-color', to);
		} );
	} );
	
//shadow
	wp.customize( 'shadow_color', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-top-full' ).css('box-shadow', '0 0 4px 4px ' + to);
			$( '.sidebar-before-footer' ).css('box-shadow', '0 0 4px 4px ' + to);
			$( '.site-content' ).css('box-shadow', '0 0 4px 4px ' + to);
		} );
	} );
	
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
	function hideControl(cname) {
	    var control = api.control(cname); 
		if(control){
			control.container.toggle( 0 );
		}
	}
	function showControl(cname) {
	    var control = api.control(cname); 
		if(control){
			control.container.toggle( 1 );
		}
	}
	function removeHeader(name) {
		var control = api.control(name);
		if( control ) {
			control.removeImage();
		}
	}
	function SetHeader(name, newImage, height, width) {
		var control = api.control(name);
		if( control ) {
			var choice, data = {};
			data.url = newImage;
			data.attachment_id = 0;
			data.thumbnail_url = newImage;
			data.timestamp = _.now();
			if (width) {
				data.width = width;
			}
			if (height) {
				data.height = height;
			}
			choice = new api.HeaderTool.ImageModel({
				header: data,
				choice: newImage.split('/').pop()
			});
			api.HeaderTool.currentHeader.set(choice.toJSON());
			choice.save();
		}
		return;
	}
	function jolene_refresh_colors( color_scheme ) {
	
		if (color_scheme == 'blue') {
		
			SetColor('site_name_back', '#006600');
			SetColor('w1', '#eeeeee');
			SetColor('header_textcolor', '#fff');
			
			SetColor('link_color', '#1e73be');
			SetColor('heading_color', '#000');
			
			SetColor('menu1_color', '#1e73be');
			SetColor('menu1_link', '#fff');
			SetColor('menu1_hover', '#1e73be');
			SetColor('menu1_hover_back', '#eee');
			
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
			
			SetColor('sidebar2_color', '#ddd');
			SetColor('sidebar2_link', '#1e73be');
			SetColor('sidebar2_hover', '#000');
			SetColor('sidebar2_text', '#828282');
			
			//columns
			SetColor('sidebar3_color', '#eee');
			SetColor('sidebar3_link', '#1e73be');
			SetColor('sidebar3_hover', '#000066');
			SetColor('sidebar3_text', '#999');
			
			SetColor('column_header_color', '#1e73be');
			SetColor('column_header_text', '#fff');
			
			SetColor('border_color', '#eee');
			SetColor('shadow_color', '#bfbfbf');
			
			SetColor('description_color', '#ccc');
			SetColor('hover_color', '#339900');
			
			SetControlVal('column_background_url', '');
			
		}
		else if (color_scheme == 'black') {
		
			SetColor('site_name_back', '#fff');
			SetColor('w1', '#000');
			SetColor('header_textcolor', '#000');
		
			SetColor('link_color',  '#1e73be');
			SetColor('heading_color',  '#000');
			SetColor('menu1_color',  '#000');
			SetColor('menu1_link',  '#fff');
			SetColor('menu1_hover',  '#ccc');
			SetColor('menu1_hover_back',  '#3f3f3f');
			
			SetColor('menu2_color',  '#000');
			SetColor('menu2_link',  '#fff');
			SetColor('menu2_hover',  '#ccc');
			SetColor('menu2_hover_back',  '#3f3f3f');
			
			SetColor('menu3_color',  '#000');
			SetColor('menu3_link',  '#fff');
			SetColor('menu3_hover',  '#ccc');
			SetColor('menu3_hover_back',  '#3f3f3f');
			
			SetColor('sidebar1_color',  '#eee');
			SetColor('sidebar1_link',  '#1e73be');
			SetColor('sidebar1_hover',  '#000');
			SetColor('sidebar1_text',  '#333');
			
			SetColor('sidebar2_color',  '#333');
			SetColor('sidebar2_link',  '#fff');
			SetColor('sidebar2_hover',  '#ccc');
			SetColor('sidebar2_text',  '#ccc');
			
			//columns
			SetColor('sidebar3_color',  '#666');
			SetColor('sidebar3_link',  '#ccc');
			SetColor('sidebar3_hover',  '#fff');
			SetColor('sidebar3_text',  '#ccc');
			
			SetColor('column_header_color',  '#000');
			SetColor('column_header_text',  '#fff');
			
			SetColor('border_color',  '#111');
			SetColor('shadow_color',  '#3f3f3f');
			
			SetColor('description_color', '#ccc');
			SetColor('hover_color', '#339900');
			
			SetControlVal('column_background_url', '');
			
		}		
		else if (color_scheme == 'green') {
		
			SetColor('site_name_back', '#000');
			SetColor('w1', '');
			SetColor('header_textcolor', '#fff');
		
			SetColor('link_color', '#1e73be');
			SetColor('heading_color', '#000');
			SetColor('menu1_color', '#336600');
			SetColor('menu1_link', '#fff');
			SetColor('menu1_hover', '#a6d684');
			SetColor('menu1_hover_back', '#003300');
			
			SetColor('menu2_color', '#336600');
			SetColor('menu2_link', '#fff');
			SetColor('menu2_hover', '#a6d684');
			SetColor('menu2_hover_back', '#003300');
			
			SetColor('menu3_color', '#336600');
			SetColor('menu3_link', '#fff');
			SetColor('menu3_hover', '#a6d684');
			SetColor('menu3_hover_back', '#003300');
			
			SetColor('sidebar1_color', '#dd9933');
			SetColor('sidebar1_link', '#000');
			SetColor('sidebar1_hover', '#fff');
			SetColor('sidebar1_text', '#333');
			
			SetColor('sidebar2_color', '#dd9933');
			SetColor('sidebar2_link', '#000');
			SetColor('sidebar2_hover', '#fff');
			SetColor('sidebar2_text', '#333');
			
			//columns
			SetColor('sidebar3_color', '#b6d6a0');
			SetColor('sidebar3_link', '#1e73be');
			SetColor('sidebar3_hover', '#000');
			SetColor('sidebar3_text', '#333');
			
			SetColor('column_header_color', '#336600');
			SetColor('column_header_text', '#fff');
			
			SetColor('border_color', '#fff');
			SetColor('border_shadow_color', '#6d6d6d');
			
			SetColor('description_color', '#ccc');
			SetColor('hover_color', '#339900');
			
			SetControlVal('column_background_url', '');
			
		}
	};
			
	parent.wp.customize( 'color_scheme', function( value ) {
		value.bind( function( to ) {
		
			jolene_refresh_colors(to);

			});
		});
	
} )( jQuery );
