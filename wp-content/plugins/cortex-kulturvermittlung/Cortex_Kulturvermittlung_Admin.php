<?php

class Cortex_Kulturvermittlung_Admin {
	public static $menuSlug = 'cortex_kulturvermittlung';

	public function __construct(){
		add_action('admin_menu', array($this, 'init'));
		add_action('admin_post_kulturvermittlung_activate_tip', array($this, 'activateTip'));
		add_action('admin_post_kulturvermittlung_deactivate_tip', array($this, 'activateTip'));
		add_action('admin_post_kulturvermittlung_activate_offer', array($this, 'activateOffer'));
		add_action('admin_post_kulturvermittlung_deactivate_offer', array($this, 'activateOffer'));
		add_action('admin_post_kulturvermittlung_remove_highlight_offer', array($this, 'highlightOffer'));
		add_action('admin_post_kulturvermittlung_add_highlight_offer', array($this, 'highlightOffer'));
		add_action( 'manage_angebot_posts_custom_column', array($this, 'populateActiveCol'), 10, 2);
		add_action('admin_enqueue_scripts', array($this, 'addAdminScripts'));

		add_filter('post_row_actions', array($this, 'addActivationLink'), 10, 2);
		add_filter( 'manage_angebot_posts_columns', array($this, 'addActiveCol'));
		add_filter('post_class', array($this, 'addHightlightClass'), 10,3);
	}

	public function init() {
		add_menu_page(
			'Profileübersicht',
			'Profile',
			'edit_pages',
			Cortex_Kulturvermittlung_Admin::$menuSlug,
			array($this,'profileOverview'),
			plugin_dir_url(__FILE__) . '/assets/img/menu-icon.png',
			25
		);
	}

	public function addAdminScripts() {
		$plugin_url = plugin_dir_url( __FILE__ );
		wp_enqueue_style( 'kulturvermittlung-admin-css', $plugin_url . '/assets/css/style.css', array(), '1.0.0', 'all' );
	}

    /*This hooks into the post overview in WP and adds custom links to activate it
    -------------------------------------------------------------------------------*/
	public function addActivationLink($actions, $post) {
		if(get_post_type($post) == 'tip'){
			if(get_field('aktiv', $post->ID)) {
				$actions['activate'] = '<a href="admin-post.php?action=kulturvermittlung_activate_tip&amp;post=' . $post->ID . '" title="Aktivieren" rel="permalink">Deaktivieren</a>';
			} else {
				$actions['activate'] = '<a href="admin-post.php?action=kulturvermittlung_deactivate_tip&amp;post=' . $post->ID . '" title="Aktivieren" rel="permalink">Aktivieren</a>';
			}
		} else if(get_post_type($post) == 'angebot') {
			if(get_field('aktiv', $post->ID)) {
				$actions['activate'] = '<a href="admin-post.php?action=kulturvermittlung_activate_offer&amp;post=' . $post->ID . '" title="Deaktivieren" rel="permalink">Deaktivieren</a>';
			} else {
				$actions['activate'] = '<a href="admin-post.php?action=kulturvermittlung_deactivate_offer&amp;post=' . $post->ID . '" title="Aktivieren" rel="permalink">Aktivieren</a>';
			}

			if(get_field('highlight', $post->ID)) {
				$actions['highlight_offer'] = '<a href="admin-post.php?action=kulturvermittlung_remove_highlight_offer&amp;post=' . $post->ID . '" title="Als Highlight entfernen" rel="permalink">Als Highlight entfernen</a>';
			} else {
				$actions['highlight_offer'] = '<a href="admin-post.php?action=kulturvermittlung_add_highlight_offer&amp;post=' . $post->ID . '" title="Als Highlight markieren" rel="permalink">Als Highlight markieren</a>';
			}
		}
		return $actions;
	}

    /* Admin Function to active a tipp
    -------------------------------------------------------------------------------*/
	public function activateTip() {
		if(!empty($_GET['post'])) {
			$post = get_post(intval($_GET['post']));
			if(!empty($post)) {
				update_field('aktiv', !get_field('aktiv', $post->ID),  $post->ID);
			}
		}

        //Redirect to the tip overview
		wp_redirect(admin_url('/edit.php?post_type=tip'));
		exit();
	}

