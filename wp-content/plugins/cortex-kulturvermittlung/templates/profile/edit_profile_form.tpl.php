<?php $upload_dir = wp_upload_dir(); ?>
<?php
    //If the form had an error in wp-admin, we will refill it with the POST data
    if(!empty($_POST['name_institution_kuenstlerin'])) {
        $values = $_POST;
    }
?>

<div style="display: none">
    <div class="cropper-template">
        <button type="button" class="confirm-crop btn"><?php _e('Fertig');?></button>
        <div class="image"></div>
    </div>
</div>

<div class="form-box">
	<h2 class="box-title"><?php _e('Persönliche Daten', 'teilhabekultur');?></h2>

	<div class="form-row">
		<div class="form-field">
			<label for="name_institution_kuenstlerin"><?php _e('Name Institution / Künstler*in');?> *</label>
			<input id="name_institution_kuenstlerin" type="text" name="name_institution_kuenstlerin" value="<?php if(!empty($values['name_institution_kuenstlerin'])) { echo $values['name_institution_kuenstlerin']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>
	</div>

    <div class="form-row">
        <div class="form-field">
            <label for="untertitel"><?php _e('Untertitel im Profil');?> *</label>
            <input id="untertitel" type="text" name="untertitel" value="<?php if(!empty($values['untertitel'])) { echo $values['untertitel']; } ?>" maxlength="200" required aria-required="true"/>
            <span class="completed"></span>
        </div>
    </div>

	<div class="form-row">
		<div class="form-field">
			<label for="ansprechperson_1_vorname"><?php _e('Vorname der Ansprechperson');?> *</label>
			<input id="ansprechperson_1_vorname" type="text" name="ansprechperson_1_vorname" value="<?php if(!empty($values['ansprechperson_1_vorname'])) { echo $values['ansprechperson_1_vorname']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>

		<div class="form-field form-field-50">
			<label for="ansprechperson_1_nachname"><?php _e('Nachname der Ansprechperson');?> *</label>
			<input id="ansprechperson_1_nachname" type="text" name="ansprechperson_1_nachname" value="<?php if(!empty($values['ansprechperson_1_nachname'])) { echo $values['ansprechperson_1_nachname']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>

		<?php if(empty($values['ansprechperson_2_vorname']) && empty($values['ansprechperson_2_nachname'])) {?>
            <div class="add-more full-width margin-top" id="add-contact-person-2">
                <a class="show-contact-person-row" data-row-id="contact-person-row-2" href="#">
                    <?php _e('weitere Ansprechperson hinzufügen','kulturvermittlung');?>
                    <img src="<?php echo $template_dir;?>/static/img/icons/arrow_down.svg" alt="<?php _e('weitere Ansprechperson hinzufügen','kulturvermittlung');?>" class="add-more-icon"/>
                </a>
            </div>
        <?php } ?>
	</div>

	<div id="contact-person-row-2" class="form-row relative <?php if(empty($values['ansprechperson_2_vorname']) && empty($values['ansprechperson_2_nachname'])) {?>hidden<?php } ?>">
		<div class="form-field">
			<label for="ansprechperson_2_vorname"><?php _e('Vorname der zweiten Ansprechperson');?></label>
			<input id="ansprechperson_2_vorname" type="text" name="ansprechperson_2_vorname" value="<?php if(!empty($values['ansprechperson_2_vorname'])) { echo $values['ansprechperson_2_vorname']; } ?>"/>
			<span class="completed"></span>
		</div>

		<div class="form-field form-field-50">
			<label for="ansprechperson_2_nachname"><?php _e('Nachname der zweiten Ansprechperson');?></label>
			<input id="ansprechperson_2_nachname" type="text" name="ansprechperson_2_nachname" value="<?php if(!empty($values['ansprechperson_2_nachname'])) { echo $values['ansprechperson_2_nachname']; } ?>"/>
			<span class="completed"></span>
		</div>

        <span class="remove-row" data-add-more="add-contact-person-2" id="remove-contact-person-2"><img src="<?php echo $template_dir;?>/static/img/icons/remove.svg" alt="<?php _e('Ansprechpartner entfernen','teilhabekultur'); ?>"/></span>

		<?php if(empty($values['ansprechperson_3_vorname']) && empty($values['ansprechperson_3_nachname'])) {?>
            <div class="add-more full-width margin-top" id="add-contact-person-3">
                <a class="show-contact-person-row" data-row-id="contact-person-row-3" href="#">
                    <?php _e('weitere Ansprechperson hinzufügen','kulturvermittlung');?>
                    <img src="<?php echo $template_dir;?>/static/img/icons/arrow_down.svg" alt="<?php _e('weitere Ansprechperson hinzufügen','kulturvermittlung');?>" class="add-more-icon"/>
                </a>
            </div>
        <?php } ?>
	</div>

	<div id="contact-person-row-3" class="form-row relative <?php if(empty($values['ansprechperson_3_vorname']) && empty($values['ansprechperson_3_nachname'])) {?>hidden<?php }?>">
		<div class="form-field">
			<label for="ansprechperson_3_vorname"><?php _e('Vorname der dritten Ansprechperson');?></label>
			<input id="ansprechperson_3_vorname" type="text" name="ansprechperson_3_vorname" value="<?php if(!empty($values['ansprechperson_3_vorname'])) { echo $values['ansprechperson_3_vorname']; } ?>"/>
			<span class="completed"></span>
		</div>

		<div class="form-field form-field-50">
			<label for="ansprechperson_3_nachname"><?php _e('Nachname der dritten Ansprechperson');?></label>
			<input id="ansprechperson_3_nachname" type="text" name="ansprechperson_3_nachname" value="<?php if(!empty($values['ansprechperson_3_nachname'])) { echo $values['ansprechperson_3_nachname']; } ?>"/>
			<span class="completed"></span>
		</div>

        <span class="remove-row" data-add-more="add-contact-person-3" id="remove-contact-person-3"><img src="<?php echo $template_dir;?>/static/img/icons/remove.svg" alt="<?php _e('Ansprechpartner entfernen','teilhabekultur'); ?>"/></span>
	</div>

	<div class="form-row flex-start">
		<div class="form-field">
			<label for="strasse"><?php _e('Straße');?> *</label>
			<input id="strasse" type="text" name="strasse" value="<?php if(!empty($values['strasse'])) { echo $values['strasse']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>

		<div class="form-field margin-left one-fourth">
			<label for="hausnummer"><?php _e('Hausnummer');?> *</label>
			<input id="hausnummer" type="text" name="hausnummer" value="<?php if(!empty($values['hausnummer'])) { echo $values['hausnummer']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>
	</div>


	<div class="form-row flex-start">
		<div class="form-field one-fourth">
			<label for="plz"><?php _e('Postleitzahl');?> *</label>
			<input id="plz" type="text" name="plz" value="<?php if(!empty($values['plz'])) { echo $values['plz']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>

		<div class="margin-left form-field">
			<label for="ort"><?php _e('Ort');?> *</label>
			<input id="ort" type="text" name="ort" value="<?php if(!empty($values['ort'])) { echo $values['ort']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="telefon"><?php _e('Telefon');?> *</label>
			<input id="telefon" type="text" name="telefon" value="<?php if(!empty($values['telefon'])) { echo $values['telefon']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>

		<div class="form-field">
			<label for="telefon"><?php _e('Fax');?></label>
			<input id="fax" type="text" name="fax" value="<?php if(!empty($values['fax'])) { echo $values['fax']; } ?>"/>
			<span class="completed"></span>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="email"><?php _e('E-Mailadresse');?> *</label>
			<input id="email" type="text" name="email" value="<?php if(!empty($values['email'])) { echo $values['email']; } ?>" required  aria-required="true" <?php if(!$registration) {?>readonly<?php } ?>/>
            <?php if($registration) { ?><span class="completed"></span><?php } ?>

            <?php if(!$registration) { ?>
                <div class="margin-top-half"><?php _e('Um deine E-Mailadresse zu ändern klick bitte <a href="' . get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('change_email_password')) . '">hier</a>.', 'teilhabekultur');?></div>
            <?php } ?>
		</div>
	</div>

    <?php if($registration) {?>
        <div class="form-row">
            <div class="form-field">
                <label for="password"><?php _e('Passwort');?></label>
                <input id="password" type="password" name="password" value="" autocomplete="new-password" required aria-required="true"/>
                <span class="reveal-password"></span>
            </div>

            <div class="form-field">
                <label for="password_confirm"><?php _e('Passwort bestätigen');?></label>
                <input id="password_confirm" type="password" name="password_confirm" autocomplete="new-password" value="" required aria-required="true"/>
                <span class="reveal-password"></span>
            </div>
        </div>
    <?php } ?>
