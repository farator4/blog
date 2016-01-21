<?php	
if(function_exists('current_user_can'))
//if(!current_user_can('manage_options')) {
    
if(!current_user_can('delete_pages')) {
    die('Access Denied');
}	
if(!function_exists('current_user_can')){
	die('Access Denied');
}

function html_showsliders( $rows,  $pageNav,$sort,$cat_row){
	global $wpdb;
	?>
    <script language="javascript">
		function ordering(name,as_or_desc)
		{
			document.getElementById('asc_or_desc').value=as_or_desc;		
			document.getElementById('order_by').value=name;
			document.getElementById('admin_form').submit();
		}
		function saveorder()
		{
			document.getElementById('saveorder').value="save";
			document.getElementById('admin_form').submit();
			
		}
		function listItemTask(this_id,replace_id)
		{
			document.getElementById('oreder_move').value=this_id+","+replace_id;
			document.getElementById('admin_form').submit();
		}
		function doNothing() {  
			var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if( keyCode == 13 ) {


				if(!e) var e = window.event;

				e.cancelBubble = true;
				e.returnValue = false;

				if (e.stopPropagation) {
						e.stopPropagation();
						e.preventDefault();
				}
			}
		}
	</script>

<div class="wrap">
	
    <?php $path_site2 = plugins_url("./images", __FILE__); ?>
		<style>
		.free_version_banner {
			position:relative;
			display:block;
			background-image:url(<?php echo $path_site2; ?>/wp_banner_bg.jpg);
			background-position:top left;
			backround-repeat:repeat;
			overflow:hidden;
		}
		
		.free_version_banner .manual_icon {
			position:absolute;
			display:block;
			top:15px;
			left:15px;
		}
		
		.free_version_banner .usermanual_text {
                        font-weight: bold !important;
			display:block;
			float:left;
			width:270px;
			margin-left:75px;
			font-family:'Open Sans',sans-serif;
			font-size:12px;
			font-weight:300;
			font-style:italic;
			color:#ffffff;
			line-height:10px;
                        margin-top: 0;
                        padding-top: 15px;
		}
		
		.free_version_banner .usermanual_text a,
		.free_version_banner .usermanual_text a:link,
		.free_version_banner .usermanual_text a:visited {
			display:inline-block;
			font-family:'Open Sans',sans-serif;
			font-size:17px;
			font-weight:600;
			font-style:italic;
			color:#ffffff;
			line-height:30.5px;
			text-decoration:underline;
		}
		
		.free_version_banner .usermanual_text a:hover,
		.free_version_banner .usermanual_text a:focus,
		.free_version_banner .usermanual_text a:active {
			text-decoration:underline;
		}
		
		.free_version_banner .get_full_version,
		.free_version_banner .get_full_version:link,
		.free_version_banner .get_full_version:visited {
                        padding-left: 60px;
                        padding-right: 4px;
			display: inline-block;
                        position: absolute;
                        top: 15px;
                        right: calc(50% - 167px);
                        height: 38px;
                        width: 268px;
                        border: 1px solid rgba(255,255,255,.6);
                        font-family: 'Open Sans',sans-serif;
                        font-size: 23px;
                        color: #ffffff;
                        line-height: 43px;
                        text-decoration: none;
                        border-radius: 2px;
		}
		
		.free_version_banner .get_full_version:hover {
			background:#ffffff;
			color:#bf1e2e;
			text-decoration:none;
			outline:none;
		}
		
		.free_version_banner .get_full_version:focus,
		.free_version_banner .get_full_version:active {
			
		}
		
		.free_version_banner .get_full_version:before {
			content:'';
			display:block;
			position:absolute;
			width:33px;
			height:23px;
			left:25px;
			top:9px;
			background-image:url(<?php echo $path_site2; ?>/wp_shop.png);
			background-position:0px 0px;
			background-repeat;
		}
		
		.free_version_banner .get_full_version:hover:before {
			background-position:0px -27px;
		}
		
		.free_version_banner .huge_it_logo {
			float:right;
			margin:15px 15px;
		}
		
		.free_version_banner .description_text {
                        padding:0 0 13px 0;
			position:relative;
			display:block;
			width:100%;
			text-align:center;
			float:left;
			font-family:'Open Sans',sans-serif;
			color:#fffefe;
			line-height:inherit;
		}
                .free_version_banner .description_text p{
                        margin:0;
                        padding:0;
                        font-size: 14px;
                }
		</style>
	<div class="free_version_banner">
		<img class="manual_icon" src="<?php echo $path_site2; ?>/icon-user-manual.png" alt="user manual" />
		<p class="usermanual_text">If you have any difficulties in using the options, Follow the link to <a href="http://huge-it.com/wordpress-slider-user-manual/" target="_blank">User Manual</a></p>
		<a class="get_full_version" href="http://huge-it.com/slider/" target="_blank">GET THE FULL VERSION</a>
                <a href="http://huge-it.com" target="_blank"><img class="huge_it_logo" src="<?php echo $path_site2; ?>/Huge-It-logo.png"/></a>
                <div style="clear: both;"></div>
		<div  class="description_text"><p>This is the free version of the plugin. Click "GET THE FULL VERSION" for more advanced options.   We appreciate every customer.</p></div>
	</div>
	<div style="clear:both;"></div>
	<div id="poststuff">
		<div id="sliders-list-page">
			<form method="post"  onkeypress="doNothing()" action="admin.php?page=sliders_huge_it_slider" id="admin_form" name="admin_form">
			<h2>Huge IT Sliders
				<a onclick="window.location.href='admin.php?page=sliders_huge_it_slider&task=add_cat'" class="add-new-h2" >Add New Slider</a>
			</h2>
			<?php
			$serch_value='';
			if(isset($_POST['serch_or_not'])) {if($_POST['serch_or_not']=="search"){ $serch_value=esc_html(stripslashes($_POST['search_events_by_title'])); }else{$serch_value="";}} 
			$serch_fields='<div class="alignleft actions"">
				<label for="search_events_by_title" style="font-size:14px">Filter: </label>
					<input type="text" name="search_events_by_title" value="'.$serch_value.'" id="search_events_by_title" onchange="clear_serch_texts()">
			</div>
			<div class="alignleft actions">
				<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\'; document.getElementById(\'serch_or_not\').value=\'search\';
				 document.getElementById(\'admin_form\').submit();" class="button-secondary action">
				 <input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=sliders_huge_it_slider\'" class="button-secondary action">
			</div>';

			 print_html_nav($pageNav['total'],$pageNav['limit'],$serch_fields);
			?>
			<table class="wp-list-table widefat fixed pages" style="width:95%">
				<thead>
				 <tr>
					<th scope="col" id="id" style="width:30px" ><span>ID</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="name" style="width:85px" ><span>Name</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="prod_count"  style="width:75px;" ><span>Images</span><span class="sorting-indicator"></span></th>
					<th style="width:40px">Delete</th>
				 </tr>
				</thead>
				<tbody>
				 <?php 
				 $trcount=1;
				  for($i=0; $i<count($rows);$i++){
					$trcount++;
					$ka0=0;
					$ka1=0;
					if(isset($rows[$i-1]->id)){
						  if($rows[$i]->sl_width==$rows[$i-1]->sl_width){
						  $x1=$rows[$i]->id;
						  $x2=$rows[$i-1]->id;
						  $ka0=1;
						  }
						  else
						  {
							  $jj=2;
							  while(isset($rows[$i-$jj]))
							  {
								  if($rows[$i]->sl_width==$rows[$i-$jj]->sl_width)
								  {
									  $ka0=1;
									  $x1=$rows[$i]->id;
									  $x2=$rows[$i-$jj]->id;
									   break;
								  }
								$jj++;
							  }
						  }
						  if($ka0){
							$move_up='<span><a href="#reorder" onclick="return listItemTask(\''.$x1.'\',\''.$x2.'\')" title="Move Up">   <img src="'.plugins_url('images/uparrow.png',__FILE__).'" width="16" height="16" border="0" alt="Move Up"></a></span>';
						  }
						  else{
							$move_up="";
						  }
					}else{$move_up="";}
					
					
					if(isset($rows[$i+1]->id)){
						
						if($rows[$i]->sl_width==$rows[$i+1]->sl_width){
						  $x1=$rows[$i]->id;
						  $x2=$rows[$i+1]->id;
						  $ka1=1;
						}
						else
						{
							  $jj=2;
							  while(isset($rows[$i+$jj]))
							  {
								  if($rows[$i]->sl_width==$rows[$i+$jj]->sl_width)
								  {
									  $ka1=1;
									  $x1=$rows[$i]->id;
									  $x2=$rows[$i+$jj]->id;
									  break;
								  }
								$jj++;
							  }
						}
						
						if($ka1){
							$move_down='<span><a href="#reorder" onclick="return listItemTask(\''.$x1.'\',\''. $x2.'\')" title="Move Down">  <img src="'.plugins_url('images/downarrow.png',__FILE__).'" width="16" height="16" border="0" alt="Move Down"></a></span>';
						}else{
							$move_down="";	
						}
					}

					$uncat=$rows[$i]->par_name;
					if(isset($rows[$i]->prod_count))
						$pr_count=$rows[$i]->prod_count;
					else
						$pr_count=0;


					?>
					<tr <?php if($trcount%2==0){ echo 'class="has-background"';}?>>
						<td><?php echo $rows[$i]->id; ?></td>
						<td><a  href="admin.php?page=sliders_huge_it_slider&task=edit_cat&id=<?php echo esc_html($rows[$i]->id) ?>"><?php echo esc_html(stripslashes($rows[$i]->name)); ?></a></td>
						<td>(<?php if(!($pr_count)){echo '0';} else{ echo $rows[$i]->prod_count;} ?>)</td>
						<td><a  href="admin.php?page=sliders_huge_it_slider&task=remove_cat&id=<?php echo esc_html($rows[$i]->id) ?>">Delete</a></td>
					</tr> 
				 <?php } ?>
				</tbody>
			</table>
			 <input type="hidden" name="oreder_move" id="oreder_move" value="" />
			 <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo esc_html($_POST['asc_or_desc']);?>"  />
			 <input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo esc_html($_POST['order_by']);?>"  />
			 <input type="hidden" name="saveorder" id="saveorder" value="" />
			 <input type="hidden" name="csrf_token_hugeit_1752" value="csrf_token_hugeit_1752" />

			 <?php
			
			 $_SESSION['csrf_token_hugeit_1752'] = 'csrf_token_hugeit_1752';
			?>
			
			
		   
			</form>
		</div>
	</div>
</div>
    <?php

}
function Html_editslider($ord_elem, $count_ord,$images,$row,$cat_row, $rowim, $rowsld, $paramssld, $rowsposts, $rowsposts8, $postsbycat)

{
 global $wpdb;
	
	if(isset($_GET["addslide"])){
	$_GET["addslide"] = esc_html($_GET["addslide"]);
	if($_GET["addslide"] == 1){
	header('Location: admin.php?page=sliders_huge_it_slider&id='.$row->id.'&task=apply');
	}
	}
		
	
?>
<script type="text/javascript">
function submitbutton(pressbutton) 
{
	if(!document.getElementById('name').value){
	alert("Name is required.");
	return;
	
	}
	
	document.getElementById("adminForm").action=document.getElementById("adminForm").action+"&task="+pressbutton;
	document.getElementById("adminForm").submit();
	
}
function change_select()
{
		submitbutton('apply'); 
	
}
</script>

<!-- GENERAL PAGE, ADD IMAGES PAGE -->

<div>
	<?php $path_site2 = plugins_url("./images", __FILE__); ?>
		<style>
		.free_version_banner {
			position:relative;
			display:block;
			background-image:url(<?php echo $path_site2; ?>/wp_banner_bg.jpg);
			background-position:top left;
			backround-repeat:repeat;
			overflow:hidden;
		}
		
		.free_version_banner .manual_icon {
			position:absolute;
			display:block;
			top:15px;
			left:15px;
		}
		
		.free_version_banner .usermanual_text {
                        font-weight: bold !important;
			display:block;
			float:left;
			width:270px;
			margin-left:75px;
			font-family:'Open Sans',sans-serif;
			font-size:12px;
			font-weight:300;
			font-style:italic;
			color:#ffffff;
			line-height:10px;
                        margin-top: 0;
                        padding-top: 15px;
		}
		
		.free_version_banner .usermanual_text a,
		.free_version_banner .usermanual_text a:link,
		.free_version_banner .usermanual_text a:visited {
			display:inline-block;
			font-family:'Open Sans',sans-serif;
			font-size:17px;
			font-weight:600;
			font-style:italic;
			color:#ffffff;
			line-height:30.5px;
			text-decoration:underline;
		}
		
		.free_version_banner .usermanual_text a:hover,
		.free_version_banner .usermanual_text a:focus,
		.free_version_banner .usermanual_text a:active {
			text-decoration:underline;
		}
		
		.free_version_banner .get_full_version,
		.free_version_banner .get_full_version:link,
		.free_version_banner .get_full_version:visited {
                        padding-left: 60px;
                        padding-right: 4px;
			display: inline-block;
                        position: absolute;
                        top: 15px;
                        right: calc(50% - 167px);
                        height: 38px;
                        width: 268px;
                        border: 1px solid rgba(255,255,255,.6);
                        font-family: 'Open Sans',sans-serif;
                        font-size: 23px;
                        color: #ffffff;
                        line-height: 43px;
                        text-decoration: none;
                        border-radius: 2px;
		}
		
		.free_version_banner .get_full_version:hover {
			background:#ffffff;
			color:#bf1e2e;
			text-decoration:none;
			outline:none;
		}
		
		.free_version_banner .get_full_version:focus,
		.free_version_banner .get_full_version:active {
			
		}
		
		.free_version_banner .get_full_version:before {
			content:'';
			display:block;
			position:absolute;
			width:33px;
			height:23px;
			left:25px;
			top:9px;
			background-image:url(<?php echo $path_site2; ?>/wp_shop.png);
			background-position:0px 0px;
			background-repeat;
		}
		
		.free_version_banner .get_full_version:hover:before {
			background-position:0px -27px;
		}
		
		.free_version_banner .huge_it_logo {
			float:right;
			margin:15px 15px;
		}
		
		.free_version_banner .description_text {
                        padding:0 0 13px 0;
			position:relative;
			display:block;
			width:100%;
			text-align:center;
			float:left;
			font-family:'Open Sans',sans-serif;
			color:#fffefe;
			line-height:inherit;
		}
                .free_version_banner .description_text p{
                        margin:0;
                        padding:0;
                        font-size: 14px;
                }
		</style>
	<div class="free_version_banner">
		<img class="manual_icon" src="<?php echo $path_site2; ?>/icon-user-manual.png" alt="user manual" />
		<p class="usermanual_text">If you have any difficulties in using the options, Follow the link to <a href="http://huge-it.com/wordpress-slider-user-manual/" target="_blank">User Manual</a></p>
		<a class="get_full_version" href="http://huge-it.com/slider/" target="_blank">GET THE FULL VERSION</a>
                <a href="http://huge-it.com" target="_blank"><img class="huge_it_logo" src="<?php echo $path_site2; ?>/Huge-It-logo.png"/></a>
                <div style="clear: both;"></div>
		<div  class="description_text"><p>This is the free version of the plugin. Click "GET THE FULL VERSION" for more advanced options.   We appreciate every customer.</p></div>
	</div>
	<div style="clear:both;"></div>
<form action="admin.php?page=sliders_huge_it_slider&id=<?php echo $row->id; ?>" method="post" name="adminForm" id="adminForm">
	<div id="poststuff" >
	<div id="slider-header">
		<ul id="sliders-list">
			
			<?php
			foreach($rowsld as $rowsldires){
				if($rowsldires->id != $row->id){
				?>
					<li>
						<a href="#" onclick="window.location.href='admin.php?page=sliders_huge_it_slider&task=edit_cat&id=<?php echo $rowsldires->id; ?>'" ><?php echo $rowsldires->name; ?></a>
					</li>
				<?php
				}
				else{ ?>
					<li class="active" onclick="this.firstElementChild.style.width = ((this.firstElementChild.value.length + 1) * 8) + 'px';" style="background-image:url(<?php echo plugins_url('images/edit.png', __FILE__) ;?>);cursor: pointer;">
						<input class="text_area" onfocus="this.style.width = ((this.value.length + 1) * 8) + 'px'" type="text" name="name" id="name" maxlength="250" value="<?php echo esc_html(stripslashes($row->name));?>" />
					</li>
				<?php	
				}
			}
		?>
			<li class="add-new">
				<a onclick="window.location.href='admin.php?page=sliders_huge_it_slider&amp;task=add_cat'">+</a>
			</li>
		</ul>
		</div>
		<div id="post-body" class="metabox-holder columns-2">
			<!-- Content -->
			<div id="post-body-content">


			<?php add_thickbox(); ?>

				<div id="post-body">
					<div id="post-body-heading">
						<h3>Slides</h3>
<script>
jQuery(document).ready(function($){
	/*jQuery(".wp-media-buttons-icon").click(function() {
		jQuery(".attachment-filters").css("display","none");
	});*/
  var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;
	 

  jQuery('.huge-it-newuploader .button').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
	
    var button = jQuery(this);
    var id = button.attr('id').replace('_button', '');
    _custom_media = true;

	jQuery("#"+id).val('');
	wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
	     jQuery("#"+id).val(attachment.url+';;;'+jQuery("#"+id).val());
		 jQuery("#save-buttom").click();
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }
  
    wp.media.editor.open(button);
	 
    return false;
  });

  jQuery('.add_media').on('click', function(){
    _custom_media = false;
	
  });
	/*jQuery(".wp-media-buttons-icon").click(function() {
		jQuery(".media-menu-item").css("display","none");
		jQuery(".media-menu-item:first").css("display","block");
		jQuery(".separator").next().css("display","block");
		jQuery('.attachment-filters').val('image').trigger('change');
		jQuery(".attachment-filters").css("display","none");
	});*/
});
</script>
						<input type="hidden" name="imagess" id="_unique_name" />
						<span class="wp-media-buttons-icon"></span>
						<div class="huge-it-newuploader uploader button button-primary add-new-image">
						<input type="button" class="button wp-media-buttons-icon" name="_unique_name_button" id="_unique_name_button" value="Add Image Slide" />
						</div>
						<a href="admin.php?page=sliders_huge_it_slider&task=popup_posts&id=<?php echo esc_html($_GET['id']); ?>&TB_iframe=1" class="button button-primary add-post-slide thickbox"  id="slideup2s" value="iframepop">
						<input  title="Add Post" class="thickbox" type="button" value="Add Post" />
						<span class="wp-media-buttons-icon"></span>Add Post Slide
						</a>
						<a href="admin.php?page=sliders_huge_it_slider&task=popup_video&id=<?php echo esc_html($_GET['id']); ?>&TB_iframe=1" class="button button-primary add-video-slide thickbox"  id="slideup3s" value="iframepop">
							<span class="wp-media-buttons-icon"></span>Add Video Slide
						</a>
						<script>
								jQuery(document).ready(function ($) {
										jQuery("#slideup").click(function () {
											window.parent.uploadID = jQuery(this).prev('input');
											formfield = jQuery('.upload').attr('name');
											tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
											return false;
										});
										window.send_to_editor = function (html) {
											imgurl = jQuery('img', html).attr('src');
											if(imgurl) {
												window.parent.uploadID.val(imgurl);
													tb_remove();
													jQuery("#save-buttom").click();
											}
											else {
												imgurl = jQuery('#embed-url-field').val();
												if(imgurl) {


													window.parent.jQuery("#_unique_name").val(imgurl+';;;');				
													jQuery("#save-buttom").click();												

													tb_remove();
												}
											}
										};
									});
						</script>				
					</div>
					<ul id="images-list">
					<?php
					
						function get_youtube_id_from_url($url){
							if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
								return $match[1];
							}
						}
					
					$i=2;
					foreach ($rowim as $key=>$rowimages){ ?>
					<?php if($rowimages->sl_type == ''){$rowimages->sl_type = 'image';}
					switch($rowimages->sl_type){
					case 'image':	?>
						<li <?php if($i%2==0){echo "class='has-background'";}$i++; ?>>
						<input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
							<div class="image-container">
								<img src="<?php echo $rowimages->image_url; ?>" />
								<div>
								<script>
									jQuery(document).ready(function($){
									  var _custom_media = true,
										  _orig_send_attachment = wp.media.editor.send.attachment;

									  jQuery('.huge-it-editnewuploader .button<?php echo $rowimages->id; ?>').click(function(e) {
										var send_attachment_bkp = wp.media.editor.send.attachment;
										var button = jQuery(this);
										var id = button.attr('id').replace('_button', '');
										_custom_media = true;
										wp.media.editor.send.attachment = function(props, attachment){
										  if ( _custom_media ) {
											jQuery("#"+id).val(attachment.url);
											jQuery("#save-buttom").click();
										  } else {
											return _orig_send_attachment.apply( this, [props, attachment] );
										  };
										}

										wp.media.editor.open(button);
										return false;
									  });

									  jQuery('.add_media').on('click', function(){
										_custom_media = false;
									  });
										/* jQuery(".huge-it-editnewuploader").click(function() {
										});
											jQuery(".wp-media-buttons-icon").click(function() {
											jQuery(".media-menu-item").css("display","none");
											jQuery(".media-menu-item:first").css("display","block");
											jQuery(".separator").next().css("display","block");
											jQuery('.attachment-filters').val('image').trigger('change');
											jQuery(".attachment-filters").css("display","none");

										});*/
									});
								</script>
								<input type="hidden" name="imagess<?php echo $rowimages->id; ?>" id="_unique_name<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->image_url; ?>" />
								<span class="wp-media-buttons-icon"></span>
								<div class="huge-it-editnewuploader uploader button<?php echo $rowimages->id; ?> add-new-image">
								<input type="button" class="button<?php echo $rowimages->id; ?> wp-media-buttons-icon editimageicon" name="_unique_name_button<?php echo $rowimages->id; ?>" id="_unique_name_button<?php echo $rowimages->id; ?>" value="Edit image" />
							</div>
									</div>
							</div>
							<div class="image-options">
								<div>
									<label for="titleimage<?php echo $rowimages->id; ?>">Title:</label>
									<input  class="text_area" type="text" id="titleimage<?php echo $rowimages->id; ?>" name="titleimage<?php echo $rowimages->id; ?>" id="titleimage<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->name; ?>">
								</div>
								<div class="description-block">
									<label for="im_description<?php echo $rowimages->id; ?>">Description:</label>
									<textarea id="im_description<?php echo $rowimages->id; ?>" name="im_description<?php echo $rowimages->id; ?>" ><?php echo $rowimages->description; ?></textarea>
								</div>
								<div class="link-block">
									<label for="sl_url<?php echo $rowimages->id; ?>">URL:</label>
									<input class="text_area url-input" type="text" id="sl_url<?php echo $rowimages->id; ?>" name="sl_url<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->sl_url; ?>" >
									<label class="long" for="sl_link_target<?php echo $rowimages->id; ?>">Open in new tab</label>
									<input type="hidden" name="sl_link_target<?php echo $rowimages->id; ?>" value="" />
									<input  <?php if($rowimages->link_target == 'on'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" id="sl_link_target<?php echo $rowimages->id; ?>" name="sl_link_target<?php echo $rowimages->id; ?>" />
									
									<!--<input type="checkbox" name="pause_on_hover" id="pause_on_hover"  <?php if($row->pause_on_hover == 'on'){ echo 'checked="checked"'; } ?>  class="link_target"/>-->
								</div>
								<div class="remove-image-container">
									<a class="button remove-image" href="admin.php?page=sliders_huge_it_slider&id=<?php echo $row->id; ?>&task=apply&removeslide=<?php echo $rowimages->id; ?>">Remove Image</a>
								</div>
							</div>
							
						<div class="clear"></div>
						</li>
						<?php
						break;
						case 'last_posts':	?>
						<li <?php if($i%2==0){echo "class='has-background'";}$i++; ?>  >
						<input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
							<div class="image-container">
								<img width='100' height='100' src="<?php echo plugins_url( 'images/pin.png' , __FILE__ ); ?>" />
							</div>
							<div class="recent-post-options image-options">
								<div>
									<div class="left">
										<?php $categories = get_categories(); ?>
										<label for="titleimage<?php echo $rowimages->id; ?>">Show Posts From:</label>
										<select name="titleimage<?php echo $rowimages->id; ?>" class="categories-list">
											<option <?php if($rowimages->name == 0){echo 'selected="selected"';} ?> value="0">All Categories</option>
										<?php foreach ($categories as $strcategories){ ?>
											<option <?php if($rowimages->name == $strcategories->cat_name){echo 'selected="selected"';} ?> value="<?php echo $strcategories->cat_name; ?>"><?php echo $strcategories->cat_name; ?></option>
										<?php	}	?> 
										</select>
									</div>
									<div  class="left">
										<label for="sl_url<?php echo $rowimages->id; ?>">Showing Posts Count:</label>
										<input class="text_area url-input number" type="number" id="sl_url<?php echo $rowimages->id; ?>" name="sl_url<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->sl_url; ?>" >
									</div>
								</div>
	
								<div>
									<label class="long" for="sl_stitle<?php echo $rowimages->id; ?>">Show Title:</label>
									<input type="hidden" name="sl_stitle<?php echo $rowimages->id; ?>" value="" />
									<input  <?php if($rowimages->sl_stitle == '1'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" name="sl_stitle<?php echo $rowimages->id; ?>" value="1" />
								</div>
								<div>
									<div class="left margin">
										<label class="long" for="sl_sdesc<?php echo $rowimages->id; ?>">Show Description:</label>
										<input type="hidden" name="sl_sdesc<?php echo $rowimages->id; ?>" value="" />
										<input  <?php if($rowimages->sl_sdesc == '1'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" name="sl_sdesc<?php echo $rowimages->id; ?>" value="1" />
									</div>
									<div class="left">
										<label for="im_description<?php echo $rowimages->id; ?>">Description Symbols Number:</label>
										<input value="<?php echo $rowimages->description; ?>" class="text_area url-input number" id="im_description<?php echo $rowimages->id; ?>" type="number" name="im_description<?php echo $rowimages->id; ?>" />
									</div>
								</div>
								<div>
									<div class="left margin">
										<label class="long" for="sl_postlink<?php echo $rowimages->id; ?>">Use Post Link:</label>
										<input type="hidden" name="sl_postlink<?php echo $rowimages->id; ?>" value="" />
										<input  <?php if($rowimages->sl_postlink == '1'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" name="sl_postlink<?php echo $rowimages->id; ?>" value="1" />
									</div>
									<div  class="left">	
										<label class="long" for="sl_link_target<?php echo $rowimages->id; ?>">Open Link In New Tab:</label>
										<input type="hidden" name="sl_link_target<?php echo $rowimages->id; ?>" value="" />
										<input  <?php if($rowimages->link_target == 'on'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" id="sl_link_target<?php echo $rowimages->id; ?>" name="sl_link_target<?php echo $rowimages->id; ?>" />
										<!--<input type="checkbox" name="pause_on_hover" id="pause_on_hover"  <?php if($row->pause_on_hover == 'on'){ echo 'checked="checked"'; } ?>  class="link_target"/>-->
									</div>
								</div>
								<div class="remove-image-container">
									<a class="button remove-image" href="admin.php?page=sliders_huge_it_slider&id=<?php echo $row->id; ?>&task=apply&removeslide=<?php echo $rowimages->id; ?>">Remove Last posts</a>
								</div>
							</div>
							
						<div class="clear"></div>
						</li>
						<?php
						break;
						case 'video': 
							
						?>
							
							<li <?php if($i%2==0){echo "class='has-background'";}$i++; ?>  >
							<input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
								<?php 	if(strpos($rowimages->image_url,'youtube') !== false || strpos($rowimages->image_url,'youtu') !== false) {
											$liclass="youtube";
											$video_thumb_url=get_youtube_id_from_url($rowimages->image_url);
											$thumburl='<img src="http://img.youtube.com/vi/'.$video_thumb_url.'/mqdefault.jpg" alt="" />';
										}else if (strpos($rowimages->image_url,'vimeo') !== false) {	
											$liclass="vimeo";
											$vimeo = $rowimages->image_url;
											$imgid =  end(explode( "/", $vimeo ));
											$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$imgid.".php"));
											$imgsrc=esc_html($hash[0]['thumbnail_large']);
											$thumburl ='<img src="'.$imgsrc.'" alt="" />';
										}
										?> 
									<div class="image-container">	
										<?php echo $thumburl; ?>
										<div class="play-icon <?php echo $liclass; ?>"></div>
										
										<div>
											<script>
													jQuery(document).ready(function ($) {
															
															jQuery("#slideup<?php echo $key; ?>").click(function () {
																window.parent.uploadID = jQuery(this).prev('input');
																formfield = jQuery('.upload').attr('name');
																tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
																
																return false;
															});
													window.send_to_editor = function (html) {
														imgurl = jQuery('img', html).attr('src');
														if(imgurl) {
															window.parent.uploadID.val(imgurl);
																tb_remove();
																jQuery("#save-buttom").click();
														}
														else {
															imgurl = jQuery('#embed-url-field').val();
															if(imgurl) {


																window.parent.jQuery("#_unique_name").val(imgurl+';;;');				
																jQuery("#save-buttom").click();												

																tb_remove();
															}
														}
													};
														});
															
											</script>
											<input type="hidden" name="imagess<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->image_url; ?>" />
										</div>
									</div>
									<div class="image-options video-options">
										<?php 	if(strpos($rowimages->image_url,'youtube') !== false || strpos($rowimages->image_url,'youtu') !== false) { ?>
										
										<div class="video-quality video-options">
											<label for="titleimage<?php echo $rowimages->id; ?>">Quality:</label>	
											<select id="titleimage<?php echo $rowimages->id; ?>" name="titleimage<?php echo $rowimages->id; ?>">
												<option value="none" <?php if($rowimages->name == 'none'){ echo 'selected="selected"'; } ?>>Auto</option>
												<option value="280" <?php if($rowimages->name == '280'){ echo 'selected="selected"'; } ?>>280</option>
												<option value="360" <?php if($rowimages->name == '360'){ echo 'selected="selected"'; } ?>>360</option>
												<option value="480" <?php if($rowimages->name == '480'){ echo 'selected="selected"'; } ?>>480</option>
												<option value="hd720" <?php if($rowimages->name == 'hd720'){ echo 'selected="selected"'; } ?>>720 HD</option>
												<option value="hd1080" <?php if($rowimages->name == 'hd1080'){ echo 'selected="selected"'; } ?>>1080 HD</option>
											</select>
										</div>
										<div class="video-volume video-options">
											<label for="im_description<?php echo $rowimages->id; ?>">Volume:</label>	
											<div class="slider-container">
												<input id="im_description<?php echo $rowimages->id; ?>" name="im_description<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->description; ?>" data-slider-range="1,100"  type="text" data-slider="true"  data-slider-highlight="true" />
											</div>
										</div>
										<div class="video-options">
											<label class="long" for="sl_url<?php echo $rowimages->id; ?>">Show Controls:</label>
											<input type="hidden" name="sl_url<?php echo $rowimages->id; ?>" value="" />
											<input <?php if($rowimages->sl_url == 'on'){ echo 'checked="checked"'; } ?> class="link_target"  type="checkbox" id="sl_url<?php echo $rowimages->id; ?>" name="sl_url<?php echo $rowimages->id; ?>" />		
										</div>
										<div class="video-options">
											<label class="long" for="sl_link_target<?php echo $rowimages->id; ?>">Show Info:</label>
											<input type="hidden" name="sl_link_target<?php echo $rowimages->id; ?>" value="" />
											<input  <?php if($rowimages->link_target == 'on'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" id="sl_link_target<?php echo $rowimages->id; ?>" name="sl_link_target<?php echo $rowimages->id; ?>" />		
										</div>
										<div class="remove-image-container">
											<a class="button remove-image" href="admin.php?page=sliders_huge_it_slider&id=<?php echo $row->id; ?>&task=apply&removeslide=<?php echo $rowimages->id; ?>">Remove Video</a>
										</div>
										<?php } else {?>
										
										<div class="video-quality video-options">
											<label for="sl_link_target<?php echo $rowimages->id; ?>">Elements Color:</label>	
											<input name="sl_link_target<?php echo $rowimages->id; ?>" type="text" class="color" id="sl_link_target<?php echo $rowimages->id; ?>" size="10" value="<?php echo $rowimages->link_target; ?>"/>
										</div>
										<div class="video-volume video-options">
											<label for="im_description<?php echo $rowimages->id; ?>">Volume:</label>	
											<div class="slider-container">
												<input id="im_description<?php echo $rowimages->id; ?>" name="im_description<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->description; ?>" data-slider-range="1,100"  type="text" data-slider="true"  data-slider-highlight="true" />
											</div>
										</div>
										<div class="remove-image-container">
											<a class="button remove-image" href="admin.php?page=sliders_huge_it_slider&id=<?php echo $row->id; ?>&task=apply&removeslide=<?php echo $rowimages->id; ?>">Remove Video</a>
										</div>
										<?php } ?>
									</div>	
							<div class="clear"></div>
							</li>
					<?php
						break;
					} ?>
			<?php } ?>
					</ul>
				</div>

			</div>
				
			<!-- SIDEBAR -->
			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					<div id="slider-unique-options" class="postbox">
					<h3 class="hndle"><span>Current Slider Options</span></h3>
					<ul id="slider-unique-options-list">
						
						<li>
							<label for="sl_width">Width</label>
							<input type="text" name="sl_width" id="sl_width" value="<?php echo $row->sl_width; ?>" class="text_area" />
						</li>
						<li>
							<label for="sl_height">Height</label>
							<input type="text" name="sl_height" id="sl_height" value="<?php echo $row->sl_height; ?>" class="text_area" />
						</li>
						
						<li>
							<label for="slider_effects_list">Effects</label>
							<select name="slider_effects_list" id="slider_effects_list">
									<option <?php if($row->slider_list_effects_s == 'none'){ echo 'selected'; } ?>  value="none">None</option>
									<option <?php if($row->slider_list_effects_s == 'cubeH'){ echo 'selected'; } ?>   value="cubeH">Cube Horizontal</option>
									<option <?php if($row->slider_list_effects_s == 'cubeV'){ echo 'selected'; } ?>  value="cubeV">Cube Vertical</option>
									<option <?php if($row->slider_list_effects_s == 'fade'){ echo 'selected'; } ?>  value="fade">Fade</option>
									<option <?php if($row->slider_list_effects_s == 'sliceH'){ echo 'selected'; } ?>  value="sliceH">Slice Horizontal</option>
									<option <?php if($row->slider_list_effects_s == 'sliceV'){ echo 'selected'; } ?>  value="sliceV">Slice Vertical</option>
									<option <?php if($row->slider_list_effects_s == 'slideH'){ echo 'selected'; } ?>  value="slideH">Slide Horizontal</option>
									<option <?php if($row->slider_list_effects_s == 'slideV'){ echo 'selected'; } ?>  value="slideV">Slide Vertical</option>
									<option <?php if($row->slider_list_effects_s == 'scaleOut'){ echo 'selected'; } ?>  value="scaleOut">Scale Out</option>
									<option <?php if($row->slider_list_effects_s == 'scaleIn'){ echo 'selected'; } ?>  value="scaleIn">Scale In</option>
									<option <?php if($row->slider_list_effects_s == 'blockScale'){ echo 'selected'; } ?>  value="blockScale">Block Scale</option>
									<option <?php if($row->slider_list_effects_s == 'kaleidoscope'){ echo 'selected'; } ?>  value="kaleidoscope">Kaleidoscope</option>
									<option <?php if($row->slider_list_effects_s == 'fan'){ echo 'selected'; } ?>  value="fan">Fan</option>
									<option <?php if($row->slider_list_effects_s == 'blindH'){ echo 'selected'; } ?>  value="blindH">Blind Horizontal</option>
									<option <?php if($row->slider_list_effects_s == 'blindV'){ echo 'selected'; } ?>  value="blindV">Blind Vertical</option>
									<option <?php if($row->slider_list_effects_s == 'random'){ echo 'selected'; } ?>  value="random">Random</option>
							</select>
						</li>

						<li>
							<label for="sl_pausetime">Pause Time</label>
							<input type="text" name="sl_pausetime" id="sl_pausetime" value="<?php echo $row->description; ?>" class="text_area" />
						</li>
						<li>
							<label for="sl_changespeed">Change Speed</label>
							<input type="text" name="sl_changespeed" id="sl_changespeed" value="<?php echo $row->param; ?>" class="text_area" />
						</li>
						<li>
							<label for="slider_position">Slider Position</label>
							<select name="sl_position" id="slider_position">
									<option <?php if($row->sl_position == 'left'){ echo 'selected'; } ?>  value="left">Left</option>
									<option <?php if($row->sl_position == 'right'){ echo 'selected'; } ?>   value="right">Right</option>
									<option <?php if($row->sl_position == 'center'){ echo 'selected'; } ?>  value="center">Center</option>
							</select>
						</li>
						<li>
							<label for="sl_loading_icon">Loading Icon</label>
							<select id="sl_loading_icon" name="sl_loading_icon">
								  <option <?php if($row->sl_loading_icon == 'on'){ echo 'selected'; } ?> value="on">On</option>
								  <option <?php if($row->sl_loading_icon == 'off'){ echo 'selected'; } ?> value="off">Off</option>
							</select>
						</li>
						<li>
							<label for="show_thumb">Navigate By</label>
							<input type="hidden" value="off" name="show_thumb" />					
							<select id="show_thumb" name="show_thumb">
								  <option <?php if($row->show_thumb == 'dotstop'){ echo 'selected'; } ?> value="dotstop">Dots</option>
								  <option <?php if($row->show_thumb == 'thumbnails'){ echo 'selected'; } ?> value="thumbnails">Thumbnails</option>
								  <option <?php if($row->show_thumb == 'nonav'){ echo 'selected'; } ?> value="nonav">No Navigation</option>
							</select>
						</li>
						<li>
							<label for="pause_on_hover">Pause on Hover</label>
							<input type="hidden" value="off" name="pause_on_hover" />					
							<input type="checkbox" name="pause_on_hover"  value="on" id="pause_on_hover"  <?php if($row->pause_on_hover  == 'on'){ echo 'checked="checked"'; } ?> />
						</li>
					</ul>
						<div id="major-publishing-actions">
							<div id="publishing-action">
								<input type="button" onclick="submitbutton('apply')" value="Save Slider" id="save-buttom" class="button button-primary button-large">
							</div>
							<div class="clear"></div>
							<!--<input type="button" onclick="window.location.href='admin.php?page=sliders_huge_it_slider'" value="Cancel" class="button-secondary action">-->
						</div>
					</div>
				</div>
				<div id="slider-shortcode-box" class="postbox shortcode ms-toggle">
					<h3 class="hndle"><span>Usage</span></h3>
					<div class="inside">
						<ul>
							<li rel="tab-1" class="selected">
								<h4>Shortcode</h4>
								<p>Copy &amp; paste the shortcode directly into any WordPress post or page.</p>
								<textarea class="full" readonly="readonly">[huge_it_slider id="<?php echo $row->id; ?>"]</textarea>
							</li>
							<li rel="tab-2">
								<h4>Template Include</h4>
								<p>Copy &amp; paste this code into a template file to include the slideshow within your theme.</p>
								<textarea class="full" readonly="readonly">&lt;?php echo do_shortcode("[huge_it_slider id='<?php echo $row->id; ?>']"); ?&gt;</textarea>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="task" value="" />
	 <input type="hidden" name="csrf_token_hugeit_1752" value="csrf_token_hugeit_1752" />
			 <?php
			
			$_SESSION['csrf_token_hugeit_1752'] = 'csrf_token_hugeit_1752';
			?>
</form>
</div>

<?php

}


function html_popup_posts($ord_elem, $count_ord,$images,$row,$cat_row, $rowim, $rowsld, $paramssld, $rowsposts, $rowsposts8, $postsbycat){
	global $wpdb;

?>
			<style>
				html.wp-toolbar {
					padding:0px !important;
				}
				#wpadminbar,#adminmenuback,#screen-meta, .update-nag,#dolly {
					display:none;
				}
				#wpbody-content {
					padding-bottom:30px;
				}
				#adminmenuwrap {display:none !important;}
				.auto-fold #wpcontent, .auto-fold #wpfooter {
					margin-left: 0px;
				}
				#wpfooter {display:none;}
			</style>
			<script type="text/javascript">
				jQuery(document).ready(function() {
				
					jQuery('#slider-posts-tabs li a').click(function(){
						jQuery('#slider-posts-tabs li').removeClass('active');
						jQuery(this).parent().addClass('active');
						jQuery('#slider-posts-tabs-contents li').removeClass('active');
						var liID=jQuery(this).attr('href');
						jQuery(liID).addClass('active');
						return false;
					});
					
					jQuery('.huge-it-insert-post-button').on('click', function() {
						alert("Add Post Slide feature is disabled in free version. If you need this functionality, you need to buy the commercial version.");
						return false;
					});
			

					jQuery('#slider-posts-tabs-content-0 .huge-it-insert-post-button').on('click', function() {
						var ID1 = jQuery('#huge-it-add-posts-params').val();
						if(ID1==""){return false;}
						window.parent.uploadID.val(ID1);
						tb_remove();
						jQuery("#save-buttom").click();
						
					});
				
					jQuery('.huge-it-post-checked').change(function(){
						if(jQuery(this).is(':checked')){
							jQuery(this).addClass('active');
							jQuery(this).parent().addClass('active');
						}else {
							jQuery(this).removeClass('active');
							jQuery(this).parent().removeClass('active');
						}
						
						var inputval="";
						jQuery('#huge-it-add-posts-params').val("");
						jQuery('.huge-it-post-checked').each(function(){
							if(jQuery(this).is(':checked')){
								inputval+=jQuery(this).val()+";";
							}
						});
						jQuery('#huge-it-add-posts-params').val(inputval);
					});
											
					jQuery('#huge_it_slider_add_posts_wrap .view-type-block a').click(function(){
						jQuery('#huge_it_slider_add_posts_wrap .view-type-block a').removeClass('active');
						jQuery(this).addClass('active');
						var strtype=jQuery(this).attr('href').replace('#','');
						jQuery('#huge-it-posts-list').removeClass('list').removeClass('thumbs');
						jQuery('#huge-it-posts-list').addClass(strtype);
						return false;
					});

					jQuery('.updated').css({"display":"none"});
				<?php	if(isset($_GET["closepop"]) && $_GET["closepop"] == 1){ ?>
					jQuery("#closepopup").click();
					self.parent.location.reload();
				<?php	} ?>
				});
				
			</script>
			<a id="closepopup"  onclick=" parent.eval('tb_remove()')" style="display:none;" > [X] </a>
	
	
	<div id="huge_it_slider_add_posts">
		<div id="huge_it_slider_add_posts_wrap">
			<span class="buy-pro">This feature is disabled in free version. </br>If you need this functionality, you need to <a href="http://huge-it.com/slider/" target="_blank">buy the commercial version</a>.</span>
			<ul id="slider-posts-tabs">
				<li  class="active"><a href="#slider-posts-tabs-content-0">Static posts</a></li>
				<li><a href="#slider-posts-tabs-content-1">Last posts</a></li>
			</ul>
			<ul id="slider-posts-tabs-contents">
				<li id="slider-posts-tabs-content-0"  class="active">
					<!-- STATIC POSTS -->
					<div class="control-panel">
	
						<label for="huge-it-categories-list">Select Category <select id="huge-it-categories-list" name="iframecatid" onchange="this.form.submit()">
						<?php $categories = get_categories(  ); ?>
						<?php	 foreach ($categories as $strcategories){
							if(isset($_POST["iframecatid"])){
							?>
								 <option value="<?php echo $strcategories->cat_ID; ?>" <?php if($strcategories->cat_ID == $_POST["iframecatid"]){echo 'selected="selected"';} ?>><?php echo $strcategories->cat_name; ?></option>';
								
							<?php }
							else
							{
							?>
								<option value="<?php echo $strcategories->cat_ID; ?>"><?php echo $strcategories->cat_name; ?></option>';
							<?php
							}
						}
						?> 
						</select></label>
				
				
						<button class='save-slider-options button-primary huge-it-insert-post-button' id='huge-it-insert-post-button-top'>Insert Posts</button>
						<label for="huge-it-description-length">Description Length <input id="huge-it-description-length" type="text" name="posthuge-it-description-length" value="<?php echo $row->published; ?>" placeholder="Description length" /></label>
						<div class="view-type-block">
							<a class="view-type list active" href="#list">View List</a>
							<a class="view-type thumbs" href="#thumbs">View List</a>
						</div>
					</div>
					<div style="clear:both;"></div>
					<ul id="huge-it-posts-list" class="list">
						<li id="huge-it-posts-list-heading" class="hascolor">
							<div class="huge-it-posts-list-image">Image</div>
							<div class="huge-it-posts-list-title">Title</div>
							<div class="huge-it-posts-list-description">
								Description
							</div>
							<div class="huge-it-posts-list-link">Link</div>
							<div class="huge-it-posts-list-category">Category</div>
							<div class="help-message">Please make sure that category you selected has posts with inserted featured image. Only posts with featured images will be shown on slides.</div>
						</li>
						<?php 

						$strx=1;
						foreach($rowsposts8 as $rowspostspop1){
							 $query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."posts where post_type = 'post' and post_status = 'publish' and ID = %d  order by ID ASC", $rowspostspop1->object_id);
						$rowspostspop=$wpdb->get_results($query);
						//print_r($rowspostspop);
						if(isset($rowspostspop[0]->ID)) {
							$post_categories =  wp_get_post_categories( $rowspostspop[0]->ID, $rowspostspop[0]->ID ); 
							$cats = array();
							
							foreach($post_categories as $c){
								$cat = get_category( $c );
								$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug, 'id' => $cat->term_id );
								//echo	$cat->slug;
							}
							if(get_the_post_thumbnail($rowspostspop[0]->ID, 'thumbnail') != ''){
								$strx++;
								$hascolor="";
								if($strx%2==0){$hascolor='class="hascolor"';}
						?>
							
							<li <?php echo $hascolor; ?>>
								<input type="checkbox" class="huge-it-post-checked"  value="<?php echo $rowspostspop[0]->ID; ?>">
								<div class="huge-it-posts-list-image"><?php echo get_the_post_thumbnail($rowspostspop[0]->ID, 'thumbnail'); ?></div>
								<div class="huge-it-posts-list-title"><?php echo $rowspostspop[0]->post_title;	?></div>
								<div class="huge-it-posts-list-description"><?php echo	$rowspostspop[0]->post_content;	?></div>
								<div class="huge-it-posts-list-link"><?php echo	$rowspostspop[0]->guid; ?></div>
								<div class="huge-it-posts-list-category"><?php echo	$cat->slug;	?></div>
							</li>
						<?php }
							}
						}							?>
					</ul>
					<input id="huge-it-add-posts-params" type="hidden" name="popupposts" value="" />
					<div class="clear"></div>
					<button class='save-slider-options button-primary huge-it-insert-post-button' id='huge-it-insert-post-button-bottom'>Insert Posts</button>
			
				</li>
				<li id="slider-posts-tabs-content-1" class="recent-post-options">
					<!-- RECENT POSTS -->
				
								<div>
									<div class="left less-margin height">
										<?php $categories = get_categories(); ?>
										<label for="titleimage">Show Posts From:</label>
										<select name="titleimage" class="categories-list">
											<option <?php if(isset($rowimages->name) && $rowimages->name == 0){echo 'selected="selected"';} ?> value="0">All Categories</option>
										<?php foreach ($categories as $strcategories){ ?>
											<option <?php if($rowimages->name == $strcategories->cat_name){echo 'selected="selected"';} ?> value="<?php echo $strcategories->cat_name; ?>"><?php echo $strcategories->cat_name; ?></option>
										<?php	}	?> 
										</select>
									</div>
									<div  class="left height">
										<label for="sl_url">Showing Posts Count:</label>
										<input class="text_area url-input number" type="number" name="sl_url" value="5" >
									</div>
								</div>
	
								<div>
									<label class="long" for="sl_stitle">Show Title:</label>
									<input type="hidden" name="sl_stitle" value="" />
									<input class="link_target" checked="checked" type="checkbox" name="sl_stitle" value="1" />
								</div>
								<div>
									<div class="left margin">
										<label class="long" for="sl_sdesc">Show Description:</label>
										<input type="hidden" name="sl_sdesc" value="" />
										<input checked="checked" class="link_target" type="checkbox" name="sl_sdesc" value="1" />
									</div>
									<div class="left top ">
										<label for="im_description">Description Symbols Number:</label>
										<input value="300" class="text_area url-input number" type="number" name="im_description" />
									</div>
								</div>
								<div>
									<div class="left margin">
										<label class="long" for="sl_postlink">Use Post Link:</label>
										<input type="hidden" name="sl_postlink" value="" />
										<input  checked="checked" class="link_target" type="checkbox" name="sl_postlink" value="1" />
									</div>
									<div  class="left">	
										<label class="long" for="sl_link_target">Open Link In New Tab:</label>
										<input type="hidden" name="sl_link_target" value="" />
										<input checked="checked" class="link_target" type="checkbox" name="sl_link_target" />
										<!--<input type="checkbox" name="pause_on_hover" id="pause_on_hover"  <?php if($row->pause_on_hover == 'on'){ echo 'checked="checked"'; } ?>  class="link_target"/>-->
									</div>
								</div>
						<input id="huge-it-add-posts-params" type="hidden" name="popupposts" value="" />
						<input id="huge-it-add-posts-params" type="hidden" name="addlastposts" value="addlastposts" />
						<div class="clear"></div>
						<button class='save-slider-options button-primary huge-it-insert-post-button' id='huge-it-insert-post-button-bottom'>Insert Posts</button>
		
				</li>
			</ul>		
		</div>
	</div>		
	<?php
}
?>

