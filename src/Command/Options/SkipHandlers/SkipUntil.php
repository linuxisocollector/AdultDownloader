<?php
namespace App\Command\Options\SkipHandlers;

use App\Helper\LoggerHelper;

class SkipUntil implements ISkipHandler {

    private $videos;
    private $until_url;
    private $does_handle = true;

    public function __construct($videos, $argument) {
        if($argument == false) {
            $this->does_handle = false;
        }
        $this->videos = $videos;
        $this->until_url = $argument;
    }

    public static function getCommandName() {
        return 'skip-until';
    }

    public function doesHandle() {
        return $this->does_handle;
    }

    public function action() {
        $out_video = [];
        $skip = true;
        foreach ($this->videos as $key => $value) {
            if($value->getUrl() == $this->until_url) {
                $skip = false;
            }
            if($skip) {
               continue; 
            }
            $out_video[] = $value;
        }
        return $out_video;
    }
    
}