</div>

<div class="form-box">
	<h2 class="box-title"><?php _e('Profil Daten', 'teilhabekultur');?></h2>

	<div class="form-row">
		<div class="form-field">
			<label for="categories"><?php _e('Kategorien');?> *</label>
			<div id="categories">
				<?php foreach(Cortex_Kulturvermittlung_Config::$sectors AS $key => $sector) {?>
					<span class="clickable-label <?php echo $key;?> <?php if(is_array($values['sparten']) && in_array($key, $values['sparten'])) {?>active<?php } ?>">
                                <input id="<?php echo $key;?>" type="checkbox" value="<?php echo $key;?>" name="sparten[]" <?php if(is_array($values['sparten']) && in_array($key, $values['sparten'])) {?>checked<?php }?>/>
                                <?php echo $sector;?>
                            </span>
				<?php } ?>
			</div>
		</div>

		<div class="form-field">
			<label for="image-gallery"><?php _e('Bildergalerie', 'teilhabekultur');?></label>
			<div class="image-gallery-uploads flex space-between margin-bottom-half">
                <?php for($i=1; $i<=3;$i++) {?>
                    <div class="image-gallery-upload image-upload" data-with-cropper="1" data-upload-url="<?php echo admin_url('admin-ajax.php?action=kulturvermittlung_upload_temp_image');?>">
                        <input name="file" type="file" />
                        <input type="hidden" name="image_gallery_image_<?php echo $i;?>" class="image-upload-hidden-field" value="<?php echo $values['image_gallery_image_' . $i];?>"/>
                        <div class="preview-image"  data-path="<?php echo $upload_dir['baseurl'] .'/temp_uploads/';?>">
			                <?php if(!empty($values['image_gallery_image_' . $i])) {
			                    if(is_int($values['image_gallery_image_' . $i])) {
				                    $imageURL = wp_get_attachment_image_url($values['image_gallery_image_'  . $i], 'medium');
                                } else{
			                        $imageURL = $upload_dir['baseurl'] .'/temp_uploads/'. $values['image_gallery_image_' . $i];
			                    }?>
			                <?php } else { $imageURL = ''; } ?>
                            <div class="dz-image">
                                <img src="<?php echo $imageURL;?>"/>
                            </div>
                        </div>

                        <span class="remove <?php if(empty($values['image_gallery_image_' . $i])) {?>hidden<?php }?>"><img src="<?php echo $template_dir;?>/static/img/icons/remove_black.svg" alt="<?php _e('Bild entfernen','teilhabekultur'); ?>"/></span>
                    </div>
                <?php } ?>
            </div>

			<?php for($i=1; $i<=3;$i++) {?>
                <input id="copyright_bildergalerie_<?php echo $i;?>" type="text" name="copyright_bildergalerie_<?php echo $i;?>" placeholder="<?php _e('Copyright-Hinweis Bild', 'kulturvermittlung');?> <?php echo $i;?>" value="<?php if(!empty($values['copyright_bildergalerie_' . $i])) { echo $values['copyright_bildergalerie_' . $i]; } ?>"/>
			<?php } ?>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="profile_image"><?php _e('Profilbild');?> *</label>

			<div id="profile_image" class="profile-image-upload image-upload margin-bottom-half" data-with-cropper="1" data-width="1000" data-height="1000" data-upload-url="<?php echo admin_url('admin-ajax.php?action=kulturvermittlung_upload_temp_image');?>">
				<input name="file" type="file" />
				<input type="hidden" name="profile_image" class="image-upload-hidden-field" value="<?php echo $values['profile_image'];?>"/>
                <div class="preview-image" data-path="<?php echo $upload_dir['baseurl'] .'/temp_uploads/';?>">
	                <?php if(!empty($values['profile_image'])) {
		                if(is_int($values['profile_image'])) {
			                $imageURL = wp_get_attachment_image_url($values['profile_image'], 'medium');
		                } else{
			                $imageURL = $upload_dir['baseurl'] .'/temp_uploads/'. $values['profile_image'];
		                }?>
	                <?php } else { $imageURL = ''; } ?>
                    <div class="dz-image">
                        <img src="<?php echo $imageURL;?>"/>
                    </div>
                </div>
			</div>
            <div class="image-size-hint"><?php _e('Mindestbreite 1000px','teilhabekultur');?></div>
            <div class="image-error"><?php _e('Das Bild ist leider zu klein, bitte lade ein größeres Bild hoch.','teilhabekultur');?></div>
            <input id="copyright_profilbild" type="text" name="copyright_profilbild" placeholder="<?php _e('Copyright-Hinweis *', 'kulturvermittlung');?>" value="<?php if(!empty($values['copyright_profilbild'])) { echo $values['copyright_profilbild']; } ?>" required aria-required="true"/>
            <span class="completed"></span>
		</div>

		<div class="form-field">
			<label for="videos"><?php _e('Videos');?></label>
			<div class="hint margin-bottom"><?php _e('Bitte gib Links zu Videos auf Vimeo oder YouTube an.','kulturvermittlung');?></div>
			<div id="videos">
                <?php if(is_array($values['videos']) && sizeof($values['videos']) > 0) {
                    $first = true;
                    foreach($values['videos'] AS $key => $video) { ?>
                        <div class="input-container margin-bottom-half">
                            <input class="video-link-input margin-bottom-half" type="text" name="videos[]" placeholder="https://..." value="<?php echo $video;?>"/>
                            <input class="video-link-input margin-bottom-half" type="text" name="video-titles[]" placeholder="Videotitel" value="<?php echo $values['videoTitles'][$key];?>"/>
                            <span class="remove <?php if($first) {?>hidden<?php }?>"><img src="<?php echo $template_dir;?>/static/img/icons/remove.svg" alt="<?php _e('Link entfernen','teilhabekultur'); ?>"/></span>
                        </div>
                    <?php $first = false; } ?>
                <?php } else { ?>
                    <div class="input-container margin-bottom-half">
                        <input class="video-link-input margin-bottom-half" type="text" name="videos[]" placeholder="https://..." value=""/>
                        <input class="video-link-input margin-bottom-half" type="text" name="video-titles[]" placeholder="Videotitel" value=""/>
                        <span class="remove hidden"><img src="<?php echo $template_dir;?>/static/img/icons/remove.svg" alt="<?php _e('Link entfernen','teilhabekultur'); ?>"/></span>
                    </div>
                <?php } ?>
			</div>

			<div class="add-more">
				<a id="add-video-link-input" href="#">
					<?php _e('weiteres Video hinzufügen','kulturvermittlung');?>
					<img src="<?php echo $template_dir;?>/static/img/icons/arrow_down.svg" alt="<?php _e('weiteres Video hinzufügen','kulturvermittlung');?>" class="add-more-icon"/>
				</a>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="title_image"><?php _e('Titelbild auswählen');?> *</label>
			<div id="title_image" class="title-image-upload image-upload margin-bottom-half" data-with-cropper="1" data-width="2000" data-height="600" data-upload-url="<?php echo admin_url('admin-ajax.php?action=kulturvermittlung_upload_temp_image');?>">
				<input name="file" type="file" />
				<input type="hidden" name="title_image" class="image-upload-hidden-field" value="<?php echo $values['title_image'];?>"/>
                <div class="preview-image" data-path="<?php echo $upload_dir['baseurl'] .'/temp_uploads/';?>">
	                <?php if(!empty($values['title_image'])) {
		                if(is_int($values['title_image'])) {
			                $imageURL = wp_get_attachment_image_url($values['title_image'], 'medium');
		                } else{
			                $imageURL = $upload_dir['baseurl'] .'/temp_uploads/'. $values['title_image'];
		                }?>
	                <?php } else { $imageURL = ''; }?>
                    <div class="dz-image">
                        <img src="<?php echo $imageURL;?>"/>
                    </div>
                </div>
			</div>
            <div class="image-size-hint"><?php _e('Mindestbreite 2000px','teilhabekultur');?></div>
            <div class="image-error"><?php _e('Das Bild ist leider zu klein, bitte lade ein größeres Bild hoch.','teilhabekultur');?></div>
            <input id="copyright_titelbild" type="text" name="copyright_titelbild" placeholder="<?php _e('Copyright-Hinweis *', 'kulturvermittlung');?>" value="<?php if(!empty($values['copyright_titelbild'])) { echo $values['copyright_titelbild']; } ?>" required aria-required="true"/>
            <span class="completed"></span>
		</div>

		<div class="form-field">
			<label for="profilbeschreibung"><?php _e('Profilbeschreibung');?> *</label>
			<textarea id="profilbeschreibung" name="profilbeschreibung" rows="5" required aria-required="true"><?php if(!empty($values['profilbeschreibung'])) { echo $values['profilbeschreibung']; } ?></textarea>
			<div class="hint"><?php _e('mindestens 400 Zeichen, maximal 2000 Zeichen', 'kulturvermittlung');?></div>
		</div>
	</div>

    <div class="form-row flex-start">
        <div class="form-field">
            <label for="zielgruppe_von"><?php _e('Zielgruppe von - bis');?></label>
            <div id="age-range-slider" role="slider"></div>
            <input id="zielgruppe_von" type="hidden" name="zielgruppe_von" value="<?php if(!empty($values['zielgruppe_von'])) { echo $values['zielgruppe_von']; } else { echo "0"; } ?>"/>
            <input id="zielgruppe_bis" type="hidden" name="zielgruppe_bis" value="<?php if(!empty($values['zielgruppe_bis'])) { echo $values['zielgruppe_bis']; } else { echo "100"; } ?>"/>
        </div>
    </div>
