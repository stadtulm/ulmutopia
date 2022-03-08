<?php $upload_dir = wp_upload_dir();
$template_dir = get_template_directory_uri(); ?>

<div style="display: none">
    <div class="cropper-template">
        <button type="button" class="confirm-crop btn">Fertig</button>
        <div class="image"></div>
    </div>
</div>

<div class="form-box">
	<h2 class="box-title"><?php _e('Allgemeine Angaben', 'teilhabekultur');?></h2>

	<div class="form-row">
		<div class="form-field">
			<label for="titel"><?php _e('Titel');?> *</label>
			<input id="titel" type="text" name="titel" value="<?php if(!empty($values['titel'])) { echo $values['titel']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="beschreibung"><?php _e('Beschreibung');?> *</label>
			<textarea id="beschreibung" name="beschreibung" rows="5" required aria-required="true"><?php if(!empty($values['beschreibung'])) { echo $values['beschreibung']; } ?></textarea>
			<div class="hint"><?php _e('mindestens 400 Zeichen, maximal 2000 Zeichen', 'kulturvermittlung');?></div>
		</div>

		<div class="form-field">
			<label for="main_image"><?php _e('Bild');?> *</label>

			<div id="main_image" class="main-image-upload image-upload margin-bottom-half" data-with-cropper="1" data-width="1000" data-height="1000" data-upload-url="<?php echo admin_url('admin-ajax.php?action=kulturvermittlung_upload_temp_image');?>">
				<input name="file" type="file" />
				<input type="hidden" name="main_image" class="image-upload-hidden-field" value="<?php echo $values['main_image'];?>"/>
				<div class="preview-image">
					<?php if(!empty($values['main_image'])) {
						if(is_int($values['main_image'])) {
							$imageURL = wp_get_attachment_image_url($values['main_image'], 'medium');
						} else{
							$imageURL = $upload_dir['baseurl'] .'/temp_uploads/'. $values['main_image'];
						}?>
					<?php } else { $imageURL = ''; }?>

                    <div class="dz-image">
                        <img src="<?php echo $imageURL;?>"/>
                    </div>
				</div>
			</div>
            <div class="image-size-hint"><?php _e('Mindestbreite 1000px','teilhabekultur');?></div>
            <div class="image-error"><?php _e('Das Bild ist leider zu klein, bitte lade ein größeres Bild hoch.','teilhabekultur');?></div>
            <input id="copyright_bild" type="text" name="copyright_bild" placeholder="<?php _e('Copyright-Hinweis  *', 'kulturvermittlung');?>" value="<?php if(!empty($values['copyright_bild'])) { echo $values['copyright_bild']; } ?>" required aria-required="true"/>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="categories"><?php _e('Kategorien');?> *</label>
			<div id="categories">
				<?php foreach(Cortex_Kulturvermittlung_Config::$sectors AS $key => $sector) {?>
					<span class="clickable-label <?php echo $key;?> <?php if(is_array($values['sparten']) && in_array($key, $values['sparten'])) {?>active<?php } ?>">
                        <input id="<?php echo $sector;?>" type="checkbox" value="<?php echo $key;?>" name="sparten[]" <?php if(is_array($values['sparten']) && in_array($key, $values['sparten'])) {?>checked<?php }?>/>
                        <?php echo $sector;?>
                    </span>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="ansprechpartner"><?php _e('Ansprechperson');?> *</label>
			<input id="ansprechpartner" type="text" name="ansprechpartner" value="<?php if(!empty($values['ansprechpartner'])) { echo $values['ansprechpartner']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>

		<div class="form-field">
			<label for="ansprechpartner_email"><?php _e('E-Mailadresse der Ansprechperson');?> *</label>
			<input id="ansprechpartner_email" type="text" name="ansprechpartner_email" value="<?php if(!empty($values['ansprechpartner_email'])) { echo $values['ansprechpartner_email']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>
	</div>

    <div class="form-row">
        <div class="form-field flex-start">
            <label for="kooperationspartner"><?php _e('Gemeinsames Angebot mit');?></label>
            <select class="select-box full-width" name="kooperationen[]" multiple id="kooperationspartner">
				<?php
				$profiles = Cortex_Kulturvermittlung_Profiles::getCooperationProfiles(get_current_user_id());
				foreach($profiles AS $profileId) { ?>
                    <option value="<?php echo $profileId;?>" <?php if(is_array($values['kooperationsprofile']) && in_array($profileId, $values['kooperationsprofile'])){?>selected<?php }?>><?php echo get_field('name_institution_kuenstlerin', 'user_' . $profileId);?></option>
				<?php } ?>
            </select>
        </div>
    </div>
</div>

<div class="form-box">
	<h2 class="box-title"><?php _e('Angaben zum Ablauf', 'teilhabekultur');?></h2>
	<div class="form-row">
		<div class="form-field">
			<label for="dauer"><?php _e('Dauer');?> *</label>
			<input id="dauer" type="text" name="dauer" value="<?php if(!empty($values['dauer'])) { echo $values['dauer']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>

		<div class="form-field">
			<label for="dauer_vor-_und_nachbereitung"><?php _e('Dauer nötige Vor- und Nachbereitungszeit für Teilnehmende', 'teilnahmekultur');?></label>
			<input id="dauer_vor-_und_nachbereitung" type="text" name="dauer_vor-_und_nachbereitung" value="<?php if(!empty($values['dauer_vor-_und_nachbereitung'])) { echo $values['dauer_vor-_und_nachbereitung']; } ?>"/>
			<span class="completed"></span>
		</div>
	</div>


	<div class="form-row">
		<div class="form-field">
			<label for="art_der_termine"><?php _e('Terminmöglichkeiten', 'teilnahmekultur');?> *</label>
			<select id="art_der_termine" name="art_der_termine" class="margin-bottom-half">
				<option value="nach_absprache" <?php if($values['art_der_termine'] == 'nach_absprache'){?>selected<?php } ?>><?php _e('Nach Absprache', 'teilnahmekultur');?></option>
				<option value="freie_eingabe" <?php if($values['art_der_termine'] == 'freie_eingabe'){?>selected<?php } ?>><?php _e('Freitext', 'teilnahmekultur');?></option>
				<option value="fester_termin" <?php if($values['art_der_termine'] == 'fester_termin'){?>selected<?php } ?>><?php _e('Terminauswahl', 'teilnahmekultur');?></option>
			</select>

			<textarea id="termin_freitext" name="termin_freitext" rows="5" class="<?php if($values['art_der_termine'] != 'freie_eingabe'){?>hidden<?php }?>"><?php echo $values['freitext_termin'];?></textarea>
            <div id="termin_fester_wert-container" class="date-input-container <?php if($values['art_der_termine'] != 'fester_termin'){?>hidden<?php } ?>">
                <input id="termin_fester_wert" class="date-picker-input" type="text" name="termin_fester_wert" value="<?php echo $values['fester_termin'];?>"/>
                <div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-termin_black.svg" alt=""></div>
            </div>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="anzahl_von_projekteinheitenmodulen"><?php _e('Anzahl von Projekteinheiten/Modulen');?></label>
            <textarea id="anzahl_von_projekteinheitenmodulen" name="anzahl_von_projekteinheitenmodulen" rows="5"><?php if(!empty($values['anzahl_von_projekteinheitenmodulen'])) { echo $values['anzahl_von_projekteinheitenmodulen']; } ?></textarea>
		</div>
	</div>


	<div class="form-row flex-start">
		<div class="form-field">
			<label for="zielgruppe_von"><?php _e('Zielgruppe von - bis');?></label>
            <div id="age-range-slider" role="slider"></div>
            <input id="zielgruppe_von" type="hidden" name="zielgruppe_von" value="<?php if(!empty($values['zielgruppe_von'])) { echo $values['zielgruppe_von']; } else { echo "0"; } ?>" required aria-required="true"/>
            <input id="zielgruppe_bis" type="hidden" name="zielgruppe_bis" value="<?php if(!empty($values['zielgruppe_bis'])) { echo $values['zielgruppe_bis']; } else { echo "100"; } ?>" required aria-required="true"/>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="preis"><?php _e('Preis');?> *</label>
			<input id="preis" type="text" name="preis" value="<?php if(!empty($values['preis'])) { echo $values['preis']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>

		<div class="form-field">
			<label for="abrechnungsform"><?php _e('Abrechnungsform');?></label>
			<input id="abrechnungsform" type="text" name="abrechnungsform" value="<?php if(!empty($values['abrechnungsform'])) { echo $values['abrechnungsform']; } ?>" />
			<span class="completed"></span>
		</div>
	</div>
</div>


<div class="form-box">
	<h2 class="box-title"><?php _e('Angaben zum Inhalt', 'teilhabekultur');?></h2>
	<div class="form-row">
		<div class="form-field">
			<label for="thema"><?php _e('Themen');?></label>
            <div id="thema">
                <?php for($i = 1; $i <= 3; $i++) {?>
                    <input class="margin-bottom-half" id="thema_<?php echo $i;?>" type="text" name="thema_<?php echo $i;?>" value="<?php if(!empty($values['themen'][$i])) { echo $values['themen'][$i]; } ?>" />
                <?php } ?>
            </div>
		</div>

		<div class="form-field">
			<label for="benotigte_materialien"><?php _e('Benötigte Materialien, Technik und Computersysteme');?></label>
			<textarea id="benotigte_materialien" name="benotigte_materialien" rows="5"><?php if(!empty($values['benotigte_materialien'])) { echo $values['benotigte_materialien']; } ?></textarea>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="benotigte_raumlichkeiten"><?php _e('Benötigte Räumlichkeiten für Teilnehmer*Innen');?></label>
			<textarea id="benotigte_raumlichkeiten" name="benotigte_raumlichkeiten" rows="5"><?php if(!empty($values['benotigte_raumlichkeiten'])) { echo $values['benotigte_raumlichkeiten']; } ?></textarea>
		</div>

		<div class="form-field">
			<label for="technik"><?php _e('Technik, die vom Anbietenden gestellt werden kann');?></label>
			<textarea id="technik" name="technik" rows="5"><?php if(!empty($values['technik'])) { echo $values['technik']; } ?></textarea>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="padagogische_unterstutzung_notwendig"><?php _e('Pädagogische Unterstützung notwendig?');?></label>
			<div id="padagogische_unterstutzung_notwendig">
				<label for="padagogische_unterstutzung_notwendig_ja" class="radio-button"><input type="radio" id="padagogische_unterstutzung_notwendig_ja" name="padagogische_unterstutzung_notwendig" value="1" <?php if(isset($values['padagogische_unterstutzung_notwendig']) && $values['padagogische_unterstutzung_notwendig'] == 1) {?>checked="checked"<?php } ?>><?php _e('Ja','kulturvermittlung');?></label>
				<label for="padagogische_unterstutzung_notwendig_nein" class="radio-button"><input type="radio" id="padagogische_unterstutzung_notwendig_nein" name="padagogische_unterstutzung_notwendig" value="0" <?php if(isset($values['padagogische_unterstutzung_notwendig']) && $values['padagogische_unterstutzung_notwendig'] == 0) {?>checked="checked"<?php } ?>><?php _e('Nein','kulturvermittlung');?></label>
			</div>
		</div>

		<div class="form-field">
			<label for="padagogische_unterstutzung_freitext"><?php _e('Wenn ja, welche?');?></label>
			<textarea id="padagogische_unterstutzung_freitext" name="padagogische_unterstutzung_freitext" rows="5"><?php if(!empty($values['padagogische_unterstutzung_freitext'])) { echo $values['padagogische_unterstutzung_freitext']; } ?></textarea>
		</div>
	</div>

    <div class="form-row">
        <div class="form-field">
            <label for="individuelle_projektanpassung_moglich"><?php _e('Individuelle Projektanpassung möglich?');?></label>
            <div id="individuelle_projektanpassung_moglich">
                <label for="individuelle_projektanpassung_moglich_ja" class="radio-button"><input type="radio" id="individuelle_projektanpassung_moglich_ja" name="individuelle_projektanpassung_moglich" value="1" <?php if(isset($values['individuelle_projektanpassung_moglich']) && $values['individuelle_projektanpassung_moglich'] == 1) {?>checked="checked"<?php } ?>><?php _e('Ja','kulturvermittlung');?></label>
                <label for="individuelle_projektanpassung_moglich_nein" class="radio-button"><input type="radio" id="padagogische_unterstutzung_notwendig_nein" name="individuelle_projektanpassung_moglich" value="0" <?php if(isset($values['individuelle_projektanpassung_moglich']) && $values['individuelle_projektanpassung_moglich'] == 0) {?>checked="checked"<?php } ?>><?php _e('Nein','kulturvermittlung');?></label>
            </div>
        </div>
    </div>


</div>

<div class="form-box">
	<h2 class="box-title"><?php _e('Genutzte digitale Plattformen und Werkzeuge', 'teilhabekultur');?></h2>
	<div class="form-row">
		<div class="form-field">
			<label for="videokonferenzen"><?php _e('Videokonferenzen');?><?php $content="Welche Videokonferenzen-Anbieter werden genutzt? Zum Beispiel <em>Zoom, Jitsi, Webex, tiktok, Bigbluebutton</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<textarea id="videokonferenzen" name="videokonferenzen" rows="3"><?php if(!empty($values['videokonferenzen'])) { echo $values['videokonferenzen']; } ?></textarea>
		</div>

		<div class="form-field">
			<label for="gemeinsames_arbeiten"><?php _e('Gemeinsames Arbeiten');?><?php $content="Welche Apps und Tools werden genutzt, um gemeinsam an einem Projekt oder einer Idee zu arbeiten? Zum Beispiel<br/><em>Moodle, Trello, Miro, Mentimeter, Lucidspark, Discord</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<textarea id="gemeinsames_arbeiten" name="gemeinsames_arbeiten" rows="3"><?php if(!empty($values['gemeinsames_arbeiten'])) { echo $values['gemeinsames_arbeiten']; } ?></textarea>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="kommunikation"><?php _e('Kommunikation');?><?php $content="Welche Kommunikationskanäle und -tools werden genutzt? Zum Beispiel <em>E-Mail, Whatsapp, Wire, Telefon, Google Docs, Discord</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<textarea id="kommunikation" name="kommunikation" rows="3"><?php if(!empty($values['kommunikation'])) { echo $values['kommunikation']; } ?></textarea>
		</div>

		<div class="form-field">
			<label for="sonstiges"><?php _e('Sonstiges');?><?php $content="Hier können weitere Angaben über verwendete digitale Apps, Tools und Plattformen gemacht werden z.B <em>Pinterest</em>"; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<textarea id="sonstiges" name="sonstiges" rows="3"><?php if(!empty($values['sonstiges'])) { echo $values['sonstiges']; } ?></textarea>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="social_media"><?php _e('Social Media');?><?php $content="Welche Social Media-Kanäle werden genutzt? Zum Beispiel <em>Instagram, Facebook, TikTok etc.</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<textarea id="social_media" name="social_media" rows="3"><?php if(!empty($values['social_media'])) { echo $values['social_media']; } ?></textarea>
		</div>

		<div class="form-field">
			<label for="avvrxr"><?php _e('Augemented Reality, Virtual Reality und Extended Reality');?><?php $content="Nutzt du bei diesem Angebot Elemente und Techniken der erweiterten oder virtuellen Realität?"; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<textarea id="avvrxr" name="avvrxr" rows="3"><?php if(!empty($values['avvrxr'])) { echo $values['avvrxr']; } ?></textarea>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="videoplattformen"><?php _e('Videoplattformen');?><?php $content="Welche Videoplattformen bzw. -anbieter werden genutzt? Zum Beispiel <em>Youtube, Vimeo</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<textarea id="videoplattformen" name="videoplattformen" rows="3"><?php if(!empty($values['videoplattformen'])) { echo $values['videoplattformen']; } ?></textarea>
		</div>

		<div class="form-field">
			<label for="soundplattformen"><?php _e('Soundplattformen');?><?php $content="Welche Sound- und Musikanbieter sowie -plattformen werden genutzt? Zum Beispiel <em>Spotify, Itunes, Deezer, JamKazam</em> etc."; include(__DIR__ . '/../includes/info_tooltip.tpl.php');?></label>
			<textarea id="soundplattformen" name="soundplattformen" rows="3"><?php if(!empty($values['soundplattformen'])) { echo $values['soundplattformen']; } ?></textarea>
		</div>
	</div>
</div>

<div class="form-box">
	<h2 class="box-title"><?php _e('Materialien & Medien', 'teilhabekultur');?></h2>

	<div class="form-row">
		<div class="form-field">
			<label for="downloads"><?php _e('Downloads');?></label>
            <div id="files">
                <div class="margin-bottom">
                    <?php foreach($values['downloads'] AS $download) { ?>
                         <div class="file-container">
                             <span class="filename"><?php echo $download['datei']['filename'];?></span>
                             <input type="hidden" name="current_downloads[]" value="<?php echo $download['datei']['ID'];?>"/>
                             <span class="remove"><img src="<?php echo $template_dir;?>/static/img/icons/remove.svg" alt="<?php _e('Datei entfernen','teilhabekultur'); ?>"/></span>
                         </div>
                    <?php }?>
                </div>

                <div class="input-container margin-bottom-half">
                    <input type="file" name="downloads[]" />
                    <span class="remove hidden"><img src="<?php echo $template_dir;?>/static/img/icons/remove.svg" alt="<?php _e('Datei entfernen','teilhabekultur'); ?>"/></span>
                </div>

            </div>

            <div class="add-more">
                <a id="add-file-input" href="#">
					<?php _e('weitere Datei hinzufügen','kulturvermittlung');?>
                    <img src="<?php echo $template_dir;?>/static/img/icons/arrow_down.svg" alt="<?php _e('weitere Datei hinzufügen','kulturvermittlung');?>" class="add-more-icon"/>
                </a>
            </div>
		</div>

		<div class="form-field">
			<label for="tipps"><?php _e('Tipps');?></label>
			<select class="select-box full-width" name="tipps[]" multiple>
                <?php foreach(Cortex_Kulturvermittlung_Config::$tipSectors AS $key => $sector) { ?>
                    <optgroup label="<?php echo $sector;?>">
	                    <?php
	                    $tips = Cortex_Kulturvermittlung_Tips::getTippsForCategory($key);
	                    foreach($tips AS $tip) { ?>
                            <option value="<?php echo $tip->ID;?>" <?php if(is_array($values['tipps']) && in_array($tip->ID, $values['tipps'])){?>selected<?php }?>><?php echo get_the_title($tip->ID);?></option>
	                    <?php }
	                    ?>
                    </optgroup>
                <?Php } ?>
            </select>
		</div>
	</div>

	<div class="form-row">
		<div class="form-field">
			<label for="image-gallery"><?php _e('Bildergalerie', 'teilhabekultur');?></label>
			<div id="image-uploads" class="image-gallery-uploads flex space-between flex-wrap">
                <?php
                foreach($values['bildergalerie'] AS $image) {
                    include(dirname(__FILE__) . '/../includes/image_gallery_entry.tpl.php');
                }

                if(sizeof($values['bildergalerie']) < 3) {
                    $missingPlaceholders = 3 - sizeof($values['bildergalerie']);
                }

                for($i = 0; $i < $missingPlaceholders; $i++) {
                    $image = NULL;
	                include(dirname(__FILE__) . '/../includes/image_gallery_entry.tpl.php');
                }
                ?>
			</div>

            <div id="copyright-notices" class="margin-bottom-half">
                <?php
                    $galleryCount = 1;
                    foreach($values['gallerie_copyrights'] AS $copyrightNotice) { ?>
	                <?php
	                    include(dirname(__FILE__) . '/../includes/copyright_notice_input.tpl.php');
                        $galleryCount++;
                    }

                    $copyrightNotice = NULL;
                    for($i = 0; $i < $missingPlaceholders; $i++) {
	                    include(dirname(__FILE__) . '/../includes/copyright_notice_input.tpl.php');
	                    $galleryCount++;
                    }?>
            </div>

            <div class="add-more">
                <div id="image-gallery-upload-template" class="image-gallery-upload margin-bottom-half hidden" data-with-cropper="1" data-upload-url="<?php echo admin_url('admin-ajax.php?action=kulturvermittlung_upload_temp_image');?>">
                    <input name="file" type="file" />
                    <input type="hidden" name="" class="image-upload-hidden-field" value=""/>
                    <div class="preview-image">
                        <div class="dz-image">
                            <img src=""/>
                        </div>
                    </div>
                    <span class="remove"><img src="<?php echo $template_dir;?>/static/img/icons/remove_black.svg" alt="<?php _e('Bild entfernen','teilhabekultur'); ?>"/></span>
                </div>

                <div id="image-gallery-copyright-template" class="hidden">
                    <input id="copyright_bildergalerie_" type="text" name="" placeholder="<?php _e('Copyright-Hinweis Bild', 'kulturvermittlung');?> " value=""/>
                </div>

                <a id="add-gallery-input" href="#">
					<?php _e('weiteres Bild hinzufügen','kulturvermittlung');?>
                    <img src="<?php echo $template_dir;?>/static/img/icons/arrow_down.svg" alt="<?php _e('weiteres Bild hinzufügen','kulturvermittlung');?>" class="add-more-icon"/>
                </a>
            </div>
		</div>

        <div class="form-field">
            <label for="videos"><?php _e('Videos');?></label>
            <div class="hint margin-bottom"><?php _e('Bitte geben Sie Links zu Videos auf Vimeo oder YouTube an.','kulturvermittlung');?></div>
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
</div>