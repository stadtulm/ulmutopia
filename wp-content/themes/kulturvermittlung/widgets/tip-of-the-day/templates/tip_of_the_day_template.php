<?php
    //Caution: This only works if the user selects posts in the backend (offers or tips)
	$url = sow_esc_url($instance['target']);
    if(preg_match('/^post: *([0-9]+)/', $instance['target'], $matches)) {
        $title = get_the_title(intval($matches[1]));
    }
?>
<h3 class="tip-of-the-day-heading"><?php _e('Tipp des Tages','kulturvermittlung');?></h3>
<div class="tip-of-the-day">
	<div class="inner">
        <div class="pre-text"><?php echo $instance['heading'];?></div>
		<div class="title"><?php echo $title;?></div>
		<a href="<?php echo $url;?>" <?php if($instance['external']) {?>target="_blank"<?php }?>><?php echo $instance['caption'];?></a>
	</div>
</div>