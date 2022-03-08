<?php

/*
Widget Name: Videoleiste
Description: Fügt eine Videoleiste ein
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Video_Row_Widget extends SiteOrigin_Widget {

	function get_template_name($instance) {
		return 'video_row_template';
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
			'video_row_widget',

			// The name of the widget for display purposes.
			"Videoleiste",

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => "Fügt eine Videoleiste ein",
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

				'a_videos' => array(
					'type' => 'repeater',
					'label' => 'Videos',
					'item_name'  => 'Video',
					'item_label' => array(
						'selector'     => "[id*='title']",
						'update_event' => 'change',
						'value_method' => 'val'
					),
					'fields' => array(
						'title' => array(
							'type' => 'text',
							'label' => 'Titel des Videos'
						),
						'videoURL' => array(
							'type' => 'text',
							'label' => 'URL zum Video'
						)
					)
				),

			),

			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
}

siteorigin_widget_register('video_row_widget', __FILE__, 'Video_Row_Widget');
