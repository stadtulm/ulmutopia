<a href="<?php echo get_the_permalink($offerId);?>" class="offer-tile">
	<div class="offer-tile-inner">
		<div class="offer-image" style="background-image: url(<?php echo get_field('bild', $offerId)['sizes']['medium'];?>);"></div>
		<div class="offer-content">
			<div class="offer-title"><?php echo get_the_title($offerId);?></div>
			<div class="offer-description"><?php echo wp_trim_words(get_field('beschreibung', $offerId), 15);?></div>
			<div class="offer-infos">
                <?php //Sector and age was added b/c filtering would look strange otherwise (was not in design)?>
                <div class="sector">
                    <div class="info"><img src="<?php echo $template_dir;?>/static/img/icons/info.svg" alt="<?php _e('Informationen anzeigen','teilhabekultur');?>" /></div>
					<?php
					$first = true;
					if(is_array(get_field('sparten', $offerId))){
						foreach(get_field('sparten', $offerId) as $sector) {
							if( ! $first){
								echo ', ';
							}
							echo Cortex_Kulturvermittlung_Config::$sectors[$sector];
							$first = false;
						}
					}
					?>
                </div>

                <div class="age"><img class="icon" src="<?php echo $template_dir;?>/static/img/icons/icon-alter.svg" alt="<?php _e('Geeignet für','teilhabekultur');?>" /><?php echo get_field('zielgruppe_von', $offerId);?> - <?php echo get_field('zielgruppe_bis', $offerId);?> <?php _e('Jahre', 'teilhabekultur');?></div>

				<div class="date"><img src="<?php echo $template_dir;?>/static/img/icons/calendar.svg" alt="<?php _e('Datum','teilhabekultur');?>" class="icon"/>
					<?php if(get_field('art_der_termine', $offerId) == 'nach_absprache') {?>
						<?php _e('Nach Absprache', 'teilhabekultur');?>
					<?php } else if(get_field('art_der_termine', $offerId) == 'freie_eingabe') {?>
						<?php echo get_field('freitext_termin', $offerId);?>
					<?php } else if(get_field('art_der_termine', $offerId) == 'fester_termin') {
						$festerTermin = get_field('fester_termin', $offerId);
						$festerTerminDate = date_create_from_format('Y-m-d H:i', $festerTermin);
						if($festerTerminDate) {
							echo $festerTerminDate->format('d.m.Y H:i');?> <?php _e('Uhr', 'teilhabekultur');?>
						<?php }
					} ?>
				</div>
			</div>
		</div>
	</div>
</a>