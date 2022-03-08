<?php

class Cortex_Kulturvermittlung_Favorites {
	public function __construct(){
		add_action('wp_ajax_nopriv_kulturvermittlung_load_favorites', array($this, 'loadFavorites'));
		add_action('wp_ajax_kulturvermittlung_load_favorites', array($this, 'loadFavorites'));

		add_action('wp_ajax_nopriv_kulturvermittlung_add_favorite', array($this, 'addFavorite'));
		add_action('wp_ajax_kulturvermittlung_add_favorite', array($this, 'addFavorite'));

		add_action('wp_ajax_nopriv_kulturvermittlung_remove_favorite', array($this, 'removeFavorite'));
		add_action('wp_ajax_kulturvermittlung_remove_favorite', array($this, 'removeFavorite'));

		add_action('wp_ajax_nopriv_kulturvermittlung_check_for_favorite', array($this, 'checkForFavorite'));
		add_action('wp_ajax_kulturvermittlung_check_for_favorite', array($this, 'checkForFavorite'));

		add_action('admin_post_nopriv_kulturvermittlung_send_favorites', array($this, 'sendFavorites'));
		add_action('admin_post_kulturvermittlung_send_favorites', array($this, 'sendFavorites'));

	}

    /* Ajax function that will load the favorites of logged in user from his acf files or otherwise loads them by IDs from a POST field
    -------------------------------------------------------------------------------*/
	public function loadFavorites() {
		$template_dir = get_template_directory_uri();
		$profileHTML = '';
		$offerHTML = '';
		$formFields = '';
		$profileFavoriteIds = [];
		$offerFavoriteIds = [];

		if(is_user_logged_in()){
			$profileFavorites = get_field('profile_favorites', 'user_' . get_current_user_id());
			if(is_array($profileFavorites)){
				foreach($profileFavorites as $favorite) {
					$profileFavoriteIds[] = $favorite['id'];
				}
			}

			$offerFavorites = get_field('offer_favorites', 'user_' . get_current_user_id());
			if(is_array($offerFavorites)){
				foreach($offerFavorites as $favorite) {
					$offerFavoriteIds[] = $favorite['id'];
				}
			}
		}else if(!empty($_POST['data']['profileFavorites']) || !empty($_POST['data']['offerFavorites'])) {
			$profileFavoriteIds = $_POST['data']['profileFavorites'];
			$offerFavoriteIds = $_POST['data']['offerFavorites'];
		}

		$hasFavorites = false;
		$hasProfileFavorites = false;
		if(is_array($profileFavoriteIds) && sizeof($profileFavoriteIds) > 0) {
			foreach($profileFavoriteIds AS $profileId) {
				if(get_field('aktiv', 'user_' . $profileId) && get_userdata($profileId) !== false) {
					$hasFavorites = true;
					$hasProfileFavorites = true;
					ob_start();
					include('templates/tiles/profile_tile.tpl.php');
					$profileHTML .= ob_get_clean();

					$formFields .= '<input type="hidden" name="profiles[]" value="' . $profileId . '"/>';
				}
			}
		}

		if(!$hasProfileFavorites) {
			$profileHTML .= translate('Du hast dir noch keine Profile als Favorit gespeichert.', 'teilhabekultur');
		}

		$hasOfferFavorites = false;
		if(is_array($offerFavoriteIds) && sizeof($offerFavoriteIds) > 0) {
			foreach($offerFavoriteIds AS $offerId) {
				if(get_field('aktiv', $offerId) && get_post_status($offerId) == 'publish'){
					$hasFavorites = true;
					$hasOfferFavorites = true;
					ob_start();
					include('templates/tiles/offer_tile.tpl.php');
					$offerHTML  .= ob_get_clean();
					$formFields .= '<input type="hidden" name="offers[]" value="' . $offerId . '"/>';
				}
			}
		}

		if(!$hasOfferFavorites){
			$offerHTML .= translate('Du hast dir noch keine Angebote als Favorit gespeichert.', 'teilhabekultur');
		}

		wp_send_json_success(array('profileFavorites' => $profileHTML, 'offerFavorites' => $offerHTML, 'formFields' => $formFields, 'hasFavorites' => $hasFavorites));
	}

