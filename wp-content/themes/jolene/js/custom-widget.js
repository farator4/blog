//set up margins to make elements similar, slider and animation for widget
//global variables
if( typeof jehanne_animtype == "undefined") {
	var jehanne_animtype = [];
	typeof jehanne_animtype;
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
//load main functions
jQuery( document ).ready(function( $ ) {

	$( window ).load(function() {
	
		setMargins();
		
		$( window ).resize(function() {
			setTimeout(function() {
				setMargins();
			}, 100);
		});

    	setTimeout(function() {
    		showWidget();
    	}, 500);
		 
		$(window).scroll( function() {
			setTimeout(function() {
				showWidget();
			}, 500);
		});
		
    	setTimeout(function() {
    		slider();
    	}, 500);
		
	});
	
	function slider() {
		//for each slider
		$( '.widget.jolene_extended .wrap-list.slider-widget' ).each(function( index ) {
		
			var id = parseInt(/jolene_extended_widget-(\d+)/.exec($(this).attr('class'))[1], 10);//current widget id, use it as index in arrays of slider params
			var previndex = 0;
			var currindex = 0;
			var newindex = 0;
			var selectedindex = 0;
			var timerinterval =  jolene_timerinterval[id];//slide change interval
			var buttoncount = 0;
			var menuitem;
			var sliderimg;	
			var slidertext;
			var slider = $(this);
			var buttons = slider.find('.link-read-more');
			var sliderheight = 0;
			var slidewidth = 0;
			var animtype = jolene_animtype[id];//animation type
			var slidespeed = jolene_slidespeed[id];//animation speed
			var textonimg = jolene_textonslide[id];//is place text on image
			var autoplayison = 1;
			var op = 0.7;//opacity
			
			var timerId;
			
			$(this).find('.slider-buttons').css('display', 'block');

			//set wrap height to the height of the largest slide
			$(this).css('height', maxHeight());
			//set each slide height to the height of the largest slide
			$(this).find( '.header-list').css('height', maxHeight());
			$(this).find( '.header-list:first-child' ).css('position', 'absolute').css('z-index', '1');;
			$(this).find( '.header-list:not(:first-child)' ).css('display', 'none').css('z-index', '1');//hide slides
			sliderheight = $(this).css('height');
			slidewidth = $(this).css('width');

			//calc slides
			menuitem = $(this).find( 'li' );
			buttoncount = menuitem.size();
		
			var sliderimg = $(this).find( '.header-list' );
			var slidertext = $(this).find( '.footer-list' );
			
			slidertext.eq(currindex).css('display', 'block');
			
			sliderimg.each(function() {
				$currtext = $(this).find('.footer-list');
				$currtext.css('max-width', parseInt($(this).css('width')));
			});
			
			playslide();
			
			$('.sidebar-toggle').click( function() {
				setTimeout(function() {
					resizeSlider();
				}, 200);
			});
			
			$(window).resize( function() {
				setTimeout(function() {
					resizeSlider();
				}, 200);
			});
			
			slidertext.mouseover(function( event ) {
				if( textonimg )
					$(this).css('opacity', '1');
			});
			slidertext.mouseleave(function( event ) {
				if( textonimg )
					$(this).css('opacity', op);
			});
			
			(menuitem).mouseover(function( event ) {
				newindex = menuitem.index(this);
				menuitem.eq(newindex).click();
			});
			
			(menuitem).mouseleave(function( event ) {
				newindex = selectedindex; 
				switchSlide();
			});
			
			menuitem.click(function( event ) {		
				newindex = menuitem.index(this);
				sliderimg.eq(currindex).stop(true, true);
				slidertext.eq(currindex).stop(true, true);
				sliderimg.eq(previndex).stop(true, true);
				slidertext.eq(previndex).stop(true, true);
				switchSlide();
				selectedindex = newindex;
			});
			
			slider.mouseover(function( event ) {
				if(autoplayison){
					clearInterval(timerId);
				}
			});
			slider.mouseleave(function( event ) {
				if(autoplayison){
					clearInterval(timerId);
					playslide();
				}
			});
			
		function playslide(){				
			timerId = setInterval( function (){
				autoplay();
			}, timerinterval);
		}
		
		function autoplay(){ 
			newindex = newindex + 1;
			if(newindex == buttoncount){
				newindex = 0;
			}
			menuitem.eq(newindex).click();
		}
		function switchSlide() {
			if (currindex != newindex) {

				animslide(currindex, newindex);
				
				menuitem.eq(currindex).removeClass( 'active-button' );
				menuitem.eq(newindex).addClass( 'active-button' ); 

				previndex = currindex;
				currindex = newindex;		
			}
		}
		function resizeSlider() {
			slider.find( '.header-list').css('height', 'auto'); //do it to recalc actual image size
			slider.css('height', maxHeight());
			slider.find( '.header-list').css('height', maxHeight()); //set it to fixed size for slides with text only
			slidewidth = slider.css('width');
			sliderheight = slider.css('height');
			sliderimg.each(function() {
				$(this).find('.footer-list').css('max-width', parseInt($(this).css('width')));
			});
		}
		function maxHeight() {
			var headers = slider.find('.header-list');
			var text = slider.find('.footer-list');
			var max = 0;
			var max_2 = 0;
			var height = 0;
			headers.each(function( index ) {
				height = parseInt( $( this ).css( 'height' ) );
				height = ( isNaN(height) ? 0 : height);
				max = (max > height ? max : height  );
			});		
			height = 0;			
			text.each(function( index ) {
				height = parseInt( $( this ).css( 'height' ) );
				height = ( isNaN(height) ? 0 : height);
				max_2 = (max_2 > height ? max_2 : height  );
			});
			if(slider.hasClass('text-on-slide')) {
				if(max > 0)
					return max;
				else	
					return max_2 + 10;
			}

			return max;
		}
		function animslide(currindex, newindex){

			sliderimg.eq(newindex).css( 'z-index', '3' );
			sliderimg.eq(currindex).css( 'z-index', '2' );
				
		switch ( animtype ) {
			case 1:
				sliderimg.eq(currindex).fadeOut();
				sliderimg.eq(newindex).fadeIn();
			break;
			case 2:  //move down
				sliderimg.eq(newindex)
					.css( 'position', 'absolute' ) //hide new slide from the screen
					.css( 'top', '-'+sliderheight ) 
					.css( 'display', 'block' )		
					.animate({
						'top':'+='+sliderheight}, {
						duration: slidespeed, 
						queue: false,
						always: function() {
							} 
				}); 
						
				sliderimg.eq(currindex)
					.animate({
						'top':'+='+sliderheight}, {
						duration: slidespeed,
						queue: false, 
						always: function() {
							hideslide($( this )); 
							} 
				});
			break;
			case 3: //move right
				sliderimg.eq(newindex)
					.css( 'top', '0' )
					.css( 'left', '-'+slidewidth )
					.css( 'display', 'block' )		
					.animate({
						'left':'+='+slidewidth}, {
						duration: slidespeed, 
						queue: false
					}); 
				sliderimg.eq(currindex)
					.animate({
						'left':'+='+slidewidth}, {
						duration: slidespeed,
						queue: false,
						always: function() { 
							hideslide($( this )); 
							} 
						});
				break;
				case 4:	//move left
					sliderimg.eq(currindex)
						.animate({
							'left':'-='+slidewidth}, {
							duration: slidespeed,
							queue: false,
							always: function() { 
								hideslide($( this )); 
								} 
							}) 
							
					sliderimg.eq(newindex)
						.css( 'top', '0px' )
						.css( 'left', slidewidth )
						.css( 'display', 'block' )		
						.animate({
							'left':'-='+slidewidth}, {
							duration: slidespeed, 
							queue: false
					});
				break;
				};
				
				if(textonimg) {//animate text
					var currtextheight = parseInt(slidertext.eq(currindex).css('height'));
					var newtextheight = parseInt(slidertext.eq(newindex).css('height'));
					slidertext.eq(newindex).css('opacity', op);
					
					if( parseInt(sliderimg.eq(newindex).css('height')) == 0) {
						sliderimg.eq(newindex).css('height', newtextheight+20);
						sliderimg.eq(currindex).css('height', 'auto');
					}
					
					switch ( animtype ) {
						case 1:
							slidertext.eq(newindex).css('bottom', 'auto');
							if(parseInt($( window ).width()) > 959 && parseInt(slidewidth) > 500 && parseInt(newtextheight) < parseInt(sliderheight)) {
								newtextheight = parseInt(slidertext.eq(newindex).css('height')) + 60;
							} else {
								newtextheight = parseInt(slidertext.eq(newindex).css('height')) + 10;
							}

							slidertext.eq(newindex)
								.css( 'top', (sliderheight)) //hide new slide from the screen	
								.css( 'display', 'block' )		
								.animate({
									'top':'-='+(newtextheight)}, {
									duration: slidespeed, 
									queue: false
							}); 
							slidertext.eq(currindex)
								.css( 'top', (sliderheight)) //hide new slide from the screen	
								.css( 'display', 'none' );
	
						break;
						case 2:
						case 3:
						case 4:
							slidertext.eq(currindex).fadeOut();
							var top = 0;
							if($( window ).width() > 959 && parseInt(slidewidth) > 500) {
								buttons.eq(newindex).delay(slidespeed).fadeIn();
								top = 40;
							}
							slidertext.eq(newindex).css( 'bottom', top).css( 'top', 'auto');
							buttons.eq(newindex).css( 'bottom', 0).css( 'top', 'auto');
							
							slidertext.eq(newindex)
								.css( 'opacity', '0') //hide new slide from the screen	
								.css( 'display', 'block' )		
								.delay(slidespeed).queue(function(n) {
									$(this).animate({
										'opacity':op}, {
										duration: slidespeed, 
										queue: false,
										always: function() { 											
											sliderimg.eq(newindex).find('img').addClass( 'hover-effect' );
											} 
									}); 
										
									n();
								});
							buttons.eq(currindex).fadeOut();
						break;
					}
				}
			}
		
			function hideslide(obj){
				obj.css( 'display', 'none' ); 
			}
		});
	}
	
	function showWidget() {
		$( '.widget.jolene_extended .wrap-list.hidden-widget.step' ).each(function( index ) {

			var top = $( this ).offset().top;
			var currentPos = $( window ).scrollTop();

			if((currentPos + $( window ).height()/2 > top 
					|| $(document).height() == currentPos)
					&& currentPos < top + $( this ).height() ) {
				$( this ).css('height', $( this ).height()); // fix height			
				$( this ).find('.header-list').hide(); // hide 
				$( this ).find('.link-read-more').hide(); // hide buttons
				$( this ).removeClass('hidden-widget'); 	

				var delay = $( this ).find('.header-list').size()*1000;			
				var x = 0;
				
				$( this ).find('.header-list').each(function( index ) {
					$( this ).delay( x ).fadeIn().height('auto');
					x += 1000;
				});
				
				var wrap = $( this );
				
				setTimeout(function() {
					button = wrap.find('.link-read-more');
					button.addClass('active-button');
					button.fadeIn();
					setTimeout(function() {
						button.removeClass('active-button');
					}, 1000 );
					
					wrap.height('auto');
					
				}, delay );
			}
		});

		
		$( '.widget.jolene_extended .wrap-list.hidden-widget.all' ).each(function( index ) {

			var top = $( this ).offset().top;
			var currentPos = $( window ).scrollTop();

			if(currentPos + $( window ).height()/2 > top && currentPos < top + $( this ).height() ) {
				$( this ).css('height', $( this ).height()); // fix height			
				$( this ).find('.header-list').hide(); // hide 
				$( this ).removeClass('hidden-widget'); 	
				
				$( this ).find('.header-list').each(function( index ) {
					$( this ).fadeIn().height('auto');
				});
				
				var delay = 2000;
				
				var wrap = $( this );
				
				setTimeout(function() {
					
					wrap.height('auto');
					
				}, delay );
			}
		});
	}
	
	function setMargins() {
	$( '.widget.jolene_extended' ).each(function( index ) {
	
		if($(this).find('.wrap-list').hasClass('slider-widget'))
			return;
			
		var headers = $( this ).find( '.style-0.header-list' );
		var headers_1 = $( this ).find( '.style-1.header-list' );
		var img = headers.find( 'img' );
		var footers = $( this ).find( '.style-0.footer-list' );
		var max_height_img = new Array();
		var max_height_title = new Array();
		var max_height_footer = new Array();
		var max_height = 0;
		var max_height_2 = 0;
		var max_title1_height = 0;
		var min_title1_height = 999999;
		
		var width = 0;
		setTimeout(function() {
			var row = 0;
			var top = 0;
			var column_count = 0;
			var curr_top = 0;
			
			headers.each(function( index ) {
				curr_top = $(this).offset().top;
				if(curr_top == top && row == 0) {
					column_count++;
				}
				if(top == 0) {
					top = curr_top;
					column_count++;
				}
				if(curr_top > top){
					row++;
				}
			});
			column_count = (column_count > 0 ? column_count : 1);
			var column = 0;
			row = 0;
			top = 0;
			max_height_img[0] = 0;
			max_height_title[0] = 0;
			max_height_footer[0] = 0;
			var num = 0;
			headers.each(function( index ) {
				height = parseInt( $( this ).find( 'img' ).css( 'height' ) );
				height = (isNaN(height) ? 0 : height);
				if(column == column_count) {
					column = 0;
					row++;
					max_height_img[row] = 0;
				}
				
				max_height_img[row] = (height > max_height_img[row] ? height : max_height_img[row]);
				column++;
			});
			
			column = 0;
			row = 0;
			footers.each(function( index ) {
				title_height = parseInt( $( this ).find( '.w-head' ).css( 'height' ) );
				title_height = (isNaN(title_height) ? 0 : title_height);
				if(column == column_count) {
					column = 0;
					row++;
					max_height_title[row] = 0;
				}
				max_height_title[row] = (title_height > max_height_title[row] ? title_height : max_height_title[row]);
				column++;
			});
			width = parseInt( footers.eq(0).css( 'width' ) );
			column = 0;
			num = 0;
			var _max_height_img = 0;
			headers.each(function( index ) {
				height = parseInt( $( this ).find( 'img' ).css( 'height' ) );
				height = ( isNaN(height) ? 0 : height);
				_max_height_img = max_height_img[Math.floor(num/column_count)];
				var top = ( _max_height_img - height > 0 ? _max_height_img - height : 0 );		
				var title = $( this ).find( '.w-head' );
				height = parseInt( title.css( 'height' ) );
				var bottomtitle = ( max_height_title[Math.floor(num/column_count)]- height > 0 ? max_height_title[Math.floor(num/column_count)] - height : 0 );
				title.css('margin-bottom', bottomtitle);		
				$( this ).find( '.footer-list' ).css('margin-top', top);					
				num++;
			});
			column = 0;
			num = 0;
			footers.each(function( index ) {	
				var height = parseInt( $( this ).css( 'height' ) );
				if(column == column_count) {
					column = 0;
					row++;
					max_height_footer[row] = 0;
				}
				max_height_footer[row] = (height > max_height_footer[row] ? height : max_height_footer[row]);
				column++;
			});
			headers.each(function( index ) {	
				var height = parseInt( $( this ).find( '.footer-list' ).css( 'height' ) );
				var pos = ( max_height_footer[Math.floor(num/column_count)] - height > 0 ? max_height_footer[Math.floor(num/column_count)] - height : 0 );
				link_more = $( this ).find( '.link-read-more' );
				link_more.css( {'top':pos} );
			});
		}, 100);
	});	
	}
});