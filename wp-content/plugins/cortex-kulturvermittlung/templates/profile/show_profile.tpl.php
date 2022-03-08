<?php $template_dir = get_template_directory_uri(); ?>

<?php //Check if this profile is marked as favorite in the local browser storage ?>
<script type="text/javascript">
    jQuery(function(){
        Favorites.checkForFavorite();
    });
</script>

<div class="breadcrumb-navigation">
    <div class="grid-inner">
        <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('profile_overview'));?>"><img src="<?php echo $template_dir;?>/static/img/icons/arrow_left_white.svg" alt="<?php _e('Zurück', 'teilnahmekultur');?>"/> <?php _e('Zurück zur Übersicht');?></a>
    </div>
</div>

<?php if($_GET['message'] == 'success' || $_GET['message'] == 'created' || $_GET['message'] == 'offer_deactivated' || $_GET['message'] == 'success_cooperation') {?>
    <div class="grid-inner">
        <div class="message-box success" role="alert"><img class="success-icon" src="<?php echo $template_dir;?>/static/img/icons/icon-ja.svg" alt="<?php _e('Erfolgeich','teilhabekultur');?>"/>
			<?php if($_GET['message'] == 'success') {
				_e('Speichern erfolgreich', 'teilhabekultur');
			} else if($_GET['message'] == 'offer_deactivated') {
				_e('Angebot erfolgreich deaktiviert', 'teilhabekultur');
            } else if($_GET['message'] == 'success_cooperation') {
                _e('Kooperation erfolgreich bestätigt', 'teilhabekultur');
			} else{
				_e('Angebot erfolgreich angelegt', 'teilhabekultur');
			}?>
        </div>
    </div>
<?php } else if($_GET['message'] == 'offer_not_found') { ?>
    <div class="grid-inner">
        <div class="message-box error" role="alert"><img class="success-icon" src="<?php echo $template_dir;?>/static/img/icons/icon-nein.svg" alt="<?php _e('Fehler','teilhabekultur');?>"/>
			<?php if($_GET['message'] == 'offer_not_found') {
				_e('Das Angebot wurde nicht gefunden.', 'teilhabekultur');
			}?>
        </div>
    </div>
<?php } ?>

