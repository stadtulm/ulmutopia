<?php

/*
Widget Name: Angebotsübersicht
Description: Übersicht aller Angebote
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Offer_Overview_Widget extends SiteOrigin_Widget {

	function get_template_name($instance) {
		return 'offer_overview_template';
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
			'offer_overview_widget',

			// The name of the widget for display purposes.
			"Angebotsübersicht",

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => "Übersicht aller Angebote",
				// 'help'        => 'https://cortex-media.de',
				'panels_groups' => array('teilhabekultur')
			),

			//The $control_options array, which is passed through to WP_Widget
			array(
			),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'heading' => array(
					'type' => 'text',
					'label' => 'Überschrift',
				),

				'text' => array(
					'type' => 'tinymce',
					'label' => 'Text',
				),
			),

			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
}

siteorigin_widget_register('offer_overview_widget', __FILE__, 'Offer_Overview_Widget');
