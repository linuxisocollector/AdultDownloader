<?php

namespace App\Command\Downloaders;

use App\Downloaders\Aria2;
use App\Helper\ProgressHelper;
use App\Parser\Pervcity;
use Exception;

class DownloadPervcityCommand extends AbstractDownloadCommand
{
    private $baseUrl = "https://members.pervcity.com/";
    protected static $defaultName = 'download:pervcity';

    public function setPublicMetadata(bool $status) {
        $this->baseUrl = "https://pervcity.com/";
    }

    protected function addAdditonalArguments() {
        $this->requireCookieFile();
    }

    public static function getPageName() {
        return 'Pervcity';
    }

    public function getPageId() {
        return 2;
    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }

    protected function getFirstPage() { 
        return 1;
    }

    protected function getVideoPath() {
        return '/categories/movies_{num}_d.html';
    }

    protected function lastPageReached($response) {
        if(strlen($response->getBody()) < 43000) {
            throw new Exception('Reached end');
        }
    }

    public function getMetadataParser() {
        return new Pervcity($this->saveEntities,$this->downloadVideosSetup,$this->publicMetadata);
    }


    protected function loadFileDownloader(ProgressHelper $progressHelper) {
        return new Aria2($progressHelper);
    }
}


