/**
 * Handles toggling the navigation menu for small screens 
 */
( function() {
	var nav = [], button = [], menu = [], nav_class = [];
	for ( i = 0; i < 4; i++ ) {
		nav[i]= document.getElementById( 'menu-' + ( i + 1 ) );
		nav_class[i] = ( 2 === i ? 'nav-menu' : 'nav-horizontal' );
		if ( ! nav[i] ) {
			continue;
		}
		button[i] = nav[i].getElementsByTagName( 'h3' )[0];
		menu[i]   = nav[i].getElementsByTagName( 'ul' )[0];
		if ( ! button[i] ) {
			continue;
		}

		// Hide button if menu is missing or empty.
		if ( ! menu[i] || ! menu[i].childNodes.length ) {
			button[i].style.display = 'none';
			continue;
		}

		button[i].onclick = function(x) {
			return function() { 	

			if ( -1 === menu[x].className.indexOf( nav_class[x] ) ) {

				menu[x].className = nav_class[x];
				
			}
			if ( -1 !== this.className.indexOf( 'toggled-on' ) ) {
				this.className = this.className.replace( ' toggled-on', '' );
				menu[x].className = menu[x].className.replace( ' toggled-on', '' );
			} else {
				this.className += ' toggled-on';
				menu[x].className += ' toggled-on';
			} }
        }(i);
	}
} )();
/**
 * The same for top sidebars
 */
( function() {
	var nav = [], button = [], menu = [], nav_class = [];
	for ( i = 0; i < 7; i++ ) {

		nav[i]= document.getElementById( 'sidebar-' + ( i + 1 ) );
		nav_class[i] = 'widget-area';
		if ( ! nav[i] ) {
			continue;
		}
		button[i] = nav[i].getElementsByTagName( 'h3' )[0];
		menu[i]   = nav[i].getElementsByTagName( 'div' )[0];
		if ( ! button[i] ) {
			continue;
		}

		// Hide button if menu is missing or empty.
		if ( ! menu[i] || ! menu[i].childNodes.length ) {
			button[i].style.display = 'none';
			continue;
		}

		button[i].onclick = function(x) {
			return function() { 	

			if ( -1 === menu[x].className.indexOf( nav_class[x] ) ) {

				menu[x].className = nav_class[x];
				
			}
			if ( -1 !== this.className.indexOf( 'toggled-on' ) ) {
				this.className = this.className.replace( ' toggled-on', '' );
				menu[x].className = menu[x].className.replace( ' toggled-on', '' );
			} else {
				this.className += ' toggled-on';
				menu[x].className += ' toggled-on';
			} }
        }(i);
	}
} )();

//Keep sub menu within screen
jQuery( document ).ready(function( $ ) {

	$('.nav-horizontal li').bind('mouseover', jolene_openSubMenu);

	function jolene_openSubMenu() {
		var all = $(window).width();
		if(parseInt(all) < 680) 
			return;
		var left = $(this).offset().left;
		var width = $(this).outerWidth(true);

		var offset = all - (left + width + 100);
		if( offset < 0 ) {
			$(this).find( 'ul' ).css('left','-50%').css('top','100%').css('width','200');
		}
	}
	
	$(window).scroll( function(){
		if ( $(this).scrollTop() > 200 ) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});
	
	$('.scrollup').click( function(){
		$('html, body').animate({scrollTop : 0}, 1000);
		return false;
	});
});