<div class="profile">
	<div class="grid-inner">
		<div class="profile-header">
			<div class="left-col">
                <div class="profile-image-container">
				    <div class="profile-image" style="background-image: url('<?php echo get_field('profilbild',$userIdACF)['sizes']['medium'];?>');"></div>
                    <?php if(!empty(get_field('copyright_profilbild', $userIdACF))) {?>
                        <div class="copyright-notice"><?php _e('Copyright:', 'teilhabekultur');?> <?php //echo esc_html(get_field('copyright_profilbild', $userIdACF));?></div>
                    <?php } ?>
                </div>
				<div class="sectors">
					<?php foreach(get_field('sparten', $userIdACF) AS $sector) { ?>
						<div class="sector <?php echo $sector;?>"><?php echo Cortex_Kulturvermittlung_Config::$sectors[$sector];?></div>
					<?php }?>
				</div>
			</div>
			<div class="right-col">
                <div class="fav-icon" data-id="<?php echo $userId; ?>" data-type="profile"><img class="not-selected" src="<?php echo $template_dir;?>/static/img/heart.svg" alt="<?php _e('Zu meinen Favoriten hinzufügen');?>"/><img class="selected" src="<?php echo $template_dir;?>/static/img/heart-selected.svg" alt="<?php _e('Aus meinen Favoriten entfernen');?>"/><img class="hover" src="<?php echo $template_dir;?>/static/img/heart-hover.svg" alt=""/></div>
				<?php if(isset($allowEdit) && $allowEdit) { ?>
                    <div class="edit-profile open-tooltip-menu" data-menu-id="profile-tooltip-menu"><img src="<?php echo $template_dir;?>/static/img/icons/edit_icon.svg" alt="<?php _e('Optionen anzeigen', 'teilhabekultur');?>"/>
                        <div id="profile-tooltip-menu" class="profile-edit-options tooltip-menu">
                            <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('edit_profile'));?>"><?php _e('Profil bearbeiten','teilhabekultur');?></a>
                            <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('change_email_password'));?>"><?php _e('E-Mail oder Passwort ändern','teilhabekultur');?></a>
                            <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('deactivate_profile'));?>"><?php _e('Profil stilllegen','teilhabekultur');?></a>
                        </div>
                    </div>
				<?php } ?>

                <div class="mobile-wrapper">
                    <div class="profile-image-mobile">
                        <div class="profile-image" style="background-image: url('<?php echo get_field('profilbild',$userIdACF)['sizes']['medium'];?>');"></div>
                        <?php if(!empty(get_field('copyright_profilbild', $userIdACF))) {?>
                            <div class="copyright-notice"><?php _e('Copyright:', 'teilhabekultur');?> <?php //echo esc_html(get_field('copyright_profilbild', $userIdACF));?></div>
                        <?php } ?>
                    </div>

                    <div class="profile-headings">
                        <h1 class="profile-name"><?php echo get_field('name_institution_kuenstlerin', $userIdACF);?></h1>
                        <h2 class="profile-profession"><?php echo get_field('untertitel', $userIdACF);?></h2>
                    </div>
                </div>

                <div class="sectors sectors-mobile">
					<?php foreach(get_field('sparten', $userIdACF) AS $sector) { ?>
                        <div class="sector <?php echo $sector;?>"><?php echo Cortex_Kulturvermittlung_Config::$sectors[$sector];?></div>
					<?php }?>
                </div>

				<div class="divider medium-margin-top small-margin-bottom"></div>
				<div class="profile-description">
					<?php echo wpautop(get_field('profilbeschreibung', $userIdACF));?>
				</div>
			</div>
		</div>

		<div class="profile-divider">
			<div class="left-col">
				<div class="divider small-margin-top medium-margin-bottom"></div>
			</div>

			<div class="right-col">
				<div class="divider small-margin-top medium-margin-bottom"></div>
			</div>
		</div>

		<div class="profile-contact-infos">
			<div class="left-col flex align-items-center">
				<?php if(!empty(get_field('facebook', $userIdACF)) || !empty(get_field('instagram', $userIdACF)) || !empty(get_field('twitter', $userIdACF)) || !empty(get_field('pintrest', $userIdACF))) {?>
					<div class="social-icons">
						<?php _e('Folge mir auf:','teilhabekultur');?>
						<?php if(!empty(get_field('facebook', $userIdACF))) {?>
							<a href="<?php echo get_field('facebook', $userIdACF);?>" target="_blank"><img src="<?php echo $template_dir;?>/static/img/social-icons/facebook_black.svg" class="social-icon" alt="<?php _e('Facebook','teilhabekultur');?>"></a>
						<?php } ?>
						<?php if(!empty(get_field('instagram', $userIdACF))) {?>
							<a href="<?php echo get_field('instagram', $userIdACF);?>" target="_blank"><img src="<?php echo $template_dir;?>/static/img/social-icons/instagram_black.svg" class="social-icon" alt="<?php _e('Instagram','teilhabekultur');?>"></a>
						<?php } ?>
						<?php if(!empty(get_field('twitter', $userIdACF))) {?>
							<a href="<?php echo get_field('twitter', $userIdACF);?>" target="_blank"><img src="<?php echo $template_dir;?>/static/img/social-icons/twitter_black.svg" class="social-icon" alt="<?php _e('Twitter','teilhabekultur');?>"></a>
						<?php } ?>
						<?php if(!empty(get_field('link_youtube_vimeo', $userIdACF))) {?>
							<a href="<?php echo get_field('link_youtube_vimeo', $userIdACF);?>" target="_blank"><img src="<?php echo $template_dir;?>/static/img/social-icons/youtube_black.svg" class="social-icon" alt="<?php _e('YouTube','teilhabekultur');?>"></a>
						<?php } ?>
						<?php if(!empty(get_field('pintrest', $userIdACF))) {?>
                            <a href="<?php echo get_field('pintrest', $userIdACF);?>" target="_blank"><img src="<?php echo $template_dir;?>/static/img/social-icons/pintrest_black.svg" class="social-icon" alt="<?php _e('Pintrest','teilhabekultur');?>"></a>
						<?php } ?>
						<?php if(!empty(get_field('tiktok', $userIdACF))) {?>
                            <a href="<?php echo get_field('tiktok', $userIdACF);?>" target="_blank"><img src="<?php echo $template_dir;?>/static/img/social-icons/tiktok_black.svg" class="social-icon" alt="<?php _e('TikTok','teilhabekultur');?>"></a>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
			<div class="right-col">
				<div class="infos">
					<div class="info-col">
						<div class="info-row"><div class="info-icon"><img src="<?php echo $template_dir;?>/static/img/icons/person.svg" alt="<?php _e('Name der Kontaktperson','teilhabekultur');?>"/></div>
                            <?php echo get_field('ansprechperson_1_vorname', $userIdACF);?> <?php echo get_field('ansprechperson_1_nachname', $userIdACF);?>
                            <?php if(!empty(get_field('ansprechperson_2_vorname', $userIdACF)) || !empty(get_field('ansprechperson_2_nachname', $userIdACF))) {?>
	                            <br/><?php echo get_field('ansprechperson_2_vorname', $userIdACF);?> <?php echo get_field('ansprechperson_2_nachname', $userIdACF);?>
                            <?php } ?>
							<?php if(!empty(get_field('ansprechperson_3_vorname', $userIdACF)) || !empty(get_field('ansprechperson_3_nachname', $userIdACF))) {?>
                                <br/><?php echo get_field('ansprechperson_3_vorname', $userIdACF);?> <?php echo get_field('ansprechperson_3_nachname', $userIdACF);?>
							<?php } ?>
                        </div>
						<div class="info-row"><div class="info-icon"><img class="phone" src="<?php echo $template_dir;?>/static/img/icons/phone.svg" alt="<?php _e('Telefonnummer der Kontaktperson','teilhabekultur');?>"/></div><?php echo get_field('telefon', $userIdACF);?></div>
					</div>

					<div class="info-col">
						<div class="info-row"><div class="info-icon"><img src="<?php echo $template_dir;?>/static/img/icons/location.svg" alt="<?php _e('Adresse','teilhabekultur');?>"/></div><?php echo get_field('strasse', $userIdACF);?> <?php echo get_field('hausnummer', $userIdACF);?> · <?php echo get_field('plz', $userIdACF);?> <?php echo get_field('ort', $userIdACF);?></div>
						<div class="info-row"><div class="info-icon"><img src="<?php echo $template_dir;?>/static/img/icons/letter.svg"  alt="<?php _e('E-Mailadresse der Kontaktperson','teilhabekultur');?>"/></div><a href="mailto:<?php echo antispambot($userInfo->user_email);?>"><?php echo antispambot($userInfo->user_email);?></a></div>
					</div>

					<div class="info-col">
						<div class="info-row empty">&nbsp;</div>
                        <?php if(!empty(get_field('link_webseite', $userIdACF))) {?>
						    <div class="info-row"><div class="info-icon"><img src="<?php echo $template_dir;?>/static/img/icons/world.svg" alt="<?php _e('Webseite','teilhabekultur');?>"/></div><a href="<?php echo get_field('link_webseite', $userIdACF);?>" target="_blank"><?php echo get_field('link_webseite', $userIdACF);?></a></div>
                        <?php } else { ?>
                            <div class="info-row empty">&nbsp;</div>
                        <?php } ?>
					</div>
				</div>
			</div>
		</div>

		<div class="divider small-margin-top"></div>

        <div class="profile-description-mobile">
            <?php echo wpautop(get_field('profilbeschreibung', $userIdACF));?>
        </div>

        <div class="full-width">
            <div class="details-box-heading"><?php _e('Diese Tools setze ich ein', 'teilnahmekultur');?></div>

            <?php
            $headings = array();
            $content = array();

            if(!empty(get_field('videokonferenzen', $userIdACF))) {
                $headings[] = translate('Videokonferenzen', 'teilhabekultur');
                $content[] = get_field('videokonferenzen', $userIdACF);
            }

            if(!empty(get_field('kommunikation', $userIdACF))) {
                $headings[] = translate('Kommunikation', 'teilhabekultur');
                $content[] = get_field('kommunikation', $userIdACF);
            }

            if(!empty(get_field('social_media', $userIdACF))) {
	            $headings[] = translate('Social Media', 'teilhabekultur');
	            $content[] = get_field('social_media', $userIdACF);
            }

            if(!empty(get_field('videoplattformen', $userIdACF))) {
	            $headings[] = translate('Videoplattformen', 'teilhabekultur');
	            $content[] = get_field('videoplattformen', $userIdACF);
            }

            if(!empty(get_field('soundplattformen', $userIdACF))) {
	            $headings[] = translate('Soundplattformen', 'teilhabekultur');
	            $content[] = get_field('soundplattformen', $userIdACF);
            }

            if(!empty(get_field('gemeinsames_arbeiten', $userIdACF))) {
	            $headings[] = translate('Gemeinsames Arbeiten', 'teilhabekultur');
	            $content[] = get_field('gemeinsames_arbeiten', $userIdACF);
            }

            if(!empty(get_field('technische_ausstattung', $userIdACF))) {
	            $headings[] = translate('Technische Ausstattung', 'teilhabekultur');
	            $content[] = get_field('technische_ausstattung', $userIdACF);
            }

            if(!empty(get_field('sonstiges', $userIdACF))) {
	            $headings[] = translate('Sonstiges', 'teilhabekultur');
	            $content[] = get_field('sonstiges', $userIdACF);
            }

            ?>

            <div class="details-box">
                <?php foreach($headings AS $key => $heading) {?>
                    <?php if($key == 0 || $key % 2 == 0) {?>
                        <div class="detail-row two-cols">
                    <?php } ?>
                            <div class="col">
                                <div class="col-heading"><div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-plattformen.svg" alt=""/></div><?php echo $heading; ?>:</div>
                                <p><?php echo nl2br($content[$key]);?></p>
                            </div>
                    <?php if($key % 2 != 0){?>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if(sizeof($headings) % 2 != 0) {?> </div> <?php } ?>

                <div class="detail-row">
                    <div class="icon-title"><?php _e('Videokonferenz möglich', 'teilhabekultur');?></div>
                    <div class="icon">
                        <?php if(get_field('videokonferenzen_moeglich', $userIdACF)) {?>
                            <img src="<?php echo $template_dir;?>/static/img/icons/icon-ja.svg"/>
                        <?php } else { ?>
                            <img src="<?php echo $template_dir;?>/static/img/icons/icon-nein.svg"/>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>


		<?php if(have_rows('bildergalerie', $userIdACF)) {?>
			<div class="image-gallery-row">
				<h2><?php _e('Bildergalerie','teilhabekultur');?></h2>
				<div class="carousel-container" data-slide-count="3">

					<div class="controls">
						<button class="prev"></button>
						<button class="next"></button>
					</div>


					<div class="carousel image-gallery <?php if(is_array(get_field('bildergalerie', $offerId)) && sizeof(get_field('bildergalerie', $offerId)) == 1) {?>single<?php }?>">
						<?php while(have_rows('bildergalerie', $userIdACF)) { the_row();?>
                            <a class="item" href="<?php echo get_sub_field('bild')['sizes']['large'];?>"><div class="image-outer-container"><div class="image-container" data-copyright="<?php echo get_sub_field('copyright');?>" style="background-image: url('<?php echo get_sub_field('bild')['sizes']['medium'];?>');"></div></div></a>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if(have_rows('videolinks', $userIdACF)) {?>
			<div class="video-gallery-row">
				<h2><?php _e('Videos','teilhabekultur');?></h2>
				<div class="carousel-container" data-slide-count="3">

					<div class="controls">
						<button class="prev"></button>
						<button class="next"></button>
					</div>

					<div class="carousel video-gallery">
						<?php while(have_rows('videolinks', $userIdACF)) { the_row();?>
							<div class="item">
                                <a target="_blank" href="<?php echo get_sub_field('videolink');?>" class="video-container" style="background-image: url('<?php echo Cortex_Kulturvermittlung_Utils::getVideoThumbnail(get_sub_field('videolink'));?>');">
                                    <div class="play-button"><img src="<?php echo $template_dir;?>/static/img/icons/play_button.svg" alt="<?php echo _e('Abspielen','teilhabekultur');?>"/></div>
                                    <?php if(!empty(get_sub_field('titel'))) {?>
                                        <div class="video-title"><?php echo get_sub_field('titel');?></div>
                                    <?php } ?>
                                </a>
                            </div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>

        <?php
            //only get the accepted cooperations
            $acceptedCooperations = Cortex_Kulturvermittlung_Profiles::getCooperationProfiles($userId);
         ?>

        <?php if(sizeof($acceptedCooperations) > 0 || have_rows('kooperationsprofile_extern', $userIdACF)) {?>
            <div class="profile-row">
                <h2><?php _e('Kooperationen (Zusammenarbeit mit)','teilhabekultur');?></h2>
                <?php $profiles = Cortex_Kulturvermittlung_Profiles::getFilteredProfiles(array($userId),array(), '' , 2); ?>
                <div class="carousel-container" data-slide-count="3">
                    <div class="controls">
                        <button class="prev"></button>
                        <button class="next"></button>
                    </div>

                    <div class="carousel profiles">
                        <?php foreach($acceptedCooperations AS $cooperationProfileId) {?>
                            <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('profile'));?>?profileId=<?php echo $cooperationProfileId;?>" class="profile-tile">
                                <div class="profile-tile-inner">
                                    <div class="profile-image" style="background-image: url('<?php echo get_field('profilbild','user_' . $cooperationProfileId)['sizes']['medium'];?>');">
                                        <div class="fav-heart"></div>
                                    </div>
                                    <div class="profile-infos">
                                        <div class="name"><?php echo get_field('name_institution_kuenstlerin', 'user_' . $cooperationProfileId);?></div>
                                        <div class="sector">
                                            <div class="info"><img src="<?php echo $template_dir;?>/static/img/icons/info.svg" alt="<?php _e('Informationen anzeigen','teilhabekultur');?>" /></div>
                                            <?php
                                            $first = true;
                                            foreach(get_field('sparten','user_' . $cooperationProfileId) as $sector) {
                                                if(!$first) {
                                                    echo ', ';
                                                }
                                                echo Cortex_Kulturvermittlung_Config::$sectors[$sector];
                                                $first = false;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                        <?php  if(have_rows('kooperationsprofile_extern', $userIdACF)) {
                            while(have_rows('kooperationsprofile_extern', $userIdACF)) { the_row();
                            if(!empty(get_sub_field('name'))) {?>
                                <a href="<?php the_sub_field('webseite');?>" class="profile-tile tns-item tns-slide-active" id="tns1-item1">
                                    <div class="profile-tile-inner">
                                        <div class="profile-image external" style="background-image: url('<?php echo $template_dir;?>/static/img/external_partner.jpg');">
                                            <span class="external-partner"><?php _e('Auswärtige Partner*innen','teilhabekultur');?></span>
                                        </div>
                                        <div class="profile-infos">
                                            <div class="name"><?php the_sub_field('name');?></div>
                                            <?php if(!empty(get_sub_field('beschreibung'))) {?>
                                                <div class="description">
                                                    <?php the_sub_field('beschreibung'); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
        <?php } ?>

		<div class="offer-row">
			<h2><?php _e('Angebote','teilhabekultur');?></h2>

            <?php
                $onlyFutureEvents = true;

                if(isset($allowEdit) && $allowEdit) {
                    $onlyFutureEvents = false;
                }
            $offers = Cortex_Kulturvermittlung_Offers::getOffersOfProfile($userId, array(get_the_ID()), NULL, false, $onlyFutureEvents, true);
            if(sizeof($offers) > 0) {?>
                <div class="carousel-container" data-slide-count="2">
                    <div class="controls">
                        <button class="prev"></button>
                        <button class="next"></button>
                    </div>

                    <div class="carousel offers">
	                    <?php
	                    foreach($offers as $offer) {
		                    $offerId = $offer->ID;
		                    include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/tiles/offer_tile.tpl.php');
	                    }
	                    ?>
                    </div>
                </div>
            <?php } else { ?>
                <?php _e('Im Moment sind von diesem/dieser Kulturschaffenden keine Angebote eingestellt.', 'teilhabekultur');?>
            <?php } ?>

			<?php if(isset($allowEdit) && $allowEdit) { ?>
                <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('edit_offer'));?>" class="enter-tipp enter-new margin-top">
                    <img class="new-icon" src="<?php echo $template_dir;?>/static/img/icons/edit_icon.svg" alt="<?php _e('Neues Angebot erstellen', 'teilhabekultur');?>"/><?php _e('Neues Angebot erstellen', 'teilhabekultur');?>
                </a>
			<?php } ?>
		</div>

		<div class="profile-row">
			<h2><?php _e('Ähnliche Profile entdecken','teilhabekultur');?></h2>

			<?php
			$profiles = Cortex_Kulturvermittlung_Profiles::getFilteredProfiles(array($userId));
			if(!empty($profiles)) {
			?>
                <div class="carousel-container" data-slide-count="3">
                    <div class="controls">
                        <button class="prev"></button>
                        <button class="next"></button>
                    </div>

                    <div class="carousel profiles">
                        <?php foreach($profiles AS $profile) {?>
                            <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('profile'));?>?profileId=<?php echo $profile->ID;?>" class="profile-tile">
                                <div class="profile-tile-inner">
                                    <div class="profile-image" style="background-image: url('<?php echo get_field('profilbild','user_' . $profile->ID)['sizes']['medium'];?>');">
                                        <div class="fav-heart"></div>
                                    </div>
                                    <div class="profile-infos">
                                        <div class="name"><?php echo get_field('name_institution_kuenstlerin', 'user_' . $profile->ID);?></div>
                                        <div class="sector">
                                            <div class="info"><img src="<?php echo $template_dir;?>/static/img/icons/info.svg" alt="<?php _e('Informationen anzeigen','teilhabekultur');?>" /></div>
                                            <?php
                                                $first = true;
                                                foreach(get_field('sparten','user_' . $profile->ID) as $sector) {
                                                    if(!$first) {
                                                        echo ', ';
                                                    }
                                                    echo Cortex_Kulturvermittlung_Config::$sectors[$sector];
                                                    $first = false;
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
                Leider gibt es keine weiteren ähnlichen Profile.
            <?php } ?>
		</div>
	</div>
</div>