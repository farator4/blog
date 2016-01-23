<style>
    .wsw-icon-suggestion-fail-type {
        background: url('<?php echo $wsw_icon_success; ?>') no-repeat top left;
        background-position: 0 -450px;
        width: 16px;
        height: 16px;
        position: absolute;

    }

    .wsw-icon-suggestion-success-type {
        background: url('<?php echo $wsw_icon_success; ?>') no-repeat top left;
        background-position: 0 -516px;
        width: 16px;
        height: 16px;
        position: absolute;

    }
</style>
<div class="wsw-suggestions-content-view">

    <?php for ($item = 0; $item < count($wsw_suggestion_content); $item++) { ?>

        <div class="wsw-suggestion_content-container">

            <?php if($wsw_suggestion_content[$item]['state'] == 'yes') {?>
                <span class="wsw-icon-suggestion-success-type"></span>
            <?php } else{?>
                <span class="wsw-icon-suggestion-fail-type"></span>
            <?php }?>

            <p style="padding-left: 20px;"><?php echo $wsw_suggestion_content[$item]['msg'];?></p>

        </div>

    <?php } ?>

</div>