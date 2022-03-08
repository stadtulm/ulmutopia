<?php

/*
Widget Name: Kooperation bestätigen
Description: Widget um den Klick auf Kooperation bestätigen zu verarbeiten
Author: Cortex Media GmbH
Author URI: https://cortex-media.de
Widget URI: https://cortex-media.de
*/

class Confirm_Cooperation_Widget extends SiteOrigin_Widget {

    function get_template_name($instance) {
        return 'confirm_cooperation_template';
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
            'confirm_cooperation_widget',

            // The name of the widget for display purposes.
            "Kooperation bestätigen",

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => "Widget um den Klick auf Kooperation bestätigen zu verarbeiten",
                // 'help'        => 'https://cortex-media.de',
                'panels_groups' => array('teilhabekultur')
            ),

            //The $control_options array, which is passed through to WP_Widget
            array(
            ),

            //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }
}

siteorigin_widget_register('confirm_cooperation_widget', __FILE__, 'Confirm_Cooperation_Widget');
