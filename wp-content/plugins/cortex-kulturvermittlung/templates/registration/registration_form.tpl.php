<?php
    if(!empty($msg)) { ?>
        <div class="message"><?php echo $msg;?></div>
    <?php }

    $template_dir = get_template_directory_uri();
?>

<?php
    global $cortexMessage;
    if(!empty($_GET['message'])) {
        $message = $_GET['message'];
    } else if(!empty($cortexMessage)) {
        $message = $cortexMessage;
    }
?>

<script>
    jQuery(function(){
        Forms.initRegistrationForm();
    });
</script>

<div class="grid-inner">
    <h1 class="full-width"><?php _e('<strong>Registrieren</strong> und Vorteile entdecken');?></h1>

    <div id="form-loaded" class="text-align-center full-width margin-bottom hidden"><strong><?php _e('Zwischengespeichertes Formular wurde geladen.', 'teilhabekultur');?></strong></div>

	<?php if($message == 'required_fields_error' || $message == 'password_error' || $message == 'email_false' || $message == 'email_exists') {?>
        <div class="grid-inner">
            <div class="message-box error" role="alert"><img class="error-icon" src="<?php echo $template_dir;?>/static/img/icons/icon-nein.svg" alt="<?php _e('Fehler','teilhabekultur');?>"/>
				<?php if($message == 'required_fields_error') {
					_e('Bitte fülle alle Pflichtfelder aus.', 'teilhabekultur');
				} else if($message == 'password_error') {
					_e('Bitte vergib ein Passwort und geh sicher, dass die beiden Passwortfelder identisch sind.', 'teilhabekultur');
				} else if($message == 'email_false') {
					_e('Bitte gib eine gültige E-Mailadresse ein.', 'teilhabekultur');
				} else if($message == 'email_exists') {
					_e('Diese E-Mailadresse ist bereits registiert. Bitte logge dich stattdessen sein.', 'teilhabekultur');
				} ?>
            </div>
        </div>
	<?php } ?>

    <form id="register-form" class="full-width" action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST">
        <input name="kulturvermittlung_action" type="hidden" value="register_user"/>
        <input type="hidden" name="action" value="kulturvermittlung_register"/>
        <?php wp_nonce_field( 'kulturvermittlung_register_user'); ?>

        <?php
            $registration = true;
            include(dirname(__FILE__) . '/../profile/edit_profile_form.tpl.php');
        ?>

        <div class="form-box">
            <div class="form-row">
                <div class="form-field">
                    <label class="checkbox" for="accepted-privacy"><input type="checkbox" value="1" id="accepted-privacy" name="accepted-privacy" required aria-required="true">Ich habe die&nbsp;<a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('data_privacy'));?>" target="_blank">Datenschutzerklärung</a>&nbsp;gelesen und akzeptiert.</label>
                </div>

                <div class="form-field">
                    <label class="checkbox" for="accepted-terms-and-conditions"><input type="checkbox" value="1" id="accepted-terms-and-conditions" name="accepted-terms-and-conditions" required aria-required="true"><?php _e('Ich habe die&nbsp;<a target="_blank" href="' . get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('terms_and_conditions')) . '" target="_blank">AGB' . '</a>&nbsp;gelesen und stimme diesen zu', 'kulturvermittlung');?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-field align-self-center">
                    <label class="checkbox" for="accepted-email-notifications"><input type="checkbox" value="1" id="accepted-email-notifications" name="accepted-email-notifications"><?php _e('Ich möchte Benachrichtigungen per E-Mail erhalten ', 'kulturvermittlung');?></label>
                </div>
                <div class="form-field">
                    <div class="success-message"></div>
                    <div class="error-messages">
                        <div class="error-message sector"><?php _e('Bitte wähle zumindest eine Sparte aus.', 'teilhabekultur');?></div>
                        <div class="error-message required-fields"><?php _e('Bitte füll mit * markierten alle Pflichtfelder aus.', 'teilhabekultur');?></div>
                        <div class="error-message profile-image"><?php _e('Bitte lade ein Profilbild hoch.', 'teilhabekultur');?></div>
                        <div class="error-message title-image"><?php _e('Bitte lade ein Titelbild hoch.', 'teilhabekultur');?></div>
                        <div class="error-message description"><?php _e('Bitte gib eine Profilbeschreibung zwischen 400 und 2000 Zeichen ein.', 'teilhabekultur');?></div>
                        <div class="error-message copyright-image-gallery"><?php _e('Bitte gib für alle Bilder der Bildergalerie einen Copyright-Hinweis an.', 'teilhabekultur');?></div>
                    </div>
                    <input type="submit" value="<?php  _e('Registrierung abschließen', 'teilhabekultur');?>">
                    <a href="#" id="store-register-form" class="button-link"><?php  _e('Formular zwischenspeichern', 'teilhabekultur');?></a>

                    <div id="main-form-loader" class="lds-loader"><div></div><div></div><div></div></div>
                </div>
            </div>
        </div>
    </form>
</div>