<?php
namespace App\Command\Options\SkipHandlers;

use App\Entity\Video;
use App\Command\Options\SkipHandlers\SkipException;

class SkipBehindTheScenes implements ISkipHandler, ISkipHandlerInProgress {
    /** @var Video[] */
    private $videos = [];
    private $does_handle = true;

    public function __construct($videos, $argument) {
        if($argument == false) {
            $this->does_handle = false;
        }
        $this->videos = $videos;
    }

    public function handle_in_progress(Video $video) {
        if($video->getMetadata()->getBehindeTheScenes()) {
            throw new SkipException('Behind the Scenes filter');
        }
    }

    public static function getCommandName() {
        return 'skip-behind-the-scences';
    }

    public function doesHandle() {
        return $this->does_handle;
    }
    

    public function action() {
        $out_video = [];
        foreach ($this->videos as $key => $value) {
            $metadata = $value->getMetadata();
            if($metadata->getBehindeTheScenes()) {
                continue;
            }
            $out_video[] = $value;
        }

        return $out_video;
    }

    
}