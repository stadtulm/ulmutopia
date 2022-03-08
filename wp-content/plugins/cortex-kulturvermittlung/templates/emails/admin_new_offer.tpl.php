<?php include(dirname(__FILE__) . '/header.tpl.php');?>

	<p><strong>Hallo,</strong></p>

	<p>Es wurde ein neues Angebot auf ulmutopia.de angelegt:<br/>
        <strong><?php echo $title;?></strong>
    </p>

    <p>Über die Schaltfläche können Sie es sich ansehen.</p>

	<div class="btn-div margin-bottom">
		<a class="btn middle" href="<?php echo $linkToOffer;?>">Zum Angebot</a>
	</div>

<?php include(dirname(__FILE__) . '/footer.tpl.php');?>