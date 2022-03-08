<?php

class Cortex_Kulturvermittlung_Tips{
	public function __construct(){
		add_action( 'admin_post_nopriv_kulturvermittlung_save_tip', array($this, 'saveTip'));
		add_action( 'admin_post_kulturvermittlung_save_tip', array($this, 'saveTip'));

		add_action('wp_ajax_nopriv_kulturvermittlung_get_tips', array($this, 'getTips'));
		add_action('wp_ajax_kulturvermittlung_get_tips', array($this, 'getTips'));
	}

    /* This saves an tip from the add new tip form in the front end
   -------------------------------------------------------------------------------*/
	public function saveTip() {
		$tipId = NULL;

        //Verify the WP Nonce
        if(!wp_verify_nonce( $_POST['_wpnonce'], 'kulturvermittlung_edit_tip')) {
            wp_nonce_ays(__("Wollen Sie wirklich einen Tipp bearbeiten?"));
        }

		if(isset($_POST['tipId']) && !empty('tipId')){
			$tipId = $_POST['tipId'];
		}

		$title = $_POST['title'];

		if($tipId === NULL) {
			$tipId = wp_insert_post(array (
				'post_type' => 'tip',
				'post_title' => $title,
				'post_content' => '',
				'post_status' => 'publish',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
			));
			$message = 'created';

			update_field('aktiv', false, $tipId);
		} else {
            if(get_post_field('post_author', $tipId) == get_current_user_id()) {
                wp_update_post(array(
                        'ID' => $tipId,
                        'post_title' => $title
                    )
                );
                $message = 'success';
            } else {
                wp_redirect(get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('tip_overview')), '303');
                exit();
            }
		}

        if(is_user_logged_in()) {
			$userInfo  = get_userdata(get_current_user_id());

			update_field('profil',get_current_user_id(), $tipId);
			update_field('profilname', get_field('name_institution_kuenstlerin', 'user_' . get_current_user_id()), $tipId);
			update_field('e-mailadresse', $userInfo->user_email, $tipId);
			update_field('telefon',  get_field('telefon', 'user_' . get_current_user_id()), $tipId);
		} else {
			update_field('profilname',$_POST['profilname'], $tipId);
			update_field('e-mailadresse', $_POST['e-mailadresse'], $tipId);
			update_field('telefon', $_POST['telefon'], $tipId);
		}

		update_field('link', $_POST['link'], $tipId);
		update_field('bereich', $_POST['bereich'], $tipId);
		update_field('beschreibung', $_POST['beschreibung'], $tipId);

		$cortexMailer = new Cortex_Kulturvermittlung_Emailer();
		$cortexMailer->sendAdminNewTip($tipId);

		wp_redirect(add_query_arg('message', $message,get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('tip_overview'))), '303');
		exit();
	}

    /* Function to render the list of all tips (either for one category, or for all categories
   -------------------------------------------------------------------------------*/
	public function getTips() {
		if(!empty($_POST['data']['category'])) {
			$tips = Cortex_Kulturvermittlung_Tips::getTippsForCategory($_POST['data']['category']);
		} else {
			$tips = Cortex_Kulturvermittlung_Tips::getTippsForCategory();
		}

		$sector = Cortex_Kulturvermittlung_Config::$tipSectors[$_POST['data']['category']];
		$html = '<div class="tip-sector"><h3>' . $sector . '</h3>';

		if(sizeof($tips) > 0){
			$html .= '<div class="tip-overview">';
			foreach($tips as $tip) {
				ob_start();
				$tipId = $tip->ID;
				include('templates/tiles/tip_tile.tpl.php');
				$html .= ob_get_clean();
			}
			$html .= '</div>';
		} else {
			$html .= '<p>' . translate('In dieser Kategorie sind noch keine Tipps vorhanden.', 'teilhabekultur') . '</p>';
		}

		$html .= '</div>';

		wp_send_json_success(array('html' => $html));
	}

    /* This function returns an array of all tips or all tips in one category
   -------------------------------------------------------------------------------*/
	public static function getTippsForCategory($category = NULL) {
		$args = array(
			'orderby'       =>  'title',
			'order'         =>  'ASC',
			'posts_per_page' => -1,
			'post_type' => 'tip'
		);

		//The filters different filters must all match
		$meta_query = array(
			'relation' => 'AND'
		);

		$meta_query[] = array(
			'key'     => 'aktiv',
			'value'   => '1',
			'compare' => '='
		);

		if($category != NULL){
			$meta_query[] = array(
				'key'     => 'bereich',
				'value'   => $category,
				'compare' => '='
			);
		}

		$args['meta_query'] = $meta_query;

		$tips = get_posts($args);
		return $tips;
	}
}

$cortexTips = new Cortex_Kulturvermittlung_Tips();