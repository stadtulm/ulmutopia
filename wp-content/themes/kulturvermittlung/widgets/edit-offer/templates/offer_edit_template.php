<?php
$offerId = NULL;


if(!empty($_GET['offerId'])) {
	$offerId = intval($_GET['offerId']);
} ?>

<?php
if(!empty($offerId)) {
    $authorId = get_post_field ('post_author', $offerId);

    //The user is not allowed to edit this offer
    if($authorId != get_current_user_id()) {
        include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/includes/unauthorized.tpl.php');
    }

    $values['titel'] = get_the_title($offerId);
    $values['beschreibung'] = get_field('beschreibung', $offerId);
	$values['sparten'] = get_field('sparten', $offerId);
	$values['ansprechpartner'] = get_field('kontakt', $offerId);
	$values['ansprechpartner_email'] = get_field('kontakt_emailadresse', $offerId);
	$values['main_image'] = get_field('bild', $offerId)['ID'];
	$values['copyright_bild'] = get_field('copyright_bild',$offerId);
	$values['dauer'] = get_field('dauer', $offerId);
	$values['dauer_vor-_und_nachbereitung'] = get_field('dauer_vor-_und_nachbereitung', $offerId);
	$values['art_der_termine'] = get_field('art_der_termine', $offerId);
	$values['freitext_termin'] = get_field('freitext_termin', $offerId);

	$values['fester_termin'] = get_field('fester_termin', $offerId);
	$values['anzahl_von_projekteinheitenmodulen'] = get_field('anzahl_von_projekteinheitenmodulen', $offerId);
	$values['zielgruppe_von'] = get_field('zielgruppe_von', $offerId);
	$values['zielgruppe_bis'] = get_field('zielgruppe_bis', $offerId);
	$values['preis'] = get_field('preis', $offerId);
	$values['abrechnungsform'] = get_field('abrechnungsform', $offerId);

	$themen = array();
	$themenFieldArray = get_field('themen', $offerId);
	$i = 1;
	foreach($themenFieldArray AS $thema) {
	    $themen[$i] = $thema['thema'];
	    $i++;
    }
	$values['themen'] = $themen;

	$values['benotigte_materialien'] = get_field('benotigte_materialien', $offerId);
	$values['benotigte_raumlichkeiten'] = get_field('benotigte_raumlichkeiten', $offerId);
	$values['technik'] = get_field('technik', $offerId);
	$values['padagogische_unterstutzung_notwendig'] = get_field('padagogische_unterstutzung_notwendig', $offerId);
	$values['padagogische_unterstutzung_freitext'] = get_field('padagogische_unterstutzung_freitext', $offerId);
	$values['individuelle_projektanpassung_moglich'] = get_field('individuelle_projektanpassung_moglich', $offerId);

	$values['videokonferenzen'] = get_field('videokonferenzen', $offerId);
	$values['gemeinsames_arbeiten'] = get_field('gemeinsames_arbeiten', $offerId);
	$values['kommunikation'] = get_field('kommunikation', $offerId);
	$values['sonstiges'] = get_field('sonstiges', $offerId);
	$values['social_media'] = get_field('social_media', $offerId);
	$values['avvrxr'] = get_field('avvrxr', $offerId);
	$values['videoplattformen'] = get_field('videoplattformen', $offerId);
	$values['soundplattformen'] = get_field('soundplattformen', $offerId);
	$values['sonstiges'] = get_field('sonstiges', $offerId);

	$values['downloads'] = get_field('downloads', $offerId);

	$values['bildergalerie'] = array();
	$values['gallerie_copyrights'] = array();

	$imageGallery = get_field('bildergalerie', $offerId);
	if(is_array($imageGallery)) {
		foreach($imageGallery as $image) {
			$values['bildergalerie'][] = $image['bild']['ID'];
			$values['gallerie_copyrights'][] = $image['copyright'];
		}
	}

	$videos = get_field('videolinks', $offerId);
	$videoURLs = array();
	$videoTitles = array();
	foreach($videos AS $video) {
		$videoURLs[] = $video['videolink'];
		$videoTitles[] =  $video['titel'];
	}

	$values['videos'] = $videoURLs;
	$values['videoTitles'] = $videoTitles;

	$tipps = array();
	foreach(get_field('tipps', $offerId) AS $tip) {
	    $tipps[] = $tip['tipp']->ID;
    }
	$values['tipps'] = $tipps;

    $kooperationsprofile = array();
    foreach(get_field('kooperationsprofile', $offerId) AS $cooperationProfile) {
        $kooperationsprofile[] = $cooperationProfile['profil'];
    }
    print_r($kooperationsprofile);
    $values['kooperationsprofile'] = $kooperationsprofile;
}

?>

<script>
    jQuery(function(){
        Forms.initOfferForm();
    });
</script>

<div class="grid-inner">
	<h1>
        <?php if(!empty($offerId)) { ?>
	        <?php _e('<strong>Angebot</strong> bearbeiten', 'teilhabekultur');?>
        <?php } else {?>
            <?php _e('<strong>Angebot</strong> erstellen', 'teilhabekultur');?>
        <?php }  ?>
    </h1>
	<form class="full-width" action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST" enctype="multipart/form-data" id="offer-form">
        <input type="hidden" name="offerId" value="<?php if(!empty($offerId)) { echo $offerId; } ?>"/>
        <input name="action" type="hidden" value="kulturvermittlung_save_offer"/>
		<input name="kulturvermittlung_action" type="hidden" value="edit_offer"/>
		<?php wp_nonce_field( 'kulturvermittlung_edit_offer'); ?>

		<?php include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/offer/edit_offer_form.tpl.php');?>

        <div class="error-messages">
            <div class="error-message copyright-image-gallery"><?php _e('Bitte gib für alle Bider der Bildergalerie einen Copyright-Hinweis an.', 'teilhabekultur');?></div>
        </div>

		<div class="margin-top margin-bottom">
			<input type="submit" value="<?php if(!empty($offerId)) { _e('Angebot speichern', 'teilhabekultur'); } else { _e('Angebot erstellen', 'teilhabekultur'); }?>">
            <?php if(empty($offerId)) {?>
                <a href="#" class="button-link" id="generate-preview-for-offer"><?php _e('Vorschau in neuem Fenster öffnen', 'teilhabekultur');?></a>
            <?php } ?>

            <div id="preview-offer-loader" class="lds-loader hidden"><div></div><div></div><div></div></div>
		</div>

	</form>
</div>