<?php
class Cortex_Kulturvermittlung_Search {
    public $postTypes = array();

    public function __construct() {
		$this->postTypes = array(
			'page' => __('Seite', 'infoma-theme'),
			'angebot' => __('Angebot', 'infoma-theme'),
			'tip' => __('Tipp', 'infoma-theme'),
		);
	}

    /* Register our filter to the form
   -------------------------------------------------------------------------------*/
    public function registerFilters() {
		add_filter('pre_get_posts', array($this, 'addCustomPostsTypesToSearch'));
	}

    /**
     * Adds all relevant custom post types to the search query
     *
     * @param $query
     * @return mixed
     */
    public function addCustomPostsTypesToSearch($query){
		if($query->is_search && ! is_admin()){
			$query->set('post_type', array_keys($this->postTypes));

			// Exclude certain pages defined in the config
			//$query->set('post__not_in', Cortex_Infoma_Config::getExcludedPageIds());
		}

		return $query;
	}
}