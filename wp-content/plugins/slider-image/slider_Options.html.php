<?php
function      html_showStyles($param_values, $op_type)
{
    ?>
	<?php $path_site = plugins_url("Front_images", __FILE__); ?>
	<style>
.options-block h3{
	display: block;
    text-align: center;
    margin: 0px 0px 10px 0px !important;
}
.options-block{
	    position: relative;
    display: block;
    float: left;
    margin: 10px 1% 25px 1% !important;
    padding: 0px 1% 10px 1% !important;
    width: 46% !important;
    background: #f9f9f9;
}
.options-block2{
	    position: relative;
    display: block;
    float: left;
    margin: 10px 1% 25px 1% !important;
    padding: 0px 1% 10px 1% !important;
    width: 96% !important;
    background: #f9f9f9;
}
.options-block2>div{
	position: relative;
    padding: 10px 10px 5px 10px;
    clear: both;
}
.options-block2 >div label{
	display: inline-block;
    width: 28%;
    height: 35px;
}
.options-block2 >div label .help{
	float: right;
    position: relative;
    display: inline-block;
    width: 20px;
    height: 20px;
    margin: 0px 10px 0px 20px;
    border: 1px solid #888;
    border-radius: 20px;
    text-indent: 7px;
}
.options-block2 >div input[type=checkbox]{
	margin: -12px 4px 0 0;
}
#options-block-description{
	margin-top: -177px !important
}

	</style>
        <div>
<?php $path_site2 = plugins_url("images", __FILE__); ?>
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
		<div  class="description_text"><p>This is the free version of the plugin. In order to use options from this section, get the full version. We appreciate every customer.</p></div>
	</div>
	<div style="clear: both;"></div>
