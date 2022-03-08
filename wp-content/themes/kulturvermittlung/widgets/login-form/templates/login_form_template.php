<div class="login-form-container">
	<div class="login-teaser-image">
        <img src="<?php echo get_template_directory_uri();?>/static/img/login_form_teaser_image.png" alt="<?php _e('Illustriertes Haus','teilhabekultur');?>"/>
	</div>

	<div class="login-form-box">
        <h1><?php echo $instance['heading_1'];?><br/><span class="bold"><?php echo $instance['heading_2'];?></span></h1>
        <div class="description-text"><?php echo $instance['description'];?></div>
        <div class="box-title"><?php _e('Login','teilhabekultur');?></div>
        <div class="login-form">
            <form name="loginform" id="loginform" action="<?php echo wp_login_url(get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile')));?>" method="post">
                <label for="user_login"><strong><?php _e('Email','teilhabekultur');?>:</strong></label>
                <div class="form-field">
                    <input type="text" name="log" id="user_login" class="input" value="" size="20" placeholder="<?php _e('Email','teilhabekultur');?>">
                </div>

                <label for="user_pass"><strong><?php _e('Passwort','teilhabekultur');?>:</strong></label>
                <div class="form-field">
                    <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" placeholder="<?php _e('Passwort','teilhabekultur');?>">
                    <button class="reveal-password" title="<?php _e('Passwort anzeigen','teilhabekultur');?>"></button>
                </div>

                <div class="flex">
                    <label><input name="rememberme" type="checkbox" id="rememberme" value="forever"> <?php _e('Angemeldet bleiben?','teilhabekultur');?></label>
                    <div class="forgot-password"><a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('lost_password'));?>"><?php _e('Passwort vergessen','teilhabekultur');?></a></div>
                </div>

                <?php if($_GET['login'] == 'failed') { ?>
                    <div class="error margin-bottom" role="alert"><strong><?php _e('Login fehlgeschlagen','teilhabekultur');?>:</strong> <?php _e('Entweder ist dein Passwort und/oder Benutzername nicht korrekt oder dein Account wurde stillgelegt.','teilhabekultur');?></div>
                <?php } ?>

                <?php if($_GET['login'] == 'required') { ?>
                    <div class="error margin-bottom" role="alert"><strong><?php _e('Bitte logge dich ein','teilhabekultur');?>:</strong> <?php _e('Für diese Funktion musst du eingeloggt sein. Wenn du automatisch ausgeloggt worden bist, warst du für eine gewisse Zeit nicht aktiv und wurdest daher aus Sicherheitsgründen ausgeloggt.','teilhabekultur');?></div>
		        <?php } ?>

	            <?php if($_GET['login'] == 'password_changed') { ?>
                    <div class="success margin-bottom" role="alert"><strong><?php _e('Passwort ändern erfolgreich','teilhabekultur');?>:</strong> <?php _e(' Aus Sicherheitsgründen wurdest du nach dem Ändern des Passworts ausgeloggt. Bitte logge dich mit deinem neuen Passwort wieder ein.');?></div>
                <?php } ?>

	            <?php if($_GET['login'] == 'password_lost') { ?>
                    <div class="success margin-bottom" role="alert"><strong><?php _e('Neues Passwort erfolgreich angefordert','teilhabekultur');?>:</strong> <?php _e(' Du hast erfolgreich ein neues Passwort angefordert. Bitte überprüfe dein E-Mailkonto und folge den Anweisungen in der E-Mail.');?></div>
	            <?php } ?>

	            <?php if($_GET['login'] == 'created') { ?>
                    <div class="success margin-bottom" role="alert"><strong><?php _e('Profil erfolgreich angelegt','teilhabekultur');?>:</strong> <?php _e(' Dein Profil wurde erfolgreich angelegt. Ein unserer Administratoren wird dein Profil zeitnah freischalten und du kannst loslegen. Wir werden dich per E-Mail darüber benachrichtigen.');?></div>
	            <?php } ?>

	            <?php if($_GET['login'] == 'not_active') { ?>
                    <div class="success margin-bottom" role="alert"><strong><?php _e('Profil stillgelegt','teilhabekultur');?>:</strong> <?php _e(' Dein Profil ist im Moment stillgelegt. Bitte wende dich ans uns per E-Mail um das Profil wieder zu aktivieren bzw. herauszufinden, warum dein Profil deaktiviert wurde.');?></div>
                <?php  } ?>

	            <?php if($_GET['login'] == 'deactivated') { ?>
                    <div class="success margin-bottom" role="alert"><strong><?php _e('Profil erfolgreich deaktviert','teilhabekultur');?>:</strong> <?php _e(' Dein Profil wurde erfolgreich deaktiviert. Login dich einfach jederzeit wieder ein, um den Profil wieder zu aktivieren.');?></div>
	            <?php } ?>

                <?php if(!empty($_GET['redirectURL'])) {?>
                    <input type="hidden" name="redirect_to" value="<?php echo urldecode($_GET['redirectURL']);?>">
                <?php } ?>
                <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="<?php _e('Anmelden','teilhabekultur');?>">
            </form>
        </div>

        <div class="divider"></div>

        <div class="register-now-text"><?php echo $instance['register_now_text'];?></div>

        <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('registration'));?>" class="register-now-button button-link"><?php _e('Jetzt registrieren','teilhabekultur');?></a>
    </div>
</div>