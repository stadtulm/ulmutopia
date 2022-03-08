<script>
    <?php
        $url = get_the_permalink(Cortex_Kulturvermittlung_Config::getPageId('frontpage'));
    ?>
    window.location.replace('<?php echo $url;?>');
</script>