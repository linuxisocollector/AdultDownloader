<?php
namespace App\Parser;

use App\Entity\Video;
use App\Helper\DownloadHelper;
use App\Helper\EntityManager;
use App\Entity\MetadataObject;
use DateTime;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractHTMLOverviewParser extends AbstractHTMLSingleParser {
  
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
            $videos[] = $video;
        }

        return $videos;
    }


}