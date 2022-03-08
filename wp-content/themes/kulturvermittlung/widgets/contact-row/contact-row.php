<?php

/*
Widget Name: Kontakt-Zeile
Description: Fügt die Kontaktzeile mit dem Call-To-Action ein
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Contact_Row_Widget extends SiteOrigin_Widget {

	function get_template_name($instance) {
		return 'contact_row_template';
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
			'contact_row_widget',

			// The name of the widget for display purposes.
			"Kontakt-Zeile",

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => "Fügt die Kontaktzeile mit dem Call-To-Action ein",
				// 'help'        => 'https://cortex-media.de',
				'panels_groups' => array('teilhabekultur')
			),

			//The $control_options array, which is passed through to WP_Widget
			array(
			),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'caption' => array(
					'type' => 'text',
					'label' => 'Beschriftung der Schaltfläche',
				),

				'target' => array(
					'type' => 'text',
					'label' => 'E-Mailadresse',
				),

			),

			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
}

siteorigin_widget_register('contact_row_widget', __FILE__, 'Contact_Row_Widget');
