<?php
	$userId = NULL;

	//Check if we have a profile ID, otherwise we'll show the own profile of the user
	if(!empty($_GET['profileId'])) {
        $userId = intval($_GET['profileId']);
        if ($userId == get_current_user_id()) {
            $allowEdit = true;
        }
    } else if(!empty(get_query_var('profileId'))) {
        $userId = intval(get_query_var('profileId'));
        if ($userId == get_current_user_id()) {
            $allowEdit = true;
        }
	} else {
		$user = wp_get_current_user();
		if(!empty($user)){
			if(in_array('artist', (array) $user->roles)){
				$userId = get_current_user_id();
				$allowEdit = true;
			}
		}
	}

	if(empty($userId)){
		//User is not logged in or not valid
		include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/includes/login_needed.tpl.php');
	} else if($allowEdit && !get_field('aktiv', 'user_' . $userId)) {
		//Profile is not active, redirect!
		include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/includes/login_needed.tpl.php');
	} else {
		$userIdACF = 'user_' . $userId;
		$userInfo  = get_userdata($userId);
		include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/profile/show_profile.tpl.php');
	}