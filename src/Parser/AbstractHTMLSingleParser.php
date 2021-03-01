<?php
namespace App\Parser;

use App\Downloaders\AbstractDownloader;
use App\Entity\Video;
use App\Helper\DownloadHelper;
use App\Helper\EntityManager;
use App\Entity\MetadataObject;
use App\Helper\VideoQualityHelper;
use DateTime;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractHTMLSingleParser  {
    private $save;
    private $download;
    private $public;
    public function __construct($save = true, $download = true,$public = false) {
        $this->save = $save;
        $this->download = $download;
        $this->public = $public;
    }

    
    /**
     * Parse Scene Date from the Detail view
     *
     * @param Crawler $crawler
     * @param Video $video
     * @param AbstractDownloader $fileDownloader
     * @param VideoQualityHelper $qualityPicker
     * @return Video
     */
    protected abstract function parseScenePageDetail(Crawler &$crawler, Video &$video,AbstractDownloader $fileDownloader,VideoQualityHelper &$qualityPicker);


    public abstract function getPublicUrl(Video $video);
    /**
     * Adds missing date from detail page to main page also saves the metadata to folder for easy consumption
     *
     * @param [type] $video
     * @return Video
     */
    public function parseScenePage(Video &$video, DownloadHelper &$downloadHelper,AbstractDownloader $fileDownloader) {
        //always invalidate scene cache.
        $client = $downloadHelper->getClient();
        $url = $this->public ? $this->getPublicUrl($video) : $video->getUrl();

        $resp = $client->request('GET',$url,[]
        );
        $qualityPicker = new VideoQualityHelper();
        $crawler = new Crawler((string)$resp->getBody());
        $video->setGrabbedHtml(true);
        $this->parseScenePageDetail($crawler,$video,$fileDownloader,$qualityPicker);
        $this->isBehindeTheScences($video);
        if($this->download) {
            $video->setFetchedTime(new DateTime());
            $video = $qualityPicker->pickQuality($video);
        }
        if($this->save) {
            $em = EntityManager::get();
            $em->persist($video);
            $em->flush($video);
        }

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

    private function isBehindeTheScences(Video &$video) {
        $bts = false;
        $metadata = $video->getMetadata();
        $stringsToCheck = array_merge([$metadata->getSceneName()],$metadata->getTags());
        $detectingStrings  = [
            'BTS',
            'Behind the Scenes'
        ];
        foreach ($stringsToCheck as $key => $checkString) {
            foreach ($detectingStrings as $key => $detectionString) {
                if(str_contains($checkString,$detectionString)) {
                    $bts = true;
                    break 2;
                }
            }
   
    
        }
        $metadata->setBehindeTheScenes($bts);
        $video->setMetadata($metadata);
        return $bts;
    }

    /**
     * Set the value of save
     *
     * @return self
     */
    public function setSave($save) : self
    {
        $this->save = $save;

        return $this;
    }

    /**
     * Set the value of download
     *
     * @return self
     */
    public function setDownload($download) : self
    {
        $this->download = $download;

        return $this;
    }

    /**
     * Set the value of public
     *
     * @return self
     */
    public function setPublic($public) : self
    {
        $this->public = $public;

        return $this;
    }
}