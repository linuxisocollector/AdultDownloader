<?php

namespace App\Command;

use App\Downloaders\Aria2;
use App\Helper\ProgressHelper;
use App\Parser\Pervcity;
use Exception;

class DownloadPervcityCommand extends AbstractDownloadCommand
{
    protected static $defaultName = 'download:pervcity';

    protected function addAdditonalArguments() {
        $this->requireCookieFile();
    }

    protected static function getPageName() {
        return 'Pervcity';
    }

    protected static function getPageId() {
        return 2;
    }

    protected function getBaseUrl() {
        return 'https://members.pervcity.com/';
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

    protected function getOverviewParser() {
        return new Pervcity();
    }


    protected function loadFileDownloader(ProgressHelper $progressHelper) {
        return new Aria2($progressHelper);
    }
}


