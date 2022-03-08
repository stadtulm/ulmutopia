<?php

class Cortex_Kulturvermittlung_Profiles{
	public function __construct(){
		add_action('admin_post_nopriv_kulturvermittlung_change_email_password', array($this, 'changeEmailAndPassword'));
		add_action('admin_post_kulturvermittlung_change_email_password', array($this, 'changeEmailAndPassword'));

		add_action('admin_post_nopriv_kulturvermittlung_deactive_profile', array($this, 'deactivateMyProfile'));
		add_action('admin_post_kulturvermittlung_deactive_profile', array($this, 'deactivateMyProfile'));

		add_action('wp_ajax_nopriv_kulturvermittlung_get_profiles', array($this, 'getProfiles'));
		add_action('wp_ajax_kulturvermittlung_get_profiles', array($this, 'getProfiles'));

        add_action('init', array($this, 'addRewrites'));
	}

    public function addRewrites() {
        $profiles = $this->getFilteredProfiles();
        add_rewrite_tag('%profileId%','([^\d]+)');
        foreach($profiles AS $profile) {
            add_rewrite_rule('^profile/' . sanitize_title(get_field('name_institution_kuenstlerin','user_' .  $profile->ID)) . '/?$','index.php?page_id=' . Cortex_Kulturvermittlung_Config::getPageId('profile' ) . '&profileId=' . $profile->ID,'top');
        }

        flush_rewrite_rules();
    }

    /* This function generates an link to the given profile id
    -------------------------------------------------------------------------------*/
	public static function generateProfileLink($userId) {
        return '/profile/' .  sanitize_title(get_field('name_institution_kuenstlerin', 'user_' . $userId));
	}

    /* This function handles the frontend UI to change an unsers email and/or password
    -------------------------------------------------------------------------------*/
	public static function changeEmailAndPassword() {
		if(is_user_logged_in()){
			$userInfo = get_userdata(get_current_user_id());
			//First check if the User entered the correct password
			$currentEmail = $userInfo->user_email;
			$password = $_POST['password'];
			$newEmail = $_POST['email'];
			$message = '';

			$user = wp_authenticate_email_password(null, $currentEmail, $password);
			if(is_wp_error($user)){
				//The entered Password is not correct
				wp_redirect(add_query_arg('message', 'wrong_password', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('change_email_password'))), '303');
				exit();
			} else if($user->ID != get_current_user_id()) {
				//The user/pwd combination does not belong to the logged in user
				wp_redirect(add_query_arg('message', 'wrong_password', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('change_email_password'))), '303');
				exit();
			}

			if($newEmail != $currentEmail) {
				if(!is_email($newEmail)) {
					//The new email address is not a valid email address
					wp_redirect(add_query_arg('message', 'email_false', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('change_email_password'))), '303');
					exit();
				}

