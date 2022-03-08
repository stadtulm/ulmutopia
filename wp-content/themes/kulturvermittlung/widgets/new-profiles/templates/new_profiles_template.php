<?php $template_dir = get_template_directory_uri(); ?>
<div class="grid-inner">
	<h3 class="margin-bottom-half"><?php _e('Neue Profile entdecken','teilhabekultur');?></h3>
	<div class="profile-row">
		<?php
		$profiles = Cortex_Kulturvermittlung_Profiles::getFilteredProfiles(array($userId), array(), '', 5);
		if(!empty($profiles)) {
			?>
			<div class="carousel-container" data-slide-count="3">
				<div class="controls">
                    <button class="prev" tabindex="0" title="<?php _e('Zurück','kulturvermittlung');?>"></button>
                    <button class="next" tabindex="0" title="<?php _e('Vor','kulturvermittlung');?>"></button>
				</div>

				<div class="carousel profiles">
					<?php foreach($profiles AS $profile) {
                        $profileId = $profile->ID;
                        include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/tiles/profile_tile.tpl.php');
					} ?>
				</div>
			</div>
		<?php } ?>

        <div class="show-all"><a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('profile_overview'));?>"><?php _e('Alle Profile anzeigen', 'teilhabekultur');?></a></div>
	</div>
</div>

