<?php

class Cortex_Kulturvermittlung_File_Handler{
	public function __construct(){
		add_action('wp_ajax_kulturvermittlung_upload_temp_image', array($this,'uploadTempImages'));
		add_action('wp_ajax_nopriv_kulturvermittlung_upload_temp_image', array($this,'uploadTempImages'));

		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');
	}


    /* Function that will save any file that was uploaded through PHP in our temp_uploads folder. This is necessary to save an incomplete form in the browser (and keep the images)
    -------------------------------------------------------------------------------*/
	public function uploadTempImages() {
        $upload_dir = wp_upload_dir();

        $tmpFileName = $_FILES['file']['tmp_name'];

        //Handle name collision
		$filename = $_FILES['file']['name'];
        if(file_exists($upload_dir['basedir'].'/temp_uploads/'. $filename)) {
            $filenameParts = pathinfo($filename);
            $filename = $filenameParts['filename'] . time() . '.' . $filenameParts['extension'];
        }

		move_uploaded_file($tmpFileName,$upload_dir['basedir'].'/temp_uploads/'. $filename);

		$jpgFilename = $this->resizeImage($upload_dir['basedir'].'/temp_uploads/'. $filename);
        if($jpgFilename) {
            wp_send_json_success(array('filename' => $jpgFilename));
        } else {
            wp_send_json_error('Error while writing JPEG Image with Imagick');
        }
	}


    /* This function takes an image file in the temp_uploads folder and moves it to the offical wordpress mediathek
    -------------------------------------------------------------------------------*/
	public function saveTempImage($filename, $description) {
        $upload_dir = wp_upload_dir();
        if(file_exists($upload_dir['basedir'].'/temp_uploads/'. $filename)) {
            $fileArray = ['name' => $filename, 'tmp_name' => $upload_dir['basedir'] . '/temp_uploads/' . $filename, 'type' => 'image/jpeg', 'error' => 0, 'size' => filesize($upload_dir['basedir'] . '/temp_uploads/' . $filename)];
            $result = media_handle_sideload($fileArray, 0, $description);

            //Unlink the temp file
            unlink($upload_dir['basedir'] . '/temp_uploads/' . $filename);

            return $result;
        } else {
            return new WP_Error('temp_image_not_found', 'The temporary uploaded image was not found in the directory');
        }
	}

    /* This function takes a non image file from the PHP $_FILES array and adds it to the wordpress mediathek
    -------------------------------------------------------------------------------*/
	public function saveFile($fileArray, $postId, $description = '') {
		$result = media_handle_sideload( $fileArray, $postId, $description);
		return $result;
	}

    /* This functions resizes, autorotates and compresses an image file and forces a JPG
    -------------------------------------------------------------------------------*/
	public function resizeImage($file) {
		$img = new Imagick($file);
		$d = $img->getImageGeometry();

		$img->setImageResolution(72,72);
		$img->resampleImage(72,72,imagick::FILTER_UNDEFINED,1);

		if($d['width'] > 2300 || $d['height'] > 2300){
			if($d['width'] > $d['height']){
				$img->scaleImage(2300, 0);
			} else{
				$img->scaleImage(0, 2300);
			}
		}
		$img->setImageCompression(Imagick::COMPRESSION_JPEG);
		$img->setImageCompressionQuality(70);
		$img->setImageFormat('jpg');
		$this->autorotate($img);
		$img->stripImage();

        $filenameParts = pathinfo($file);
        $newFile = $filenameParts['filename'] . '.' . 'jpg';

		if($img->writeImage($filenameParts['dirname'] . '/' . $newFile)) {
            $img->destroy();

            //If we made a JPG from an PNG, we unlink the old one
            if($file != $filenameParts['dirname'] . '/' . $newFile) {
                unlink($file);
            }
            return $newFile;
        } else {
            return false;
        }
	}

    /* Function to rotate an imagick image to respect the exif rotation (otherwise iphone images would be upside down)
    -------------------------------------------------------------------------------*/
	function autorotate(Imagick $image){
		switch ($image->getImageOrientation()) {
			case Imagick::ORIENTATION_TOPLEFT:
				break;
			case Imagick::ORIENTATION_TOPRIGHT:
				$image->flopImage();
				break;
			case Imagick::ORIENTATION_BOTTOMRIGHT:
				$image->rotateImage("#000", 180);
				break;
			case Imagick::ORIENTATION_BOTTOMLEFT:
				$image->flopImage();
				$image->rotateImage("#000", 180);
				break;
			case Imagick::ORIENTATION_LEFTTOP:
				$image->flopImage();
				$image->rotateImage("#000", -90);
				break;
			case Imagick::ORIENTATION_RIGHTTOP:
				$image->rotateImage("#000", 90);
				break;
			case Imagick::ORIENTATION_RIGHTBOTTOM:
				$image->flopImage();
				$image->rotateImage("#000", 90);
				break;
			case Imagick::ORIENTATION_LEFTBOTTOM:
				$image->rotateImage("#000", -90);
				break;
			default: // Invalid orientation
				break;
		}
		$image->setImageOrientation(Imagick::ORIENTATION_TOPLEFT);
	}
}

$cortexImageHandler = new Cortex_Kulturvermittlung_File_Handler();