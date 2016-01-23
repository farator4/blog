<div class="wsw-content-lsi-view">
    <ul>
        <?php for ($item = 0; $item < count($wsw_lsi_list); $item++) { ?>
            <li class="wsw-lsi-item">
                <div class="wsw-lsi-item-container">
                    <div class="wsw-lsi-item-title"><a href="<?php echo $wsw_lsi_list[$item]['BingUrl'];?>" target="_blank"><?php echo $wsw_lsi_list[$item]['lsi'];?></a></div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>