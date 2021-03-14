<?php

namespace App\Command\Downloaders;

use App\Downloaders\Aria2;
use App\Helper\ProgressHelper;
use App\Parser\Pervcity;
use App\Parser\Swallowed;
use Exception;

class DownloadSwallowedCommand extends AbstractDownloadCommand
{
    private $baseUrl = "https://members.swallowed.com";
    protected static $defaultName = 'download:swallowed';

    public function setPublicMetadata(bool $status) {
        $this->baseUrl = "https://tour.swallowed.com";
    }

    protected function addAdditonalArguments() {
        $this->requireCookieFile();
    }

    public static function getPageName() {
        return 'Swallowed';
    }

    public function getPageId() {
        return 3;
    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }

    protected function getFirstPage() { 
        return 1;
    }

    protected function getVideoPath() {
        return [
            $this->getPageName() => '/videos?page={num}',
        ];

    }

    

    protected function lastPageReached($response) {
        if(strlen($response->getBody()) < 47000) {
            //@todo FinishedException type
            throw new Exception('Reached end');
        }
    }

    public function getMetadataParser() {
        return new Swallowed($this->saveEntities,$this->downloadVideosSetup,$this->publicMetadata);
    }


    protected function loadFileDownloader(ProgressHelper $progressHelper) {
        return new Aria2($progressHelper);
    }
}


