<?php
namespace App\Helper;

use App\Command\Options\SkipHandlers\SkipException;
use App\Entity\Video;
use Exception;

class VideoQualityHelper {

    private static $BehindeTheScenesQuality = 720;
    private static $SceneQuality = 1080;
    private $links = [];
    public function __construct()
    {
        
    }

    public function addLink($quality, string $url) {
        $lowerQuality = trim(strtolower((string)$quality));
        //sanitze input
        switch ($lowerQuality) {
            case '4k':
            case '3840x2160':
                $lowerQuality = 2160;
                break;
            case '1080p':
            case '1920x1080':
            case 'full hd':
                $lowerQuality = 1080;
                break;
            case '720p':
            case '1280x720':
                $lowerQuality = 720;
                break;
            case '480p':
            case 'sd':
                $lowerQuality = 480;
                break;
            case '640x360':
            case 'mobile':
            case '360p':
                $lowerQuality = 360;
                break;
            case '480x240':
            case '240p':
                $lowerQuality = 240;
                break;
            case '144p':
                $lowerQuality = 144;
                break;
            default:
                LoggerHelper::writeToConsole("No Matching Quality Key found $lowerQuality",'Error');
                $lowerQuality = 0;

                break;
        }
        if(array_key_exists($lowerQuality,$this->links)) {
            LoggerHelper::writeToConsole("Duplicated Quality Key: $quality",'error');
        }
        $this->links[$lowerQuality] = $url;
    }

    public static function setBehindeTheScenesQuality(String $quality) {
        if(!is_numeric($quality)) {
            throw new Exception("The Behinde the Scenes Quality $quality has to be numeric");
        }
        self::$BehindeTheScenesQuality = (int)$quality;
    }

    public static function setSceneQuality(String $quality) {
       if(!is_numeric($quality)) {
           throw new Exception("The Scene Quality $quality has to be numeric");
       }
       self::$SceneQuality = (int)$quality;
    }
    /**
     * Undocumented function
     *
     * @param string[] $urls
     * @return void
     */
    public function pickQuality(Video $video) {
        $maxQuality = $video->getMetadata()->getBehindeTheScenes() ? self::$BehindeTheScenesQuality : self::$SceneQuality;
        krsort($this->links);
        foreach ($this->links as $quality => $link) {
            if($maxQuality >= $quality) {
                $video->setDownloadUrl($link);
                $video->setDownloadedQualtity($quality);
                return $video;
            }
        }
        throw new Exception('No Quality found for Video');
    } 
}