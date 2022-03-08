<?php
    $url = sow_esc_url($instance['target']);
?>

<div class="button-element-container">
	<a class="button-link" href="<?php echo $url;?>" <?php if($instance['external']) {?>target="_blank"<?php }?>><?php echo $instance['caption'];?></a>
</div>
