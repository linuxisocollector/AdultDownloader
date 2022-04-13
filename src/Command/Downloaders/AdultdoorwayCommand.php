<?php

namespace App\Command\Downloaders;

use App\Downloaders\Aria2;
use App\Helper\ProgressHelper;
use App\Parser\Adultdoorway;
use App\Parser\HookupHotshot;
use Exception;

/** @package App\Command */
class AdultdoorwayCommand extends AbstractDownloadCommand
{
    protected static $defaultName = 'download:adultdoorway';

    public function setPublicMetadata(bool $status) {
        $this->videoPath = 'categories/movies/{num}/latest/';
    }

    protected function addAdditonalArguments() {
        $this->requireCookieFile();
    }


    public static function getPageName() {
        return 'Adultdoorway';
    }

    public function getPageId() {
        return 4;
    }

    public function getBaseUrl() {
        return 'https://adultdoorway.com';
    }

    protected function getFirstPage() { 
        return 1;
    }

    protected function getVideoPath() {
        return [
            'FacialAbuse'=> 'members/facialabuse/category.php?id=5&page={num}&s=d',
            'TheHandJobSite' => 'members/thehandjobsite/category.php?id=5&page={num}&s=d',
            'ThePantyHoseSite' => 'members/thepantyhosesite/category.php?id=5&page={num}&s=d',
            'PinkKittyGirls' => 'members/pinkkittygirls/category.php?id=5&page={num}&s=d',
            'NastyLittleFacials' => 'members/nastylittlefacials/category.php?id=5&page={num}&s=d',
            'BustyAmateurBoobs' => 'members/bustyamateurboobs/category.php?id=5&page={num}&s=d',
            'JoeThePervert' => 'members/joethepervert/category.php?id=5&page={num}&s=d',
            'BonusVideos' => '/members/category.php?id=74&page={num}&s=d'
        ];
    }

    protected function lastPageReached($response,$page_num) {
        if(strlen($response->getBody()) < 45000) {
            throw new Exception('Reached end');
        }
    }

    public function getMetadataParser() {
        return new Adultdoorway($this->saveEntities,$this->downloadVideosSetup,$this->publicMetadata);
    }


    protected function loadFileDownloader(ProgressHelper $progressHelper) {
        return new Aria2($progressHelper);
    }
}


