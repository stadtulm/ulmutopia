<?php include(dirname(__FILE__) . '/header.tpl.php');?>

	<p><strong>Hallo,</strong></p>

	<p>schön, dass Du auf Ulmutopia.de passende Angebote gefunden hast. Hier ist die Liste deiner Favoriten:</p>

	<h3>Profile</h3>
	<?php if(!empty($profileIds)) { ?>
		<ul>
			<?php foreach($profileIds AS $profileId) {?>
				<li><a href="<?php echo Cortex_Kulturvermittlung_Profiles::generateProfileLink($profileId);?>"><?php echo get_field('name_institution_kuenstlerin', 'user_' . $profileId);?></a></li>
			<?php } ?>
		</ul>
	<?php } ?>


	<h3>Angebote</h3>
	<?php if(!empty($offerIds)) { ?>
		<ul>
			<?php foreach($offerIds AS $offerId) {?>
				<li><a href="<?php echo get_the_permalink($offerId);?>"><?php echo get_the_title($offerId);?></a></li>
			<?php } ?>
		</ul>
	<?php } ?>

    <p>
        Viel Spaß beim ausprobieren und mitgestalten wünscht,<br/>
        Dein Team der Kulturvermittlung Stadt Ulm
    </p>

<?php include(dirname(__FILE__) . '/footer.tpl.php');?>