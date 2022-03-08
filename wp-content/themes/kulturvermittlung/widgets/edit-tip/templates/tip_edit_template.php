<?php
$userId = NULL;
$user = wp_get_current_user();
if(!empty($user)){
	if(in_array('artist', (array) $user->roles)){
		$userId = get_current_user_id();
	}
}

if(!empty($_GET['tipId'])) {
	$tipId = intval($_GET['tipId']);
}


if(!empty($msg)) { ?>
	<div class="message"><?php echo $msg;?></div>
<?php }

$template_dir = get_template_directory_uri();
?>

<script>
    jQuery(function(){

    });
</script>

<div class="grid-inner">
	<h1>
		<?php if(!empty($tipId)) {?>
			<?php _e('<strong>Tipp</strong> speichern', 'teilhabekultur');?>
		<?php } else {?>
			<?php _e('<strong>Tipp</strong> einreichen', 'teilhabekultur');?>
		<?php } ?>

	</h1>
	<form class="full-width" action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST">
		<input name="kulturvermittlung_action" type="hidden" value="edit_tip"/>
		<input name="action" type="hidden" value="kulturvermittlung_save_tip"/>
		<?php if(!empty($tipId)) {?>
            <input type="hidden" name="tipId" value="<?php echo $tipId;?>"/>
		<?php } ?>
		<?php wp_nonce_field( 'kulturvermittlung_edit_tip'); ?>

		<?php include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/tip/edit_tipp_form.tpl.php');?>

		<div class="margin-bottom">
			<input type="submit" value="<?php if(!empty($offerId)) { _e('Tipp speichern', 'teilhabekultur'); } else { _e('Tipp einreichen', 'teilhabekultur'); }?>">
		</div>

	</form>
</div>