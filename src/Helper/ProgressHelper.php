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

        $this->progressBar1 = new ProgressBar($section1, count($this->videos));
        $this->progressBar1->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %message%');
        $this->progressBar1->setMessage($this->videos[0]->getMetadata()->getSceneName());
        $this->progressBar2 = new ProgressBar($section2, 100);
        $this->progressBar2->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %message%');
        // starts and displays the progress bar
        $this->progressBar1->start();

        //progress to current status
        $em = EntityManager::get()->getRepository('App\Entity\Video');

        $downloaded_vids = $em->findBy([
            'page' => $this->videos[0]->getPage()->getId(),
            'downloaded_video' => true
        ]);
        $this->progressBar1->advance(count($downloaded_vids));
        $this->progressBar2->setMessage("Starting");
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