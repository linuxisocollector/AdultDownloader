<?php
namespace App\Parser;

use App\Downloaders\AbstractDownloader;
use App\Entity\Video;
use DateTime;
use App\Entity\MetadataObject;
use Symfony\Component\DomCrawler\Crawler;
use App\Helper\VideoQualityHelper;

/** @package App\Parser */
class HookupHotshot extends AbstractHTMLOverviewParser {

    protected function parseScenePageDetail(Crawler &$crawler, Video &$video,AbstractDownloader &$fileDownloader) {
        $sources = $this->getArrayFromCrawler($crawler->filter('video source'));
        $qualities = [];
        foreach ($sources as $key => $source_crawler) {
            $qualities[$source_crawler->attr('res')]=  $source_crawler->attr('src');
        }
        $key = VideoQualityHelper::pickQuality($qualities,$video);
        $video->setDownloadUrl($qualities[$key]);
        $video->setDownloadedQualtity($key);

    }


    protected function getVideoParentObject(Crawler $crawler) {
        $filterd = $this->getArrayFromCrawler($crawler->filter('#et-projects li'));
        return $filterd;
    }


    protected function parseOverviewVideo(Crawler &$crawler, Video &$video,MetadataObject &$metadata) {
        $video->setUrl($crawler->filter('.date-img-wrapper a')->attr('href'));
        $metadata->setSceneName($crawler->filter('.date-title a')->text());
        $metadata->setThumbnailUrl($crawler->filter('.date-img-wrapper a img')->attr('src'));
        $actress = $crawler->filter('.date-starring')->text();
        $actress = trim(str_replace('Starring ','',$actress));
        $thumbnail_url = $metadata->getThumbnailUrl();
        //parse date from wordpress upload date
        $thumb_url = str_replace('https://hookuphotshot.com/wp-content/uploads/','',$thumbnail_url);
        $thumb_url_expoloded = explode('/',$thumb_url);
        $dt = new DateTime();
        $dt->setDate($thumb_url_expoloded[0],$thumb_url_expoloded[1],1);
        $metadata->setActress($actress);
        $metadata->setDate($dt);
    }
}