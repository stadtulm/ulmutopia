<div class="text-element <?php echo $instance['text_alignment'];?> <?php if($instance['col_count'] == '2') { echo "two-cols"; } ?>">
	<?php
		$instance['text'] = $GLOBALS['wp_embed']->run_shortcode( $instance['text'] );
		$instance['text'] = $GLOBALS['wp_embed']->autoembed( $instance['text'] );
		echo wpautop($instance['text']);
	?>
</div>