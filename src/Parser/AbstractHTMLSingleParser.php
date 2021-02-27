<?php
namespace App\Parser;

use App\Downloaders\AbstractDownloader;
use App\Entity\Video;
use App\Helper\DownloadHelper;
use App\Helper\EntityManager;
use App\Entity\MetadataObject;
use DateTime;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractHTMLSingleParser  {
    public function __construct() {

    }


    /**
     * Parse Scene Date from the Detail view
     *
     * @param Crawler $crawler
     * @param Video $video
     * @return void
     */
    protected abstract function parseScenePageDetail(Crawler &$crawler, Video &$video,AbstractDownloader $fileDownloader);

    /**
     * Adds missing date from detail page to main page also saves the metadata to folder for easy consumption
     *
     * @param [type] $video
     * @return Video
     */
    public function parseScenePage(Video &$video, DownloadHelper &$downloadHelper,AbstractDownloader $fileDownloader) {
        //always invalidate scene cache.
        $client = $downloadHelper->getClient();
        $resp = $client->request('GET',$video->getUrl(),[]
        );

        $crawler = new Crawler((string)$resp->getBody());
        $video->setFetchedTime(new DateTime());
        $video->setGrabbedHtml(true);
        $this->parseScenePageDetail($crawler,$video,$fileDownloader);
        $em = EntityManager::get();
        $em->persist($video);
        $em->flush($video);
        return $video;
    }

    /**
     * Returns a array from a filtered crawler (I hate anonymous functions)
     *
     * @param Crawler $crawler
     * @return Crawler[]
     */
    protected function getArrayFromCrawler(Crawler $crawler) {
        
        $vid_array = $crawler->each(function(Crawler $video){
            return $video;
        });

        return $vid_array;
    }
}