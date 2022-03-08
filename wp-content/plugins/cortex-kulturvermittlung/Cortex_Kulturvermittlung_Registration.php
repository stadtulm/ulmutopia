<?php

class Cortex_Kulturvermittlung_Registration {
    public function __construct() {
        add_shortcode( 'kulturvermittlung_register_form', array($this, 'registrationForm'));
        add_action( 'admin_post_nopriv_kulturvermittlung_save_my_profile', array($this, 'updateMyProfile'));
        add_action( 'admin_post_kulturvermittlung_save_my_profile', array($this, 'updateMyProfile'));
        add_action( 'admin_post_nopriv_kulturvermittlung_register', array($this, 'registerUser'));
        add_action( 'admin_post_kulturvermittlung_register', array($this, 'registerUser'));
    }

    /* This handles the shortcode [register_form] and prints the registarion form
   -------------------------------------------------------------------------------*/
    public function registrationForm($atts, $content = "") {
        //The form was sent, handle it now
        if(!empty($_POST['kulturvermittlung_action']) && $_POST['kulturvermittlung_action'] == 'register_user') {
            return NULL;
        } else{
            return $this->showRegistrationForm();
        }
    }

    /* Function that will render the registration form
   -------------------------------------------------------------------------------*/
    public function showRegistrationForm($msg = NULL) {
        ob_start();
        $values = $_POST;
        include('templates/registration/registration_form.tpl.php');
        $html = ob_get_clean();

        return $html;
    }

