<?php
namespace App\Command\Options\SkipHandlers;

use App\Helper\LoggerHelper;

class SkipList implements ISkipHandler {

    private $videos;
    private $until_url;

    public function __construct($videos, $argument) {
        
        if(!file_exists($argument)) {
            LoggerHelper::writeToConsole('Can not find file skip-list','error');
            throw new \Exception('Can not find file skip-list');
        }
        $this->videos = $videos;
        $file_content = file_get_contents($argument);
        $file_content = explode("\n",$file_content);
        $this->until_url = $file_content;
    }

    public function doesHandle() {
        return true;
    }

    public static function getCommandName() {
        return 'skip-list';
    }

    
    public function action() {
        $out_video = [];
        foreach ($this->videos as $key => $value) {
            if(in_array($value->getUrl(),$this->until_url)) {
               continue; 
            }
            $out_video[] = $value;
        }
        return $out_video;
    }
    
}