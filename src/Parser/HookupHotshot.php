<?php
namespace App\Parser;


use App\Downloaders\AbstractDownloader;
use Symfony\Component\DomCrawler\Crawler;
use App\Entity\Video;
use App\Entity\MetadataObject;
use App\Helper\VideoQualityHelper;
use DateTime;

/** @package App\Parser */
class HookupHotshot extends AbstractHTMLOverviewParser {

    public function getPublicUrl(Video $video) {
        $str = str_replace('/members/scenes/','/trailers/',$video->getUrl());
        $str = str_replace('_vids','',$str);
        return $str;
    }

    protected function parseScenePageDetail(Crawler &$crawler, Video &$video,AbstractDownloader $fileDownloader,VideoQualityHelper &$qualityPicker) {
        $sources = $this->getArrayFromCrawler($crawler->filter('.downloaddropdown li a'));
        $qualities = [];
        foreach ($sources as $key => $source_crawler) {
            $quality_label = $source_crawler->text();
            if(str_contains($quality_label,'1080')) {
                $quality_label = "1080";
            } else if(str_contains($quality_label,'720')) {
                $quality_label = "720";
            } else if(str_contains($quality_label,'480')) {
                $quality_label = "480";
            }
            $qualityPicker->addLink($quality_label,$source_crawler->attr('href'));
        }
        $meta = $video->getMetadata();
        $meta->setActress($crawler->filter('.update_models a')->text());
        $tagsNodes = $this->getArrayFromCrawler($crawler->filter('.featuring ul li'));
        $tags = [];
        foreach ($tagsNodes as $key => $value) {
            $text = $value->text();
            if(in_array($text,[
                'Featuring:',
                $meta->getActress(),
                'Tags:'
            ])) {
                continue;
            }
        }
        $meta->setTags($tags);
        $video->setMetadata($meta);
    }


    protected function getVideoParentObject(Crawler $crawler) {
        $filterd = $this->getArrayFromCrawler($crawler->filter('.bodyArea .items .item-video'));
        return $filterd;
    }


    protected function parseOverviewVideo(Crawler &$crawler, Video &$video,MetadataObject &$metadata) {
        $video->setUrl($crawler->filter('.item-thumb a')->attr('href'));
        $metadata->setSceneName($crawler->filter('.item-thumb a')->attr('title'));
        $thumb_url = $crawler->filter('.item-thumb a img')->attr('src0_3x');
        if( $thumb_url === null) {
            $thumb_url = $crawler->filter('.item-thumb a img')->attr('src');
        }
        $metadata->setThumbnailUrl($thumb_url);
        //parse date from wordpress upload date
        $dt = new DateTime();
        $date = $crawler->filter('.item-info .date')->text();
        $date_exploded = explode('-',$date);
        $dt->setDate($date_exploded[0],$date_exploded[1],$date_exploded[2]);
        $metadata->setDate($dt);
    }
}