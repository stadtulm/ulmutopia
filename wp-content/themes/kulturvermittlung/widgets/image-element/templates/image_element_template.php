
<?php
if(!empty($instance['image'])) {
	$imageURLSmall = wp_get_attachment_image_src($instance['image'], 'small')[0];
	$imageURLMedium = wp_get_attachment_image_src($instance['image'], 'medium')[0];
	$imageURLLarge = wp_get_attachment_image_src($instance['image'], 'large')[0];
	$imageURLMax = wp_get_attachment_image_src($instance['image'], 'extra-large')[0];
	$imageLightboxURL = wp_get_attachment_image_src( $instance['image'], 'extra-large' )[0];
    $altTag = Cortex_Kulturvermittlung_Utils::getALTTag($instance['image']);

	if ($instance['with_lightbox']) {?>
		<a href="<?php echo $imageLightboxURL; ?>" data-rel="lightbox">
	<?php } ?>
	<picture>
		<source sizes="(max-width: 768px) 768px, (max-width: 1480px) 1480px, 100vw"
		        srcset="<?php echo $imageURLSmall;?> 400w,<?php echo $imageURLMedium;?> 1024w,<?php echo $imageURLLarge;?> 1680w,<?php echo $imageURLMax;?> 1920w ">
		<img src="<?php echo $imageURLMedium;?>" alt="<?php echo $altTag;?>">
	</picture>
	<?php if($instance['with_lightbox']) {?>
		</a>
	<?php }

	if(!empty($instance['caption'])) {?>
		<div class="image-caption"><?php echo $instance['caption'];?></div>
	<?php }
}