				if(email_exists($newEmail)) {
					//The new email address is already taken
					wp_redirect(add_query_arg('message', 'email_exists', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('change_email_password'))), '303');
					exit();
				}

				$result = wp_update_user( array( 'ID' => $user->ID, 'user_email' => $newEmail));

				if(is_wp_error($result)){
					//The change could not be made .. no idea why
					wp_redirect(add_query_arg('message', 'error', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('change_email_password'))), '303');
					exit();
				} else{
					$message = 'success';
				}
			}

			if(isset($_POST['new_password']) && !empty($_POST['new_password'])) {
				if(empty($_POST['new_password']) || empty($_POST['password_confirm']) || $_POST['new_password'] != $_POST['password_confirm']) {
					//The new password is either empty or doesn't match the confirmed password
					wp_redirect(add_query_arg('message', 'password_error', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('change_email_password'))), '303');
					exit();
				} else {
					wp_set_password($_POST['new_password'], get_current_user_id());
					$message = 'password_changed';
				}
			}

			if($message == 'success') {
				wp_redirect(add_query_arg('message', $message, get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile'))), '303');
				exit();
			} else {
				wp_redirect(add_query_arg('login', $message, get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register'))), '303');
				exit();
			}
		}
	}

    /* This function handles the deactivation of the currently logged in user
    -------------------------------------------------------------------------------*/
	public function deactivateMyProfile() {
		$userId = get_current_user_id();
		update_field('aktiv', false ,'user_' . $userId);
		wp_logout();
		wp_redirect(add_query_arg('login', 'deactivated', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register'))), '303');
		exit();
	}

    /* This function returns an filtered HTML list of profiles via an Ajax request, e.g. for the profile overview page
    -------------------------------------------------------------------------------*/
	public function getProfiles() {
		$categories = array();
		$searchString = '';

		if(!empty($_POST['data']['categories'])) {
			$categories = $_POST['data']['categories'];
		}

		if(!empty($_POST['data']['searchString'])) {
			$searchString = $_POST['data']['searchString'];
		}

		$profiles = self::getFilteredProfiles(array(), $categories, $searchString);
		$html = '';
		$template_dir = get_template_directory_uri();

		if(sizeof($profiles) > 0){
			foreach($profiles as $profile) {
				ob_start();
				$profileId = $profile->ID;
				include('templates/tiles/profile_tile.tpl.php');
				$html .= ob_get_clean();
			}
		} else {
			$html .= '<div class="no-results">' . translate('Für diese Anfrage wurden leider keine passenden Kulturprofile gefunden.', 'teilhabekultur') . '</div>';
		}

		wp_send_json_success(array('html' => $html));
	}

    /* This function returns an filtered array of profiles, to be used to print profile tiles inside the PHP code
    -------------------------------------------------------------------------------*/
	public static function getFilteredProfiles($excludeIds = array(), $categories = array(), $searchString = '', $limit = NULL) {
		$query_args = array(
			'role' => 'artist',
			'exclude' => $excludeIds,
			'orderby' => 'user_registered',
			'order' => 'DESC'
		);

		//The filters different filters must all match
		$meta_query = array(
			'relation' => 'AND'
		);

		//We only want active profiles
		$meta_query[] = array(
			'key'     => 'aktiv',
			'value'   => '1',
			'compare' => '='
		);

		//Is there a search string?
		if(!empty($searchString)){
			$meta_query[] = array(
				'key'     => 'name_institution_kuenstlerin',
				'value'   => sanitize_text_field($searchString),
				'compare' => 'LIKE'
			);
		}

		if(is_array($categories) && sizeof($categories) > 0) {
			if(sizeof($categories) == 1) {
				$meta_query[] = array(
					'key'     => 'sparten',
					'value'   => $categories[0],
					'compare' =>  'LIKE'
				);
			} else {
				$meta_query_categories = array(
					'relation' => 'OR'
				);

				foreach($categories as $category) {
					$meta_query_categories[] = array(
						'key'     => 'sparten',
						'value'   => $category,
						'compare' =>  'LIKE'
					);
				}
				$meta_query[] = $meta_query_categories;
			}
		}

		$query_args['meta_query'] = $meta_query;
		$profiles = get_users($query_args);

		usort($profiles, array('Cortex_Kulturvermittlung_Utils','sortProfiles'));

		if($limit != NULL) {
			$profiles = array_splice($profiles, 0, $limit);
		}

		return $profiles;
	}

    /* This returns an array of all cooperation profiles of a certain userId
   -------------------------------------------------------------------------------*/
    public static function getCooperationProfiles($userId, $onlyAccepted = true) {
        $cooperationProfiles = array();
        if(!empty(get_field('kooperationsprofile_intern', 'user_' . $userId) && is_array(get_field('kooperationsprofile_intern', 'user_' . $userId)))) {
            foreach (get_field('kooperationsprofile_intern', 'user_' . $userId) as $cooperationProfile) {
                if ($onlyAccepted) {
                    if ($cooperationProfile['akzeptiert']) {
                        if(get_field('aktiv', 'user_' . $cooperationProfile['profil'])) {
                            $cooperationProfiles[] = $cooperationProfile['profil'];
                        }
                    }
                } else {
                    if(get_field('aktiv', 'user_' . $cooperationProfile['profil'])) {
                        $cooperationProfiles[] = $cooperationProfile['profil'];
                    }
                }
            }
        }

        return $cooperationProfiles;
    }
}

$cortexKulturProfiles = new Cortex_Kulturvermittlung_Profiles();