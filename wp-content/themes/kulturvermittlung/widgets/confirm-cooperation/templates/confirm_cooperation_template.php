<?php
$userId = NULL;
$user = wp_get_current_user();
if(!empty($user)){
    if(in_array('artist', (array) $user->roles)){
        $userId = get_current_user_id();
    }
}

if(empty($userId)) {
    $redirectURL = add_query_arg('profileId', $_GET['profileId'], get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('confirm_cooperation')));
    include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/includes/login_needed.tpl.php');
} else {
    if(!empty($_GET['profileId'])) {
        $profileId = intval($_GET['profileId']);
        $cooperationProfiles = get_field('kooperationsprofile_intern', 'user_' . $profileId);

        //First confirm the cooperation partner for the other person
        foreach($cooperationProfiles AS $key => $cooperationProfile) {
            if($cooperationProfile['profil'] == $userId) {
                $cooperationProfile['akzeptiert'] = true;
            }
            $cooperationProfiles[$key] = $cooperationProfile;
        }
        update_field('kooperationsprofile_intern', $cooperationProfiles,  'user_' . $profileId);

        //Now look through our partners. If the id is present, also confirm it, otherwise just add it
        $alreadyAdded = false;
        $cooperationProfiles = get_field('kooperationsprofile_intern', 'user_' . $userId);
        foreach($cooperationProfiles AS $key => $cooperationProfile) {
            if($cooperationProfile['profil'] == $profileId) {
                $alreadyAdded = true;
                $cooperationProfile['akzeptiert'] = true;
            }
            $cooperationProfiles[$key] = $cooperationProfile;
        }
        if(!$alreadyAdded) {
            $cooperationProfiles[] = array('profil' => $profileId, 'akzeptiert' => true, 'email_verschickt' => true);
        }
        update_field('kooperationsprofile_intern', $cooperationProfiles,  'user_' . $userId);
        ?>
        <script>
            window.location.replace('<?php echo add_query_arg('message', 'success_cooperation', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile')));?>');
        </script>
    <?php  } else { ?>
        <script>
            window.location.replace('<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile'));?>');
        </script>
    <?php }
}
