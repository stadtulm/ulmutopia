<?php include(dirname(__FILE__) . '/header.tpl.php');?>

	<p><strong>Hallo,</strong></p>

	<p>Es wurde ein neuer Tipp auf ulmutopia.de angelegt:<br/>
		<strong><?php echo $title;?></strong>
	</p>

	<p>Bitte überprüfen Sie den Tipp und schalten Sie ihn über den untenstehenden Link frei.</p>

	<div class="btn-div margin-bottom">
		<a class="btn middle" href="<?php echo $linkToOverview;?>">Zur Tippübersicht</a>
	</div>

<?php include(dirname(__FILE__) . '/footer.tpl.php');?>