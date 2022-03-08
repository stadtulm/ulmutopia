<?php if(!empty($instance['image'])){
    $imageURL = wp_get_attachment_image_src($instance['image'], 'full')[0];
} else if(!empty($instance['island'])) {
	$imageURL = get_template_directory_uri() . '/static/img/ulm_utopia_header_island.jpg';
} else {
	$imageURL = get_template_directory_uri() . '/static/img/ulm_utopia_header_small.jpg';
}

?>

<div class="hero-element <?php echo $instance['size'];?>" style="background-image: url('<?php echo $imageURL;?>');">
	<div class="grid-inner relative">
		<div class="text-container">
			<h1 class="<?php if($instance['blue_background']) {?>blue-background<?php } else {?>full-width<?php } ?> <?php if(empty($instance['introduction'])) {?>no-text<?php }?>"><?php echo $instance['heading_normal'];?> <strong><?php echo $instance['heading_strong'];?></strong></h1>
			<?php if(!empty($instance['introduction'])) {?>
                <div class="intro-text">
                    <?php echo wpautop($instance['introduction']);?>
                </div>
            <?php } ?>
		</div>

		<?php if(!empty($instance['island'])) {?>
            <?php
                $islands = ['insel01' => 'Insel 1',
						'insel02' => 'Insel 2',
						'insel03' => 'Insel 3',
						'insel04' => 'Insel 4',
						'insel05' => 'Insel 5',
						'insel06' => 'Insel 6',
						'insel07' => 'Insel 7',
						'insel08' => 'Insel 8'];

                $randomIsland = array_rand($islands);
            ?>
            <div class="island-overlay"><img src="<?php echo get_template_directory_uri() . '/static/img/islands/' . $randomIsland .'.png';?>" alt=""/></div>
		<?php } ?>
	</div>
</div>