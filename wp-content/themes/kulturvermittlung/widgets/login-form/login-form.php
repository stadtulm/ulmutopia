<?php

/*
Widget Name: Login Formular
Description: Fügt das Login Formular ein
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Teilhabekultur_Login_Form_Widget extends SiteOrigin_Widget {

	function get_template_name($instance) {
		return 'login_form_template';
	}

	function get_template_dir($instance) {
		return 'templates';
	}

	function get_style_name($instance) {
		return '';
	}

	function __construct() {
		//Call the parent constructor with the required arguments.

		parent::__construct(
		// The unique id for your widget.
			'teilhabekultur_login_form_widget',

			// The name of the widget for display purposes.
			"Login Formular",

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => "Fügt das Login Formular ein",
				// 'help'        => 'https://cortex-media.de',
				'panels_groups' => array('teilhabekultur')
			),

			//The $control_options array, which is passed through to WP_Widget
			array(
			),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'heading_1' => array(
					'type' => 'text',
					'label' => 'Überschrift Teil 1',
				),

				'heading_2' => array(
					'type' => 'text',
					'label' => 'Überschrift Teil 2',
				),

				'description' => array(
					'type' => 'tinymce',
					'label' => 'Beschreibungstext über den Login-Formular',
				),

				'register_now_text' => array(
					'type' => 'tinymce',
					'label' => 'Text über der Registrieren Schaltfläche',
				),
			),

			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
}

siteorigin_widget_register('teilhabekultur_login_form_widget', __FILE__, 'Teilhabekultur_Login_Form_Widget');
