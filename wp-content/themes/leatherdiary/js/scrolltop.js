jQuery(document).ready(function($) {
		var stickyHeaderTop = $('.header-content').offset().top;
		$(window).scroll(function(){
		    if( $(window).scrollTop() > stickyHeaderTop ) {
			$('#fixed-navigation').addClass("sticky-nav");
		    } else {
			$('#fixed-navigation').removeClass("sticky-nav");
		    }
		});
});