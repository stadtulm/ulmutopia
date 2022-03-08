<?php

/*
Widget Name: Standard Bild
Description: Fügt ein beliebiges Bild ein
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Image_Element_Widget extends SiteOrigin_Widget {

	function get_template_name($instance) {
		return 'image_element_template';
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
			'image_element_widget',

			// The name of the widget for display purposes.
			"Standard Bild",

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => "Fügt ein beliebiges Bild ein",
				// 'help'        => 'https://cortex-media.de',
				'panels_groups' => array('teilhabekultur')
			),

			//The $control_options array, which is passed through to WP_Widget
			array(
			),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'image' => array(
					'type' => 'media',
					'choose' => 'Bild wählen',
					'update' => 'Bild einfügen',
					'library' => 'image' //'image', 'audio', 'video', 'file'
				),

				'size' => array(
					'type' => 'select',
					'label' => 'Size',
					'options' => array(
						'auto' => 'Automatisch',
						'medium_large' => 'Klein',
						'medium' => 'Mittel',
						'large' => 'Groß',
					),
					'default' => 'auto'
				),

				'with_lightbox' => array(
					'type' => 'checkbox',
					'label' => "Mit Lightbox?",
					'default' => true
				),

				'caption' => array(
					'type' => 'text',
					'label' => 'Bildunterschrift',
				)
			),

			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
}

siteorigin_widget_register('image_element_widget', __FILE__, 'Image_Element_Widget');