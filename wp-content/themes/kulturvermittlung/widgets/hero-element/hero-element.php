<?php

/*
Widget Name: Hero Element
Description: Fügt das Hero Element ein
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Hero_Element_Widget extends SiteOrigin_Widget {

	function get_template_name($instance) {
		return 'hero_element_template';
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
			'hero_element_widget',

			// The name of the widget for display purposes.
			"Hero Element",

			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => "Fügt das Hero Element ein",
				// 'help'        => 'https://cortex-media.de',
				'panels_groups' => array('teilhabekultur')
			),

			//The $control_options array, which is passed through to WP_Widget
			array(
			),

			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'size' => array(
					'type' => 'select',
					'label' => 'Größe wählen',
					'default' => 'small',
					'options' => array(
						'small' => 'Klein',
						'groß' => 'groß',
					)
				),

				'heading_normal' => array(
					'type' => 'text',
					'label' => 'Überschrift Teil 1',
				),

				'heading_strong' => array(
					'type' => 'text',
					'label' => 'Überschrift Teil 2 (fett)',
				),

				'blue_background' => array(
					'type' => 'checkbox',
					'label' => "Blauer Hintergrund für Überschrift?",
					'default' => false
				),

				'introduction' => array(
					'type' => 'tinymce',
					'label' => 'Einleitungstext',
				),

				'image' => array(
					'type' => 'media',
					'choose' => 'Titelbild wählen',
					'update' => 'Titelbild einfügen',
					'library' => 'image' //'image', 'audio', 'video', 'file'
				),

				//This not used atm b/c the islands are shown randomly
				'island' => array(
					'type' => 'select',
					'label' => 'Insel wählen',
					'default' => '',
					'options' => array(
						'' => 'Keine',
						'insel01' => 'Insel 1',
						'insel02' => 'Insel 2',
						'insel03' => 'Insel 3',
						'insel04' => 'Insel 4',
						'insel05' => 'Insel 5',
						'insel06' => 'Insel 6',
						'insel07' => 'Insel 7',
						'insel08' => 'Insel 8',
					)
				)
			),

			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
}

siteorigin_widget_register('hero_element_widget', __FILE__, 'Hero_Element_Widget');
