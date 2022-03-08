<?php
/*********************************
 * Setup
 *********************************/
/* Do not show the admin bar
-------------------------------------------------------------------------------*/
show_admin_bar(false);

/* Theme Setup Function
-------------------------------------------------------------------------------*/
if (!function_exists('teilhabekultur_setup')) {

	function teilhabekultur_setup() {
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size( 800, 800, true );


		register_nav_menus(array(
			'primary' => 'Hauptmenü uneingeloggt',
			'primary_logged_in' => 'Hauptmenü eingeloggt',
			'footer' => 'Footer',
		));

		add_theme_support('title-tag');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );
	}
}

add_action('after_setup_theme', 'teilhabekultur_setup');

/* Proper way to enqueue scripts and styles
-------------------------------------------------------------------------------*/
function teilhabekultur_scripts() {
	wp_enqueue_style('reset', get_template_directory_uri() . '/static/css/reset.css', array(),'1.0');
	wp_enqueue_style('fonts', get_template_directory_uri() . '/static/fonts/fonts.css', array(),'1.0');
	wp_enqueue_style('tiny-slider', get_template_directory_uri() . '/static/js/libs/tiny-slider.css', array(),'1.0');
	wp_enqueue_style('dropzone', get_template_directory_uri() . '/static/js/libs/dropzone.css', array(),'1.0');
	wp_enqueue_style('flatpicker', get_template_directory_uri() . '/static/js/libs/flatpickr.min.css', array(),'1.0');
	wp_enqueue_style('featherlight', get_template_directory_uri() . '/static/js/libs/featherlight.min.css', array(),'1.0');
	wp_enqueue_style('featherlight-gallery', get_template_directory_uri() . '/static/js/libs/featherlight.gallery.min.css', array(),'1.0');
	wp_enqueue_style('nouislider', get_template_directory_uri() . '/static/js/libs/nouislider.css', array(),'1.0');
	wp_enqueue_style('select2', get_template_directory_uri() . '/static/js/libs/select2.min.css', array(),'1.0');
	wp_enqueue_style('cropper', get_template_directory_uri() . '/static/js/libs/cropper.min.css', array(),'1.0');

	wp_enqueue_style('style', get_stylesheet_uri(), array(),'1.8.9');

	wp_enqueue_script('tiny-slider', get_template_directory_uri() . '/static/js/libs/tiny-slider.js', array('jquery'), '1.0.0', false);
	wp_enqueue_script('dropzone', get_template_directory_uri() . '/static/js/libs/dropzone.js', array('jquery'), '1.0.0', false);
	wp_enqueue_script('featherlight', get_template_directory_uri() . '/static/js/libs/featherlight.min.js', array('jquery'), '1.0.0', false);
	wp_enqueue_script('featherlight-gallery', get_template_directory_uri() . '/static/js/libs/featherlight.gallery.min.js', array('jquery'), '1.0.0', false);
	wp_enqueue_script('flatpicker', get_template_directory_uri() . '/static/js/libs/flatpickr.js', array('jquery'), '1.0.0', false);
	wp_enqueue_script('flatpicker-de', get_template_directory_uri() . '/static/js/libs/flatpickr_de.js', array('jquery'), '1.0.0', false);
	wp_enqueue_script('nouislider', get_template_directory_uri() . '/static/js/libs/nouislider.js', array(),'1.0', false);
	wp_enqueue_script('select2', get_template_directory_uri() . '/static/js/libs/select2.min.js', array(),'1.0', false);
	wp_enqueue_script('cropper-cortex', get_template_directory_uri() . '/static/js/libs/cropper.min.js', array('jquery'),'1.1', false);
	wp_enqueue_script('custom-functions', get_template_directory_uri() . '/static/js/functions.js', array('jquery'), '1.3.4', false);
	wp_enqueue_script('forms', get_template_directory_uri() . '/static/js/forms.js', array('jquery','cropper-cortex'), '1.4.5', false);
	wp_enqueue_script('favorites', get_template_directory_uri() . '/static/js/favorites.js', array('jquery'), '1.2.3', false);
	wp_enqueue_script('overviews', get_template_directory_uri() . '/static/js/overviews.js', array('jquery'), '1.2.2', false);
}
add_action('wp_enqueue_scripts', 'teilhabekultur_scripts');


