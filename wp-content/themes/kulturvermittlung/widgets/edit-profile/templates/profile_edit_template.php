<?php
$userId = NULL;
$user = wp_get_current_user();
if(!empty($user)){
    if(in_array('artist', (array) $user->roles)){
        $userId = get_current_user_id();
    }
}


if(empty($userId)) {
	include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/includes/login_needed.tpl.php');
} else {
    $userInfo  = get_userdata($userId);
    $userACF = 'user_' . get_current_user_id();
    $values = array();
    $values['name_institution_kuenstlerin'] = get_field('name_institution_kuenstlerin', $userACF);
	$values['untertitel'] = get_field('untertitel', $userACF);
    $values['ansprechperson_1_vorname'] = get_field('ansprechperson_1_vorname', $userACF);
    $values['ansprechperson_1_nachname'] = get_field('ansprechperson_1_nachname', $userACF);
    $values['ansprechperson_2_vorname'] = get_field('ansprechperson_2_vorname', $userACF);
    $values['ansprechperson_2_nachname'] = get_field('ansprechperson_2_nachname', $userACF);
    $values['ansprechperson_3_vorname'] = get_field('ansprechperson_3_vorname', $userACF);
    $values['ansprechperson_3_nachname'] = get_field('ansprechperson_3_nachname', $userACF);
    $values['strasse'] = get_field('strasse', $userACF);
    $values['hausnummer'] = get_field('hausnummer', $userACF);
    $values['plz'] = get_field('plz', $userACF);
    $values['ort'] = get_field('ort', $userACF);
    $values['telefon'] = get_field('telefon', $userACF);
    $values['fax'] = get_field('fax', $userACF);
    $values['email'] = $userInfo->user_email;
    $values['sparten'] = get_field('sparten', $userACF);
	$values['zielgruppe_von'] = get_field('zielgruppe_von', $userACF);
	$values['zielgruppe_bis'] = get_field('zielgruppe_bis', $userACF);

    $imageGallery = get_field('bildergalerie', $userACF);
    if(is_array($imageGallery)) {
        $i = 1;
        foreach($imageGallery as $image) {
            $values['image_gallery_image_' . $i] = $image['bild']['ID'];
	        $values['copyright_bildergalerie_' . $i] = $image['copyright'];
            $i++;
        }
    }

    $videos = get_field('videolinks', $userACF);
    $videoURLs = array();
	$videoTitles = array();
    foreach($videos AS $video) {
        $videoURLs[] = $video['videolink'];
        $videoTitles[] =  $video['titel'];
    }

    $values['videos'] = $videoURLs;
    $values['videoTitles'] = $videoTitles;
    $values['profile_image'] = get_field('profilbild', $userACF)['ID'];
	$values['copyright_profilbild'] = get_field('copyright_profilbild', $userACF);
    $values['title_image'] = get_field('titelbild', $userACF)['ID'];
	$values['copyright_titelbild'] = get_field('copyright_titelbild', $userACF);
    $values['profilbeschreibung'] = get_field('profilbeschreibung', $userACF);
    $values['my_website'] = get_field('link_webseite', $userACF);
    $values['my_video_channel'] = get_field('link_youtube_vimeo', $userACF);
    $values['my_facebook'] = get_field('facebook', $userACF);
    $values['my_instagram'] = get_field('instagram', $userACF);
	$values['my_pintrest'] = get_field('pintrest', $userACF);
	$values['my_tiktok'] = get_field('tiktok', $userACF);
    $values['videokonferenzen'] = get_field('videokonferenzen', $userACF);
    $values['gemeinsames_arbeiten'] = get_field('gemeinsames_arbeiten', $userACF);
    $values['kommunikation'] = get_field('kommunikation', $userACF);
    $values['sonstiges'] = get_field('sonstiges', $userACF);
    $values['social_media'] = get_field('social_media', $userACF);
    $values['videoplattformen'] = get_field('videoplattformen', $userACF);
    $values['technische_ausstattung'] = get_field('technische_ausstattung', $userACF);
    $values['soundplattformen'] = get_field('soundplattformen', $userACF);
    $values['videokonferenz_moeglich'] = get_field('videokonferenzen_moeglich', $userACF);

    $kooperationsprofileIntern = array();
    foreach(get_field('kooperationsprofile_intern', $userACF) as $kooperationsprofil) {
        $kooperationsprofileIntern[] = $kooperationsprofil['profil'];
    }
    $values['kooperationspartner_intern'] = $kooperationsprofileIntern;

    $kooperationsprofileExtern = array();
    foreach(get_field('kooperationsprofile_extern', $userACF) as $kooperationsprofil) {
        $kooperationsprofileExtern[] = array('name' => $kooperationsprofil['name'], 'webseite' => $kooperationsprofil['webseite'], 'beschreibung' => $kooperationsprofil['beschreibung']);
    }
    $values['kooperationspartner_extern'] = $kooperationsprofileExtern;

?>

    <?php
    if(!empty($msg)) { ?>
        <div class="message"><?php echo $msg;?></div>
    <?php }

    $template_dir = get_template_directory_uri();
    ?>

    <script>
        jQuery(function(){
            Forms.initRegistrationForm();
        });
    </script>

    <div class="grid-inner">
        <h1><?php _e('<strong>Mein Profil</strong> bearbeiten', 'teilhabekultur');?></h1>
        <form class="full-width" action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST" id="register-form">
            <input name="kulturvermittlung_action" type="hidden" value="edit_profile"/>
            <input name="action" type="hidden" value="kulturvermittlung_save_my_profile"/>
            <input name="user_id" type="hidden" value="<?php echo get_current_user_id();?>"/>
            <?php wp_nonce_field( 'kulturvermittlung_edit_profile'); ?>

            <?php include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/profile/edit_profile_form.tpl.php');?>

            <div class="form-box">
                <h2 class="box-title with-description"><?php _e('Meine Angebot', 'teilhabekultur');?></h2>

                <div class="my-offers">
                    <?php
                        $myOffers = Cortex_Kulturvermittlung_Offers::getOffersOfProfile($userId);
                        if(!empty($myOffers)) {?>
                            <table>
                            <?php foreach($myOffers AS $offer) { ?>
                                <tr>
                                    <td>
                                        <div class="title">
                                            <a href="<?php echo get_the_permalink($offer->ID);?>" target="_blank"><?php echo get_the_title($offer->ID);?></a>
                                        </div>
                                    </td>
                                    <td class="link">
                                        <a target="_blank" href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('edit_offer'));?>?offerId=<?php echo $offer->ID;?>"><?php _e('bearbeiten','teilhabekultur');?></a>
                                    </td>
                                    <td class="link">
                                        <a target="_blank" href="<?php echo admin_url('admin-post.php');?>?action=kulturvermittlung_deactive_offer&offerId=<?php echo $offer->ID;?>"><?php _e('stilllegen','teilhabekultur');?></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </table>
                        <?php } else { ?>
                            <p><?php _e('Du hast keine aktiven Angebote.', 'teilhabekultur');?></p>
                        <?php }
                    ?>

                    <?php
                        $myDeactivatedOffers = Cortex_Kulturvermittlung_Offers::getOffersOfProfile($userId, array(), NULL, true);
                        if(!empty($myDeactivatedOffers)) {?>
                            <div class="margin-top">
                                <strong><?php _e('Stillgelegte Angebote', 'teilhabekultur');?></strong>
                                <table>
                                    <?php foreach($myDeactivatedOffers AS $offer) { ?>
                                        <tr>
                                            <td>
                                                <div class="title">
                                                    <a href="<?php echo get_the_permalink($offer->ID);?>" target="_blank"><?php echo get_the_title($offer->ID);?></a>
                                                </div>
                                            </td>
                                            <td class="link">
                                                <a target="_blank" href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('edit_offer'));?>?offerId=<?php echo $offer->ID;?>"><?php _e('bearbeiten','teilhabekultur');?></a>
                                            </td>
                                            <td class="link">
                                                <a target="_blank" href="<?php echo admin_url('admin-post.php');?>?action=kulturvermittlung_activate_offer&offerId=<?php echo $offer->ID;?>"><?php _e('aktivieren','teilhabekultur');?></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        <?php } ?>
                </div>


                <a target="_blank" href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('edit_offer'));?>" class="enter-tipp enter-new margin-top">
                    <img class="new-icon" src="<?php echo $template_dir;?>/static/img/icons/edit_icon.svg" alt="<?php _e('Neues Angebot erstellen', 'teilhabekultur');?>"/><?php _e('Neues Angebot erstellen', 'teilhabekultur');?>
                </a>
            </div>

            <div class="error-messages">
                <div class="error-message sector"><?php _e('Bitte wähle zumindest eine Sparte aus.', 'teilhabekultur');?></div>
                <div class="error-message required-fields"><?php _e('Bitte füll mit * markierten alle Pflichtfelder aus.', 'teilhabekultur');?></div>
                <div class="error-message profile-image"><?php _e('Bitte lade ein Profilbild hoch.', 'teilhabekultur');?></div>
                <div class="error-message title-image"><?php _e('Bitte lade ein Titelbild hoch.', 'teilhabekultur');?></div>
                <div class="error-message description"><?php _e('Bitte gib eine Profilbeschreibung zwischen 400 und 2000 Zeichen ein.', 'teilhabekultur');?></div>
                <div class="error-message copyright-image-gallery"><?php _e('Bitte gib für alle Bilder der Bildergalerie einen Copyright-Hinweis an.', 'teilhabekultur');?></div>
            </div>

            <div class="margin-bottom">
                <input type="submit" value="<?php  _e('Änderungen speichern', 'teilhabekultur');?>">
                <div id="main-form-loader" class="lds-loader"><div></div><div></div><div></div></div>
            </div>

        </form>
    </div>
<?php } ?>