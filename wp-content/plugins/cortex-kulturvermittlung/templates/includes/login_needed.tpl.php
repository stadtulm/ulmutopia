<script>
    <?php if(!empty($redirectURL)) {
        $url = get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register')) . '?login=required&redirectURL='  . urlencode($redirectURL);
    } else {
        $url = get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('login_register')) . '?login=required';
    }?>
	window.location.replace('<?php echo $url;?>');
</script>