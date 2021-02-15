<?php
namespace App\Helper;

use Exception;
use App\Entity\Video;
use Symfony\Component\Finder\Finder;

class StashHelper {

    private $stash_scenes;
    private $stash_performers;
    /** @var String */
    private $stashdbpath;
    private $image_directory;
    private $existing_tags;
    /** @var Video[] */
    private $videos;
    public function __construct($stashdbpath,$image_directory,$videos)
    {
        $this->stashdbpath = $stashdbpath;
        $this->image_directory = $image_directory;
        $this->loadStashDB();
        $this->loadVideos($videos);
    }

    private function getMappingPath() {
        return $this->stashdbpath."/"."mappings.json";
    }

    private function folderByType($type) {
        return $this->stashdbpath."/".$type;
    }

    private function base64EncodeImage($filename) {

    }

    private function loadVideos($videos) {
        foreach ($videos as $key => $video) {
            //@todo Write message if something failed
            if(file_exists($video)) {

            }
        }
    }
    private function loadStashDB() {
        if(!file_exists($this->getMappingPath())) {
            throw new Exception('Mapping file not found '.$this->getMappingPath());
        }
        $mappings = json_decode(file_get_contents($this->getMappingPath()));
        $parsed = [];
        foreach ($mappings as $mapping_type => $type_mapping) {
            if(!in_array($mapping_type,[
                'tags',
                'performers',
                'scenes'
            ])) {
                continue;
            }
            $mapping_type_loaded = [];
            foreach ($type_mapping as $key => $mapping) {
                $file_path = $this->folderByType($mapping_type)."/".$mapping->checksum.".json";
                if(!file_exists($file_path)) {
                    LoggerHelper::writeToConsole($mapping->name." not found in path $file_path",'info');
                    continue;
                }
                $mapping_type_loaded[] = file_get_contents($file_path);
            }
            $parsed[$mapping_type] = $mapping_type_loaded;
        }
        $this->stash_scenes = $parsed['scenes'];
        $this->stash_performers = $parsed['performers'];

    }


}