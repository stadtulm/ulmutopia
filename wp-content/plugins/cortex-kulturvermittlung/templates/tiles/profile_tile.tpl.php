<a href="<?php echo Cortex_Kulturvermittlung_Profiles::generateProfileLink($profileId);?>" class="profile-tile">
	<div class="profile-tile-inner">
		<div class="profile-image" style="background-image: url('<?php echo get_field('profilbild','user_' . $profileId)['sizes']['medium'];?>');">
			<div class="fav-heart"></div>
		</div>
		<div class="profile-infos">
			<div class="name"><?php echo get_field('name_institution_kuenstlerin', 'user_' . $profileId);?></div>
			<div class="sector">
				<div class="info"><img src="<?php echo $template_dir;?>/static/img/icons/info.svg" alt="<?php _e('Informationen anzeigen','teilhabekultur');?>" /></div>
				<?php
				$first = true;
				foreach(get_field('sparten','user_' . $profileId) as $sector) {
					if(!$first) {
						echo ', ';
					}
					echo Cortex_Kulturvermittlung_Config::$sectors[$sector];
					$first = false;
				}
				?>
			</div>
		</div>
	</div>
</a>