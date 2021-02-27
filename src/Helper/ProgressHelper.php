<?php
namespace App\Helper;

use App\Entity\Video;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ProgressHelper {

    private $videos;
    private $progressBar1;
    private $progressBar2;
    /** @var ConsoleSectionOutput */
    private $section2;
    /**
     * Undocumented function
     *
     * @param Video[] $videos
     * @param ConsoleSectionOutput $output
     */
    public function __construct($videos,ConsoleOutput $output )
    {
        $this->videos = $videos;
        $section1 = $output->section();
        $section2 = $output->section();
        $this->section2 = $section2;
        $video_strlen = (strlen(count($videos)));
        $this->progressBar1 = new ProgressBar($section1, count($this->videos));
        $format_videos = '';
        $padding_video = 0;
        if($video_strlen < 3) {
            $padding_video = (6 - $video_strlen *2) / 2;
        }
        $format_videos =  str_repeat(' ',$padding_video)." %current%/%max%".str_repeat(' ',$padding_video)." [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %message%";
        $this->progressBar1->setFormat($format_videos);
        if(count($this->videos) > 0) {
            $this->progressBar1->setMessage($this->videos[0]->getMetadata()->getSceneName());
        }

        $this->progressBar2 = new ProgressBar($section2, 100);
        $percentage_padding = $video_strlen - 3;
        $percentage_padding = $percentage_padding <=0 ? 0 : $percentage_padding;
        
        $format_download = str_repeat(' ',$percentage_padding)." %current%/%max%".str_repeat(' ',$percentage_padding)." [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %message%";

        $this->progressBar2->setFormat($format_download);
        // starts and displays the progress bar
        $this->progressBar1->start();
       // $this->progressBar2->setMessage("Starting");
        $this->progressBar2->start();


    }


    public function AdvancePrimary(Video $video) {
        $this->progressBar1->setMessage($video->getMetadata()->getSceneName());
        $this->progressBar1->advance();
        $this->progressBar2->finish();
        $this->progressBar2->start();
    }

    public function AdvanceDownloadStatus($percentage,$size_download) {
        $this->progressBar2->setMessage("from ". $size_download);
        $this->progressBar2->setProgress($percentage);
    }
}