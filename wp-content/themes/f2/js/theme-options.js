jQuery(document).ready(function() {
    jQuery('.image-upload-button').click(function() {
         targetfield = jQuery(this).prev('.image-url');
         tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
         return false;
    });
    window.send_to_editor = function(html) {
         imgurl = jQuery('img',html).attr('src');
         jQuery(targetfield).val(imgurl);
         tb_remove();
    }
});
