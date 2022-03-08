<?php
get_header(); ?>
<?php if ( have_posts() ) : ?>
	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="grid-inner">
			<div class="tip-sector">
				<?php $sector = get_field('bereich', get_the_ID()); ?>
				<h3><?php echo Cortex_Kulturvermittlung_Config::$tipSectors[$sector];?></h3>
				<div class="tip-overview">
					<?php
						$tipId = get_the_ID();
						include(WP_PLUGIN_DIR . '/cortex-kulturvermittlung/templates/tiles/tip_tile.tpl.php');
					?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
<?php else : ?>
<?php endif; // end have_posts() check ?>

<?php get_footer(); ?>