</div>

<div class="form-box">
	<h2 class="box-title"><?php _e('Meine Links', 'teilhabekultur');?></h2>

	<div class="form-row">
		<div class="form-field">
			<label for="my_website"><?php _e('Meine Webseite');?></label>
			<input id="my_website" type="text" name="my_website" value="<?php if(!empty($values['my_website'])) { echo $values['my_website']; } ?>"/>
		</div>

		<div class="form-field">
			<label for="my_video_channel"><?php _e('Mein YouTube/Video Kanal');?></label>
			<input id="my_video_channel" type="text" name="my_video_channel" value="<?php if(!empty($values['my_video_channel'])) { echo $values['my_video_channel']; } ?>"/>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="my_facebook"><?php _e('Meine Facebook Seite');?></label>
			<input id="my_facebook" type="text" name="my_facebook" value="<?php if(!empty($values['my_facebook'])) { echo $values['my_facebook']; } ?>"/>
		</div>

		<div class="form-field">
			<label for="my_instagram"><?php _e('Mein Instagram');?></label>
			<input id="my_instagram" type="text" name="my_instagram" value="<?php if(!empty($values['my_instagram'])) { echo $values['my_instagram']; } ?>"/>
		</div>
	</div>

    <div class="form-row">
        <div class="form-field">
            <label for="my_pintrest"><?php _e('Meine Pintrest');?></label>
            <input id="my_pintrest" type="text" name="my_pintrest" value="<?php if(!empty($values['my_pintrest'])) { echo $values['my_pintrest']; } ?>"/>
        </div>

        <div class="form-field">
            <label for="my_tiktok"><?php _e('Mein TikTok');?></label>
            <input id="my_tiktok" type="text" name="my_tiktok" value="<?php if(!empty($values['my_tiktok'])) { echo $values['my_tiktok']; } ?>"/>
        </div>
    </div>
