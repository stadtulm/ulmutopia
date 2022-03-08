<?php
$template_dir = get_template_directory_uri();

if(isset($allowEdit) && $allowEdit) {
	$profileLink = get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile'));
} else {
	$profileLink = Cortex_Kulturvermittlung_Profiles::generateProfileLink(get_the_author_meta('ID'));
}

if(isset($_GET['preview']) && $_GET['preview'] == 'true') {
    $preview = true;
} else {
    $preview = false;
}

//In a further version this link could be different if you reached the page via an profil or the offer overview page. for now just go back to the overview
$backLink = get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('offer_overview'));
?>

<?php //Check if this offer is marked as favorite in the local browser storage ?>
<script type="text/javascript">
    jQuery(function(){
        Favorites.checkForFavorite();
    });
</script>


<div class="breadcrumb-navigation">
    <div class="grid-inner">
        <a href="<?php echo $backLink;?>"><img src="<?php echo $template_dir;?>/static/img/icons/arrow_left_white.svg" alt="<?php _e('Zurück', 'teilnahmekultur');?>"/> <?php _e('Zurück zur Übersicht');?></a>
    </div>
</div>

<?php if(!empty($_GET['message']) && ($_GET['message'] == 'success' || $_GET['message'] == 'created' || $_GET['message'] == 'offer_activated')) {?>
    <div class="grid-inner">
        <div class="message-box success" role="alert"><img class="success-icon" src="<?php echo $template_dir;?>/static/img/icons/icon-ja.svg" alt="<?php _e('Erfolgeich','teilhabekultur');?>"/>
            <?php if($_GET['message'] == 'success') {
                _e('Speichern erfolgreich', 'teilhabekultur');
            } else if($_GET['message'] == 'offer_activated') {
	            _e('Angebot erfolgreich aktiviert', 'teilhabekultur');
            } else {
	            _e('Angebot erfolgreich angelegt', 'teilhabekultur');
            } ?>
        </div>
    </div>
<?php } else if(!empty($_GET['message']) && $_GET['message'] == 'not_allowed') {?>
    <div class="grid-inner">
        <div class="message-box error" role="alert"><img class="success-icon" src="<?php echo $template_dir;?>/static/img/icons/icon-nein.svg" alt="<?php _e('Fehler','teilhabekultur');?>"/>
			<?php if($_GET['message'] == 'not_allowed') {
				_e('Du hast nicht die erforderliche Berechtigung für diese Aktion.', 'teilhabekultur');
			}?>
        </div>
    </div>
<?php } ?>

