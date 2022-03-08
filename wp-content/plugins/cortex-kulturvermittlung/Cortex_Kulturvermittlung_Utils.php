<?php

class Cortex_Kulturvermittlung_Utils {

    /* Helper function to extract the vimeo or yt id from an videoURL
   -------------------------------------------------------------------------------*/
	public static function extractVideoId($videoURL){
		if(strpos($videoURL, 'vimeo')) {
			$regs = array();
			$id = '';
			if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $videoURL, $regs)) {
				$id = $regs[3];
			}

			return $id;
		} else{
			preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoURL, $match);
			$youtubeId = $match[1];

			return $youtubeId;
		}
	}

    /* Helper function that generates the URL of a preview image for an given video URL
   -------------------------------------------------------------------------------*/
	public static function getVideoThumbnail($videoURL) {
		$id = Cortex_Kulturvermittlung_Utils::extractVideoId($videoURL);

		if(strpos($videoURL, 'vimeo')) {
			$data = file_get_contents("http://vimeo.com/api/v2/video/$id.json");
			$data = json_decode($data);

			return $data[0]->thumbnail_medium;
		} else {
			return 'http://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
		}
	}

	/**
	 * This takes an array and reorders it from ['name'][0],['name'][1], ['type'][0], ['type'][1] to [0]['name'], [0]['type']. Is used to have a better accessible $_FILES array
	 *
	 * @param array
	 * @return array
	 */
	public static function diverseArray($vector){
		$result = array();
		foreach($vector as $key1 => $value1) {
			foreach($value1 as $key2 => $value2) {
				$result[$key2][$key1] = $value2;
			}
		}

		return $result;
	}

    /* This functions sorts the highlight profiles to the top
   -------------------------------------------------------------------------------*/
	public static function sortProfiles($a, $b) {
		if(get_field('highlightprofil', 'user_' . $a->ID) &&  get_field('highlightprofil', 'user_' . $b->ID)) {
			return 0;
		} else if(get_field('highlightprofil', 'user_' . $a->ID)) {
			return -1;
		}  else {
			return 1;
		}
	}


    /* This functions sorts the highlight offers to the top
   -------------------------------------------------------------------------------*/
	public static function sortOffers($a, $b) {
		if(get_field('highlightangebot', $a->ID) && get_field('highlightangebot', $b->ID)) {
			return 0;
		} else if(get_field('highlightangebot', $a->ID)){
			return -1;
		} else if(get_field('highlightangebot', $b->ID)) {
			return 1;
		}
	}

    /* This functions sorts the highlight offers to the top
    -------------------------------------------------------------------------------*/
    public static function getALTTag($attachementID) {
        //Get the attachment ID of the translation!
        $attachementID = apply_filters( 'wpml_object_id', $attachementID, 'attachment' );

        // Get ALT
        $thumb_alt = get_post_meta( $attachementID, '_wp_attachment_image_alt', true );

        // No ALT supplied get attachment info
        if (empty( $thumb_alt))
            $attachment = get_post($attachementID);

        // Use caption if no ALT supplied
        if (empty($thumb_alt))
            $thumb_alt = $attachment->post_excerpt;

        // Use title if no caption supplied either
        if (empty($thumb_alt))
            $thumb_alt = $attachment->post_title;

        // Return ALT
        return esc_attr(trim(strip_tags( $thumb_alt )));
    }
}