<?php $template_dir = get_template_directory_uri(); ?>
<?php
    $categories = array();
    $searchString = '';

    if(!empty($_GET['category'])){
        $categories = array(sanitize_text_field($_GET['category']));
    }

    if(!empty($_GET['search'])) {
        $searchString = $_GET['search'];
        $heading = translate('Suchergebnisse für', 'teilhabekultur') . ' <strong>' . sanitize_text_field($_GET['search']) . '</strong>';
    } else {
        $heading = $instance['heading'];
    }

    $profiles = Cortex_Kulturvermittlung_Profiles::getFilteredProfiles(array(), $categories, $searchString);
?>
<?php if(!empty($heading)) {?>
    <h1><?php echo $heading;?></h1>
<?php } ?>

<?php if(!empty($instance['text'])) {
    echo $instance['text'];
}?>

<div class="filters" id="profile-filters">
    <div class="filter-heading"><?php _e('Filtern', 'teilhabekultur');?></div>
    <div id="categories">
		<?php foreach(Cortex_Kulturvermittlung_Config::$sectors AS $key => $sector) {?>
            <button class="clickable-label <?php echo $key;?>  <?php if(!empty($_GET['category']) && $_GET['category'] == $key) {?>active<?php } ?>">
                <input id="<?php echo $key;?>" type="checkbox" value="<?php echo $key;?>" name="sparten[]" <?php if(!empty($_GET['category']) && $_GET['category'] == $key) {?>checked<?php }?>/>
                <?php echo $sector;?>
            </button>
		<?php } ?>
    </div>

    <div id="profile-loader" class="lds-loader"><div></div><div></div><div></div></div>
</div>

<div class="profile-overview">
	<?php if(!empty($profiles)) {?>
		<?php foreach($profiles AS $profile) {
			$profileId = $profile->ID;
            include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/tiles/profile_tile.tpl.php');
		} ?>
	<?php } else { ?>
        <div class="no-results">
	        <?php _e('Für diese Anfrage wurden leider keine passenden Profile gefunden.', 'teilhabekultur');?>
        </div>
    <?php } ?>
</div>

<?php if(!empty($_GET['withOffers'])) {?>
    <h2><?php _e('Angebote', 'teilhabekltur');?></h2>
    <div class="offer-overview">
        <?php
        $offers = Cortex_Kulturvermittlung_Offers::getFilteredOffers(array(), $categories, 0, 100, $searchString);
        if(!empty($offers)) {?>
                <?php
                    foreach($offers AS $offer) {
                        $offerId = $offer->ID;
                        include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/tiles/offer_tile.tpl.php');
                    }
                ?>
            </div>
        <?php } else { ?>
            <div class="no-results">
	            <?php _e('Für diese Anfrage wurden leider keine passenden Angebote gefunden.', 'teilhabekultur'); ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>