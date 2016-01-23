<style>
    #wsw-event-box {
        border:1px solid #B8B2B2;
        border-radius: 15px;
        margin:10px;
        padding:10px;
    }
</style>

<div id="wsw-event-box" class="rich-rating" style="<?php echo ($seo_show_rich_snippets != '1' ? 'display: none;' :'');?>">
    Structured Data, Event<br>
    <span class="item">Name: <span class="fn entry-title"><a href="<?php echo $seo_event_url; ?>"><?php echo $seo_event_name; ?></a></span></span><br>
    Date and Time: <span class="date"><?php echo $seo_event_date; ?></span><br>
    Location: <span class="location"><?php echo $seo_event_location; ?></span><br>
    Street: <span class="street"><?php echo $seo_event_street; ?></span><br>
    Locality: <span class="locality"><?php echo $seo_event_locality; ?></span>
    Region: <span class="region"><?php echo $seo_event_region; ?></span>

</div>