
// Save settings for Global.
function save_global_settings()
{

    var mRadio = jQuery('input[name=opt_keyword_decorate_bold_type]');
    var opt_keyword_decorate_bold_type = mRadio.filter(':checked').val();

    mRadio = jQuery('input[name=opt_keyword_decorate_italic_type]');
    var opt_keyword_decorate_italic_type = mRadio.filter(':checked').val();

    mRadio = jQuery('input[name=opt_keyword_decorate_underline_type]');
    var opt_keyword_decorate_underline_type = mRadio.filter(':checked').val();

    mRadio = jQuery('input[name=opt_image_alternate_type]');
    var opt_image_alternate_type = mRadio.filter(':checked').val();

    mRadio = jQuery('input[name=opt_image_title_type]');
    var opt_image_title_type = mRadio.filter(':checked').val();

    var data = {
        action:'wsw_save_global_settings',
        security:jQuery('#wsw-global-ajax-nonce').val(),
        chk_keyword_to_titles  : (jQuery('#chk_keyword_to_titles').attr('checked')) ? '1' : '0',

        chk_nofollow_in_external  : (jQuery('#chk_nofollow_in_external').attr('checked')) ? '1' : '0',
        chk_nofollow_in_image  : (jQuery('#chk_nofollow_in_image').attr('checked')) ? '1' : '0',
        chk_use_facebook  : (jQuery('#chk_use_facebook').attr('checked')) ? '1' : '0',
        chk_use_twitter  : (jQuery('#chk_use_twitter').attr('checked')) ? '1' : '0',
        chk_use_richsnippets  : (jQuery('#chk_use_richsnippets').attr('checked')) ? '1' : '0',
        chk_author_linking  : (jQuery('#chk_author_linking').attr('checked')) ? '1' : '0',


        chk_keyword_decorate_bold  : (jQuery('#chk_keyword_decorate_bold').attr('checked')) ? '1' : '0',
        chk_keyword_decorate_italic  : (jQuery('#chk_keyword_decorate_italic').attr('checked')) ? '1' : '0',
        chk_keyword_decorate_underline  : (jQuery('#chk_keyword_decorate_underline').attr('checked')) ? '1' : '0',


        opt_keyword_decorate_bold_type : opt_keyword_decorate_bold_type,
        opt_keyword_decorate_italic_type : opt_keyword_decorate_italic_type,
        opt_keyword_decorate_underline_type : opt_keyword_decorate_underline_type,

        txt_image_alternate  : jQuery('#txt_image_alternate').val(),
        txt_image_title  : jQuery('#txt_image_title').val(),
        opt_image_alternate_type    :opt_image_alternate_type,
        opt_image_title_type    :opt_image_title_type,

        chk_tagging_using_google  : (jQuery('#chk_tagging_using_google').attr('checked')) ? '1' : '0',
        txt_generic_tags  : jQuery('#txt_generic_tags').val(),

        chk_block_login_page  : (jQuery('#chk_block_login_page').attr('checked')) ? '1' : '0',
        chk_block_admin_page  : (jQuery('#chk_block_admin_page').attr('checked')) ? '1' : '0',
        lsi_bing_api_key  : jQuery('#lsi_bing_api_key').val(),

        chk_tweak_permalink  : (jQuery('#chk_tweak_permalink').attr('checked')) ? '1' : '0',
        chk_use_meta_robot  : (jQuery('#chk_use_meta_robot').attr('checked')) ? '1' : '0',
        chk_make_sitemap  : (jQuery('#chk_make_sitemap').attr('checked')) ? '1' : '0'

    };

    jQuery.post(ajax_object.ajax_url, data, function(respond) {

        jQuery("#wsw-notice-save-view").show();
    });

    if(jQuery('#chk_author_linking').attr('checked')){

        var dataLink = {
            action  : 'wsw_set_support_link'
        };

        jQuery.post(ajax_object.ajax_url, dataLink, function(respond) {
            jQuery("#wsw_support_title_1").hide();
            jQuery("#wsw_support_title_2").show();
            jQuery("#wsw_support_title_3").hide();
        });
    }

}

