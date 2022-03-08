<div class="tip-tile" style="<?php if($hidden){?>display: none;<?php } ?>">
	<div class="tip-tile-inner">
		<a class="tip-title" href="<?php echo get_field('link', $tipId);?>" target="_blank"><?php echo get_the_title($tipId);?></a>
		<a href="<?php echo get_field('link', $tipId);?>" target="_blank" class="link"><?php echo get_field('link', $tipId);?></a>

        <?php if(strlen(get_field('beschreibung',  $tipId)) > 150) {?>
            <div class="tip-description">
                <?php echo get_field('beschreibung',  $tipId);?>
                <div class="tip-description-fade"></div>
            </div>
            <a class="read-more" href="#"><?php _e('mehr anzeigen', 'teilhabekultur');?></a>
        <?php } else { ?>
            <div class="tip-description">
                <?php echo get_field('beschreibung',  $tipId);?>
            </div>
        <?php } ?>
	</div>
</div>