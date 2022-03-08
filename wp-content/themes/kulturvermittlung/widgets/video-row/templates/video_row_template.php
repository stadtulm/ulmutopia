<?php $template_dir = get_template_directory_uri(); ?>
<div class="video-gallery-row">
	<h2><?php echo $instance['title'];?></h2>
	<div class="carousel-container" data-slide-count="3">

		<div class="controls">
			<button class="prev" tabindex="0" title="<?php _e('Zurück','kulturvermittlung');?>"></button>
			<button class="next" tabindex="0" title="<?php _e('Vor','kulturvermittlung');?>"></button>
		</div>

		<div class="carousel video-gallery">
			<?php foreach($instance['a_videos'] AS $video) {?>
				<div class="item">
					<a target="_blank" href="<?php echo $video['videoURL'];?>" class="video-container" style="background-image: url('<?php echo Cortex_Kulturvermittlung_Utils::getVideoThumbnail($video['videoURL']);?>');">
						<div class="play-button"><img src="<?php echo $template_dir;?>/static/img/icons/play_button.svg" alt="<?php echo _e('Abspielen','teilhabekultur');?>"/></div>
						<?php if($video['title']) {?>
							<div class="video-title"><?php echo $video['title'];?></div>
						<?php } ?>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>