    /* Ajax function that will add favorites to the acf fields of an logged in user
    -------------------------------------------------------------------------------*/
	public function addFavorite() {
		if(is_user_logged_in()){
			if( ! empty($_POST['data']['type']) && ! empty($_POST['data']['id'])){
				if($_POST['data']['type'] == 'profile'){
					$field = 'profile_favorites';
				} else if($_POST['data']['type'] == 'offer'){
					$field = 'offer_favorites';
				} else{
					wp_send_json_error(array('msg' => 'type was not correctly specified'));
					return;
				}


				$favorites = get_field($field, 'user_' . get_current_user_id());
				$favorites[] = array('id' => intval($_POST['data']['id']));

				update_field($field, $favorites, 'user_' . get_current_user_id());
				wp_send_json_success();
			} else{
				wp_send_json_error(array('msg' => 'Important parameter missing'));
				return;
			}
		} else {
			wp_send_json_error(array('msg' => 'user is not logged in'));
		}
	}

    /* Ajax function that will remove favorites to the acf fields of an logged in user
    -------------------------------------------------------------------------------*/
	public function removeFavorite() {
		if(is_user_logged_in()){
			if( ! empty($_POST['data']['type']) && ! empty($_POST['data']['id'])){
				if($_POST['data']['type'] == 'profile'){
					$field = 'profile_favorites';
				} else if($_POST['data']['type'] == 'offer'){
					$field = 'offer_favorites';
				} else{
					wp_send_json_error(array('msg' => 'type was not correctly specified'));
					return;
				}

				$favorites = get_field($field, 'user_' . get_current_user_id());

				$keyToRemove = NULL;
				foreach($favorites AS $key => $favorite) {
					if($favorite['id'] == $_POST['data']['id']) {
						$keyToRemove = $key;
						break;
					}
				}

				if($keyToRemove !== NULL) {
					unset($favorites[$keyToRemove]);
				}

				update_field($field, $favorites, 'user_' . get_current_user_id());
				wp_send_json_success();
			} else{
				wp_send_json_error(array('msg' => 'Important parameter missing'));
				return;
			}
		} else {
			wp_send_json_error(array('msg' => 'user is not logged in'));
		}
	}

    /* Ajax function that checks if an offer or tip is already on the favorites list of a user (in order to make the heart red on the detail page of an offer or tip)
    -------------------------------------------------------------------------------*/
	public function checkForFavorite() {
		if(is_user_logged_in()){
			if( ! empty($_POST['data']['type']) && ! empty($_POST['data']['id'])){
				if($_POST['data']['type'] == 'profile'){
					$field = 'profile_favorites';
				} else if($_POST['data']['type'] == 'offer'){
					$field = 'offer_favorites';
				} else{
					wp_send_json_success(array('isFavorite' => false));
					return;
				}

				$favorites = get_field($field, 'user_' . get_current_user_id());
				if(is_array($favorites)){
					foreach($favorites as $favorite) {
						if($favorite['id'] == $_POST['data']['id']){
							wp_send_json_success(array('isFavorite' => true));

							return;
						}
					}
				}

				wp_send_json_success(array('isFavorite' => false));
				return;
			} else{
				wp_send_json_success(array('isFavorite' => false));
				return;
			}
		} else {
			wp_send_json_success(array('isFavorite' => false));
		}
	}


    /* The Ajax function send the list of favorites via email
    -------------------------------------------------------------------------------*/
	public function sendFavorites() {
		if(!empty($_POST['email']) && is_email($_POST['email'])) {
			$profileIds = array();
			$offerIds = array();

			foreach($_POST['profiles'] AS $id) {
				$profileIds[] = $id;
			}

			foreach($_POST['offers'] AS $id) {
				$offerIds[] = $id;
			}

			$cortexMailer = new Cortex_Kulturvermittlung_Emailer();
			$cortexMailer->sendFavorites($profileIds, $offerIds, $_POST['email']);

			wp_redirect(add_query_arg('message', "success",get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('favorites'))), '303');
			exit();
		} else{
			wp_redirect(add_query_arg('message', "error",get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('favorites'))), '303');
			exit();
		}

	}
}

$cortexKulturFavorites = new Cortex_Kulturvermittlung_Favorites();