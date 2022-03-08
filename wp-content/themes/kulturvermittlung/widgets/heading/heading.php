<?php

/*
Widget Name: Standard Überschrift
Description: Fügt eine oder mehrere Überschrift(en) ein
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Cortex_Heading_Widget extends SiteOrigin_Widget {

	function get_template_name($instance) {
		return 'cortex_heading_template';
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
			'cortex_heading_widget',

			// The name of the widget for display purposes.
			"Überschrift",

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => "Fügt eine oder mehrere Überschrift(en) ein",
				'panels_groups' => array('teilhabekultur')
			),

			//The $control_options array, which is passed through to WP_Widget
			array(
			),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'heading2' => array(
					'type' => 'text',
					'label' => 'Unterüberschrift h2',
				),
				'heading3' => array(
					'type' => 'text',
					'label' => 'Unterüberschrift h3',
				),
				'heading4' => array(
					'type' => 'text',
					'label' => 'Unterüberschrift h4',
				)
			),

			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
}

siteorigin_widget_register('cortex_heading_widget', __FILE__, 'Cortex_Heading_Widget');
