<?php
	if(is_user_logged_in()) {
        $userInfo = get_userdata(get_current_user_id());
        $currentEmail = $userInfo->user_email;
        $template_dir = get_template_directory_uri();
    } else {
        include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/includes/login_needed.tpl.php');
    }
?>
<div class="grid-inner">
	<h1>
		<?php _e('<strong>E-Mailadresse und Passwort</strong>', 'teilhabekultur');?>
	</h1>

	<?php if($_GET['message'] == 'wrong_password' || $_GET['message'] == 'password_error' || $_GET['message'] == 'email_false' || $_GET['message'] == 'email_exists') {?>
        <div class="grid-inner">
            <div class="message-box error" role="alert"><img class="error-icon" src="<?php echo $template_dir;?>/static/img/icons/icon-nein.svg" alt="<?php _e('Fehler', 'kulturvermittlung');?>"/>
				<?php if($_GET['message'] == 'wrong_password') {
					_e('Dein aktuelles Passwort war leider nicht korrekt, bitte versuch es erneut.', 'teilhabekultur');
				} else if($_GET['message'] == 'password_error') {
					_e('Bitte bestätige das neue Passwort und geh sicher, dass die beiden Passwortfelder identisch sind.', 'teilhabekultur');
				} else if($_GET['message'] == 'email_false') {
					_e('Bitte gib eine gültige E-Mailadresse ein.', 'teilhabekultur');
				} else if($_GET['message'] == 'email_exists') {
					_e('Deine neue E-Mailadresse ist bereits an einen anderen Nutzer vergeben.', 'teilhabekultur');
				}?>
            </div>
        </div>
	<?php } ?>


    <form class="full-width" action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST" id="change-password-form">
		<input name="action" type="hidden" value="kulturvermittlung_change_email_password"/>

		<?php wp_nonce_field( 'kulturvermittlung_change_email_password'); ?>

		<div class="form-box">
			<h2 class="box-title with-description"><?php _e('E-Mailadresse und Passwort ändern', 'teilhabekultur');?></h2>

			<p class="margin-bottom"><?php _e('Hier kannst du deine E-Mailadresse ändern. Bitte gib zur Bestätigung dein aktuelles Passwort ein.<br/>Wenn du dein Passwort ebenfalls ändern willst, fülle die beiden Felder für das neue Passwort aus. Ansonsten lass die Felder einfach frei.', 'teilhabekultur');?></>

			<div class="form-row">
				<div class="form-field">
					<label for="email"><?php _e('E-Mailadresse');?> *</label>
					<input id="email" type="text" name="email" value="<?php echo $currentEmail;  ?>" required/>
					<span class="completed"></span>
				</div>
			</div>

			<div class="form-row">
				<div class="form-field">
					<label for="password"><?php _e('Dein aktuelles Passwort');?></label>
					<input id="password" type="password" name="password" value="" autocomplete="new-password" required/>
					<span class="reveal-password"></span>
				</div>
			</div>

			<div class="form-row">
				<div class="form-field">
					<label for="new_password"><?php _e('Neues Passwort');?></label>
					<input id="new_password" type="password" name="new_password" value="" autocomplete="new-password"/>
					<span class="reveal-password"></span>
				</div>

				<div class="form-field">
					<label for="password_confirm"><?php _e('Neues Passwort bestätigen');?></label>
					<input id="password_confirm" type="password" name="password_confirm" autocomplete="new-password" value=""/>
					<span class="reveal-password"></span>
				</div>
			</div>
		</div>

		<div class="margin-bottom">
			<input type="submit" value="<?php _e('Änderungen speichern', 'teilhabekultur'); ?>">
			<a href="<?php echo Cortex_Kulturvermittlung_Profiles::generateProfileLink(get_current_user_id());?>" class="button-link" id="generate-preview-for-offer"><?php _e('Zurück zu meinem Profil', 'teilhabekultur');?></a>
		</div>
	</form>
</div>