<style>
#wsw-rating-box {
border:1px solid #B8B2B2;
border-radius: 15px;
margin:10px;
padding:10px;
<?php if($seo_show_rich_snippets != '1') echo 'display: none;';?>
}
</style>
<div id="wsw-rating-box">
    Structured Data, Review<br>
    <span class="item">Title: <span class="fn entry-title"><?php echo $seo_post_title; ?></span></span><br>
    Reviewed by <span class="reviewer"><?php echo $seo_review_author; ?></span><br>
    Rating: <span class="rating"><?php echo $seo_rating_value; ?></span><br>
    Summary: <span class="summary"><?php echo $seo_review_summary; ?></span><br>
    Description: <span class="description"><?php echo $seo_review_description; ?></span>
</div>