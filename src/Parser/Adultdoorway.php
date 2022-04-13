<?php
namespace App\Parser;


use App\Downloaders\AbstractDownloader;
use Symfony\Component\DomCrawler\Crawler;
use App\Entity\Video;
use App\Entity\MetadataObject;
use App\Helper\VideoQualityHelper;
use DateTime;

/** @package App\Parser */
class Adultdoorway extends AbstractHTMLOverviewParser {

    public function getPublicUrl(Video $video) {
        return $video->getUrl();
    }
    

    protected function parseScenePageDetail(Crawler &$crawler, Video &$video,AbstractDownloader $fileDownloader,VideoQualityHelper &$qualityPicker,$client) {
        $sources = $this->getArrayFromCrawler($crawler->filter('#download_options_block .dropdown li a'));
        foreach ($sources as $key => $source_crawler) {
            $quality_label = explode(' ',$source_crawler->text())[0];
            $href = $source_crawler->attr('href');
            $href = parse_url($href)['path'];
            $qualityPicker->addLink($quality_label,$href);
        }
        $meta = $video->getMetadata();
        $meta->setDescription($crawler->filter('.update_description')->text());
        $video->setMetadata($meta);
    }


    protected function getVideoParentObject(Crawler $crawler) {
        $filterd = $this->getArrayFromCrawler($crawler->filter('.category_listing_wrapper_updates .update_details'));
        return $filterd;
    }

    protected function parseOverviewVideo(Crawler &$crawler, Video &$video,MetadataObject &$metadata) {
        $url = $crawler->filter('a')->first()->attr('href');
        $queryParams = [];
        parse_str(parse_url($url)['query'],$queryParams);
        $metadata->setSceneName($queryParams['id']." ".$crawler->filter('.model_title')->text());
        $thumb_url = $crawler->filter('.update_thumb')->attr('src0_3x');
        if( $thumb_url === null) {
            $thumb_url = $crawler->filter('.update_thumb')->attr('src');
        }
        //fetch without cdn so we don't run into expired issues
        $parsed = parse_url($thumb_url);
        $video->setUrl("members/".$url);
        
        $metadata->setThumbnailUrl($parsed['path']);
    }
}