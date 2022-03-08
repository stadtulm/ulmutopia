<h1><?php echo $instance['heading'];?></h1>

<?php if(!empty($instance['text'])) {
	echo $instance['text'];
}?>

<div class="filters" id="offer-filters">
    <div class="filter-heading"><?php _e('Filtern', 'teilhabekultur');?></div>
    <div id="categories">
		<?php foreach(Cortex_Kulturvermittlung_Config::$sectors AS $key => $sector) {?>
            <button class="clickable-label <?php echo $key;?>  <?php if(!empty($_GET['category']) && $_GET['category'] == $key) {?>active<?php } ?>">
                <input id="<?php echo $key;?>" type="checkbox" value="<?php echo $key;?>" name="sparten[]" <?php if(!empty($_GET['category']) && $_GET['category'] == $key) {?>checked<?php }?>/>
                <?php echo $sector;?>
            </button>
		<?php } ?>
    </div>

    <strong><?php _e('geeignet für:', 'teilhabekultur');?></strong> <strong id="min-age-label"><?php _e('alle');?></strong>
    <div class="age-slider-container slider-container">
        <div id="age-slider" role="slider"></div>
    </div>

    <div id="offer-loader" class="lds-loader"><div></div><div></div><div></div></div>
</div>

<?php
    $template_dir = get_template_directory_uri();
    $offers = Cortex_Kulturvermittlung_Offers::getFilteredOffers(array(), array(), 0, 100, '', NULL, true);
?>
<div class="offer-overview">
    <?php
        if(sizeof($offers) > 0) {
            foreach($offers as $offer) {
	            $offerId = $offer->ID;
	            include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/tiles/offer_tile.tpl.php');
            }
        } else { ?>
            <div class="no-results">
                <?php _e('Im Moment werden von unseren Kulturschaffenden keine Angebote angeboten.', 'teilhabekultur'); ?>
            </div>
    <?php } ?>
</div>