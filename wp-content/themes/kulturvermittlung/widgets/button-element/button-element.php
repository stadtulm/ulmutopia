<?php

/*
Widget Name: Schaltfläche
Description: Fügt eine Schaltfläche mit einer Verlinkung ein
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Button_Element_Widget extends SiteOrigin_Widget {

	function get_template_name($instance) {
		return 'button_element_template';
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
			'button_element_widget',

			// The name of the widget for display purposes.
			"Schaltfläche",

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => "Fügt eine Schaltfläche mit einer Verlinkung ein",
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
					'label' => 'Beschriftung',
				),

				'font_weight' => array(
					'type' => 'select',
					'label' => 'Schriftstärke',
					'default' => 'bold',
					'options' => array(
						'normal' => 'normal',
						'bold' => 'fett'
					)
				),

				'target' => array(
					'type' => 'link',
					'label' => 'Ziel der Verlinkung',
				),

				'external' => array(
					'type' => 'checkbox',
					'label' => "Neues Fenster?",
					'default' => false
				),
			),

			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
}

siteorigin_widget_register('button_element_widget', __FILE__, 'Button_Element_Widget');
