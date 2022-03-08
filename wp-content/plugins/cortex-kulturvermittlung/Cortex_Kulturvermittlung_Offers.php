<?php

class Cortex_Kulturvermittlung_Offers{
	public function __construct(){
		add_action( 'admin_post_nopriv_kulturvermittlung_save_offer', array($this, 'saveOffer'));
		add_action( 'admin_post_kulturvermittlung_save_offer', array($this, 'saveOffer'));

		add_action('admin_post_nopriv_kulturvermittlung_deactive_offer', array($this, 'deactivateOffer'));
		add_action('admin_post_kulturvermittlung_deactive_offer', array($this, 'deactivateOffer'));

		add_action('admin_post_nopriv_kulturvermittlung_activate_offer', array($this, 'activateOffer'));
		add_action('admin_post_kulturvermittlung_activate_offer', array($this, 'activateOffer'));

		add_action('wp_ajax_nopriv_kulturvermittlung_generate_preview_offer', array($this, 'generatePreviewOffer'));
		add_action('wp_ajax_kulturvermittlung_generate_preview_offer', array($this, 'generatePreviewOffer'));

		add_action('wp_ajax_nopriv_kulturvermittlung_get_offers', array($this, 'getOffers'));
		add_action('wp_ajax_kulturvermittlung_get_offers', array($this, 'getOffers'));
	}

    /* Admin Post action that handles the preview save of an offer
    -------------------------------------------------------------------------------*/
	public function generatePreviewOffer() {
		$this->saveOffer(true);
	}