// Save settings for Post.
function save_post_settings()
{
    var post_id = jQuery('#seowizard-post-id').text();

    var keywordRadio = jQuery('input[name=wsw_keyword_type]');
    var checkedKeywordValue = keywordRadio.filter(':checked').val();
    var data = {
        action:'wsw_save_post_settings',
        security: jQuery('#wsw-metabox-ajax-nonce').val(),
        post_id: post_id,
        keyword_value  : jQuery('#wsw_keyword_value').val(),
        is_meta_keyword  : (jQuery('#wsw_is_meta_keyword').attr('checked')) ? '1' : '',
        meta_keyword_type: checkedKeywordValue,
        is_meta_title  : (jQuery('#wsw_is_meta_title').attr('checked')) ? '1' : '',
        meta_title:jQuery('#wsw_meta_title').attr('value'),
        is_meta_description  : (jQuery('#wsw_is_meta_description').attr('checked')) ? '1' : '',
        is_meta_robot_noindex  : (jQuery('#wsw_is_meta_robot_noindex').attr('checked')) ? '1' : '',
        is_meta_robot_nofollow  : (jQuery('#wsw_is_meta_robot_nofollow').attr('checked')) ? '1' : '',

        is_meta_robot_noodp  : (jQuery('#wsw_is_meta_robot_noodp').attr('checked')) ? '1' : '',
        is_meta_robot_noydir  : (jQuery('#wsw_is_meta_robot_noydir').attr('checked')) ? '1' : '',

        meta_description:jQuery('#wsw_meta_description').attr('value'),
        is_over_sentences  : (jQuery('#wsw_is_over_sentences').attr('checked')) ? '1' : '',
        first_over_sentences  : (jQuery('#wsw_first_over_sentences').attr('checked')) ? '1' : '',
        last_over_sentences  : (jQuery('#wsw_last_over_sentences').attr('checked')) ? '1' : '',

        is_rich_snippets  : (jQuery('#wsw_is_rich_snippets').attr('checked')) ? '1' : '',
        show_rich_snippets  : (jQuery('#wsw_show_rich_snippets').attr('checked')) ? '1' : '',

        rating_value  : jQuery('#wsw_review_rating option:selected').text(),
        review_author:jQuery('#wsw_review_author').val(),
        review_summary:jQuery('#wsw_review_summary').val(),
        review_description:jQuery('#wsw_review_description').val(),

        event_name:jQuery('#wsw_event_name').val(),
        event_date:jQuery('#wsw_event_date').val(),
        event_url:jQuery('#wsw_event_url').val(),
        event_location_name:jQuery('#wsw_event_location_name').val(),
        event_location_street:jQuery('#wsw_event_location_street').val(),
        event_location_locality:jQuery('#wsw_event_location_locality').val(),
        event_location_region:jQuery('#wsw_event_location_region').val(),

        people_fname:jQuery('#wsw_people_fname').val(),
        people_lname:jQuery('#wsw_people_lname').val(),
        people_locality:jQuery('#wsw_people_locality').val(),
        people_region:jQuery('#wsw_people_region').val(),
        people_title:jQuery('#wsw_people_title').val(),
        people_homeurl:jQuery('#wsw_people_homeurl').val() ,
        people_photourl:jQuery('#wsw_people_photourl').val(),

        product_name:jQuery('#wsw_product_name').val(),
        product_imageurl:jQuery('#wsw_product_imageurl').val(),
        product_description:jQuery('#wsw_product_description').val() ,
        product_offers:jQuery('#wsw_product_offers').val(),

        is_social_facebook  : (jQuery('#wsw_is_social_facebook').attr('checked')) ? '1' : '',
        social_facebook_publisher:jQuery('#wsw_social_facebook_publisher').val(),
        social_facebook_author:jQuery('#wsw_social_facebook_author').val(),
        social_facebook_title:jQuery('#wsw_social_facebook_title').val(),
        social_facebook_description:jQuery('#wsw_social_facebook_description').val(),

        is_social_twitter  : (jQuery('#wsw_is_social_twitter').attr('checked')) ? '1' : '',
        social_twitter_title:jQuery('#wsw_social_twitter_title').val(),
        social_twitter_description:jQuery('#wsw_social_twitter_description').val(),
        is_disable_autolink:(jQuery('#wsw_disable_autolinks').attr('checked'))?'1':'',
        autolink_anchor:jQuery('#wsw_autolinks').val()

    };

    jQuery.post(ajax_object.ajax_url, data, function(respond) {

        jQuery("#wsw-notice-save-view").show();
        alert('Save Settings Successfully.!');

    });

}

// Show the score for the Page.
function show_page_score()
{
    var post_id = jQuery('#seowizard-post-id').text();

    var score_data = {
        action:'wsw_calc_post_score',
        post_id: post_id
    };

    jQuery.post(ajax_object.ajax_url, score_data, function(respond) {
        var previewBody = document.getElementById('wsw-score-value-box');
        previewBody.innerHTML = respond;
    });


    var density_data = {
        action:'wsw_calc_post_density',
        post_id: post_id
    };

    jQuery.post(ajax_object.ajax_url, density_data, function(respond) {
        var previewBody = document.getElementById('wsw-density-value-box');
        previewBody.innerHTML = respond;
    });


    var suggestion_keyword_data = {
        action:'wsw_get_keyword_suggestion',
        post_id: post_id
    };

    jQuery.post(ajax_object.ajax_url, suggestion_keyword_data, function(respond) {
        var previewBody = document.getElementById('wsw-suggestions-keyword-view');
        previewBody.innerHTML = respond;
        jQuery("#wsw_page_analysis_loading").hide();
        jQuery("#wsw_page_analysis_view").show();
    });

    var suggestion_url_data = {
        action:'wsw_get_url_suggestion',
        post_id: post_id
    };

    jQuery.post(ajax_object.ajax_url, suggestion_url_data, function(respond) {
        var previewBody = document.getElementById('wsw-suggestions-url-view');
        previewBody.innerHTML = respond;
    });

    var suggestion_content_data = {
        action:'wsw_get_content_suggestion',
        post_id: post_id
    };

    jQuery.post(ajax_object.ajax_url, suggestion_content_data, function(respond) {
        var previewBody = document.getElementById('wsw-suggestions-content-view');
        previewBody.innerHTML = respond;
    });

}