/* Remove static width and heights for images
-------------------------------------------------------------------------------*/
function remove_wps_width_attribute( $html ) {
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}
add_filter( 'post_thumbnail_html', 'remove_wps_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_wps_width_attribute', 10 );


/* Add first and last to menu_items
-------------------------------------------------------------------------------*/
function add_first_and_last($output) {
	$output = preg_replace('/class="menu-item/', 'class="menu-item-first menu-item', $output, 1);
	$output = substr_replace($output, 'class="menu-item-last menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
	return $output;
}

add_filter('wp_nav_menu', 'add_first_and_last');

/* Add our widget collection
-------------------------------------------------------------------------------*/
function teilhabekultur_add_widget_collection($folders){
	$folders[] = get_template_directory() . '/widgets/';
	return $folders;
}
add_filter('siteorigin_widgets_widget_folders', 'teilhabekultur_add_widget_collection');


/* Add a custom widget group
-------------------------------------------------------------------------------*/
function teilhabekultur_add_widget_tabs($tabs) {
	$tabs[] = array(
		'title' => 'Ulmutopia Widgets',
		'filter' => array(
			'groups' => array('teilhabekultur')
		),
	);


	return $tabs;
}
add_filter('siteorigin_panels_widget_dialog_tabs', 'teilhabekultur_add_widget_tabs', 20);


/* This adds Checkboxes to the Design Tab of the PageBuilder Row and
/* lets the user decide about some styling (grid-inner or not, margin-bottom, ...)
-------------------------------------------------------------------------------*/
function teilhabekultur_add_row_style_fields($fields) {
	$fields['no_grid_inner'] = array(
		'name'        => 'Volle Breite nutzen',
		'type'        => 'checkbox',
		'group'       => 'design',
		'description' => 'Anwählen, damit die Zeile über die volle Breite der Seite geht und das Raster ignoriert.',
		'priority'    => 1,
	);

	$fields['grid_inner_wide'] = array(
		'name'        => 'Breiteres Raster nutzen',
		'type'        => 'checkbox',
		'group'       => 'design',
		'description' => 'Anwählen, damit das breitere (1370px) Raster verwendet wird.',
		'priority'    => 1,
	);


	$fields['with_padding_right'] = array(
		'name'        => 'Gleichmäßige Spaltengröße',
		'type'        => 'checkbox',
		'group'       => 'design',
		'description' => 'Anwählen, damit die letzte Spalte in einer mehrspaltigen Zeile auch einen Abstand nach rechts hat, z.B. damit alle Bilder in einer Spalte gleich groß sind.',
		'priority'    => 2,
	);

	$fields['margin_bottom_double'] = array(
		'name'        => 'Doppelter Abstand nach unten',
		'type'        => 'checkbox',
		'group'       => 'design',
		'description' => 'Anwählen, damit die Zeile einen Abstand zur nächsten Zeile zugewiesen bekommt.',
		'priority'    => 3,
	);

	$fields['margin_bottom'] = array(
		'name'        => 'Abstand nach unten',
		'type'        => 'checkbox',
		'group'       => 'design',
		'description' => 'Anwählen, damit die Zeile einen Abstand zur nächsten Zeile zugewiesen bekommt.',
		'priority'    => 3,
	);

	$fields['margin_bottom_half'] = array(
		'name'        => 'Halber Abstand nach unten',
		'type'        => 'checkbox',
		'group'       => 'design',
		'description' => 'Anwählen, damit die Zeile halben Abstand zur nächsten Zeile zugewiesen bekommt.',
		'priority'    => 4,
	);

	return $fields;
}

add_filter( 'siteorigin_panels_row_style_fields', 'teilhabekultur_add_row_style_fields');


/* This adds the grid-inner and margin-bottom class to all rows of the page builder
/* The user is however able to set a checkbox and disable the grid-inner or aply more or no margin
-------------------------------------------------------------------------------*/
function teilhabekultur_row_style_attributes( $attributes, $args ) {
	if(empty($args['no_grid_inner'])) {
		array_push($attributes['class'], 'grid-inner');
	}
	if(!empty($args['grid_inner_wide'])) {
		array_push($attributes['class'], 'wide');
	}

	if(!empty($args['margin_bottom'])) {
		array_push($attributes['class'], 'margin-bottom');
	} else if(!empty($args['margin_bottom_double'])) {
		array_push($attributes['class'], 'margin-bottom-double');
	} else if(!empty($args['margin_bottom_half'])) {
		array_push($attributes['class'], 'margin-bottom-half');
	}

	if(!empty($args['with_padding_right'])) {
		array_push($attributes['class'], 'with-padding-right');
	}

	if(!empty($args['sidebar_right'])) {
		array_push($attributes['class'], 'no-grid-inner-mobile');
		array_push($attributes['class'], 'right-black');
	}

	return $attributes;
}
add_filter('siteorigin_panels_row_style_attributes', 'teilhabekultur_row_style_attributes', 10, 2);

/* This adds Checkboxes to the Design Tab of the PageBuilder Widget
/* and lets the user decide about some styling (margins)
-------------------------------------------------------------------------------*/
function teilhabekultur_add_widget_style_fields($fields) {
	$fields['margin_bottom'] = array(
		'name'        => 'Abstand nach unten',
		'type'        => 'checkbox',
		'group'       => 'design',
		'description' => 'Anwählen damit das Widget einen Abstand zum nachfolgenden Widget zugewiesen bekommt.',
		'priority'    => 3,
	);

	$fields['margin_bottom_double'] = array(
		'name'        => 'Doppelter Abstand nach unten',
		'type'        => 'checkbox',
		'group'       => 'design',
		'description' => 'Anwählen damit das Widget den  doppelten Abstand zum nachfolgenden Widget zugewiesen bekommt.',
		'priority'    => 4,
	);

	$fields['text_padding_right'] = array(
		'name'        => 'Abstand nach rechts',
		'type'        => 'checkbox',
		'group'       => 'design',
		'description' => 'Anwählen damit ein Textblock einen Abstand nach rechts bekommt (z.B. um Ihn von Bildern abzusetzen).',
		'priority'    => 2,
	);

	return $fields;
}
add_filter( 'siteorigin_panels_widget_style_fields', 'teilhabekultur_add_widget_style_fields');

/* This adds margin-bottom and margin-bottom double to single widgets
-------------------------------------------------------------------------------*/
function teilhabekultur_widget_style_attributes( $attributes, $args ) {
	if(!empty($args['margin_bottom'])) {
		array_push($attributes['class'], 'margin-bottom');
	} else if(!empty($args['margin_bottom_double'])) {
		array_push($attributes['class'], 'margin-bottom-double');
	}

	if(!empty($args['text_padding_right'])) {
		array_push($attributes['class'], 'text-padding-right');
	}


	return $attributes;
}
add_filter('siteorigin_panels_widget_style_attributes', 'teilhabekultur_widget_style_attributes', 10, 2);


/* Disable W3TC footer comment for all users */
add_filter( 'w3tc_can_print_comment', '__return_false', 10, 1 );


/* Add our style to the editor
-------------------------------------------------------------------------------*/
add_editor_style('style.css');

/* Load Textdomain
-------------------------------------------------------------------------------*/
//load_theme_textdomain('teilhabekultur');