<?php $template_dir = get_template_directory_uri(); ?>

<div class="infobox <?php echo $instance['type'];?>">
	<h3 class="<?php echo $instance['icon'];?>">
		<?php if($instance['icon'] == 'bell') {?>
			<img src="<?php
			echo $template_dir . '/static/img/icons/';
			if($instance['type'] == 'blue_fill') {
				echo 'bell_white.svg';
			} else{
				echo 'bell.svg';
			}?>" class="icon" alt="<?php _e('Achtung', 'kulturvermittlung');?>"/><?php }?><?php echo $instance['heading'];?>
	</h3>

	<?php echo wpautop($instance['text']);?>
</div>