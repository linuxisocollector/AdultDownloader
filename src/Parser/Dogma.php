<?php
namespace App\Parser;


use App\Downloaders\AbstractDownloader;
use Symfony\Component\DomCrawler\Crawler;
use App\Entity\Video;
use App\Entity\MetadataObject;
use App\Helper\LoggerHelper;
use App\Helper\VideoQualityHelper;
use DateTime;

/** @package App\Parser */
class Dogma extends AbstractHTMLOverviewParser {

    public function getPublicUrl(Video $video) {
        return $video->getUrl();
    }
    

    protected function parseScenePageDetail(Crawler &$crawler, Video &$video,AbstractDownloader $fileDownloader,VideoQualityHelper &$qualityPicker,$client) {
        $crawler->filter('h1')->first()->text();
        $url = $crawler->filter('#player3')->first()->attr('data-url');
        if($this->download) {
            $res = $client->request('GET',$url,[]);
            $body = $res->getBody();
            $qualityPicker->addLink('720p',json_decode($body,true)['url']);
        } else {
            LoggerHelper::writeToConsole($url,'info');
        }
        $meta = $video->getMetadata();
        $name = $crawler->filter('#product_reference span')->first()->text();
        if(str_contains($name,'/')) {
            $name = explode('/',$name)[0];
        }
        $meta->setSceneName(trim($name));
        $performers = [];
        $performers_craw = $this->getArrayFromCrawler($crawler->filter('.actress'));
        foreach ($performers_craw as $key => $performer) {
            $performers[] = $performer->text();
        }
        $meta->setPerformers($performers);
        $meta->setBehindeTheScenes(false);
        $tags = [];
        $tags_craw = $this->getArrayFromCrawler($crawler->filter('.tag'));
        foreach ($tags_craw as $key => $tag) {
            $tags[] = $tag->text();
        }
        $dateStr = $crawler->filter('#product-info-block a.dvd')->first()->text();
        $date = DateTime::createFromFormat('Y/m/d',$dateStr);
        $meta->setPublicSceneUrl($video->getUrl());
        if($date !== false) {
            $meta->setDate($date);
        }
        $meta->setTags($tags);
        if($crawler->filter('.rte')->count() > 0) {
            $meta->setDescription($crawler->filter('.rte')->first()->text());
        }
        $video->setMetadata($meta);
    }


    protected function getVideoParentObject(Crawler $crawler) {
        $filterd = $this->getArrayFromCrawler($crawler->filter('.product_list .product-container'));
        return $filterd;
    }

    protected function parseOverviewVideo(Crawler &$crawler, Video &$video,MetadataObject &$metadata) {
        $url = $crawler->filter('a.product_img_link')->first()->attr('href');        
        // $metadata->setSceneName(str_replace('.html','',explode('/',parse_url($url)['path'])[2]));
        $thumb_url = $crawler->filter('.replace-2x ')->attr('src');
        if( $thumb_url === null) {
            $thumb_url = $crawler->filter('.replace-2x')->attr('src');
        }
        $video->setUrl($url);
        
        $metadata->setThumbnailUrl($thumb_url);
    }
}