<?php
   if(empty($userId)) {
?>

<div class="form-box">
	<h2 class="box-title"><?php _e('Kontakt', 'teilhabekultur');?></h2>

    <div class="form-row">
        <div class="form-field">
            <label for="profilname"><?php _e('Name');?> *</label>
            <input id="profilname" type="text" name="profilname" value="<?php if(!empty($values['profilname'])) { echo $values['profilname']; } ?>" required aria-required="true"/>
            <span class="completed"></span>
        </div>
    </div>

	<div class="form-row">
		<div class="form-field">
			<label for="e-mailadresse"><?php _e('E-Mailadresse');?> *</label>
			<input id="e-mailadresse" type="text" name="e-mailadresse" value="<?php if(!empty($values['e-mailadresse'])) { echo $values['e-mailadresse']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>

		<div class="form-field">
			<label for="telefon"><?php _e('Telefon');?> *</label>
			<input id="telefon" type="text" name="telefon" value="<?php if(!empty($values['telefon'])) { echo $values['telefon']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>
	</div>
</div>
<?php } ?>

<div class="form-box">
	<h2 class="box-title"><?php _e('Dein Tipp', 'teilhabekultur');?></h2>

	<div class="form-row">
        <div class="form-field">
            <label for="title"><?php _e('Titel des Links');?> *</label>
            <input id="title" type="text" name="title" value="<?php if(!empty($values['title'])) { echo $values['title']; } ?>" required aria-required="true"/>
            <span class="completed"></span>
        </div>

		<div class="form-field">
			<label for="link"><?php _e('Adresse des Links');?> *</label>
			<input id="link" type="text" name="link" value="<?php if(!empty($values['link'])) { echo $values['link']; } ?>" required aria-required="true"/>
			<span class="completed"></span>
		</div>
    </div>
    <div class="form-row">
		<div class="form-field">
			<label for="link"><?php _e('Art des Links');?> *</label>
			<select name="bereich">
				<option value="tutorials">Tutorials</option>
				<option value="best_practice_beispiele">Best-Practice Beispiele</option>
				<option value="wissenswertes">Wissenswertes (Studien, Fachbeiträge, Literatur etc.)</option>
				<option value="handlungsempfehlungen">Handlungsempfehlungen und Methoden (Gesprächsführung, Projektvorbereitung etc.)</option>
				<option value="vorlagen">Vorlagen (Verträge, Kalkulationstabellen, Flyer etc.)</option>
				<option value="interessante_newsletter">Interessante Newsletter</option>
				<option value="spannende_websites">Spannende Websites</option>
				<option value="konferenzen_und_tagungen">Konferenzen und Tagungen</option>
			</select>
		</div>
	</div>

	<div class="form-row">
		<p>
			Bitte beschreibt den Link kurz aus eurer Sicht und ordnet die Informationen einer der folgenden neun Bereiche zu. Sollte es sich um Informationen handeln, die ihr nicht verlinken könnt,
			schickt uns diese gerne an <a href="mailto:kulturvermittlung@ulm.de">kulturvermittlung@ulm.de</a> .

		<div class="form-field">
			<label for="beschreibung"><?php _e('Beschreibung');?> *</label>
			<textarea name="beschreibung" rows="5"><?php echo $values['beschreibung'];?></textarea>
		</div>
	</div>
</div>