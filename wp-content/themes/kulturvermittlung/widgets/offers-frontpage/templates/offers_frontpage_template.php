<?php $template_dir = get_template_directory_uri(); ?>
<div class="offer-row">
	<h2 class="margin-bottom-half"><?php _e('Angebote','teilhabekultur');?></h2>



<?php
    $offers = Cortex_Kulturvermittlung_Offers::getFilteredOffers(array(),array(), 0, 100, '', 5);
	if(sizeof($offers) > 0) {?>
		<div class="carousel-container" data-slide-count="2">
			<div class="controls">
                <button class="prev" tabindex="0" title="<?php _e('Zurück','kulturvermittlung');?>"></button>
                <button class="next" tabindex="0" title="<?php _e('Vor','kulturvermittlung');?>"></button>
			</div>

			<div class="carousel offers">
				<?php
                    foreach($offers as $offer) {
                        $offerId = $offer->ID;
                        include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/tiles/offer_tile.tpl.php');
                    }
				?>
			</div>
		</div>
<?php } else { ?>
    <?php _e('Im Moment werden von unseren Kulturschaffenden keine Angebote angeboten.', 'teilhabekultur');?>
<?php } ?>
    <div class="show-all"><a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('offer_overview'));?>"><?php _e('Alle Angebote anzeigen', 'teilhabekultur');?></a></div>
</div>

