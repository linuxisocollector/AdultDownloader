<?php
namespace App\Helper;
use App\Entity\Video;

class VideoQualityHelper {

    /**
     * Undocumented function
     *
     * @param string[] $urls
     * @return void
     */
    public static function pickQuality( $urls, Video $video) {
        if($video->getMetadata()->getBehindeTheScenes()) {
            //default to 720p
            if(array_key_exists('720',$urls)) {
                return '720';
            }
        } else {
            if(array_key_exists('4K',$urls)) {
                unset($urls['4K']);
            }
            return array_key_first($urls);
        }
    } 
}