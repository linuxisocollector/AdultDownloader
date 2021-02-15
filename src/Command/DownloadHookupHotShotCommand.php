<?php

namespace App\Command;

use App\Downloaders\Aria2;
use App\Helper\ProgressHelper;
use App\Parser\HookupHotshot;
use Exception;

class DownloadHookupHotShotCommand extends AbstractDownloadCommand
{
    protected static $defaultName = 'download:hookuphotshot';

    protected function getPageName() {
        return 'HookupHotshot';
    }

    protected function getPageId() {
        return 1;
    }

    protected function getBaseUrl() {
        return 'https://hookuphotshot.com/';
    }

    protected function getFirstPage() { 
        return 0;
    }

    protected function getVideoPath() {
        return '/the-dates/page/{num}/';
    }

    protected function lastPageReached($response) {
        if(str_contains($response->getBody(),'Sorry... there are no more dates. Click ')) {
            throw new Exception('Reached end');
        }
    }

    protected function getOverviewParser() {
        return new HookupHotshot();
    }


    protected function getVideoDownloadClient(ProgressHelper $progressHelper) {
        return new Aria2($progressHelper);
    }
}


