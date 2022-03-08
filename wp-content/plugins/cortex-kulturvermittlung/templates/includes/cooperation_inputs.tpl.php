<div class="form-field">
    <div class="margin-bottom">
        <label for="partner_name"><?php _e('Name');?> *</label>
        <input id="partner_name" type="text" name="partner_name[]" value="<?php if(!empty($partner_name)) { echo $partner_name; } ?>"/>
    </div>

    <label for="partner_url"><?php _e('Webseite');?></label>
    <input id="partner_url" type="text" name="partner_url[]" value="<?php if(!empty($partner_url)) { echo $partner_url; } ?>"/>
</div>

<div class="form-field">
    <label for="partner_beschreibung"><?php _e('Beschreibung');?></label>
    <textarea id="partner_beschreibung" name="partner_beschreibung[]" rows="5" ><?php if(!empty($partner_beschreibung)) { echo $partner_beschreibung; } ?></textarea>
</div>

<span class="remove remove-cooperation <?php if(!$showDelete){ echo "hidden"; } ?>"><img src="<?php echo $template_dir;?>/static/img/icons/remove.svg" alt="<?php _e('Eintrag entfernen','teilhabekultur'); ?>"/></span>