</div>

<div class="form-box">
	<h2 class="box-title with-description"><?php _e('Genutzte digitale Plattformen und Werkzeuge', 'teilhabekultur');?></h2>

    <p class="margin-bottom"><?php _e('Hier kannst du angeben, welche Apps, Tools und Plattformen du in deiner Arbeit bzw. deinen Projekten und Angeboten vornehmlich nutzt.', 'teilhabekultur');?></p>
	<div class="form-row">
		<div class="form-field">
            <label for="videokonferenzen"><?php _e('Videokonferenzen');?><?php $content="Welche Videokonferenzen-Anbieter werden genutzt? Zum Beispiel <em>Zoom, Jitsi, Webex, tiktok, Bigbluebutton</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<input id="videokonferenzen" type="text" name="videokonferenzen" value="<?php if(!empty($values['videokonferenzen'])) { echo $values['videokonferenzen']; } ?>"/>
		</div>

		<div class="form-field">
			<label for="gemeinsames_arbeiten"><?php _e('Gemeinsames Arbeiten');?><?php $content="Welche Apps und Tools werden genutzt, um gemeinsam an einem Projekt oder einer Idee zu arbeiten? Zum Beispiel<br/><em>Moodle, Trello, Miro, Mentimeter, Lucidspark, Discord</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<input id="gemeinsames_arbeiten" type="text" name="gemeinsames_arbeiten" value="<?php if(!empty($values['gemeinsames_arbeiten'])) { echo $values['gemeinsames_arbeiten']; } ?>"/>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="kommunikation"><?php _e('Kommunikation');?><?php $content="Welche Kommunikationskanäle und -tools werden genutzt? Zum Beispiel <em>E-Mail, Whatsapp, Wire, Telefon, Google Docs, Discord</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<input id="kommunikation" type="text" name="kommunikation" value="<?php if(!empty($values['kommunikation'])) { echo $values['kommunikation']; } ?>"/>
		</div>

		<div class="form-field">
			<label for="sonstiges"><?php _e('Sonstiges');?><?php $content="Hier können weitere Angaben über verwendete digitale Apps, Tools und Plattformen gemacht werden z.B <em>Pinterest</em>"; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<input id="sonstiges" type="text" name="sonstiges" value="<?php if(!empty($values['sonstiges'])) { echo $values['sonstiges']; } ?>"/>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<div class="margin-bottom-row">
				<label for="social_media"><?php _e('Social Media');?><?php $content="Welche Social Media-Kanäle werden genutzt? Zum Beispiel <em>Instagram, Facebook, TikTok etc.</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
				<input id="social_media" type="text" name="social_media" value="<?php if(!empty($values['social_media'])) { echo $values['social_media']; } ?>"/>
			</div>

			<label for="videoplattformen"><?php _e('Videoplattformen');?><?php $content="Welche Videoplattformen bzw. -anbieter werden genutzt? Zum Beispiel <em>Youtube, Vimeo</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<input id="videoplattformen" type="text" name="videoplattformen" value="<?php if(!empty($values['videoplattformen'])) { echo $values['videoplattformen']; } ?>"/>
		</div>

		<div class="form-field">
			<label for="technische_ausstattung "><?php _e('Technische Ausstattung');?><?php $content="Welche technische Ausstattung bringst du mit, die in deinen Angeboten genutzt oder hinzugebucht werden kann?<br/>Zum Beispiel <em>Tablets, Monitore, Boxen, VR-Brille, mobiler WLAN-Router, Kopfhörer etc.</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<textarea id="technische_ausstattung" name="technische_ausstattung" rows="5"><?php if(!empty($values['technische_ausstattung'])) { echo $values['technische_ausstattung']; } ?></textarea>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="soundplattformen"><?php _e('Soundplattformen');?><?php $content="Welche Sound- und Musikanbieter sowie -plattformen werden genutzt? Zum Beispiel <em>Spotify, Itunes, Deezer, JamKazam</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<input id="soundplattformen" type="text" name="soundplattformen" value="<?php if(!empty($values['soundplattformen'])) { echo $values['soundplattformen']; } ?>"/>
		</div>

		<div class="form-field">
			<label for="videokonferenz_moeglich"><?php _e('Videokonferenz möglich');?></label>
			<div id="videokonferenz_moeglich">
				<label for="videokonferenz_moeglich_ja" class="radio-button"><input type="radio" id="videokonferenz_moeglich_ja" name="videokonferenz_moeglich" value="1" <?php if(isset($values['videokonferenz_moeglich']) && $values['videokonferenz_moeglich'] == 1) {?>checked="checked"<?php } ?>><?php _e('Ja','kulturvermittlung');?></label>
				<label for="videokonferenz_moeglich_nein" class="radio-button"><input type="radio" id="videokonferenz_moeglich_nein" name="videokonferenz_moeglich" value="0" <?php if(isset($values['videokonferenz_moeglich']) && $values['videokonferenz_moeglich'] == 0) {?>checked="checked"<?php } ?>><?php _e('Nein','kulturvermittlung');?></label>
			</div>
		</div>
	</div>