<?php
function html_popup_video(){
	global $wpdb;

?>
	<style>
		html.wp-toolbar {
			padding:0px !important;
		}
		#wpadminbar,#adminmenuback,#screen-meta, .update-nag,#dolly {
			display:none;
		}
		#wpbody-content {
			padding-bottom:30px;
		}
		#adminmenuwrap {display:none !important;}
		.auto-fold #wpcontent, .auto-fold #wpfooter {
			margin-left: 0px;
		}
		#wpfooter {display:none;}
		iframe {height:250px !important;}
		#TB_window {height:250px !important;}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function() {	
			jQuery('.huge-it-insert-video-button').on('click', function() {
						alert("Add Video Slide feature is disabled in free version. If you need this functionality, you need to buy the commercial version.");
						return false;
					});

			jQuery('.huge-it-insert-post-button').on('click', function() {
				var ID1 = jQuery('#huge_it_add_video_input').val();
				if(ID1==""){alert("Please copy and past url form Youtobe or Vimeo to insert into slider.");return false;}
				
				window.parent.uploadID.val(ID1);
				
				tb_remove();
				jQuery("#save-buttom").click();
			});
			
			jQuery('#huge_it_add_video_input').change(function(){
				
				if (jQuery(this).val().indexOf("youtube") >= 0){
					jQuery('#add-video-popup-options > div').removeClass('active');
					jQuery('#add-video-popup-options  .youtube').addClass('active');
				}else if (jQuery(this).val().indexOf("vimeo") >= 0){
					jQuery('#add-video-popup-options > div').removeClass('active');
					jQuery('#add-video-popup-options  .vimeo').addClass('active');
				}else {
					jQuery('#add-video-popup-options > div').removeClass('active');
					jQuery('#add-video-popup-options  .error-message').addClass('active');
				}
			})
					
			jQuery('.updated').css({"display":"none"});
		<?php	if(isset($_GET["closepop"]) && $_GET["closepop"] == 1){ ?>
			jQuery("#closepopup").click();
			self.parent.location.reload();
		<?php	} ?>
		
		});
		
	</script>
	<a id="closepopup"  onclick=" parent.eval('tb_remove()')" style="display:none;" > [X] </a>

	<div id="huge_it_slider_add_videos">
		<span class="buy-pro">This feature is disabled in free version. <br>If you need this functionality, you need to <a href="http://huge-it.com/slider/" target="_blank">buy the commercial version</a>.</span>
		<div id="huge_it_slider_add_videos_wrap">
			<h2>Add Video URL From Youtube or Vimeo</h2>
			<div class="control-panel">
			
					<input type="text" id="huge_it_add_video_input" name="huge_it_add_video_input" />
					<button class='save-slider-options button-primary huge-it-insert-video-button' id='huge-it-insert-video-button'>Insert Video Slide</button>
					<div id="add-video-popup-options">
						<div class="youtube">
							<div>
								<label for="show_quality">Quality:</label>	
								<select id="show_quality" name="show_quality">
									<option value="none">Auto</option>
									<option value="280">280</option>
									<option value="360"selected="selected">360</option>
									<option value="480">480</option>
									<option value="hd720">720 HD</option>
									<option value="hd1080">1080 HD</option>
								</select>
							</div>
							<div>
								<label for="">Volume:</label>	
								<div class="slider-container">
									<input name="show_volume" value="50" data-slider-range="1,100"  type="text" data-slider="true"  data-slider-highlight="true" />
								</div>
							</div>
							<div>
								<label for="show_controls">Show Controls:</label>
								<input type="hidden" name="show_controls" value="" />
								<input type="checkbox" class="checkbox" checked="checked" name="show_controls" />	
							</div>
							<div>
								<label for="show_info">Show Info:</label>
								<input type="hidden" name="show_info" value="" />
								<input type="checkbox" class="checkbox" checked="checked" name="show_info" />	
							</div>
						</div>
						<div class="vimeo">
							<div>
								<label for="">Elements Color:</label>	
								<input name="show_quality_vim" type="text" class="color" id="" size="10" value="00adef"/>
							</div>
							<div>
								<label for="">Volume:</label>	
								<div class="slider-container">
									<input name="show_volume_v" value="50" data-slider-range="1,100"  type="text" data-slider="true"  data-slider-highlight="true" />
								</div>
							</div>
						</div>
						<div class="error-message">
							Please insert link only from youtube or vimeo
						</div>
					</div>
				
			</div>
		</div>	
	</div>
<?php

	
	
	
}
?>