<div id="poststuff">

		<div id="post-body-content" class="slider-options">
			<div id="post-body-heading">
				<h3>General Options</h3>
				<a class="save-slider-options button-primary">Save</a>
				<script>
						jQuery(document).ready(function ($) {
								
								jQuery("#slideup<?php echo isset($key)?$key:''; ?>").click(function () {
									window.parent.uploadID = jQuery(this).prev('input');
									formfield = jQuery('.upload').attr('name');
									tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
									return false;
								});
								window.send_to_editor = function (html) {
									imgurl = jQuery('img', html).attr('src');
									window.parent.uploadID.val(imgurl);
									tb_remove();
								};
							});
							
				</script>		
			</div>
			<div id="slider-options-list">
			<form action="admin.php?page=Options_slider_styles" method="post" id="adminForm" name="adminForm">
		
			<div class="options-block" id="options-block-slider">
				<h3>Slider Styles</h3>
				<div class="has-background">
					<label for="slider_crop_image">Image Behaviour
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Choose how to behave the image in slider</p>
                                                </div>
                                            </div>
                                        </label>
					<select id="slider_crop_image" name="params[slider_crop_image]">
						  <option <?php if($param_values['slider_crop_image'] == 'crop'){ echo 'selected'; } ?> value="crop">Natural</option>
						  <option <?php if($param_values['slider_crop_image'] == 'resize'){ echo 'selected'; } ?> value="resize">Resize</option>
					</select>
				</div>
				<div >
					<label for="slider_slider_background_color">Slider Background Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the color for background of the slider</p>
                                                </div>
                                            </div>
                                        </label>
						<input name="params[slider_slider_background_color]" type="text" class="color" id="slider_slider_background_color" value="#<?php echo $param_values['slider_slider_background_color']; ?>" size="10">
				</div>
			
				<div class="has-background">
					<label for="slider_slideshow_border_size">Slider Border Size
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the border for the slideshow</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" name="params[slider_slideshow_border_size]" id="slider_slideshow_border_size" value="<?php echo $param_values['slider_slideshow_border_size']; ?>" class="text" />
				</div>
				<div>
					<label for="slider_slideshow_border_color">Slider Border Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Select the border color for the slideshow</p>
                                                </div>
                                            </div>
                                        </label>
						<input name="params[slider_slideshow_border_color]" type="text" class="color" id="slider_slideshow_border_color" value="#<?php echo $param_values['slider_slideshow_border_color']; ?>" size="10">
				</div>
				<div class="has-background">
					<label for="slider_slideshow_border_radius">Slider Border radius
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the border radius for the slideshow</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" name="params[slider_slideshow_border_radius]" id="slider_slideshow_border_radius" value="<?php echo $param_values['slider_slideshow_border_radius']; ?>" class="text" />
				</div>
				<div>
					<label for="slider_load_icon">Slider Loading Image
                                           <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the loading icon for the slideshow</p>
                                                </div>
                                            </div>
                                        </label>
					<!--<select id="slider_load_icon" name="params[slider_load_icon]">
						  <option <?php //if($param_values['slider_load_icon'] == 'on'){ echo 'selected'; } ?> value="on">On</option>
						  <option <?php //if($param_values['slider_load_icon'] == 'off'){ echo 'selected'; } ?> value="off">Off</option>
					</select>-->
					<ul id="slider-loading-icon">
						<li <?php if($param_values['loading_icon_type'] == 1){ echo 'class="act"'; } ?>>
							<label for="params[loading_icon_type]_1">
								<div class="image-block-icon">
									<img src="<?php echo $path_site; ?>/loading/loading1.gif" alt="" />
								</div>
									<input type="radio" id="params[loading_icon_type]_1" name="params[loading_icon_type]" value="1" <?php if($param_values['loading_icon_type'] == 1){ echo 'checked="checked"'; } ?>>
							</label>
						</li>
						<li <?php if($param_values['loading_icon_type'] == 2){ echo 'class="act"'; } ?>>
							<label for="params[loading_icon_type]_2">
								<div class="image-block-icon">
									<img src="<?php echo $path_site; ?>/loading/loading2.gif" alt="" />
								</div>
									<input type="radio" id="params[loading_icon_type]_2" name="params[loading_icon_type]" value="2" <?php if($param_values['loading_icon_type'] == 2){ echo 'checked="checked"'; } ?>>
							</label>
						</li>
						<li <?php if($param_values['loading_icon_type'] == 3){ echo 'class="act"'; } ?>>
							<label for="params[loading_icon_type]_3">
								<div class="image-block-icon">
									<img src="<?php echo $path_site; ?>/loading/loading3.gif" alt="" />
								</div>
									<input type="radio" id="params[loading_icon_type]_3" name="params[loading_icon_type]" value="3" <?php if($param_values['loading_icon_type'] == 3){ echo 'checked="checked"'; } ?>>
							</label>
						</li>
						<li <?php if($param_values['loading_icon_type'] == 4){ echo 'class="act"'; } ?>>
							<label for="params[loading_icon_type]_4">
								<div class="image-block-icon">
									<img src="<?php echo $path_site; ?>/loading/loading4.gif" alt="" />
								</div>
									<input type="radio" id="params[loading_icon_type]_4" name="params[loading_icon_type]" value="4" <?php if($param_values['loading_icon_type'] == 4){ echo 'checked="checked"'; } ?>>
							</label>
						</li>
						<li <?php if($param_values['loading_icon_type'] == 5){ echo 'class="act"'; } ?>>
							<label for="params[loading_icon_type]_5">
								<div class="image-block-icon">
									<img src="<?php echo $path_site; ?>/loading/loading5.gif" alt="" />
								</div>
									<input type="radio" id="params[loading_icon_type]_5" name="params[loading_icon_type]" value="5" <?php if($param_values['loading_icon_type'] == 5){ echo 'checked="checked"'; } ?>>
							</label>
						</li>
						<li <?php if($param_values['loading_icon_type'] == 6){ echo 'class="act"'; } ?>>
							<label for="params[loading_icon_type]_6">
								<div class="image-block-icon">
									<img src="<?php echo $path_site; ?>/loading/loading6.gif" alt="" />
								</div>
									<input type="radio" id="params[loading_icon_type]_6" name="params[loading_icon_type]" value="6" <?php if($param_values['loading_icon_type'] == 6){ echo 'checked="checked"'; } ?>>
							</label>
						</li>
					</ul>
				</div>
			</div>
			<div class="options-block" id="options-block-title">
				<h3>Title Styles</h3>
				<div class="has-background">
					<label for="title-container-width">Title Width
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Select the width for the title</p>
                                                </div>
                                            </div>
                                        </label>
					<div class="slider-container">
						<input name="params[slider_title_width]" id="title-container-width" data-slider-range="1,100"  type="text" data-slider="true"  data-slider-highlight="true" value="<?php echo $param_values['slider_title_width']; ?>" />
						<span><?php echo $param_values['slider_title_width']; ?>%</span>
					</div>
					<div style="clear:both;"></div>
				</div>
				<!--<div>
					<label for="params[slider_title_height]">Title height</label>
					<div class="slider-container">
						<input name="params[slider_title_height]" id="title-container-height" data-slider-range="1,100" type="text" data-slider="true"  data-slider-highlight="true" value="<?php echo $param_values['slider_title_height']; ?>" />
						<span><?php echo $param_values['slider_title_height']; ?>%</span>
					</div>
				</div>-->
				<div>
					<label for="slider_title_has_margin">Title Has Margin
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Choose the margin level for title</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="hidden" value="off" name="params[slider_title_has_margin]" />					
					<input type="checkbox" id="slider_title_has_margin"  <?php if($param_values['slider_title_has_margin']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[slider_title_has_margin]"  value="on" />
				</div>
				<div class="has-background">
					<label for="slider_title_font_size">Title Font Size
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Specify the font size for the image title</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" name="params[slider_title_font_size]" id="slider_title_font_size" value="<?php echo $param_values['slider_title_font_size']; ?>" class="text" />
					<span>px</span>
				</div>
				<div>
					<label for="slider_title_color">Title Text Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the color for the title</p>
                                                </div>
                                            </div>
                                        </label>
						<input name="params[slider_title_color]" type="text" class="color" id="slider_title_color" value="#<?php echo $param_values['slider_title_color']; ?>" size="10" />
				</div>
				<div  class="has-background">
					<label for="slider_title_text_align">Title Text Align
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Choose where to place the title</p>
                                                </div>
                                            </div>
                                        </label>
					<select id="slider_title_text_align" name="params[slider_title_text_align]">
						  <option <?php if($param_values['slider_title_text_align'] == 'justify'){ echo 'justify'; } ?> value="justify">Full width</option>
						  <option <?php if($param_values['slider_title_text_align'] == 'center'){ echo 'selected'; } ?> value="center">Center</option>
						  <option <?php if($param_values['slider_title_text_align'] == 'left'){ echo 'selected'; } ?> value="left">Left</option>
						  <option <?php if($param_values['slider_title_text_align'] == 'right'){ echo 'selected'; } ?> value="right">Right</option>
					</select>
				</div>
				<div>
					<label for="title-background-transparency">Title Background Transparency
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the level of transparency for the title</p>
                                                </div>
                                            </div>
                                        </label>
					<div class="slider-container">
						<input name="params[slider_title_background_transparency]" id="title-background-transparency" data-slider-highlight="true"  data-slider-values="0,10,20,30,40,50,60,70,80,90,100" type="text" data-slider="true" value="<?php echo $param_values['slider_title_background_transparency']; ?>" />
						<span><?php echo $param_values['slider_title_background_transparency']; ?>%</span>
					</div>
				</div>
				<div class="has-background">
					<label for="slider_title_background_color">Title Background color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Choose the color for the cell containing the title</p>
                                                </div>
                                            </div>
                                        </label>
					<input name="params[slider_title_background_color]" type="text" class="color" id="slider_title_background_color" value="#<?php echo $param_values['slider_title_background_color']; ?>" size="10" />
				</div>
				<div>
					<label for="slider_title_border_size">Title Border Size
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the border size for the title</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" name="params[slider_title_border_size]" id="slider_title_border_size" value="<?php echo $param_values['slider_title_border_size']; ?>" class="text" />
					<span>px</span>
				</div>
				<div class="has-background">
					<label for="slider_title_border_color">Title Border Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Select the border color for the title</p>
                                                </div>
                                            </div>
                                        </label>
					<input name="params[slider_title_border_color]" type="text" class="color" id="slider_title_border_color" value="#<?php echo $param_values['slider_title_border_color']; ?>" size="10">
				</div>
				<div>
					<label for="slider_title_border_radius">Title Border Radius
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the border radius for the title</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" name="params[slider_title_border_radius]" id="slider_title_border_radius" value="<?php echo $param_values['slider_title_border_radius']; ?>" class="text" />
					<span>px</span>
				</div>
				<div class="has-height has-background">
					<label for="">Title Position
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Define the position of the title using the view graph</p>
                                                </div>
                                            </div>
                                        </label>
						<div>
						<table class="bws_position_table">
							<tbody>
							  <tr>
								<td><input type="radio" value="left-top" id="slideshow_title_top-left" name="params[slider_title_position]" <?php if($param_values['slider_title_position'] == 'left-top'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="center-top" id="slideshow_title_top-center" name="params[slider_title_position]" <?php if($param_values['slider_title_position'] == 'center-top'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="right-top" id="slideshow_title_top-right" name="params[slider_title_position]"  <?php if($param_values['slider_title_position'] == 'right-top'){ echo 'checked="checked"'; } ?> /></td>
							  </tr>
							  <tr>
								<td><input type="radio" value="left-middle" id="slideshow_title_middle-left" name="params[slider_title_position]" <?php if($param_values['slider_title_position'] == 'left-middle'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="center-middle" id="slideshow_title_middle-center" name="params[slider_title_position]" <?php if($param_values['slider_title_position'] == 'center-middle'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="right-middle" id="slideshow_title_middle-right" name="params[slider_title_position]" <?php if($param_values['slider_title_position'] == 'right-middle'){ echo 'checked="checked"'; } ?> /></td>
							  </tr>
							  <tr>
								<td><input type="radio" value="left-bottom" id="slideshow_title_bottom-left" name="params[slider_title_position]" <?php if($param_values['slider_title_position'] == 'left-bottom'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="center-bottom" id="slideshow_title_bottom-center" name="params[slider_title_position]" <?php if($param_values['slider_title_position'] == 'center-bottom'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="right-bottom" id="slideshow_title_bottom-right" name="params[slider_title_position]" <?php if($param_values['slider_title_position'] == 'right-bottom'){ echo 'checked="checked"'; } ?> /></td>
							  </tr>
							</tbody>	
						</table>
						</div>
				</div>
			</div>
			<div class="options-block" id="options-block-description">
				<h3>Description Styles</h3>
				<div class="has-background">
					<label for="description-container-width">Description Width
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the width for the description text</p>
                                                </div>
                                            </div>
                                        </label>
					<div class="slider-container">
						<input name="params[slider_description_width]" id="description-container-width" data-slider-range="1,100"  type="text" data-slider="true"  data-slider-highlight="true" value="<?php echo $param_values['slider_description_width']; ?>" />
						<span><?php echo $param_values['slider_description_width']; ?>%</span>
					</div>
					<div style="clear:both;"></div>
				</div>
				<!--<div>
					<label for="params[slider_description_height]">description height</label>
					<div class="slider-container">
						<input name="params[slider_description_height]" id="description-container-height" data-slider-range="1,100" type="text" data-slider="true"  data-slider-highlight="true" value="<?php echo $param_values['slider_description_height']; ?>" />
						<span><?php echo $param_values['slider_description_height']; ?>%</span>
					</div>
				</div>-->
				<div>
					<label for="slider_description_has_margin">Description Has Margin
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Choose the margin for description text </p>
                                                </div>
                                            </div>
                                        </label>
						<input type="hidden" value="off" name="params[slider_description_has_margin]" />
						<input type="checkbox" id="slider_description_has_margin"  <?php if($param_values['slider_description_has_margin']  == 'on'){ echo 'checked="checked"'; } ?>  name="params[slider_description_has_margin]" value="on" />
				</div>
				<div class="has-background">
					<label for="slider_description_font_size">Description Font Size
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Specify the font size for the image description</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" name="params[slider_description_font_size]" id="slider_description_font_size" value="<?php echo $param_values['slider_description_font_size']; ?>" class="text" />
					<span>px</span>
				</div>
				<div>
					<label for="slider_description_color">Description Text Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the color for the image description</p>
                                                </div>
                                            </div>
                                        </label>
					<input name="params[slider_description_color]" type="text" class="color" id="slider_description_color" value="#<?php echo $param_values['slider_description_color']; ?>" size="10" />
				</div>
				<div  class="has-background">
					<label for="slider_description_text_align">Description Text Align
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>choose where to place the description text</p>
                                                </div>
                                            </div>
                                        </label>
					<select id="slider_description_text_align" name="params[slider_description_text_align]">	
					  <option <?php if($param_values['slider_description_text_align'] == 'justify'){ echo 'selected'; } ?> value="justify">Full width</option>
					  <option <?php if($param_values['slider_description_text_align'] == 'center'){ echo 'selected'; } ?> value="center">Center</option>
					  <option <?php if($param_values['slider_description_text_align'] == 'left'){ echo 'selected'; } ?> value="left">Left</option>
					  <option <?php if($param_values['slider_description_text_align'] == 'right'){ echo 'selected'; } ?> value="right">Right</option>
					</select>
				</div>
				<div>
					<label for="description-background-transparency">Description Background Transparency
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the level of description background transparency</p>
                                                </div>
                                            </div>
                                        </label>
					<div class="slider-container">
						<input name="params[slider_description_background_transparency]" id="description-background-transparency" data-slider-highlight="true"  data-slider-values="0,10,20,30,40,50,60,70,80,90,100" type="text" data-slider="true" value="<?php echo $param_values['slider_description_background_transparency']; ?>" />
						<span><?php echo $param_values['slider_description_background_transparency']; ?>%</span>
					</div>
				</div>
				<div class="has-background">
					<label for="slider_description_background_color">Description Background Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Choose the color for description's background</p>
                                                </div>
                                            </div>
                                        </label>
						<input name="params[slider_description_background_color]" type="text" class="color" id="slider_description_background_color" value="#<?php echo $param_values['slider_description_background_color']; ?>" size="10">
				</div>
				<div>
					<label for="slider_description_border_size">Description Border Size
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Specify the border for the image description</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" name="params[slider_description_border_size]" id="slider_description_border_size" value="<?php echo $param_values['slider_description_border_size']; ?>" class="text" />
					<span>px</span>
				</div>
				<div class="has-background">
					<label for="slider_description_border_color">Description Border Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Select the border color for the image descriptio</p>
                                                </div>
                                            </div>
                                        </label>
					<input name="params[slider_description_border_color]" type="text" class="color" id="slider_description_border_color" value="#<?php echo $param_values['slider_description_border_color']; ?>" size="10">
				</div>
				<div>
					<label for="slider_description_border_radius">Description Border Radius
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the border radius for the image description cell</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" name="params[slider_description_border_radius]" id="slider_description_border_radius" value="<?php echo $param_values['slider_description_border_radius']; ?>" class="text" />
					<span>px</span>
				</div>
				<div class="has-height has-background">
					<label for="params[slider_description_position]">Description Position
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Select the positioning of the description. Please make sure it does not coincide with the title position avoiding overloading</p>
                                                </div>
                                            </div>
                                        </label>
						<div>
						<table class="bws_position_table">
							<tbody>
							  <tr>
								<td><input type="radio" value="left-top" id="slideshow_description_top-left" name="params[slider_description_position]" <?php if($param_values['slider_description_position'] == 'left-top'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="center-top" id="slideshow_description_top-center" name="params[slider_description_position]" <?php if($param_values['slider_description_position'] == 'center-top'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="right-top" id="slideshow_description_top-right" name="params[slider_description_position]"  <?php if($param_values['slider_description_position'] == 'right-top'){ echo 'checked="checked"'; } ?> /></td>
							  </tr>
							  <tr>
								<td><input type="radio" value="left-middle" id="slideshow_description_middle-left" name="params[slider_description_position]" <?php if($param_values['slider_description_position'] == 'left-middle'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="center-middle" id="slideshow_description_middle-center" name="params[slider_description_position]" <?php if($param_values['slider_description_position'] == 'center-middle'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="right-middle" id="slideshow_description_middle-right" name="params[slider_description_position]" <?php if($param_values['slider_description_position'] == 'right-middle'){ echo 'checked="checked"'; } ?> /></td>
							  </tr>
							  <tr>
								<td><input type="radio" value="left-bottom" id="slideshow_description_bottom-left" name="params[slider_description_position]" <?php if($param_values['slider_description_position'] == 'left-bottom'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="center-bottom" id="slideshow_description_bottom-center" name="params[slider_description_position]" <?php if($param_values['slider_description_position'] == 'center-bottom'){ echo 'checked="checked"'; } ?> /></td>
								<td><input type="radio" value="right-bottom" id="slideshow_description_bottom-right" name="params[slider_description_position]" <?php if($param_values['slider_description_position'] == 'right-bottom'){ echo 'checked="checked"'; } ?> /></td>
							  </tr>
							</tbody>	
						</table>
						</div>
				</div>
			</div>
			
			<div class="options-block" id="options-block-thumbnail">
				<h3>Navigation Thumbnails Styles</h3>
				<div class="has-background">
					<label for="slider_thumb_count_slides">Count of Thumbs Slides
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the count of slides in thumbnail slider</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" name="params[slider_thumb_count_slides]" id="slider_thumb_count_slides" value="<?php echo $param_values['slider_thumb_count_slides']; ?>" class="text" />
				</div>				
				<div >
					<label for="slider_thumb_height">Slider Thumb Height
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the thumbnail height</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" name="params[slider_thumb_height]" id="slider_thumb_height" value="<?php echo $param_values['slider_thumb_height']; ?>" class="text" />
					<span>px</span>
				</div>
				<div class="has-background">
					<label for="slider_thumb_back_color">Thumbnails Background Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Select the background color for the thumbnails</p>
                                                </div>
                                            </div>
                                        </label>
						<input name="params[slider_thumb_back_color]" type="text" class="color" id="slider_thumb_back_color" value="#<?php echo $param_values['slider_thumb_back_color']; ?>" size="10">
				</div>
				<div>
					<label for="slider_thumb_passive_color">Passive Thumbnail Overlay Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Select the background color for the thumbnails</p>
                                                </div>
                                            </div>
                                        </label>
						<input name="params[slider_thumb_passive_color]" type="text" class="color" id="slider_thumb_passive_color" value="#<?php echo $param_values['slider_thumb_passive_color']; ?>" size="10">
				</div>
				<div>
					<label for="slider_thumb_passive_color_trans">Passive Thumbnail Overlay Transparency
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Set the level of transparency for the title</p>
                                                </div>
                                            </div>
                                        </label>
					<div class="slider-container">
						<input name="params[slider_thumb_passive_color_trans]" id="slider_thumb_passive_color_trans" data-slider-highlight="true"  data-slider-values="0,10,20,30,40,50,60,70,80,90,100" type="text" data-slider="true" value="<?php echo $param_values['slider_thumb_passive_color_trans']; ?>" />
						<span><?php echo $param_values['slider_thumb_passive_color_trans']; ?>%</span>
					</div>
				</div>
				
				

			</div>
				<div class="options-block" id="options-block-navigation">
					<h3>Navigation Dots Styles</h3>
				
				<div class="has-background">
					<label for="slider_dots_position_new">Navigation Dots Position
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Choose the navigation dots position</p>
                                                </div>
                                            </div>
                                        </label>
					<select id="slider_dots_position_new" name="params[slider_dots_position_new]">
						  <option <?php if($param_values['slider_dots_position_new'] == 'dotstop'){ echo 'selected'; } ?> value="dotstop">Top</option>
						  <option <?php if($param_values['slider_dots_position_new'] == 'dotsbottom'){ echo 'selected'; } ?> value="dotsbottom">Bottom</option>
					</select>
				</div>
				<div >
					<label for="slider_dots_color">Navigation Dots Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Select the dot color for the navigation</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" class="color" name="params[slider_dots_color]" id="slider_dots_color" value="<?php echo $param_values['slider_dots_color']; ?>" class="text" />
				</div>
				<div class="has-background">
					<label for="slider_active_dot_color">Navigation Active Dot Color
                                            <div class="help">?
                                                <div class="help-block">
                                                    <span class="pnt"></span>
                                                    <p>Specify the color for the dot for the currently displayed image</p>
                                                </div>
                                            </div>
                                        </label>
					<input type="text" class="color" name="params[slider_active_dot_color]" id="slider_active_dot_color" value="<?php echo $param_values['slider_active_dot_color']; ?>" class="text" />
				</div>
				
				

			</div>
			
			<!-- /////////// -->
				<div class="options-block2" id="options-block-thumbnail"><!-- <div class="options-block" id="options-block-title"> -->
					<div>
						<div>
							<label for="slider_show_arrows">Show Navigation Arrows
		                                            <div class="help">?
		                                                <div class="help-block">
		                                                    <span class="pnt"></span>
		                                                    <p>Choose whether to show navigation arrows</p>
		                                                </div>
		                                            </div>
		                                        </label>
							<input type="hidden" value="off" name="params[slider_show_arrows]" />		
							<input type="checkbox" id="slider_show_arrows" <?php if($param_values['slider_show_arrows']  == 'on'){ echo 'checked="checked"'; } ?> name="params[slider_show_arrows]" value="on" />
						</div>
						<div class="has-height " style="padding-top:20px;">
							<label for="">Navigation Arrows Style
                                <div class="help">?
                                    <div class="help-block">
                                        <span class="pnt"></span>
                                        <p>Select the type of the navigation arrows to be used for the website</p>
                                    </div>
                                </div>
                            </label>
						</div>

					<ul id="arrows-type">
						<li <?php if($param_values['slider_navigation_type'] == 1){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.simple.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="1" <?php if($param_values['slider_navigation_type'] == 1){ echo 'checked="checked"'; } ?>>
						</li>
						<li <?php if($param_values['slider_navigation_type'] == 2){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.circle.shadow.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="2" <?php if($param_values['slider_navigation_type'] == 2){ echo 'checked="checked"'; } ?>>
						</li>
						<li <?php if($param_values['slider_navigation_type'] == 3){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.circle.simple.dark.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="3" <?php if($param_values['slider_navigation_type'] == 3){ echo 'checked="checked"'; } ?>>
						</li>
						
						<li <?php if($param_values['slider_navigation_type'] == 4){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.cube.dark.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="4" <?php if($param_values['slider_navigation_type'] == 4){ echo 'checked="checked"'; } ?>>
						</li>
						<li <?php if($param_values['slider_navigation_type'] == 5 ){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.light.blue.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="5" <?php if($param_values['slider_navigation_type'] == 5){ echo 'checked="checked"'; } ?>>
						</li>
						<li <?php if($param_values['slider_navigation_type'] == 6){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.light.cube.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="6" <?php if($param_values['slider_navigation_type'] == 6){ echo 'checked="checked"'; } ?>>
						</li>
						<li <?php if($param_values['slider_navigation_type'] == 7){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.light.transparent.circle.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="7" <?php if($param_values['slider_navigation_type'] == 7){ echo 'checked="checked"'; } ?>>
						</li>
						<li <?php if($param_values['slider_navigation_type'] == 8){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="8" <?php if($param_values['slider_navigation_type'] == 8){ echo 'checked="checked"'; } ?>>
						</li>
						<li <?php if($param_values['slider_navigation_type'] == 9){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.circle.blue.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="9" <?php if($param_values['slider_navigation_type'] == 9){ echo 'checked="checked"'; } ?>>
						</li>	
						<li <?php if($param_values['slider_navigation_type'] == 10){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.circle.green.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="10" <?php if($param_values['slider_navigation_type'] == 10){ echo 'checked="checked"'; } ?>>
						</li>
						<li <?php if($param_values['slider_navigation_type'] == 11){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.blue.retro.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="11" <?php if($param_values['slider_navigation_type'] == 11){ echo 'checked="checked"'; } ?>>
						</li>
						<li <?php if($param_values['slider_navigation_type'] == 12){ echo 'class="active"'; } ?>>
							<div class="image-block">
								<img src="<?php echo $path_site; ?>/arrows/arrows.green.retro.png" alt="" />
							</div>
							<input type="radio" name="params[slider_navigation_type]" value="12" <?php if($param_values['slider_navigation_type'] == 12){ echo 'checked="checked"'; } ?>>
						</li>	
						<li <?php if($param_values['slider_navigation_type'] == 13){ echo 'class="active"'; } ?>>
								<div class="image-block">
									<img src="<?php echo $path_site; ?>/arrows/arrows.red.circle.png" alt="" />
								</div>
								<input type="radio" name="params[slider_navigation_type]" value="13" <?php if($param_values['slider_navigation_type'] == 13){ echo 'checked="checked"'; } ?>>
						</li>	
						<li class="color" <?php if($param_values['slider_navigation_type'] == 14){ echo 'class="active"'; } ?>>
								<div class="image-block">
									<img src="<?php echo $path_site; ?>/arrows/arrows.triangle.white.png" alt="" />
								</div>
								<input type="radio" name="params[slider_navigation_type]" value="14" <?php if($param_values['slider_navigation_type'] == 14){ echo 'checked="checked"'; } ?>>
						</li>	
						<li <?php if($param_values['slider_navigation_type'] == 15){ echo 'class="active"'; } ?>>
								<div class="image-block">
									<img src="<?php echo $path_site; ?>/arrows/arrows.ancient.png" alt="" />
								</div>
								<input type="radio" name="params[slider_navigation_type]" value="15" <?php if($param_values['slider_navigation_type'] == 15){ echo 'checked="checked"'; } ?>>
						</li>
						<li <?php if($param_values['slider_navigation_type'] == 16){ echo 'class="active"'; } ?>>
								<div class="image-block">
									<img src="<?php echo $path_site; ?>/arrows/arrows.black.out.png" alt="" />
								</div>
								<input type="radio" name="params[slider_navigation_type]" value="16" <?php if($param_values['slider_navigation_type'] == 16){ echo 'checked="checked"'; } ?>>
						</li>							
					</ul>
					</div>
				</div>

			<div id="post-body-footer">
				
				<a onclick="document.getElementById('adminForm').submit()" class="save-slider-options button-primary">Save</a>
				<div class="clear"></div>
				<script>
						jQuery(document).ready(function ($) {
								
								jQuery("#slideup<?php echo isset($key)?$key:''; ?>").click(function () {
									window.parent.uploadID = jQuery(this).prev('input');
									formfield = jQuery('.upload').attr('name');
									tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
									return false;
								});
								window.send_to_editor = function (html) {
									imgurl = jQuery('img', html).attr('src');
									window.parent.uploadID.val(imgurl);
									tb_remove();
								};
							});
							
				</script>		
			</div>
			</form>
		</div>
	</div>
</div>
</div>
<input type="hidden" name="option" value=""/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="controller" value="options"/>
<input type="hidden" name="op_type" value="styles"/>
<input type="hidden" name="boxchecked" value="0"/>

<?php
}