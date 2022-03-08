<?php
class Cortex_Kulturvermittlung_Config {
	public static $javascriptVersion = 1;

	public static $colors = array(
		'musik' => '#AED7E4',
		'theater' => '#E69FBF',
		'tanz' => '#CDCFB8',
		'kunst' => '#FCE49A',
		'literatur' => '#BFDC9A',
		'film' => '#B090C9',
		'spartenmix' => '#7FC5B9',
		'gesellschaft' => '#D8DBDA'
	);

	public static $pageIds = array(
        'frontpage' => -1,
		'registration' => -1,
		'registration_success' => -1,
		'my_profile' => -1,
		'login_register' => -1,
		'lost_password' => -1,
		'profile' => -1,
		'profile_overview' => -1,
		'edit_profile' => -1,
		'edit_offer' => -1,
		'offer_overview' => -1,
		'data_privacy' => -1,
		'terms_and_conditions' => -1,
		'tip_overview' => -1,
		'edit_tip' => -1,
		'favorites' => -1,
		'change_email_password' => -1,
		'deactivate_profile' => -1,
		'search' => -1,
        'confirm_cooperation' => -1
	);

	public static function getPageId($pageSlug) {
		return Cortex_Kulturvermittlung_Config::$pageIds[$pageSlug];
	}

	public static $sectors = array(
		'musik' => 'Musik',
		'theater' => 'Theater',
		'tanz' => 'Tanz',
		'kunst' => 'Kunst',
		'literatur' => 'Literatur',
		'film' => 'Film',
		'spartenmix' => 'Spartenmix',
		'gesellschaft' => 'Gesellschaft'
	);

	public static $tipSectors = array(
		'tutorials' => 'Tutorials',
		'best_practice_beispiele' => 'Best-Practice Beispiele',
		'wissenswertes' => 'Wissenswertes (Studien, Fachbeiträge, Literatur etc.)',
		'handlungsempfehlungen' => 'Handlungsempfehlungen und Methoden (Gesprächsführung, Projektvorbereitung etc.)',
		'vorlagen' => 'Vorlagen (Verträge, Kalkulationstabellen, Flyer etc.)',
		'interessante_newsletter' => 'Interessante Newsletter',
		'spannende_websites' => 'Spannende Websites',
		'konferenzen_und_tagungen' => 'Konferenzen und Tagungen',
		'finanzierungsquellen' => 'Finanzierungsquellen',
		'einfache_sprache' => 'Einfache Sprache',
	);
}