<?php

namespace App\Command;

use App\Downloaders\Aria2;
use App\Helper\ProgressHelper;
use App\Parser\HookupHotshot;
use Exception;

class DownloadHookupHotShotCommand extends AbstractDownloadCommand
{
    protected static $defaultName = 'download:hookuphotshot';

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
        return 'members/categories/movies/{num}/latest/';
    }

    protected function lastPageReached($response) {
        if(str_contains($response->getBody(),'Nothing found here.')) {
            throw new Exception('Reached end');
        }
    }

    public function getOverviewParser() {
        return new HookupHotshot();
    }


    protected function loadFileDownloader(ProgressHelper $progressHelper) {
        return new Aria2($progressHelper);
    }
}