</div>

<div class="form-box">
    <h2 class="box-title with-description"><?php _e('Kooperationen (Zusammenarbeit mit)', 'teilhabekultur');?></h2>
    <div class="form-row">
        <div class="form-field flex-start">
            <label for="kooperationspartner_intern"><?php _e('Kooperationen auf ulmutopia.de');?><?php $content="Hier kannst du angeben, mit wem du auf ulmutopia.de zusammenarbeitest"; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
            <select class="select-box full-width" name="kooperationspartner_intern[]" multiple id="kooperationspartner_intern">
	            <?php
                $profiles = Cortex_Kulturvermittlung_Profiles::getFilteredProfiles(array(get_current_user_id()));
	            foreach($profiles AS $profile) { ?>
                    <option value="<?php echo $profile->ID;?>" <?php if(is_array($values['kooperationspartner_intern']) && in_array($profile->ID, $values['kooperationspartner_intern'])){?>selected<?php }?>><?php echo get_field('name_institution_kuenstlerin', 'user_' . $profile->ID);?></option>
	            <?php } ?>
            </select>
        </div>
    </div>


    <label class="margin-bottom-half">
        <strong><?php _e('Externe Kooperationen','teilhabekultur');?></strong>
        <?php $content="Hier kannst du angeben, mit wem du außerhalb von ulmutopia.de zusammenarbeitest"; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?>
    </label>

    <div class="external-cooperation-partners">
        <div class="rows">
            <?php foreach($values['kooperationspartner_extern'] as $cooperationExternal) {
                $showDelete = true;
                $partner_name = $cooperationExternal['name'];
                $partner_url = $cooperationExternal['webseite'];
                $partner_beschreibung = $cooperationExternal['beschreibung'];
            ?>
            <div class="form-row">
                <?php include(__DIR__ . '/../includes/cooperation_inputs.tpl.php');?>
            </div>
            <?php } ?>

            <?php if(!isset($values['kooperationspartner_extern']) || sizeof($values['kooperationspartner_extern']) == 0) {?>
                <div class="form-row">
                    <?php include(__DIR__ . '/../includes/cooperation_inputs.tpl.php');?>
                </div>
            <?php } ?>
        </div>
        <div class="add-more">
            <a id="add-cooperation-input" href="#">
		        <?php _e('weiteren Partner hinzufügen','kulturvermittlung');?>
                <img src="<?php echo $template_dir;?>/static/img/icons/arrow_down.svg" alt="<?php _e('weiteres Partner hinzufügen','kulturvermittlung');?>" class="add-more-icon"/>
            </a>
        </div>
    </div>
</div>
