<div class="contact-form-container">
	<form id="contact-form" class="contact-form" action="" method="POST">
		<div class="form-field">
            <label for="first_name"><strong><?php _e('Vorname *','kulturvermittlung');?>:</strong></label>
			<input id="first_name" type="text" name="first_name" value="" placeholder="<?php _e('Vorname *','kulturvermittlung');?>" required aria-required="true"/>
		</div>

		<div class="form-field">
            <label for="first_name"><strong><?php _e('Nachname *','kulturvermittlung');?>:</strong></label>
			<input type="text" name="last_name" value="" placeholder="Nachname *" required aria-required="true"/>
		</div>


		<div class="form-field">
            <label for="first_name"><strong><?php _e('E-Mailadresse *','kulturvermittlung');?>:</strong></label>
			<input type="email" name="email" value="" placeholder="E-Mailadresse *" required aria-required="true"/>
		</div>

		<div class="form-field">
            <label for="first_name"><strong><?php _e('Institution','kulturvermittlung');?></strong>:</label>
			<input type="text" name="institution" value="" placeholder="Institution"/>
		</div>

		<div class="margin-bottom">
            <label for="first_name"><strong><?php _e('Deine Nachricht *','kulturvermittlung');?></strong>:</label>
			<textarea name="message" placeholder="Deine Nachricht &hellip; *" rows="5"></textarea>
		</div>

        <div role="status">
            <div class="message-box-permanent success success-message" data-message="<?php _e('Danke für deine Nachricht. Wir melden uns schnellstmöglich bei dir.','teilhabekultur');?>">
                <img class="success-icon" src="<?php echo get_template_directory_uri();?>/static/img/icons/icon-ja.svg" alt="<?php _e('Erfolgeich','teilhabekultur');?>"/>
                <div class="message"></div>
            </div>
        </div>

		<input type="submit" value="<?php _e('Nachricht senden', 'teilhabekultur');?>">
	</form>
</div>