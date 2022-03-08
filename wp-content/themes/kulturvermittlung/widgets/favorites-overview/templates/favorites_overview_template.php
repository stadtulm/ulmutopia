<?php $template_dir = get_template_directory_uri(); ?>

<script type="text/javascript">
    jQuery(function(){
        Favorites.loadFavorites();
    });
</script>

<?php if($_GET['message'] == 'success' || $_GET['message'] == 'error') {?>
    <?php if($_GET['message'] == 'success') {?>
        <div class="message-box success" role="alert"><img class="success-icon" src="<?php echo $template_dir;?>/static/img/icons/icon-ja.svg" alt="<?php _e('Erfolgeich','teilhabekultur');?>"/>
			<?php _e('Deine Favoriten wurden erfolgreich verschickt.', 'teilhabekultur');?>
        </div>
    <?php } else { ?>
        <div class="message-box success" role="alert"><img class="success-icon" src="<?php echo $template_dir;?>/static/img/icons/icon-ja.svg" alt="<?php _e('Erfolgeich','teilhabekultur');?>"/>
		    <?php _e('Es ist ein Fehler aufgetreten. Bitte überprüfe die E-Mailadresse.', 'teilhabekultur');?>
        </div>
    <?php } ?>
<?php } ?>

<div id="send-favorites-via-email" class="send-favorites-form-container">
    <div class="col5">
        <form action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="POST" id="send-favorites-form" class="send-favorites-form">
            <input name="action" type="hidden" value="kulturvermittlung_send_favorites"/>
            <input class="margin-bottom" type="email" name="email" value="" placeholder="<?php _e('Deine E-Mailadresse', 'teilhabekultur');?>"/>
            <input type="submit" value="<?php _e('Favoriten per E-Mail verschicken', 'teilhabekultur');?>"/>
        </form>
    </div>

    <div id="add-favorites-notice" class="full-width hidden">
		<em><?php _e('Bitte füge zunächst Favoriten hinzu, danach kannst du an dieser Stelle deine E-Mailadresse eingeben.', 'teilhabekultur');?></em>
    </div>
</div>



<div id="profile-favorites" class="profile-tiles">
    <h3><?php _e('Profile');?></h3>
    <div class="profiles">
        <?php _e('Du hast dir noch keine Profile als Favorit gespeichert.', 'teilhabekultur');?>
    </div>
</div>

<div id="offer-favorites" class="offer-tiles">
    <h3><?php _e('Angebote');?></h3>
    <div class="offers">
	    <?php _e('Du hast dir noch keine Angebote als Favorit gespeichert.', 'teilhabekultur');?>
    </div>
</div>