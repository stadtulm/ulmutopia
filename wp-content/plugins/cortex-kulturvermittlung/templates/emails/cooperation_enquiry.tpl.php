<?php include(dirname(__FILE__) . '/header.tpl.php');?>

    <p><strong>Hallo <?php echo $salutation;?>,</strong></p>

    <p>das Kulturprofil <?php echo $profileName;?> möchte dich gern als Kooperationspartner auf ulmutopia.de hinzufügen. Bitte bestätige diese Anfrage und die Kooperation wird automatisch ulmutopia.de erscheinen.</p>

    <p>
        Dein Team der Kulturvermittlung Stadt Ulm
    </p>


    <div class="btn-div margin-bottom">
        <a class="btn middle" href="<?php echo $acceptLink;?>">Anfrage bestätigen</a>
    </div>

<?php include(dirname(__FILE__) . '/footer.tpl.php');?>