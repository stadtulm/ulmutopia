

<div class="login-form-container">
	<div class="login-teaser-image">
		<img src="<?php echo get_template_directory_uri();?>/static/img/login_form_teaser_image.png"/>
	</div>

	<div class="login-form-box">
		<h1>Passwort <span class="bold">vergessen</span></h1>
		<div class="description-text">Bitte gib deine E-Mail-Adresse hier ein. Du bekommst eine E-Mail zugesandt, mit deren Hilfe du ein neues Passwort erstellen kannst.</div>
		<div class="box-title"><?php _e('Neues Passwort anfordern','teilhabekultur');?></div>
		<div class="login-form">
			<form name="lostpasswordform" id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
				<input type="text" name="user_login" id="user_login" class="input form-field" value="" size="20" tabindex="10" placeholder="Email">
				<input type="hidden" name="redirect_to" value="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register'));?>?login=password_lost">
				<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Neues Passwort" tabindex="100">
			</form>
		</div>
	</div>
</div>