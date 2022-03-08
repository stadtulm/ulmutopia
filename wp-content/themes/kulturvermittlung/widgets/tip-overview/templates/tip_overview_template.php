<?php $template_dir = get_template_directory_uri(); ?>
<?php if($_GET['message'] == 'success' || $_GET['message'] == 'created') {?>
    <div class="message-box success" role="alert"><img class="success-icon" src="<?php echo $template_dir;?>/static/img/icons/icon-ja.svg" alt="<?php _e('Erfolgeich','teilhabekultur');?>"/>
        <?php if($_GET['message'] == 'success') {
            _e('Speichern erfolgreich', 'teilhabekultur');
        } else {
            _e('Dein Tipp wurde erfolgreich eingereicht und erscheint, sobald er von einem Administrator freigegeben wurde.', 'teilhabekultur');
        } ?>
    </div>
<?php } ?>


<a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('edit_tip'));?>" class="enter-tipp enter-new margin-bottom">
    <img class="new-icon" src="<?php echo $template_dir;?>/static/img/icons/edit_icon.svg" alt="<?php _e('Neuen Tipp einreichen', 'teilhabekultur');?>"/><?php _e('Neuen Tipp einreichen', 'teilhabekultur');?>
</a>

<?php
foreach(Cortex_Kulturvermittlung_Config::$tipSectors AS $key => $sector) {
    $tips = Cortex_Kulturvermittlung_Tips::getTippsForCategory($key);
    if(sizeof($tips) > 0){ ?>
        <div class="tip-sector">
            <h3><?php echo $sector;?></h3>

            <div class="tip-overview">
                <?php
                $i = 0;
                $hidden = false;
                foreach($tips as $tip) {
                    $tipId = $tip->ID;
                    if($i > 1) {
                        $hidden = true;
                    }
                    include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/tiles/tip_tile.tpl.php');
                    $i++;
                }?>

                <?php if($hidden) {?>
                    <a href="#" class="show-more-tips"><?php _e('Mehr anzeigen', 'teilhabekultur');?></a>
                <?php } ?>
            </div>
        </div>
    <?php }
} ?>
