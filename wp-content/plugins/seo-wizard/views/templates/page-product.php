<style>
    #wsw-product-box {
        border:1px solid #B8B2B2;
        border-radius: 15px;
        margin:10px;
        padding:10px;
    }
</style>

<div id="wsw-product-box" class="rich-rating" style="<?php echo ($seo_show_rich_snippets != '1' ? 'display: none;' :'');?>">
    Structured Data, Product<br>
    <span class="item">Name: <span class="fn entry-title"><?php echo $seo_product_name; ?></span></span><br>
    Description: <span class="location"><?php echo $seo_product_description; ?></span><br>
    Price: <span class="region"><?php echo $seo_product_price; ?></span><br>
</div>