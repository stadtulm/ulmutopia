<?php
/**
 * The main template file
 *
 *
 */

get_header(); ?>
<?php if ( have_posts() ) : ?>
	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
<?php else : ?>
<?php endif; // end have_posts() check ?>

<?php get_footer(); ?>
