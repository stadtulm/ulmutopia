<?php

/*
Widget Name: Bildergalerie
Description: Fügt eine Bildergalerie ein
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Gallery_Row_Widget extends SiteOrigin_Widget {

	function get_template_name($instance) {
		return 'gallery_row_template';
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
			'gallery_row_widget',

			// The name of the widget for display purposes.
			"Bildergalerie",

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => "Fügt eine Bildergalerie ein",
				// 'help'        => 'https://cortex-media.de',
				'panels_groups' => array('teilhabekultur')
			),

			//The $control_options array, which is passed through to WP_Widget
			array(
			),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'title' => array(
					'type' => 'text',
					'label' => 'Überschrift',
				),

				'a_images' => array(
					'type' => 'repeater',
					'label' => 'Bilder',
					'item_name'  => 'Bild',
					'fields' => array(
						'copyright' => array(
							'type' => 'text',
							'label' => 'Copyright des Bilds'
						),
						'image' => array(
							'type' => 'media',
							'choose' => 'Bild wählen',
							'update' => 'Bild einfügen',
							'library' => 'image' //'image', 'audio', 'video', 'file'
						),
					)
				),

			),

			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
}

siteorigin_widget_register('gallery_row_widget', __FILE__, 'Gallery_Row_Widget');