    /* Admin Function to active an offer
    -------------------------------------------------------------------------------*/
	public function activateOffer() {
        if(current_user_can( 'edit_others_posts' )) {
            if (!empty($_GET['post'])) {
                $post = get_post(intval($_GET['post']));
                if (!empty($post)) {
                    update_field('aktiv', !get_field('aktiv', $post->ID), $post->ID);
                }
            }

            //Redirect to the offer overview
            wp_redirect(admin_url('/edit.php?post_type=angebot'));
            exit();
        } else {
            wp_redirect(get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile')), '303');
        }
	}

    /* Admin Function to hightlight an over
    -------------------------------------------------------------------------------*/
	public function highlightOffer() {
        if(current_user_can( 'edit_others_posts' )) {
            if (!empty($_GET['post'])) {
                $post = get_post(intval($_GET['post']));
                if (!empty($post)) {
                    update_field('highlightangebot', !get_field('highlightangebot', $post->ID), $post->ID);
                }
            }

            //Redirect to he offer overview
            wp_redirect(admin_url('/edit.php?post_type=angebot'));
            exit();
        } else {
            wp_redirect(get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile')), '303');
        }
	}

    /* This function handles clicks within are own custom "Profile" Admin Menu
    -------------------------------------------------------------------------------*/
	public function profileOverview() {
		if(!empty($_GET['cortex_kulturvermittlung_action'])) {
            if(current_user_can( 'edit_others_posts' )) {
                if ($_GET['cortex_kulturvermittlung_action'] == 'activate') {
                    $user = get_user_by('ID', intval($_GET['user_id']));
                    if (!empty($user)) {
                        update_field('aktiv', true, 'user_' . $user->ID);
                        $now = new DateTime("now", new DateTimeZone('Europe/Berlin'));

                        if (empty(get_field('aktivierungsdatum', 'user_' . $user->ID))) {
                            $mailer = new Cortex_Kulturvermittlung_Emailer();
                            $mailer->sendActivationEmail($user->ID);
                        }
                        update_field('aktivierungsdatum', $now->format('Y-m-d H:i:s'), 'user_' . $user->ID);
                        $success = true;
                        $successCode = 1;
                    } else {
                        $error = true;
                        $errorCode = 1;
                    }
                } else if ($_GET['cortex_kulturvermittlung_action'] == 'deactivate') {
                    $user = get_user_by('ID', intval($_GET['user_id']));
                    if (!empty($user)) {
                        update_field('aktiv', false, 'user_' . $user->ID);
                        $success = true;
                        $successCode = 2;
                    } else {
                        $error = true;
                        $errorCode = 1;
                    }
                } else if ($_GET['cortex_kulturvermittlung_action'] == 'delete') {
                    $user = get_user_by('ID', intval($_GET['user_id']));
                    if (!empty($user)) {
                        //Ths will also delete all posts (Angebote!) of the user.
                        wp_delete_user($user->ID, NULL);
                        $success = true;
                        $successCode = 3;
                    } else {
                        $error = true;
                        $errorCode = 1;
                    }
                } else if ($_GET['cortex_kulturvermittlung_action'] == 'removeHightlight') {
                    $user = get_user_by('ID', intval($_GET['user_id']));
                    if (!empty($user)) {
                        update_field('highlightprofil', false, 'user_' . $user->ID);
                        $success = true;
                        $successCode = 4;
                    } else {
                        $error = true;
                        $errorCode = 1;
                    }
                } else if ($_GET['cortex_kulturvermittlung_action'] == 'setHightlight') {
                    $user = get_user_by('ID', intval($_GET['user_id']));
                    if (!empty($user)) {
                        update_field('highlightprofil', true, 'user_' . $user->ID);
                        $success = true;
                        $successCode = 5;
                    } else {
                        $error = true;
                        $errorCode = 1;
                    }
                }
            } else {
                wp_redirect(get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('my_profile')), '303');
            }
		}

		$args = array(
			'role'    => 'artist',
			'orderby' => 'user_registered',
			'order'   => 'DESC'
		);

		$users = get_users($args);
		include('templates/admin/profile_overview.tpl.php');
	}

    /* Filter that adds an "active" col the list columns
    -------------------------------------------------------------------------------*/
	public function addActiveCol($columns) {
		$columns['active'] = 'Aktiv?';
		return $columns;
	}

    /* Filter that fills the active col for posts
    -------------------------------------------------------------------------------*/
	public function populateActiveCol($column, $post_id) {
		if($column == 'active') {
			if(get_field('aktiv', $post_id)) {
				echo '<span class="dashicons dashicons-yes green"></span>';
			} else {
				echo '<span class="dashicons dashicons-no-alt red"></span>';
			}
		}
	}

    /* Filter the colors the highlight offers green
    -------------------------------------------------------------------------------*/
	public function addHightlightClass($classes, $class, $post_id) {
		if (!is_admin()) { //make sure we are in the dashboard
			return $classes;
		}

		$screen = get_current_screen(); //verify which page we're on
		if ('my-custom-type' != $screen->post_type && 'edit' != $screen->base) {
			return $classes;
		}

		//Add the highlight class
		if(get_field('highlightangebot', $post_id)){
			$classes[] = 'highlight';
		}

		return $classes;
	}
}
$cortexKulturAdmin = new Cortex_Kulturvermittlung_Admin();