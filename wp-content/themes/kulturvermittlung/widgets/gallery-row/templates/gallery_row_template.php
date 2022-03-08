<div class="image-gallery-row">
	<h2><?php echo $instance['title'];?></h2>
	<div class="carousel-container" data-slide-count="3">

		<div class="controls">
            <button class="prev" tabindex="0" title="<?php _e('Zurück','kulturvermittlung');?>"></button>
            <button class="next" tabindex="0" title="<?php _e('Vor','kulturvermittlung');?>"></button>
		</div>


		<div class="carousel image-gallery">
			<?php foreach($instance['a_images'] AS $image) {
				$imageURLMedium = wp_get_attachment_image_src($image['image'], 'medium')[0];
				$imageURLLarge = wp_get_attachment_image_src($image['image'], 'large')[0];
				?>
				<a class="item" href="<?php echo $imageURLLarge;?>"><div class="image-outer-container"><div class="image-container" data-copyright="<?php echo $image['copyright'];?>" style="background-image: url('<?php echo $imageURLMedium;?>');"></div></div></a>
			<?php } ?>
		</div>
	</div>
</div>