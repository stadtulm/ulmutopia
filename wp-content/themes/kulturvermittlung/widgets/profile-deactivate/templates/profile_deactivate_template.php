<?php
	$template_dir = get_template_directory_uri();
    if(!is_user_logged_in()) {
        include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/includes/login_needed.tpl.php');
    }
?>
<div class="grid-inner">
	<h1>
		<?php _e('<strong>Profil</strong> stillegen', 'teilhabekultur');?>
	</h1>

	<form class="full-width" action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST" id="deactivate-profile-form">
		<input name="action" type="hidden" value="kulturvermittlung_deactive_profile"/>

		<?php wp_nonce_field( 'kulturvermittlung_deactive_profile'); ?>

		<div class="form-box">
			<h2 class="box-title with-description"><?php _e('Du möchtest eine Pause?', 'teilhabekultur');?></h2>

			<p class="margin-bottom"><?php _e('Hier kannst du dein Profil stillegen, so dass es von anderen Besuchern von ulmutopia.de nicht mehr aufgerufen werden kann. Du kannst dein Profil jederzeit wieder aktivieren.', 'teilhabekultur');?></p>
		</div>

		<div class="margin-bottom">
			<input type="submit" value="<?php _e('Profil stillegen', 'teilhabekultur'); ?>">
			<a href="<?php echo Cortex_Kulturvermittlung_Profiles::generateProfileLink(get_current_user_id());?>" class="button-link" id="generate-preview-for-offer"><?php _e('Zurück zu meinem Profil', 'teilhabekultur');?></a>
		</div>
	</form>
</div>