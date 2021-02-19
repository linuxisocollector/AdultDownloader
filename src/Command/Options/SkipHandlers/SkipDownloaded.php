<?php
namespace App\Command\Options\SkipHandlers;

use App\Entity\Video;

class SkipDownloaded implements ISkipHandler {
    /** @var Video[] */
    private $videos = [];
    private $does_handle = true;

    public function __construct($videos, $argument) {
        if($argument == true) {
            $this->does_handle = false;
        }
        $this->videos = $videos;
    }

    public static function getCommandName() {
        return 'force';
    }

    public function doesHandle() {
        return $this->does_handle;
    }

    public function action() {
        $out_video = [];
        foreach ($this->videos as $key => $value) {
            if($value->getDownloadedVideo()) {
                continue;
            }
            $out_video[] = $value;
        }

        return $out_video;
    }
    
}