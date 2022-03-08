<?php include(dirname(__FILE__) . '/header.tpl.php');?>

	<p><strong>Hallo <?php echo $salutation;?>,</strong></p>

    <p>herzlich willkommen bei Ulmutopia.de! Dein Account auf ulmutopia.de wurde freigeschaltet! Du kannst dich ab sofort mit Deiner E-Mailadresse und Deinem hinterlegtem Passwort anmelden.</p>

    <p>
        Wir freuen uns darauf, dass Du Deine spannenden Kulturangebote auf unserer Plattform anbietest.<br/>
        Dein Team der Kulturvermittlung Stadt Ulm
    </p>


	<div class="btn-div margin-bottom">
		<a class="btn middle" href="<?php echo get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register'));?>">Zum Login</a>
	</div>

<?php include(dirname(__FILE__) . '/footer.tpl.php');?>