// Show the LSI for the Page.
function show_page_lsi()
{

    jQuery("#wsw_lsi_view_loading").show();
    jQuery("#wsw-lsi-view").hide();

    var post_id = jQuery('#seowizard-post-id').text();

    var lsi_data = {
        action:'wsw_get_lsi',
        post_id: post_id
    };

    jQuery.post(ajax_object.ajax_url, lsi_data, function(respond) {
        var previewBody = document.getElementById('wsw-lsi-view');
        previewBody.innerHTML = respond;
        jQuery("#wsw_lsi_view_loading").hide();
        jQuery("#wsw-lsi-view").show();

    });

}

// show message

function showMessage(message)
{
   // jQuery('#wsw_dialog_message').text(message);
    jQuery("#wsw_dialog").show();
   // jQuery('#dialog').dialog();
}
// Show the content for the Page.
function show_page_content()
{
    jQuery("#wsw_dialog").hide();
    jQuery("#wsw_youtube_view_loading").show();
    jQuery("#wsw-youtube-view").hide();
    var post_id = jQuery('#seowizard-post-id').text();
    var keyword = jQuery('#wsw_keyword_value').val();

    if(keyword ==''){
        jQuery("#wsw_youtube_view_loading").hide();
        jQuery("#wsw-youtube-view").show();
        return;
    }

    var youtube_data = {
        action:'wsw_get_youtube',
        post_id: post_id
    };

    jQuery.post(ajax_object.ajax_url, youtube_data, function(respond) {
        var previewBody = document.getElementById('wsw-youtube-view');
       // previewBody.innerHTML = respond;
        jQuery("#wsw_youtube_view_loading").hide();
        jQuery("#wsw-youtube-view").show();

        var obj = jQuery.parseJSON( respond );

        var youtubeList = obj['videos']['list'][keyword]['list'];
        for( i=0; i<8; i++){


            jQuery('#wsw_clipbord_' + i).attr('src', youtubeList[i]['thumbnail']);
            jQuery('#wsw_clipbord_' + i).attr('data-clipboard-text', youtubeList[i]['url']);
            jQuery('#wsw_videos_item_duration_' + i).text( youtubeList[i]['duration']);

            jQuery('#wsw_videos_item_title_' + i).attr('href', youtubeList[i]['url']);
            jQuery('#wsw_videos_item_title_' + i).attr('title', youtubeList[i]['title']);
            jQuery('#wsw_videos_item_title_' + i).text( youtubeList[i]['title']);

            jQuery('#wsw_videos_item_author_' + i).text( 'by ' + youtubeList[i]['author']);
            jQuery('#wsw_videos_item_views_' + i).text( youtubeList[i]['views'] + ' views');

        }

        var client_0 = new ZeroClipboard( document.getElementById("wsw_clipbord_0") );
        client_0.on( "ready", function( readyEvent ) {

            client_0.on( "aftercopy", function( event ) {
                showMessage(event.data["text/plain"]);

            } );
        } );

        var client_1 = new ZeroClipboard( document.getElementById("wsw_clipbord_1") );
        client_1.on( "ready", function( readyEvent ) {
            client_1.on( "aftercopy", function( event ) {
                showMessage(event.data["text/plain"]);
            } );
        } );

        var client_2 = new ZeroClipboard( document.getElementById("wsw_clipbord_2") );
        client_2.on( "ready", function( readyEvent ) {
            client_2.on( "aftercopy", function( event ) {
                showMessage(event.data["text/plain"]);
            } );
        } );

        var client_3 = new ZeroClipboard( document.getElementById("wsw_clipbord_3") );
        client_3.on( "ready", function( readyEvent ) {
            client_3.on( "aftercopy", function( event ) {
                showMessage(event.data["text/plain"]);
            } );
        } );

        var client_4 = new ZeroClipboard( document.getElementById("wsw_clipbord_4") );
        client_4.on( "ready", function( readyEvent ) {
            client_4.on( "aftercopy", function( event ) {
                showMessage(event.data["text/plain"]);
            } );
        } );

        var client_5 = new ZeroClipboard( document.getElementById("wsw_clipbord_5") );
        client_5.on( "ready", function( readyEvent ) {
            client_5.on( "aftercopy", function( event ) {
                showMessage(event.data["text/plain"]);
            } );
        } );

        var client_6 = new ZeroClipboard( document.getElementById("wsw_clipbord_6") );
        client_6.on( "ready", function( readyEvent ) {
            client_6.on( "aftercopy", function( event ) {
                showMessage(event.data["text/plain"]);
            } );
        } );

        var client_7 = new ZeroClipboard( document.getElementById("wsw_clipbord_7") );
        client_7.on( "ready", function( readyEvent ) {
            client_7.on( "aftercopy", function( event ) {
                showMessage(event.data["text/plain"]);
            } );
        } );

       

    });



}
