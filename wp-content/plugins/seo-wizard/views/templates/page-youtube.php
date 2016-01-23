




<div class="wsw-content-video-view">
   <?php
   $video_list = $wsw_youtube_list['videos']['list'][$wsw_youtube_keyword]['list'];
   ?>
       <?php if(count($video_list)) {
            for ($item = 0; $item < count($video_list); $item++) {?>
                <div id="wsw-videos-item-thumbnail-container" style= "float:left; width: 170px;height: 300px">
                    <img id="wsw_clipbord_<?php echo($item);?>" width="150" src="<?php echo $video_list[$item]['thumbnail'];?>" />
                    <input type="hidden" id="wsw_youtube_url_<?php echo($item);?>" value="<?php echo $video_list[$item]['url'];?>" />
                    <div class="wsw-videos-item-duration"><?php echo $video_list[$item]['duration'];?></div>
                    <div class="wsw-videos-item-title" style="margin-right: 10px"><a href="<?php echo $video_list[$item]['url'];?>" target="_blank" title="<?php echo $video_list[$item]['title'];?>"><?php echo $video_list[$item]['title'];?></a></div>
                    <div class="wsw-videos-item-author">by <?php echo $video_list[$item]['author'];?></div>
                    <div class="wsw-videos-item-views"><?php echo $video_list[$item]['views'];?> views</div>
                </div>
       <?php
            }
        }
        else {
        }
        ?>
</div>
