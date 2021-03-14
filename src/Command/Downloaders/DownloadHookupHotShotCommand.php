<?php

namespace App\Command\Downloaders;

use App\Downloaders\Aria2;
use App\Helper\ProgressHelper;
use App\Parser\HookupHotshot;
use Exception;

/** @package App\Command */
class DownloadHookupHotShotCommand extends AbstractDownloadCommand
{
    private $videoPath = 'members/categories/movies/{num}/latest/';
    protected static $defaultName = 'download:hookuphotshot';

    public function setPublicMetadata(bool $status) {
        $this->videoPath = 'categories/movies/{num}/latest/';
    }

    protected function addAdditonalArguments() {
        $this->requireBasicAuth();

    }


    public static function getPageName() {
        return 'HookupHotshot';
    }

    public function getPageId() {
        return 1;
    }

    public function getBaseUrl() {
        return 'https://hookuphotshot.com/';
    }

    protected function getFirstPage() { 
        return 1;
    }

    protected function getVideoPath() {
        return [$this->getPageName() => $this->videoPath];
    }

    protected function lastPageReached($response) {
        if(str_contains($response->getBody(),'Nothing found here.')) {
            throw new Exception('Reached end');
        }
    }

    public function getMetadataParser() {
        return new HookupHotshot($this->saveEntities,$this->downloadVideosSetup,$this->publicMetadata);
    }


    protected function loadFileDownloader(ProgressHelper $progressHelper) {
        return new Aria2($progressHelper);
    }
}