<div class="offer">
	<div class="grid-inner">
		<div class="left-col">
            <div class="main-image-container">
			    <img class="main-image margin-bottom-half" src="<?php echo get_field('bild',$offerId)['sizes']['medium'];?>" alt="<?php echo get_the_title($offerId);?>"/>
	            <?php if(!empty(get_field('copyright_bild', $offerId))) {?>
                    <div class="copyright-notice"><?php _e('Copyright:', 'teilhabekultur');?> <?php echo get_field('copyright_bild', $offerId);?></div>
	            <?php } ?>
            </div>

			<div class="sectors">
				<?php foreach(get_field('sparten', $offerId) AS $sector) { ?>
					<div class="sector <?php echo $sector;?>"><?php echo Cortex_Kulturvermittlung_Config::$sectors[$sector];?></div>
				<?php }?>
			</div>

			<h2 class="no-margin-bottom"><?php _e('Details', 'teilhabekultur');?></h2>
			<?php if(have_rows('themen', $offerId)) { ?>
				<div class="margin-bottom-half">
					<strong><?php _e('Die Themen', 'teilhabekultur');?></strong>
					<ul>
						<?php foreach(get_field('themen', $offerId) AS $thema) {?>
							<li><?php echo $thema['thema'];?></li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>

			<?php if(get_field('anzahl_von_projekteinheitenmodulen', $offerId)) { ?>
				<div class="margin-bottom">
					<strong><?php _e('Ablauf', 'teilhabekultur');?></strong><br/>
					<?php echo nl2br(get_field('anzahl_von_projekteinheitenmodulen', $offerId));?>
				</div>
			<?php }?>

            <div class="downloads margin-bottom">
                <?php if(have_rows('downloads', $offerId)) {?>
                    <strong><?php _e('Downloads', 'teilhabekultur');?></strong><br/>
                    <ul>
                        <?php while(have_rows('downloads', $offerId)) { the_row(); ?>
                            <li><a href="<?php echo get_sub_field('datei')['url'];?>" target="_blank"><?php echo get_sub_field('datei')['filename'];?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
		</div>

		<div class="right-col">
            <?php if(!$preview) {?>
                <div class="fav-icon" data-id="<?php echo $offerId; ?>" data-type="offer"><img class="not-selected" src="<?php echo $template_dir;?>/static/img/heart.svg" alt="<?php _e('Zu meinen Favoriten hinzufügen');?>"/><img class="selected" src="<?php echo $template_dir;?>/static/img/heart-selected.svg" alt="<?php _e('Aus meinen Favoriten entfernen');?>"/><img class="hover" src="<?php echo $template_dir;?>/static/img/heart-hover.svg" alt=""/></div>
                <?php if(isset($allowEdit) && $allowEdit) { ?>
                    <div class="edit-offer open-tooltip-menu" data-menu-id="offer-tooltip-menu"><img src="<?php echo $template_dir;?>/static/img/icons/edit_icon.svg" alt="<?php _e('Optionen anzeigen', 'teilhabekultur');?>"/>
                        <div id="offer-tooltip-menu" class="offer-edit-options tooltip-menu">
                            <a href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('edit_offer'));?>?offerId=<?php echo get_the_ID();?>"><?php _e('Angebot bearbeiten','teilhabekultur');?></a>
                            <a href="<?php echo admin_url('admin-post.php');?>?action=kulturvermittlung_deactive_offer&offerId=<?php echo get_the_ID();?>"><?php _e('Angebot stilllegen','teilhabekultur');?></a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="preview-notice"><?php _e('Vorschau', 'teilhabekultur');?></div>
            <?php } ?>

            <div class="main-image-mobile">
                <img class="main-image margin-bottom-half" src="<?php echo get_field('bild',$offerId)['sizes']['medium'];?>" alt="<?php echo get_the_title($offerId);?>"/>
				<?php if(!empty(get_field('copyright_bild', $offerId))) {?>
                    <div class="copyright-notice"><?php _e('Copyright:', 'teilhabekultur');?> <?php echo get_field('copyright_bild', $offerId);?></div>
				<?php } ?>
            </div>

			<h1><?php echo get_the_title($offerId);?></h1>
            <div class="profile-link"><?php _e('Ein Angebot von', 'teilhabekultur');?> <a href="<?php echo $profileLink;?>" target="_blank"><?php echo get_field('name_institution_kuenstlerin', 'user_' . get_the_author_meta('ID'));?></a></div>
            <?php
                if(!empty(get_field('kooperationsprofile', $offerId))) { $firstCooperation = true; ?>
                    <div class="cooperation-partners profile-link"><?php _e('In Zusammenarbeit mit', 'teilhabekultur');?>
                        <?php while(have_rows('kooperationsprofile', $offerId)) { the_row();?>
                            <?php if(!$firstCooperation) {?>, <?php }?><a href="<?php echo Cortex_Kulturvermittlung_Profiles::generateProfileLink(get_sub_field('profil'));?>" target="_blank"><?php echo get_field('name_institution_kuenstlerin', 'user_' . get_sub_field('profil'));?></a>
                        <?php $firstCooperation = false; } ?>
                    </div>
                <?php }
            ?>

            <div class="sectors sectors-mobile">
				<?php foreach(get_field('sparten', $offerId) AS $sector) { ?>
                    <div class="sector <?php echo $sector;?>"><?php echo Cortex_Kulturvermittlung_Config::$sectors[$sector];?></div>
				<?php }?>
            </div>

            <div class="divider medium-margin-top medium-margin-bottom"></div>
			<div class="description margin-bottom">
				<?php echo nl2br(get_field('beschreibung', $offerId));?>
			</div>

			<div class="infos">
				<div class="info">
                    <div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-dauer.svg" alt=""/></div><strong><?php _e('Dauer', 'teilhabekultur');?>:</strong> <?php echo get_field('dauer', $offerId);?>
				</div>
				<?php if(!empty(get_field('dauer_vor-_und_nachbereitung', $offerId))) {?>
					<div class="info">
                        <div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-dauer.svg" alt=""/></div><strong><?php _e('Dauer der Vor- und Nachbereitung für Teilnehmende', 'teilhabekultur');?>:</strong> <?php echo get_field('dauer_vor-_und_nachbereitung', $offerId);?>
					</div>
				<?php } ?>

				<div class="info">
					<div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-termine.svg" alt=""/></div><strong><?php _e('Terminmöglichkeiten', 'teilhabekultur');?>:</strong>
					<?php if(get_field('art_der_termine', $offerId) == 'nach_absprache') {?>
						<?php _e('Nach Absprache', 'teilhabekultur');?>
					<?php } else if(get_field('art_der_termine') == 'freie_eingabe') {?>
						<?php echo get_field('freitext_termin', $offerId);?>
					<?php } else if(get_field('art_der_termine') == 'fester_termin') {
                        $festerTermin = get_field('fester_termin', $offerId);
						$festerTerminDate = date_create_from_format('Y-m-d H:i', $festerTermin);

						echo $festerTerminDate->format('d.m.Y H:i');?> <?php _e('Uhr', 'teilhabekultur');?>
					<?php } ?>
				</div>
				<div class="info">
                    <div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-alter.svg" alt=""/></div><strong><?php _e('Geeignetes Alter', 'teilhabekultur');?>:</strong> <?php echo get_field('zielgruppe_von', $offerId);?> - <?php echo get_field('zielgruppe_bis', $offerId);?> <?php _e('Jahre', 'teilhabekultur');?>
				</div>
				<div class="info">
                    <div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-kosten.svg" alt=""/></div><strong><?php _e('Kosten', 'teilhabekultur');?>:</strong> <?php echo get_field('preis', $offerId);?>
				</div>
				<div class="info">
                    <div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-kosten.svg" alt=""/></div><strong><?php _e('Abrechnungsform', 'teilhabekultur');?>:</strong> <?php echo get_field('abrechnungsform', $offerId);?>
				</div>
				<div class="info">
                    <div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-ansprechpartner.svg" alt=""/></div><strong><?php _e('Ansprechperson', 'teilhabekultur');?>:</strong> <?php echo get_field('kontakt', $offerId);?>
				</div>
			</div>

			<div class="details-box-heading"><?php _e('Angebots-Checkliste', 'teilnahmekultur');?></div>
			<div class="details-box">
				<div class="detail-row two-cols">
					<div class="col">
						<div class="col-heading"><div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-tools.svg" alt=""/></div><?php _e('Dieses Angebot benötigt', 'teilhabekultur');?>:</div>
                        <?php if(!empty(get_field('benotigte_materialien', $offerId))) {?>
						    <p>
                                <strong><?php _e('Benötigte Materialien, Technik und Computersysteme:', 'teilhabekultur');?></strong><br/>
                                <?php echo nl2br(get_field('benotigte_materialien', $offerId));?>
                            </p>
                        <?php } ?>

						<?php if(!empty(get_field('benotigte_raumlichkeiten', $offerId))) {?>
						    <p>
                                <strong><?php _e('Benötigte Räumlichkeiten für Teilnehmer*Innen:', 'teilhabekultur');?></strong><br/>
                                <?php echo nl2br(get_field('benotigte_raumlichkeiten', $offerId));?>
                            </p>
                        <?php } ?>

						<?php if(!empty(get_field('technik', $offerId))) {?>
                            <strong><?php _e('Technik, die vom Anbietenden gestellt werden kann:', 'teilhabekultur');?></strong><br/>
						    <p><?php echo nl2br(get_field('technik', $offerId));?></p>
                        <?php } ?>
					</div>

					<div class="col">
						<div class="col-heading"><div class="icon"><img src="<?php echo $template_dir;?>/static/img/icons/icon-plattformen.svg" alt=""/></div><?php _e('Digitale Plattformen', 'teilhabekultur');?>:</div>
						<?php if(!empty(get_field('videokonferenzen', $offerId)) ||
                                 !empty(get_field('kommunikation', $offerId)) ||
                                 !empty(get_field('social_media', $offerId)) ||
                                 !empty(get_field('videoplattformen', $offerId)) ||
                                 !empty(get_field('soundplattformen', $offerId)) ||
                                 !empty(get_field('gemeinsames_arbeiten', $offerId)) ||
                                 !empty(get_field('avvrxr', $offerId)) ||
                                 !empty(get_field('sonstiges', $offerId))) {?>
                            <ul>
                                <?php if(!empty(get_field('videokonferenzen', $offerId))){?><li><?php echo get_field('videokonferenzen', $offerId);?></li><?php }?>
                                <?php if(!empty(get_field('kommunikation', $offerId))){?><li><?php echo get_field('kommunikation', $offerId);?></li><?php }?>
                                <?php if(!empty(get_field('social_media', $offerId))){?><li><?php echo get_field('social_media', $offerId);?></li><?php }?>
                                <?php if(!empty(get_field('videoplattformen', $offerId))){?><li><?php echo get_field('videoplattformen', $offerId);?></li><?php }?>
                                <?php if(!empty(get_field('soundplattformen', $offerId))){?><li><?php echo get_field('soundplattformen', $offerId);?></li><?php }?>
                                <?php if(!empty(get_field('gemeinsames_arbeiten', $offerId))){?><li><?php echo get_field('gemeinsames_arbeiten', $offerId);?></li><?php }?>
                                <?php if(!empty(get_field('avvrxr', $offerId))){?><li><?php echo get_field('avvrxr', $offerId);?></li><?php }?>
                                <?php if(!empty(get_field('sonstiges', $offerId))){?><li><?php echo get_field('sonstiges', $offerId);?></li><?php }?>
                            </ul>
                        <?php } ?>
					</div>
				</div>

                <?php if(get_field('padagogische_unterstutzung_notwendig', $offerId)) {?>
    				<div class="detail-row">
                        <div class="icon-title"><?php _e('Pädagogische Unterstützung gewünscht', 'teilhabekultur');?></div>
                        <div class="icon">
                            <img src="<?php echo $template_dir;?>/static/img/icons/icon-ja.svg"/>
                        </div>

                        <div class="text">
                            <?php echo get_field('padagogische_unterstutzung_freitext', $offerId);?>
                        </div>
				    </div>
                <?php } ?>

				<?php if(get_field('individuelle_projektanpassung_moglich', $offerId)) {?>
                    <div class="detail-row">
                        <div class="icon-title"><?php _e('Individuelle Projektanpassung möglich', 'teilhabekultur');?></div>
                        <div class="icon">
                                <img src="<?php echo $template_dir;?>/static/img/icons/icon-ja.svg"/>
                        </div>
                    </div>
				<?php } ?>
			</div>
		</div>
	</div>

	<?php the_widget('Contact_Row_Widget', array('caption' => translate('Kontakt zur Ansprechperson aufnehmen', 'teilhabekultur'), 'email' => get_field('kontakt_emailadresse', $offerId)));?>

    <div class="grid-inner margin-top">
	    <?php if(have_rows('bildergalerie', $offerId)) {?>
            <div class="image-gallery-row">
                <h2><?php _e('Bildergalerie','teilhabekultur');?></h2>
                <div class="carousel-container" data-slide-count="3">

                    <div class="controls">
                        <button class="prev"></button>
                        <button class="next"></button>
                    </div>

                    <div class="carousel image-gallery <?php if(is_array(get_field('bildergalerie', $offerId)) && sizeof(get_field('bildergalerie', $offerId)) == 1) {?>single<?php }?>">
					    <?php while(have_rows('bildergalerie', $offerId)) { the_row();?>
                            <a class="item" href="<?php echo get_sub_field('bild')['sizes']['large'];?>"><div class="image-outer-container"><div class="image-container" data-copyright="<?php echo get_sub_field('copyright');?>" style="background-image: url('<?php echo get_sub_field('bild')['sizes']['medium'];?>');"></div></div></a>
					    <?php } ?>
                    </div>
                </div>
            </div>
	    <?php } ?>

	    <?php if(have_rows('videolinks', $offerId)) {?>
            <div class="video-gallery-row">
                <h2><?php _e('Videos','teilhabekultur');?></h2>
                <div class="carousel-container" data-slide-count="3">

                    <div class="controls">
                        <button class="prev"></button>
                        <button class="next"></button>
                    </div>

                    <div class="carousel video-gallery">
					    <?php while(have_rows('videolinks', $offerId)) { the_row();?>
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

	    <?php if(have_rows('tipps', $offerId)) {?>
            <div class="tipps-row">
                <h2><?php _e('Tipps für dieses Angebot','teilhabekultur');?></h2>
                <div class="carousel-container" data-slide-count="2">

                    <div class="controls">
                        <button class="prev"></button>
                        <button class="next"></button>
                    </div>

                    <div class="carousel video-gallery">
					    <?php while(have_rows('tipps', $offerId)) { the_row();
							    $tip = get_sub_field('tipp');
							    $tipId = $tip->ID;
							    include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/tiles/tip_tile.tpl.php');
					    } ?>
                    </div>
                </div>
            </div>
        <?php }?>

        <div class="offer-row">
            <h2><?php _e('Weitere Angebote dieses Kulturschaffenden','teilhabekultur');?></h2>
            <?php
                $onlyFutureEvents = true;
                if (isset($allowEdit) && $allowEdit) {
                    $onlyFutureEvents = false;
                }
            $offers = Cortex_Kulturvermittlung_Offers::getOffersOfProfile(get_the_author_meta('ID'), array(get_the_ID()), NULL, false, $onlyFutureEvents, true);

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
		        <?php _e('Im Moment sind von diesem/dieser Kulturschaffenden keine weiteren Angebote eingestellt.', 'teilhabekultur');?>
	        <?php } ?>

        </div>
    </div>
</div>