    /* Function that will register a new ulmutopia user
   -------------------------------------------------------------------------------*/
    public function registerUser() {
        //First check if nounce is correct
        if(!wp_verify_nonce( $_POST['_wpnonce'], 'kulturvermittlung_register_user')) {
            wp_nonce_ays(__("Wollen Sie sich wirklich als neuer Nutzer registieren?"));
        }

        //Now check for all requiredFields
        $requiredFields = array(
            'name_institution_kuenstlerin',
            'ansprechperson_1_vorname',
            'ansprechperson_1_nachname',
            'strasse',
            'hausnummer',
            'plz',
            'ort',
            'telefon',
            'email',
            'sparten',
            'profilbeschreibung'
        );

        foreach($requiredFields AS $requiredField) {
            if(!isset($_POST[$requiredField])) {
                $this->showRegisterForm('required_fields_error');
            }
        }

        //Check if the passwords match
        if(empty($_POST['password']) || empty($_POST['password_confirm']) || $_POST['password'] != $_POST['password_confirm']) {
            $this->showRegisterForm('password_error');
        }

        //Check if  email is valid
        if(empty($_POST['email']) || !is_email($_POST['email'])) {
            $this->showRegisterForm('email_false');
        }

        $username = sanitize_user($_POST['name_institution_kuenstlerin'], true);
        $username = str_replace(' ', '_' ,strtolower($username));
        $password = $_POST['password'];
        $email = $_POST['email'];

        //Check if email is already used (E-Mail must be unique)
        if(email_exists($email)) {
            $this->showRegisterForm('email_exists');
        }

        //Check if username is taken and add a number if so
        $i = 1;
        while(username_exists($username)) {
            $username = $username . $i;
            $i++;
        }
        $userId = wp_create_user($username, $password, $email);

        //If the user was successfully created, fill out it's profile
        if ($userId) {
            $updateUserResult = wp_update_user(array('ID' => $userId, 'display_name' => $_POST['name_institution_kuenstlerin'], 'nickname' => $_POST['name_institution_kuenstlerin']));
            if(is_wp_error($updateUserResult)){
                error_log("There was an error updating the display name of the user with the ID " . $userId);
                error_log("WP_Error was:" . print_r($updateUserResult, true));
            }
            $userObject = new WP_User($userId);

            // Replace the current role with 'artist' role
            $userObject->set_role('artist');

            //Insert all profile values and images
            update_field('name_institution_kuenstlerin', $_POST['name_institution_kuenstlerin'], 'user_' . $userId);
            update_field('untertitel', $_POST['untertitel'], 'user_' . $userId);

            update_field('ansprechperson_1_vorname', $_POST['ansprechperson_1_vorname'], 'user_' . $userId);
            update_field('ansprechperson_1_nachname', $_POST['ansprechperson_1_nachname'], 'user_' . $userId);

            if(!empty($_POST['ansprechperson_2_vorname'])) {
                update_field('ansprechperson_2_vorname', $_POST['ansprechperson_2_vorname'], 'user_' . $userId);
            }

            if(!empty($_POST['ansprechperson_2_nachname'])) {
                update_field('ansprechperson_2_nachname', $_POST['ansprechperson_2_nachname'], 'user_' . $userId);
            }

            if(!empty($_POST['ansprechperson_3_vorname'])) {
                update_field('ansprechperson_3_vorname', $_POST['ansprechperson_3_vorname'], 'user_' . $userId);
            }

            if(!empty($_POST['ansprechperson_3_nachname'])) {
                update_field('ansprechperson_3_nachname', $_POST['ansprechperson_3_nachname'], 'user_' . $userId);
            }

            update_field('strasse', $_POST['strasse'], 'user_' . $userId);
            update_field('hausnummer', $_POST['hausnummer'], 'user_' . $userId);
            update_field('plz', $_POST['plz'], 'user_' . $userId);
            update_field('ort', $_POST['ort'], 'user_' . $userId);
            update_field('telefon', $_POST['telefon'], 'user_' . $userId);

            if(!empty($_POST['fax'])){
                update_field('fax', $_POST['fax'], 'user_' . $userId);
            }

            update_field('sparten', $_POST['sparten'], 'user_' . $userId);

            update_field('zielgruppe_von', $_POST['zielgruppe_von'], 'user_' . $userId);
            update_field('zielgruppe_bis', $_POST['zielgruppe_bis'], 'user_' . $userId);

            $videoLinks = array();
            if(is_array($_POST['videos'])){
                foreach($_POST['videos'] as $key => $video) {
                    if(!empty($video)){
                        $videoTitle = $_POST['video-titles'][$key];
                        $videoLinks[] = array('videolink' => $video, 'titel' => $videoTitle);
                    }
                }
            }
            update_field('videolinks', $videoLinks, 'user_' . $userId);
            update_field('profilbeschreibung', $_POST['profilbeschreibung'],'user_' . $userId);

            //Handle profile image
            $cortexImageHandler = new Cortex_Kulturvermittlung_File_Handler();
            $result = $cortexImageHandler->saveTempImage($_POST['profile_image'], "Profilbild " . $_POST['name_institution_kuenstlerin']);

            if(is_wp_error($result)) {
                error_log("There was an error saving an image file:" . $_POST['profile_image']);
                error_log("Failed to save image: " . $result->get_error_message());
            } else{
                update_field('profilbild', $result, 'user_' . $userId);
            }
            update_field('copyright_profilbild', $_POST['copyright_profilbild'], 'user_' . $userId);

            //Handle title image
            $result = $cortexImageHandler->saveTempImage($_POST['title_image'], "Titelbild " . $_POST['name_institution_kuenstlerin']);

            if(is_wp_error($result)) {
                error_log("There was an error saving an image file:" . $_POST['title_image']);
                error_log("Failed to save image: " . $result->get_error_message());
            } else{
                update_field('titelbild', $result, 'user_' . $userId);
            }
            update_field('copyright_titelbild', $_POST['copyright_titelbild'], 'user_' . $userId);

            $imageGalleryEntries = array('image_gallery_image_1', 'image_gallery_image_2', 'image_gallery_image_3');
            $imageGalleryACFField = array();
            foreach($imageGalleryEntries AS $galleryEntry) {
                $result = $cortexImageHandler->saveTempImage($_POST[$galleryEntry], "Bildergalerie " . $_POST['name_institution_kuenstlerin']);
                if(is_wp_error($result)) {
                    error_log("There was an error saving an image file:" . $_POST[$galleryEntry]);
                    error_log("Failed to save image: " . $result->get_error_message());
                } else{
                    $imageGalleryACFField[] = array('bild' => $result);
                }
            }
            update_field('bildergalerie', $imageGalleryACFField, 'user_' . $userId);

            //My Social Links
            update_field('link_webseite', $_POST['my_website'], 'user_' . $userId);
            update_field('link_youtube_vimeo', $_POST['my_video_channel'], 'user_' . $userId);
            update_field('facebook', $_POST['my_facebook'], 'user_' . $userId);
            update_field('instagram', $_POST['my_instagram'], 'user_' . $userId);
            update_field('pintrest', $_POST['my_pintrest'], 'user_' . $userId);
            update_field('tiktok', $_POST['my_tiktok'], 'user_' . $userId);

            //Digitale Plattformen und Werkzeuge
            update_field('videokonferenzen', $_POST['videokonferenzen'], 'user_' . $userId);
            update_field('kommunikation', $_POST['kommunikation'], 'user_' . $userId);
            update_field('social_media', $_POST['social_media'], 'user_' . $userId);
            update_field('videoplattformen', $_POST['videoplattformen'], 'user_' . $userId);
            update_field('soundplattformen', $_POST['soundplattformen'], 'user_' . $userId);
            update_field('gemeinsames_arbeiten', $_POST['gemeinsames_arbeiten'], 'user_' . $userId);
            update_field('sonstiges', $_POST['sonstiges'], 'user_' . $userId);
            update_field('technische_ausstattung', $_POST['technische_ausstattung'], 'user_' . $userId);

            if($_POST['videokonferenz_moeglich'] == '1') {
                update_field('videokonferenzen_moeglich', true, 'user_' . $userId);
            } else {
                update_field('videokonferenzen_moeglich', false, 'user_' . $userId);
            }

            if($_POST['accepted-email-notifications'] == '1') {
                update_field('e-mail_benachrichtigung_erlaubt', true, 'user_' . $userId);
            } else {
                update_field('e-mail_benachrichtigung_erlaubt', false, 'user_' . $userId);
            }

            //Save Kooperationspartner internal
            $cooperationInternal = array();
            if(is_array($_POST['kooperationspartner_intern'])){
                $cortexEmailer = new Cortex_Kulturvermittlung_Emailer();
                foreach($_POST['kooperationspartner_intern'] as $cooperation) {
                    $cortexEmailer->sendCooperationEnquiry($userId, $cooperation);
                    $cooperationInternal[] = array('profil' => $cooperation, 'akzeptiert' => false, 'email_verschickt' => true);
                }
            }
            update_field('kooperationsprofile_intern', $cooperationInternal,  'user_' . $userId);

            //Save external cooperation partners
            $cooperationExternal = array();
            foreach($_POST['partner_name'] as $key => $name){
                if(!empty($name)) {
                    $cooperationExternal[] = array(
                        'name' => $name,
                        'webseite' => $_POST['partner_url'][$key],
                        'beschreibung' => $_POST['partner_beschreibung'][$key],
                    );
                }
            }
            update_field('kooperationsprofile_extern', $cooperationExternal,  'user_' . $userId);

            //Profile will start deactivated
            update_field('aktiv', false, 'user_' . $userId);

            $mailer = new Cortex_Kulturvermittlung_Emailer();
            $mailer->sendRegistrationConfirmation($userId);
            $mailer->sendAdminNewAccount();

            wp_redirect(add_query_arg('login', 'created', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register'))), '303');
            exit();
        } else {
            error_log("There was an error creating a new user.");
            wp_redirect(get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register')), '303');
        }
    }

    /* This shows the login form if something was incorrect, e.g. not all required fields were present (and keeps the form values that the user sent)
    -------------------------------------------------------------------------------*/
    public function showRegisterForm($message) {
        global $post;
        $post = get_post(Cortex_Kulturvermittlung_Config::getPageId('registration'));
        setup_postdata($post);
        global $cortexMessage;
        $cortexMessage = $message;
        get_header();
        the_content();
        get_footer();
        exit();
    }

    /* This function updates an existing user profile
   -------------------------------------------------------------------------------*/
    public function updateMyProfile() {
        //First check if nounce is correct
        if(!wp_verify_nonce( $_POST['_wpnonce'], 'kulturvermittlung_edit_profile')) {
            wp_nonce_ays(__("Wollen Sie sich wirklich ihr Profil updaten?"));
        }

        //Now check for all requiredFields
        $requiredFields = array(
            'name_institution_kuenstlerin',
            'ansprechperson_1_vorname',
            'ansprechperson_1_nachname',
            'strasse',
            'hausnummer',
            'plz',
            'ort',
            'telefon',
            'email',
            'sparten',
            'profilbeschreibung'
        );

        foreach($requiredFields AS $requiredField) {
            if(!isset($_POST[$requiredField])) {
                wp_redirect(get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile')), 303);
                exit();
            }
        }

        $userId = get_current_user_id();
        //Did the form provide an user id?
        if(!empty($_POST['user_id'])) {
            //Is the userId of the currently logged in user the same as the provided ID in the form?
            if($userId == intval($_POST['user_id'])) {
                //Update all the fields and images
                update_field('name_institution_kuenstlerin', $_POST['name_institution_kuenstlerin'], 'user_' . $userId);
                update_field('untertitel', $_POST['untertitel'], 'user_' . $userId);
                update_field('ansprechperson_1_vorname', $_POST['ansprechperson_1_vorname'], 'user_' . $userId);
                update_field('ansprechperson_1_nachname', $_POST['ansprechperson_1_nachname'], 'user_' . $userId);

                if(!empty($_POST['ansprechperson_2_vorname'])) {
                    update_field('ansprechperson_2_vorname', $_POST['ansprechperson_2_vorname'], 'user_' . $userId);
                } else {
                    update_field('ansprechperson_2_vorname', '', 'user_' . $userId);
                }

                if(!empty($_POST['ansprechperson_2_nachname'])) {
                    update_field('ansprechperson_2_nachname', $_POST['ansprechperson_2_nachname'], 'user_' . $userId);
                } else {
                    update_field('ansprechperson_2_nachname', '', 'user_' . $userId);
                }

                if(!empty($_POST['ansprechperson_3_vorname'])) {
                    update_field('ansprechperson_3_vorname', $_POST['ansprechperson_3_vorname'], 'user_' . $userId);
                } else {
                    update_field('ansprechperson_3_vorname', '', 'user_' . $userId);
                }

                if(!empty($_POST['ansprechperson_3_nachname'])) {
                    update_field('ansprechperson_3_nachname', $_POST['ansprechperson_3_nachname'], 'user_' . $userId);
                } else {
                    update_field('ansprechperson_3_nachname', '', 'user_' . $userId);
                }

                update_field('strasse', $_POST['strasse'], 'user_' . $userId);
                update_field('hausnummer', $_POST['hausnummer'], 'user_' . $userId);
                update_field('plz', $_POST['plz'], 'user_' . $userId);
                update_field('ort', $_POST['ort'], 'user_' . $userId);
                update_field('telefon', $_POST['telefon'], 'user_' . $userId);

                if(!empty($_POST['fax'])){
                    update_field('fax', $_POST['fax'], 'user_' . $userId);
                } else {
                    update_field('fax', '', 'user_' . $userId);
                }

                update_field('sparten', $_POST['sparten'], 'user_' . $userId);
                update_field('zielgruppe_von', $_POST['zielgruppe_von'], 'user_' . $userId);
                update_field('zielgruppe_bis', $_POST['zielgruppe_bis'], 'user_' . $userId);

                $videoLinks = array();
                if(is_array($_POST['videos'])){
                    foreach($_POST['videos'] as $key => $video) {
                        if(!empty($video)){
                            $videoTitle = $_POST['video-titles'][$key];
                            $videoLinks[] = array('videolink' => $video, 'titel' => $videoTitle);

                        }
                    }
                }
                update_field('videolinks', $videoLinks, 'user_' . $userId);
                update_field('profilbeschreibung', $_POST['profilbeschreibung'],'user_' . $userId);


                $cortexImageHandler = new Cortex_Kulturvermittlung_File_Handler();
                //The old image is an attachment id, so if the user uploaded a new one, this is a string with the new file name
                if(!is_numeric($_POST['profile_image'])){
                    $result = $cortexImageHandler->saveTempImage($_POST['profile_image'], "Profilbild " . $_POST['name_institution_kuenstlerin']);
                    if(is_wp_error($result)){
                        error_log("There was an error saving an image file:" . $_POST['profile_image']);
                        error_log("Failed to save image: " . $result->get_error_message());
                    } else{
                        update_field('profilbild', $result, 'user_' . $userId);
                    }
                }
                update_field('copyright_profilbild', $_POST['copyright_profilbild'], 'user_' . $userId);

                if(!is_numeric($_POST['title_image'])) {
                    //Handle title image
                    $result = $cortexImageHandler->saveTempImage($_POST['title_image'], "Titelbild " . $_POST['name_institution_kuenstlerin']);
                    if(is_wp_error($result)) {
                        error_log("There was an error saving an image file:" . $_POST['title_image']);
                        error_log("Failed to save image: " . $result->get_error_message());
                    } else{
                        update_field('titelbild', $result, 'user_' . $userId);
                    }
                }
                update_field('copyright_titelbild', $_POST['copyright_titelbild'], 'user_' . $userId);

                $imageGalleryEntries = array('image_gallery_image_1', 'image_gallery_image_2', 'image_gallery_image_3');
                $imageGalleryCopyrights = array('copyright_bildergalerie_1', 'copyright_bildergalerie_2', 'copyright_bildergalerie_3');
                $imageGalleryACFField = array();
                foreach($imageGalleryEntries AS $key => $galleryEntry) {
                    $copyrightNotice = $_POST[$imageGalleryCopyrights[$key]];

                    if(!empty($_POST[$galleryEntry])) {
                        if(!is_numeric($_POST[$galleryEntry])){
                            $result = $cortexImageHandler->saveTempImage($_POST[$galleryEntry], "Bildergalerie " . $_POST['name_institution_kuenstlerin']);
                            if(is_wp_error($result)){
                                error_log("Failed to save image: " . $result->get_error_message());
                            } else{
                                $imageGalleryACFField[] = array('bild' => $result, 'copyright' => $copyrightNotice);
                            }
                        } else {
                            $imageGalleryACFField[] = array('bild' => $_POST[$galleryEntry], 'copyright' => $copyrightNotice);
                        }
                    }
                }

                update_field('bildergalerie', $imageGalleryACFField, 'user_' . $userId);

                //My Social Links
                update_field('link_webseite', $_POST['my_website'], 'user_' . $userId);
                update_field('link_youtube_vimeo', $_POST['my_video_channel'], 'user_' . $userId);
                update_field('facebook', $_POST['my_facebook'], 'user_' . $userId);
                update_field('instagram', $_POST['my_instagram'], 'user_' . $userId);
                update_field('pintrest', $_POST['my_pintrest'], 'user_' . $userId);
                update_field('tiktok', $_POST['my_tiktok'], 'user_' . $userId);

                //Digitale Plattformen und Werkzeuge
                update_field('videokonferenzen', $_POST['videokonferenzen'], 'user_' . $userId);
                update_field('kommunikation', $_POST['kommunikation'], 'user_' . $userId);
                update_field('social_media', $_POST['social_media'], 'user_' . $userId);
                update_field('videoplattformen', $_POST['videoplattformen'], 'user_' . $userId);
                update_field('soundplattformen', $_POST['soundplattformen'], 'user_' . $userId);
                update_field('gemeinsames_arbeiten', $_POST['gemeinsames_arbeiten'], 'user_' . $userId);
                update_field('sonstiges', $_POST['sonstiges'], 'user_' . $userId);
                update_field('technische_ausstattung', $_POST['technische_ausstattung'], 'user_' . $userId);

                if($_POST['videokonferenz_moeglich'] == '1') {
                    update_field('videokonferenzen_moeglich', true, 'user_' . $userId);
                } else {
                    update_field('videokonferenzen_moeglich', false, 'user_' . $userId);
                }

                //Save Kooperationspartner internal
                $cooperationInternal = array();

                //First save all the already accepted profiles
                $acceptedProfileIds = array();
                $emailedProfileIds = array();
                if(!empty(get_field('kooperationsprofile_intern', 'user_' . $userId) && is_array(get_field('kooperationsprofile_intern', 'user_' . $userId)))) {
                    foreach(get_field('kooperationsprofile_intern', 'user_' . $userId) AS $cooperationProfile) {
                        if( $cooperationProfile['akzeptiert']) {
                            $acceptedProfileIds[] = $cooperationProfile['profil'];
                        }

                        if( $cooperationProfile['email_verschickt']) {
                            $emailedProfileIds[] = $cooperationProfile['profil'];
                        }
                    }
                }

                if(is_array($_POST['kooperationspartner_intern'])){
                    $cortexEmailer = new Cortex_Kulturvermittlung_Emailer();

                    foreach($_POST['kooperationspartner_intern'] as $cooperation) {
                        $accepted = false;
                        if(in_array($cooperation, $acceptedProfileIds)) {
                            $accepted = true;
                            $arrayPosition = array_search($cooperation, $acceptedProfileIds);
                            unset($acceptedProfileIds[$arrayPosition]);
                        }

                        $emailed = false;
                        if(in_array($cooperation, $emailedProfileIds)) {
                            $emailed = true;
                        } else {
                            if(!$accepted) {
                                //Send an email
                                $cortexEmailer->sendCooperationEnquiry($userId, $cooperation);
                                $emailed = true;
                            }
                        }

                        $cooperationInternal[] = array('profil' => $cooperation, 'akzeptiert' => $accepted, 'email_verschickt' => $emailed);
                    }
                }
                update_field('kooperationsprofile_intern', $cooperationInternal,  'user_' . $userId);

                //What's left in $acceptedProfileIds are cooperations that the user deleted.
                //Go through these leftover accepted IDs and delete ourselves from the cooperations of this user
                foreach($acceptedProfileIds AS $deletedCooperationId) {
                    $allForeignCooperations = get_field('kooperationsprofile_intern', 'user_' . $deletedCooperationId);
                    $newForeignCooperations = array();
                    foreach($allForeignCooperations AS $foreignCooperation) {
                        if($foreignCooperation['profil'] != $userId) {
                            $newForeignCooperations[] = $foreignCooperation;
                        }
                    }

                    update_field('kooperationsprofile_intern', $newForeignCooperations,'user_' . $deletedCooperationId);

                    //Go through all offers of this person and remove ourselves
                    $foreignCooperationOffers = Cortex_Kulturvermittlung_Offers::getOffersOfProfile($deletedCooperationId);
                    foreach($foreignCooperationOffers AS $offer) {
                        $cooperationPartnersForOffer = get_field('kooperationsprofile', $offer->ID);
                        $newCooperationPartnersForOffer = array();
                        foreach($cooperationPartnersForOffer AS $partner) {
                            if($partner['profil'] != $userId) {
                                $newCooperationPartnersForOffer[] = $partner;
                            }
                        }

                        update_field('kooperationsprofile', $newCooperationPartnersForOffer,$offer->ID);
                    }
                }
                //Go through all my offers and remove the deleted cooperation partners
                $myOffers = Cortex_Kulturvermittlung_Offers::getOffersOfProfile($userId);
                foreach($myOffers AS $offer) {
                    $cooperationPartnersForOffer = get_field('kooperationsprofile', $offer->ID);
                    $newCooperationPartnersForOffer = array();
                    foreach($cooperationPartnersForOffer AS $partner) {
                        if(!in_array($partner['profil'], $acceptedProfileIds)) {
                            $newCooperationPartnersForOffer[] = $partner;
                        }
                    }
                    update_field('kooperationsprofile', $newCooperationPartnersForOffer,$offer->ID);
                }

                //Save Kooperationspartner extern
                $cooperationExternal = array();
                foreach($_POST['partner_name'] as $key => $name){
                    if(!empty($name)) {
                        $cooperationExternal[] = array(
                            'name' => $name,
                            'webseite' => $_POST['partner_url'][$key],
                            'beschreibung' => $_POST['partner_beschreibung'][$key],
                        );
                    }
                }
                update_field('kooperationsprofile_extern', $cooperationExternal,  'user_' . $userId);

            } else {
                //The user tried to change a user profile that doesn't belong to him
                wp_redirect(Cortex_Kulturvermittlung_Profiles::generateProfileLink($_POST['user_id']), 303);
                exit();
            }
        } else {
            //There was no user id in the form POST
            wp_redirect(get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile')), 303);
            exit();
        }

        //The save was successful, redirect the user
        wp_redirect(add_query_arg('message', 'success', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile'))), '303');
        exit();
    }

}

$cortexKulturvermittlungRegistration = new Cortex_Kulturvermittlung_Registration();