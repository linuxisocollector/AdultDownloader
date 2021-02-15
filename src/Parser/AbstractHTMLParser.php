<?php
namespace App\Parser;

use App\Entity\Video;
use App\Helper\DownloadHelper;
use App\Helper\EntityManager;
use App\Entity\MetadataObject;
use DateTime;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractHTMLParser  {
    public function __construct() {

    }
    /**
     * Should get the scene container where all the videos elements are in the overview page
     *
     * @param Crawler $html
     * @return Crawler[]
     */
    protected abstract function getVideoParentObject(Crawler $html);

    /**
     * Parse a single Video Preview element from a overview page
     * At a absolute minimum the Url has to be set after using this function
     *
     * @param Crawler $crawler
     * @param Video $video
     * @param MetadataObject $metadata
     * @return void
     */
    protected abstract function parseOverviewVideo(Crawler &$crawler, Video &$video,MetadataObject &$metadata);

    /**
     * Parse Scene Date from the Detail view
     *
     * @param Crawler $crawler
     * @param Video $video
     * @return void
     */
    protected abstract function parseScenePageDetail(Crawler &$crawler, Video &$video);

    private function isBehindeTheScences(Video $video) {
        $bts = false;
        $metadata = $video->getMetadata();

        if(str_contains('BTS',$metadata->getSceneName())) {
            $bts = true;
        }

        if(str_contains('Behind the Scenes',$metadata->getSceneName())) {
            $bts = true;
        }

        $metadata->setBehindeTheScenes($bts);
        $video->setMetadata($metadata);

        return $bts;
    }
    public function ParsePage($html,$url) {
        $videos = [];
        $filtered = $this->getVideoParentObject(new Crawler((string)$html));
        foreach ($filtered as $key => $value) {
            $video = new Video();
            $metadata = new MetadataObject();
            try {
                $this->parseOverviewVideo($value,$video,$metadata);
            } catch (Exception $ex) {
                dump($ex);
                dump($url);
                dump($video);
            }
            $video->setMetadata($metadata);
            $this->isBehindeTheScences($video);
            $videos[] = $video;
        }

        return $videos;
    }

    /**
     * Adds missing date from detail page to main page also saves the metadata to folder for easy consumption
     *
     * @param [type] $video
     * @return Video
     */
    public function parseScenePage(Video $video, DownloadHelper $downloadHelper) {
        //always invalidate scene cache.
        $client = $downloadHelper->getClient();
        $resp = $client->request('GET',$video->getUrl(),[]
        );

        $crawler = new Crawler((string)$resp->getBody());
        $video->setFetchedTime(new DateTime());
        $video->setGrabbedHtml(true);
        $this->parseScenePageDetail($crawler,$video);
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