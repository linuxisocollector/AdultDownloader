<?php
namespace App\Helper;

use App\Entity\Video;
use FFmpeg\FFProbe;
class VideoInfoHelper {
    /** @var \FFmpeg\FFProbe */
    private $ffprobe = null;
    public function __construct()
    {
        $this->ffprobe = FFProbe::create();
    }

    private function getVideoInfo(Video $video) {
        return $this->ffprobe
            ->format($video->getFilePath())
            ->all();
    }

    public function getVideoDuration(Video $video) {
        $info = $this->getVideoInfo($video);
        return $info['duration'];
    }

    public function getVideoResolution(Video $video) {

    }

    public function getOhash(Video $video) {
        return Ohash::OpenSubtitlesHash($video->getFilePath());
    }
}