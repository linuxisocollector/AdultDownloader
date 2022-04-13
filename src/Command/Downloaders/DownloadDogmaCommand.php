<?php

namespace App\Command\Downloaders;

use App\Downloaders\Aria2;
use App\Downloaders\Streamlink;
use App\Helper\ProgressHelper;
use App\Parser\Dogma;
use Exception;

/** @package App\Command */
class DownloadDogmaCommand extends AbstractDownloadCommand
{
    private $videoPath = 'search?id_feature=17,18,16&search_feature=%E6%9C%88%E9%A1%8D%E3%83%97%E3%83%A9%E3%83%B3%20-%20%E3%83%95%E3%82%9A%E3%83%AC%E3%83%9F%E3%82%A2%E3%83%A0&p={num}';
    protected static $defaultName = 'download:dogma';

    public function setPublicMetadata(bool $status) {
    }

    protected function addAdditonalArguments() {
        $this->requireCookieFile();
    }


    public static function getPageName() {
        return 'Dogma';
    }

    public function getPageId() {
        return 5;
    }

    public function getBaseUrl() {
        return 'http://www.dogma.co.jp/';
    }

    protected function getFirstPage() { 
        return 1;
    }

    protected function getVideoPath() {
        return [$this->getPageName() => $this->videoPath];
    }

    protected function lastPageReached($response,$page_num) {
        if($page_num > 17) {
            throw new Exception('Reached end');
        }
    }

    public function getMetadataParser() {
        return new Dogma($this->saveEntities,$this->downloadVideosSetup,$this->publicMetadata);
    }


    protected function loadFileDownloader(ProgressHelper $progressHelper) {
        return new Streamlink($progressHelper);
    }
}


