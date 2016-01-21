jQuery(document).ready(function () {
	jQuery('#arrows-type input[name="params[slider_navigation_type]"]').change(function(){
		jQuery(this).parents('ul').find('li.active').removeClass('active');
		jQuery(this).parents('li').addClass('active');
	});
	jQuery('#slider-loading-icon li').click(function(){ //alert(jQuery(this).find("input:checked").val());
		jQuery(this).parents('ul').find('li.act').removeClass('act');
		jQuery(this).addClass('act');
	});	
	jQuery('.slider-options .save-slider-options').click(function(){
		alert("General Settings are disabled in free version. If you need those functionalityes, you need to buy the commercial version.");
	});	
		
	jQuery('input[data-slider="true"]').bind("slider:changed", function (event, data) {
		 jQuery(this).parent().find('span').html(parseInt(data.value)+"%");
		 jQuery(this).val(parseInt(data.value));
	});
		
	jQuery('.help').hover(function(){
           jQuery(this).parent().find('.help-block').removeClass('active');
           var width=jQuery(this).parent().find('.help-block').outerWidth();
            jQuery(this).parent().find('.help-block').addClass('active').css({'left':-((width /2)-10)});
        },function() {
			jQuery(this).parent().find('.help-block').removeClass('active');
	});
	
});

  jQuery(function() {
    jQuery( "#images-list" ).sortable({
      stop: function() {
			jQuery("#images-list li").removeClass('has-background');
			count=jQuery("#images-list li").length;
			for(var i=0;i<=count;i+=2){
					jQuery("#images-list li").eq(i).addClass("has-background");
			}
			jQuery("#images-list li").each(function(){
				jQuery(this).find('.order_by').val(jQuery(this).index());
			});
      },
      revert: true
    });
   // jQuery( "ul, li" ).disableSelection();
  });