    /* function that handles the save form of an offer
    -------------------------------------------------------------------------------*/
	public function saveOffer($preview = false) {
        if(!is_user_logged_in()) {
            //The user is not logged in, return
            wp_redirect(get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register')), '303');
            exit();
        }

        //Verify the WP Nonce
        if(!wp_verify_nonce( $_POST['_wpnonce'], 'kulturvermittlung_edit_offer')) {
            wp_nonce_ays(__("Wollen Sie wirklich ein Angebot bearbeiten?"));
        }

		$offerId = NULL;

        //If it's a preview save, save the offer as draft
		if($preview) {
			$postStatus = 'draft';
			$data = $_POST;
		} else {
			$postStatus = 'publish';
			$data = $_POST;
		}

        //Do we edit an offer?
		if(isset($data['offerId']) && !empty($data['offerId'])){
			$offerId = intval($data['offerId']);
		}

		$title = $data['titel'];

		if($offerId === NULL) {
            //We insert a new offer
			$offerId = wp_insert_post(array (
				'post_type' => 'angebot',
				'post_title' => $title,
				'post_content' => '',
				'post_status' => $postStatus,
				'comment_status' => 'closed',
				'ping_status' => 'closed',
			));
			$message = 'created';
		} else {
			//If the was previously saved as an preview, we still want to show the created message
			if(get_post_status($offerId) == 'draft') {
				$message = 'created';
			} else {
				$message = 'success';
			}

            //Check if this offer belongs the logged in user
            if(get_post_field('post_author', $offerId) == get_current_user_id()) {
                wp_update_post(array(
                        'ID' => $offerId,
                        'post_title' => $title,
                        'post_status' => $postStatus,
                    )
                );
            } else {
                wp_redirect(add_query_arg('message', 'not_allowed', get_the_permalink($offerId)), '303');
                exit();
            }
		}

		$cortexImageHandler = new Cortex_Kulturvermittlung_File_Handler();

        //Update the fields and save the images
		update_field('beschreibung', $data['beschreibung'], $offerId);
		update_field('kontakt', $data['ansprechpartner'], $offerId);
		update_field('kontakt_emailadresse', $data['ansprechpartner_email'], $offerId);
		update_field('sparten', $data['sparten'], $offerId);

		if(!empty($data['main_image']) && !is_numeric($data['main_image'])){
			$result = $cortexImageHandler->saveTempImage($data['main_image'], "Hauptbild Angebot " . $title);
			if(is_wp_error($result)){
                error_log("There was an error saving the temp image:" . print_r($data['main_image'], true));
                error_log("WP_Error was:" . print_r($result, true));
			} else{
				update_field('bild', $result, $offerId);
			}
		}
		update_field('copyright_bild', $data['copyright_bild'], $offerId);

		update_field('dauer', $data['dauer'], $offerId);
		update_field('dauer_vor-_und_nachbereitung', $data['dauer_vor-_und_nachbereitung'], $offerId);
		update_field('art_der_termine', $data['art_der_termine'], $offerId);

		if($data['art_der_termine'] == 'freie_eingabe') {
			update_field('freitext_termin', $data['termin_freitext'], $offerId);
			update_field('fester_termin', NULL, $offerId);
		} else if($data['art_der_termine'] == 'fester_termin') {
			update_field('freitext_termin', NULL, $offerId);
			update_field('fester_termin', $data['termin_fester_wert'], $offerId);
		} else {
			update_field('freitext_termin', NULL, $offerId);
			update_field('fester_termin', NULL, $offerId);
		}

		update_field('anzahl_von_projekteinheitenmodulen', $data['anzahl_von_projekteinheitenmodulen'], $offerId);
		update_field('zielgruppe_von', $data['zielgruppe_von'], $offerId);
		update_field('zielgruppe_bis', $data['zielgruppe_bis'], $offerId);
		update_field('preis', $data['preis'], $offerId);
		update_field('abrechnungsform', $data['abrechnungsform'], $offerId);

		$themen = array();
		for($i = 1; $i <= 3; $i++) {
			if(!empty($data['thema_' . $i])){
				$themen[] = array('thema' => $data['thema_' . $i]);
			}
		}
		update_field('themen', $themen, $offerId);

		update_field('benotigte_materialien', $data['benotigte_materialien'], $offerId);
		update_field('benotigte_raumlichkeiten', $data['benotigte_raumlichkeiten'], $offerId);
		update_field('technik', $data['technik'], $offerId);

		if($data['padagogische_unterstutzung_notwendig'] == 1) {
			update_field('padagogische_unterstutzung_notwendig', true, $offerId);
			update_field('padagogische_unterstutzung_freitext', $data['padagogische_unterstutzung_freitext'], $offerId);
		} else {
			update_field('padagogische_unterstutzung_notwendig', false, $offerId);
			update_field('padagogische_unterstutzung_freitext', '', $offerId);
		}

		if($data['individuelle_projektanpassung_moglich'] == 1) {
			update_field('individuelle_projektanpassung_moglich', true, $offerId);
		} else {
			update_field('individuelle_projektanpassung_moglich', false, $offerId);
		}

		update_field('videokonferenzen', $data['videokonferenzen'], $offerId);
		update_field('gemeinsames_arbeiten', $data['gemeinsames_arbeiten'], $offerId);
		update_field('kommunikation', $data['kommunikation'], $offerId);
		update_field('sonstiges', $data['sonstiges'], $offerId);
		update_field('social_media', $data['social_media'], $offerId);
		update_field('avvrxr', $data['avvrxr'], $offerId);
		update_field('videoplattformen', $data['videoplattformen'], $offerId);
		update_field('soundplattformen', $data['soundplattformen'], $offerId);
		update_field('sonstiges', $data['sonstiges'], $offerId);


		$downloadsACFArray = array();

		//Handle the old files
		if(is_array($data['current_downloads']) && sizeof($data['current_downloads']) > 0){
			foreach($data['current_downloads'] as $oldFile) {
				$downloadsACFArray[] = array('datei' => $oldFile);
			}
		}

		//Handle the new files
		$fileHandler = new Cortex_Kulturvermittlung_File_Handler();
		if(isset($_FILES['downloads'])){
			foreach($_FILES['downloads']['name'] as $key => $download) {
				if( ! empty($_FILES['downloads']['tmp_name'][$key])){
					$file = array(
						'name'     => $_FILES['downloads']['name'][$key],
						'type'     => $_FILES['downloads']['type'][$key],
						'tmp_name' => $_FILES['downloads']['tmp_name'][$key],
						'error'    => $_FILES['downloads']['error'][$key],
						'size'     => $_FILES['downloads']['size'][$key]
					);

					$result = $fileHandler->saveFile($file, $offerId, '');
					if(is_wp_error($result)){
                        error_log("There was an error saving an temp file:" . print_r($file, true));
                        error_log("WP_Error was:" . print_r($result, true));
					} else{
						$downloadsACFArray[] = array('datei' => $result);
					}
				}
			}
		}
		update_field('downloads', $downloadsACFArray, $offerId);

		//Handle the image gallery
		$imageGalleryACFField = array();
		foreach($data['image_gallery_image'] AS $key => $galleryEntry) {
			if(!empty($galleryEntry)){
				$copyrightNotice = $data['copyright_bildergalerie'][$key];
				if(!is_numeric($galleryEntry)){
					$result = $cortexImageHandler->saveTempImage($galleryEntry, "Bildergalerie " . $title);
					if(is_wp_error($result)){
                        error_log("There was an error saving the temp image:" . print_r($galleryEntry, true));
                        error_log("WP_Error was:" . print_r($result, true));
					} else{
						$imageGalleryACFField[] = array('bild' => $result, 'copyright' => $copyrightNotice);
					}
				} else{
					$imageGalleryACFField[] = array('bild' => $galleryEntry, 'copyright' => $copyrightNotice);
				}
			}
		}

		update_field('bildergalerie', $imageGalleryACFField, $offerId);

		//Handle Video Links
		$videoLinks = array();
		if(is_array($data['videos'])){
			foreach($data['videos'] as $key => $video) {
				if(!empty($video)){
					$videoTitle = $data['video-titles'][$key];
					$videoLinks[] = array('videolink' => $video, 'titel' => $videoTitle);
				}
			}
		}
		update_field('videolinks', $videoLinks, $offerId);

        //Save Tipps
		$tipps = array();
		if(is_array($data['tipps'])){
			foreach($data['tipps'] as $tipp) {
				$tipps[] = array('tipp' => $tipp);
			}
		}
		update_field('tipps', $tipps, $offerId);

        //Save cooperations
        $cooperations = array();
		if(is_array($data['kooperationen'])){
            foreach($data['kooperationen'] as $cooperation) {
                $cooperations[] = array('profil' => $cooperation);
            }
        }
		update_field('kooperationsprofile', $cooperations, $offerId);

        //If it's a preview, we send the preview link via ajax and will open it via js
		if($preview){
			wp_send_json_success(array('postId' => $offerId, 'link' => get_preview_post_link($offerId)));
		} else {
            //If it's a regular save, redirect to the detail view of the saved offer
			if($message == "created") {
				$cortexMailer = new Cortex_Kulturvermittlung_Emailer();
				$cortexMailer->sendAdminNewOffer($offerId);

				//Angebote are always aktiv from the start
				update_field('aktiv', true, $offerId);
			}

			wp_redirect(add_query_arg('message', $message,get_the_permalink($offerId)), '303');
			exit();
		}
	}

    /* This shows the login form if something was incorrect, e.g. not alle required fields were presentror
    -------------------------------------------------------------------------------*/
	public function showOfferForm($message, $offerId = NULL) {
		global $post;
		$post = get_post(Cortex_Kulturvermittlung_Config::getPageId('edit_offer'));
		setup_postdata($post);
		global $cortexMessage;
		$cortexMessage = $message;
		get_header();
		the_content();
		get_footer();
		exit();
	}

    /* This function handles any activation of an offer through the user frontend
    -------------------------------------------------------------------------------*/
	public function activateOffer() {
		if(!empty($_GET['offerId'])) {
			$offerId = intval($_GET['offerId']);

			$offer = get_post($offerId);
			if(!empty($offer)) {
				//Check if the offer belongs to the current user
				if($offer->post_author == get_current_user_id()) {
					update_field('aktiv', true ,$offerId);
					wp_redirect(add_query_arg('message', 'offer_activated', get_the_permalink($offerId)), '303');
					exit();
				} else {
					wp_redirect(add_query_arg('message', 'not_allowed', get_the_permalink($offerId)), '303');
					exit();
				}
			} else {
				wp_redirect(add_query_arg('message', 'offer_not_found', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile'))), '303');
				exit();
			}
		}
	}

    /* This function handles any deactivation of an offer through the user frontend
    -------------------------------------------------------------------------------*/
	public function deactivateOffer() {
		if(!empty($_GET['offerId'])) {
			$offerId = intval($_GET['offerId']);

			$offer = get_post($offerId);
			if(!empty($offer)) {
				//Check if the offer belongs to the current user
				if($offer->post_author == get_current_user_id()) {
					update_field('aktiv', false ,$offerId);
					wp_redirect(add_query_arg('message', 'offer_deactivated', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile'))), '303');
					exit();
				} else {
					wp_redirect(add_query_arg('message', 'not_allowed', get_the_permalink($offerId)), '303');
					exit();
				}
			} else {
				wp_redirect(add_query_arg('message', 'offer_not_found', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile'))), '303');
				exit();
			}
		}
	}

    /* This function returns the HTML list of filtered offers for any request via ajax, e.g. for the filtered offers overview
    -------------------------------------------------------------------------------*/
	public function getOffers() {
		$categories = array();
		$searchString = '';
		$ageMin = 0;
		$ageMax = 100;

		if(!empty($_POST['data']['categories'])) {
			$categories = $_POST['data']['categories'];
		}

		if(!empty($_POST['data']['searchString'])) {
			$searchString = $_POST['data']['searchString'];
		}

		if(!empty($_POST['data']['ageMin'])) {
			$ageMin = $_POST['data']['ageMin'];
		}

		if(!empty($_POST['data']['ageMax'])) {
			$ageMax = $_POST['data']['ageMax'];
		}

		$offers = self::getFilteredOffers(array(), $categories, $ageMin, $ageMax, $searchString);
		$html = '';
		$template_dir = get_template_directory_uri();
		if(sizeof($offers) > 0){
			foreach($offers as $offer) {
				ob_start();
				$offerId = $offer->ID;
				include('templates/tiles/offer_tile.tpl.php');
				$html .= ob_get_clean();
			}
		} else {
			$html .= '<div class="no-results">' . translate('Für diese Anfrage wurden leider keine Angebote gefunden.', 'teilhabekultur') . '</div>';
		}

		wp_send_json_success(array('html' => $html));
	}

    /* This functions returns a filtered array of offers when the offers are NOT loaded via ajax, but generated via PHP code
    -------------------------------------------------------------------------------*/
	public static function getFilteredOffers($excludeIds = array(), $categories = array(), $ageMin = 0, $ageMax = 100, $searchString = '', $limit = NULL,  $onlyFutureEvents = false) {
		$args = array(
			'orderby'       =>  'post_date',
			'order'         =>  'DESC',
			'exclude' => $excludeIds,
			'numberposts' => -1,
			'post_type' => 'angebot'
		);


		//The filters different filters must all match
		$meta_query = array(
			'relation' => 'AND'
		);

		//We only want active offers
		$meta_query[] = array(
			'key'     => 'aktiv',
			'value'   => '1',
			'compare' => '='
		);

		if(is_array($categories) && sizeof($categories) > 0) {
			if(sizeof($categories) == 1) {
				$meta_query[] = array(
					'key'     => 'sparten',
					'value'   => $categories[0],
					'compare' =>  'LIKE'
				);
			}
		}

		/*if($ageMin > 0 || $ageMax < 100){
			$meta_query[] = array(
				'key'     => 'zielgruppe_bis',
				'value'   => intval($ageMin),
				'compare' => '>=',
				'type'    => 'NUMERIC'
			);

			$meta_query[] = array(
				'key'     => 'zielgruppe_bis',
				'value'   => intval($ageMax),
				'compare' => '>=',
				'type'    => 'NUMERIC'
			);
		}*/

		$args['meta_query'] = $meta_query;
		$offersWithoutAge = get_posts($args);

		$offers = array();

		foreach($offersWithoutAge AS $offer) {
			$offerMinAge = get_field('zielgruppe_von', $offer->ID);
			$offerMaxAge = get_field('zielgruppe_bis', $offer->ID);

			if($ageMin > 0) {
				//e.g. The Users wants offers for 7 years old, but ageMin ist 8, so don't include it
				if($ageMin < $offerMinAge) {
					continue;
				}
			}

			if($ageMax < 100) {
				//e.g. the Users wants offers for 90 year old people, if the maxAge is 86, don't include it
				if($ageMax > $offerMaxAge) {
					continue;
				}
			}

			$offers[] = $offer;
		}

        if($onlyFutureEvents) {
            $now = new DateTime('NOW');
            foreach($offers AS $key => $offer) {
                if(get_field('art_der_termine', $offer->ID) == 'fester_termin') {
                    $festerTermin = get_field('fester_termin', $offer->ID);
                    $festerTerminDate = date_create_from_format('Y-m-d H:i', $festerTermin);

                    if($festerTerminDate < $now) {
                        unset($offers[$key]);
                    }
                }

            }
        }

		usort($offers, array('Cortex_Kulturvermittlung_Utils','sortOffers'));

		return $offers;
	}

    /* This function returns als offers of a given profile (userId)
    -------------------------------------------------------------------------------*/
	public static function getOffersOfProfile($userId, $excludeIds = array(), $limit = NULL, $onlyDeactivated = false, $onlyFutureEvents = false, $withCooperationProfiles = false) {
		$args = array(
			'orderby'       =>  'post_date',
			'order'         =>  'DESC',
			'exclude' => $excludeIds,
			'author'        =>  $userId,
			'numberposts' => -1,
			'post_type' => 'angebot'
		);

		//The filters different filters must all match
		$meta_query = array(
			'relation' => 'AND'
		);


		if($onlyDeactivated) {
			//We only want non active offers
			$meta_query[] = array(
				'key'     => 'aktiv',
				'value'   => '1',
				'compare' => '!='
			);
		} else {
			//We only want active offers
			$meta_query[] = array(
				'key'     => 'aktiv',
				'value'   => '1',
				'compare' => '='
			);
		}

		$args['meta_query'] = $meta_query;

		$offers = get_posts($args);


        if($withCooperationProfiles) {
            //Get cooperations of user
            $cooperations = Cortex_Kulturvermittlung_Profiles::getCooperationProfiles($userId);
            foreach($cooperations AS $cooperationProfileId) {
                $offers = array_merge($offers, Cortex_Kulturvermittlung_Offers::getOffersOfProfile($cooperationProfileId, $excludeIds, $limit, $onlyDeactivated, $onlyFutureEvents));
            }
        }

        if($onlyFutureEvents) {
            $now = new DateTime('NOW');
            foreach($offers AS $key => $offer) {
                if(get_field('art_der_termine', $offer->ID) == 'fester_termin') {
                    $festerTermin = get_field('fester_termin', $offer->ID);
                    $festerTerminDate = date_create_from_format('Y-m-d H:i', $festerTermin);

                    if($festerTerminDate < $now) {
                        unset($offers[$key]);
                    }
                }

            }
        }

		if($limit != NULL) {
			$offers = array_splice($offers, 0, $limit);
		}

		return $offers;
	}
}

$cortexOffers = new Cortex_Kulturvermittlung_Offers();