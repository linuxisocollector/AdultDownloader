<?php
namespace App\Parser;

use App\Downloaders\AbstractDownloader;
use Symfony\Component\DomCrawler\Crawler;
use App\Entity\Video;
use App\Entity\MetadataObject;
use App\Helper\VideoQualityHelper;
use DateTime;

class Swallowed extends AbstractHTMLOverviewParser{

    public function getPublicUrl(Video $video) {

        return $video->getMetadata()->getPublicSceneUrl();
    }

    protected function getVideoParentObject(Crawler $html) {
        $filterd = $this->getArrayFromCrawler($html->filter('.content-item'));
        return $filterd;
    }


    protected function parseOverviewVideo(Crawler &$crawler, Video &$video, MetadataObject &$metadata) {
        $video->setUrl($crawler->filter('.main-big-img')->attr('href'));
        $metadata->setSceneName(trim($crawler->filter('.info-wrap .title a')->text()));
        $metadata->setThumbnailUrl($crawler->filter('.main-big-img img')->attr('src'));
        $performers = $this->getArrayFromCrawler($crawler->filter('.models a'));
        $performersArr = [];
        foreach ($performers as $key => $performer) {
            $performersArr[] = $performer->text();
        }
        $metadata->setPerformers($performersArr);
        $date_time = $crawler->filter('.item-meta time')->text();
        $date_array = date_parse($date_time);
     
        // returns original date string assuming the format was Y-m-d H:i:s
        $dt = new DateTime();
        $dt->setDate($date_array['year'],$date_array['month'],$date_array['day']);
        $metadata->setDate($dt);
    }

    protected function parseScenePageDetail(Crawler &$crawler, Video &$video,AbstractDownloader $fileDownloader,VideoQualityHelper &$qualityPicker) {
        $tags_crawlers = $this->getArrayFromCrawler($crawler->filter('.tags a'));
        $tags = [];
        foreach ($tags_crawlers as $key => $tag_crawler) {
            if($tag_crawler->text() == 'Exclusive') {
                continue;
            }
            $tags[] = $tag_crawler->text();
        }

        $description = $crawler->filter('.content-desc > p');
        if($description->getNode(0) === null) {
            $description = $crawler->filter('.content-desc');
        }
        $downloads_crawlers = $this->getArrayFromCrawler($crawler->filter('.download-video .dropdown-menu li a'));
        foreach ($downloads_crawlers as $key => $download_crawler) {
            $link = $download_crawler->attr('href');
            if(!isset($link)) {
                continue;
            }
      
            $text = $download_crawler->filter('.dimension')->text();
            if(str_contains($link,'orig')) {
                //@todo Don't know how to handle same res with different quality
                $text = '3840x2160'; 
            }
            $qualityPicker->addLink($text,$link);
        }
        $id = explode('/',str_replace('https://members.swallowed.com/download/','',$link))[0];
        $urlSplit = explode('/',$video->getUrl());
        $metadata = $video->getMetadata();
        $metadata->setPublicSceneUrl('https://tour.swallowed.com/view/'.$id.'/'.end($urlSplit));
        $metadata->setTags($tags);
        $metadata->setDescription($description->text());
        $video->setMetadata($metadata);
    }

}
?>