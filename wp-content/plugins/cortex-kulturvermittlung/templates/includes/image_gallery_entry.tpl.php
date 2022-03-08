<div class="image-gallery-upload margin-bottom-half image-upload" data-with-cropper="1"  data-upload-url="<?php echo admin_url('admin-ajax.php?action=kulturvermittlung_upload_temp_image');?>">
	<input name="file" type="file" />
	<input type="hidden" name="image_gallery_image[]" class="image-upload-hidden-field" value="<?php if(!empty($image)) { echo $image; }?>"/>
	<div class="preview-image">
		<?php
		$imageURL = '';
		if(!empty($image) && is_numeric($image)) {
			$imageURL = wp_get_attachment_image_url($image, 'medium');
		} else if(!empty($image)){
			$imageURL = $upload_dir['baseurl'] .'/temp_uploads/'. $image;
		}?>
		<div class="dz-image">
			<img <?php if(!empty($imageURL)){?> src="<?php echo $imageURL;?>" <?php } ?>/>
		</div>
	</div>

	<span class="remove <?php if(empty($image)){ echo "hidden"; } ?>"><img src="<?php echo $template_dir;?>/static/img/icons/remove_black.svg" alt="<?php _e('Bild entfernen','teilhabekultur'); ?>"/></span>
</div>