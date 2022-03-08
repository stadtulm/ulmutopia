<div class="category-overview">
    <form id="category-search-form" action="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('profile_overview'));?>" method="GET">
        <div class="input-container">
            <label for="category-search-input"><?php _e('Suchst du etwas Bestimmtes?', 'teilhabekultur');?></label>
            <input type="hidden" name="withOffers" value="1"/>
            <input name="search" type="text" id="category-search-input">
            <div class="icon"><img src="<?php echo get_template_directory_uri();?>/static/img/search_icon.svg" alt=""/></div>
        </div>
    </form>

	<div class="categories">
		<?php foreach(Cortex_Kulturvermittlung_Config::$sectors AS $key => $sector) { ?>
			<a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('profile_overview'));?>?category=<?php echo $key;?>&withOffers=1" class="category-tile <?php echo $key;?>">
				<div class="category-image  <?php echo $key;?>"></div>
				<div class="category-name"><?php echo $sector;?></div>
			</a>
		<?php } ?>
	</div>
</div>