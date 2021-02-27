<?php
namespace App\Parser;

use App\Downloaders\AbstractDownloader;
use Symfony\Component\DomCrawler\Crawler;
use App\Entity\Video;
use App\Entity\MetadataObject;
use App\Helper\VideoQualityHelper;
use DateTime;

class Pervcity extends AbstractHTMLOverviewParser{

    protected function getVideoParentObject(Crawler $html) {
        $filterd = $this->getArrayFromCrawler($html->filter('.dvdsArea .videoBlock'));
        
        return $filterd;
    }

    protected function parseOverviewVideo(Crawler &$crawler, Video &$video, MetadataObject &$metadata) {
        $video->setUrl($crawler->filter('.videoPic a')->attr('href'));
        $metadata->setSceneName($crawler->filter('.videoContent h3 a')->text());
        $metadata->setThumbnailUrl($crawler->filter('.videoPic a img')->attr('src'));
        $actress = $crawler->filter('.videoContent .update_models')->text();
        $actress = trim($actress);
        $metadata->setActress($actress);
        $date_time = $crawler->filter('.videoContent .date')->text();
        $dt = new DateTime();
        $date_time_exploded = explode('-',$date_time);
        $dt->setDate($date_time_exploded[2],$date_time_exploded[1],$date_time_exploded[0]);
        $metadata->setDate($dt);
    }

    protected function parseScenePageDetail(Crawler &$crawler, Video &$video,AbstractDownloader $fileDownloader) {
        $tags_crawlers = $this->getArrayFromCrawler($crawler->filter('.tagcats a'));
        $tags = [];
        foreach ($tags_crawlers as $key => $tag_crawler) {
            $tags[] = $tag_crawler->text();
        }
        $description = $crawler->filter('.infoBox > p')->text();

        $downloads_crawlers = $this->getArrayFromCrawler($crawler->filter('#downloads .contentdownload .listpanel'));
        $qualities = [];
        foreach ($downloads_crawlers as $key => $download_crawler) {
            $text = $download_crawler->filter('h4')->text();
            if($text == '720p') {
                $text = '720';
            } else if($text == 'Full HD') {
                $text = '1080';
            } else if($text == 'SD') {
                $text = '480';
            }
            $qualities[$text]=  $download_crawler->filter('.btndownload')->attr('href');
        }
        $metadata = $video->getMetadata();
        $metadata->setTags($tags);
        $metadata->setDescription($description);
        $video->setMetadata($metadata);
        //@todo Quality Setting through command line argument
        if(array_key_exists("720",$qualities) && array_key_exists("1080",$qualities)) {
            unset($qualities["1080"]);
        }
        $key = VideoQualityHelper::pickQuality($qualities,$video);
        $video->setDownloadUrl($qualities[$key]);
        $video->setDownloadedQualtity($key);
    }

}
?>