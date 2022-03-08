<?php
get_header(); ?>
<?php if ( have_posts() ) : ?>
	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post();
		$offerId = get_the_ID();
		$userId = NULL;
		$user = wp_get_current_user();
		if(!empty($user)){
			if(in_array('artist', (array) $user->roles)){
				$userId = get_current_user_id();
			}
		}

		if($userId != NULL && get_the_author_meta('ID') == $userId) {
			$allowEdit = true;
		}
		include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/offer/show_offer.tpl.php');
	endwhile; ?>
<?php else : ?>
<?php endif; // end have_posts() check ?>

<?php get_footer(); ?>
