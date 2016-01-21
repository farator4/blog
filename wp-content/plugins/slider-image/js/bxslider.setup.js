jQuery(document).ready(function() {
	//if(ifhasthumb=='thumbnails'){
		
	if(typeof huge_it_bx =="undefined"){
		var huge_it_bx=new Array();
	}
	
	function init_huge_it_bx_slider(sliderID,index){
			if (huge_it_obj == undefined) {
					huge_it_obj='';
			}
			if (huge_video_playing == undefined) {
					huge_video_playing='';
			}
			if (huge_interval == undefined) {
					huge_interval='';
			}
			
			var array_ind=huge_it_bx.length;
			
			
				huge_it_bx[array_ind] = jQuery(".huge_it_slideshow_thumbs_"+sliderID+"").bxSlider({

					slideWidth: huge_it_obj.width_thumbs,
					minSlides: huge_it_obj.slideCount,
					maxSlides:huge_it_obj.slideCount,
					moveSlides: 1,
					auto: true, 
					pause: +huge_it_obj.pauseTime,
					pager: false,
					controls: false,
					mode: 'horizontal',
					infiniteLoop:true,
					speed: +huge_it_obj.speed
				   
			
					
				   
					  
				});
				///on hover on slider stop both slider and thumbnail slider 
				jQuery("ul[class^='huge_it_slider_"+sliderID+"']").hover(function(){
					
					huge_it_bx[array_ind].stopAuto();
				},function(){
							huge_it_bx[array_ind].startAuto();
				});




		////on hovering thumbnail slider stop both
				jQuery("ul[class^='huge_it_slideshow_thumbs_"+sliderID+"']").hover(function(){
			  //	var interval = huge_it_playInterval_1;

					window.clearInterval(huge_interval['huge_it_playInterval_'+sliderID]);

					huge_it_bx[array_ind].stopAuto();
				},function(){
				//var interval = huge_it_playInterval_1;
				window.clearInterval(huge_interval['huge_it_playInterval_'+sliderID]);
				//huge_play['function play_'+sliderID]();
					
					eval('play_'+sliderID+'()')
					huge_it_bx[array_ind].startAuto();
				})
			


			


				  jQuery(".huge_it_slideshow_thumbs_"+sliderID).find('li').on('click',function(){
						window.clearInterval(huge_interval['huge_it_playInterval_'+sliderID]);
						//jQuery(this).parent().unbind();
						huge_it_bx[array_ind].stopAuto();
				  })

				  jQuery(".huge_it_slideshow_thumbs_container_"+sliderID).find("a[class^='bx-']").on('click',function(){
						window.clearInterval(huge_interval['huge_it_playInterval_'+sliderID]);
						//jQuery("ul[class^='huge_it_slideshow_thumbs_"+sliderID+"']").unbind();
						huge_it_bx[array_ind].stopAuto();


				  })



				   jQuery("#huge_it_slideshow_left_"+sliderID).on('click',function(){
				 
						huge_it_bx[array_ind].goToPrevSlide();
						

						huge_it_bx[array_ind].stopAuto();
						restart=setTimeout(function(){
							huge_it_bx[array_ind].startAuto();
							},+huge_it_obj.speed)
				  })
					jQuery("#huge_it_slideshow_right_"+sliderID).on('click',function(){
						huge_it_bx[array_ind].goToNextSlide()
					
						
					huge_it_bx[array_ind].stopAuto();
					restart=setTimeout(function(){
						huge_it_bx[array_ind].startAuto();
						},+huge_it_obj.speed)
				  })

		////////////////////////// 	  

		//setInterval(function(){
				if(huge_video_playing['video_is_playing_'+sliderID]==true){
					 huge_it_bx[array_ind].stopAuto();
					
				}else if(huge_video_playing['video_is_playing_'+sliderID]==false){
					huge_it_bx[array_ind].startAuto();
					
				}
				if(jQuery('#huge_it_loading_image_'+sliderID).css('display')=='table-cell'){
					huge_it_bx[array_ind].stopAuto();
					
				}else if(jQuery('#huge_it_loading_image_'+sliderID).css('display')=='none'){
					huge_it_bx[array_ind].startAuto();
					
				}
		//},100)
			
			
		
	}
	if(typeof sliderID_array !=="undefined"){
		jQuery.each(sliderID_array,function(ind,val){

			var sliderID=val;
			init_huge_it_bx_slider(val,ind);
			
			
		});
	}
		
		
	//}			

})





