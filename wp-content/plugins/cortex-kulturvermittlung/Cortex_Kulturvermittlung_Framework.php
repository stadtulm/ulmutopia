<?php
/*
Plugin Name: Kulturvermittlung
Plugin URI: https://www.kulturvermittlung-ulm.de
Description: Plugin for handling all Functions of the Kulturvermittlung Website
Version: 1.0
Author: Cortex Media GmbH
Author URI:  https://www.cortex-media.de
*/

require_once('Cortex_Kulturvermittlung_Config.php');
require_once('Cortex_Kulturvermittlung_Registration.php');
require_once('Cortex_Kulturvermittlung_File_Handler.php');
require_once('Cortex_Kulturvermittlung_Utils.php');
require_once('Cortex_Kulturvermittlung_Offers.php');
require_once('Cortex_Kulturvermittlung_Tips.php');
require_once('Cortex_Kulturvermittlung_Emailer.php');
require_once('Cortex_Kulturvermittlung_Favorites.php');
require_once ('Cortex_Kulturvermittlung_Profiles.php');
require_once('Cortex_Kulturvermittlung_Search.php');
require_once('Cortex_Kulturvermittlung_Admin.php');

class Cortex_Kulturvermittlung_Framework {
	public function __construct() {
		add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
		add_action( 'wp_login_failed', array($this, 'customLoginFailed'));
		add_action('wp_login', array($this, 'checkIfActive'), 10, 2);
		add_action('init', array($this, 'cortexInit'));
	}

	public function enqueueScripts() {

	}

	public function cortexInit() {
		$labels = array(
			'name' => 'Angebote',
			'singular_name' => 'Angebot',
			'add_new' => 'Neu anlegen',
			'add_new_item' => 'Neues Angebot anlegen',
			'edit_item' => 'Angebot bearbeiten',
			'new_item' => 'Neues Angebot',
			'view_item' => 'Angebot anzeigen',
			'search_items' => 'Angebot suchen',
			'not_found' => 'Keine Angebote gefunden',
			'not_found_in_trash' => 'Keine Einträge im Papierkorb gefunden',
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => plugin_dir_url(__FILE__) . '/assets/img/menu-icon.png',
			'rewrite' => array('slug' => 'angebot'),
			'capability_type' => 'post',
			'hierarchical' => false,
			'taxonomies' => array('post_tag'),
			'menu_position' => null,
			'supports' => array('title', 'revisions', 'author')
		);

		register_post_type('angebot', $args);

		$labels = array(
			'name' => 'Tipps',
			'singular_name' => 'Tipp',
			'add_new' => 'Neu anlegen',
			'add_new_item' => 'Neuen Tipp anlegen',
			'edit_item' => 'Tipp bearbeiten',
			'new_item' => 'Neuen Tipp',
			'view_item' => 'Tipp anzeigen',
			'search_items' => 'Tipp suchen',
			'not_found' => 'Keine Tipps gefunden',
			'not_found_in_trash' => 'Keine Einträge im Papierkorb gefunden',
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => plugin_dir_url(__FILE__) . '/assets/img/menu-icon.png',
			'rewrite' => array('slug' => 'tipp'),
			'capability_type' => 'post',
			'hierarchical' => false,
			'taxonomies' => array('post_tag'),
			'menu_position' => null,
			'supports' => array('title', 'revisions', 'author')
		);

		register_post_type('tip', $args);
		add_action('wp_ajax_cortex_send_contact_form', array($this, 'sendContactForm'));
		add_action('wp_ajax_nopriv_cortex_send_contact_form', array($this, 'sendContactForm'));

		add_rewrite_rule(
			'^search/$',
			'index.php?s=',
			'top'
		);
	}

	public static function activationHook() {
		add_role('artist', __('Kulturschaffenden'), array());
	}


    /* If the user is logged in through our login form, redirect him back and show error
    -------------------------------------------------------------------------------*/
	function customLoginFailed($username) {
		$referrer = wp_get_referer();
		if ($referrer && !strstr($referrer, 'wp-login') && !strstr($referrer,'wp-admin') ){
			wp_redirect(add_query_arg('login', 'failed', $referrer));
			exit();
		}
	}

    /* If the user is logged in through our login form, check if it's an active profile and redirect him to the login page
    -------------------------------------------------------------------------------*/
	function checkIfActive($user_login, $user) {
		if(!get_field('aktiv','user_' . $user->ID) && in_array('artist', (array) $user->roles)) {
			wp_logout();
			if(!empty(get_field('aktivierungsdatum','user_' . $user->ID))) {
				wp_redirect(add_query_arg('login', 'not_active', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register'))), '303');
			} else{
				wp_redirect(add_query_arg('login', 'created', get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register'))), '303');
			}
			exit();
		}
	}

    /* Ajax Function that handles the sending of the contact form
    -------------------------------------------------------------------------------*/
	public function sendContactForm() {
		$cortexMailer = new Cortex_Kulturvermittlung_Emailer();
		$data = $_POST['data'];
		$cortexMailer->sendContactForm($data);
		wp_send_json_success();
	}
}

register_activation_hook( __FILE__, array ('Cortex_Kulturvermittlung_Framework', 'activationHook'));
$cortexKulturvermittlung = new Cortex_Kulturvermittlung_Framework();