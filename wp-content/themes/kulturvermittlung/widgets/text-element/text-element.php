<?php

/*
Widget Name: Text Element
Description: Fügt einen formatierbaren Text ein
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Text_Element_Widget extends SiteOrigin_Widget {

	function get_template_name($instance) {
		return 'text_element_template';
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
			'text_element_widget',

			// The name of the widget for display purposes.
			"Text Element",

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => "Fügt einen formatierbaren Text ein",
				// 'help'        => 'https://cortex-media.de',
				'panels_groups' => array('teilhabekultur')
			),

			//The $control_options array, which is passed through to WP_Widget
			array(
			),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'text' => array(
					'type' => 'tinymce',
					'label' => 'Text',
				),

				'col_count' => array(
					'type' => 'select',
					'label' => 'Anzahl der Spalten',
					'default' => '1',
					'options' => array(
						'1' => 'einspaltig',
						'2' => 'zweispaltig'
					)
				),

				'text_alignment' => array(
					'type' => 'select',
					'label' => 'Textausrichtung',
					'default' => '1',
					'options' => array(
						'left' => 'linksbündig',
						'center' => 'zentriert'
					)
				),
			),

			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
}

siteorigin_widget_register('text_element_widget', __FILE__, 'Text_Element_Widget');
