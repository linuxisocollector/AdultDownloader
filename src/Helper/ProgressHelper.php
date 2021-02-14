<?php
namespace App\Helper;

use App\Entity\Video;
use Symfony\Component\Console\Helper\ProgressBar;

class ProgressHelper {

    private $videos;
    private $progressBar1;
    private $progressBar2;
    private $io;

    public function __construct($videos,$output,$io)
    {
        $this->videos = $videos;
        $this->io = $io;
        $section1 = $output->section();
        $section2 = $output->section();
       

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
    }

    public function AdvanceDownloadStatus($percentage,$size_download) {
        $this->progressBar2->setMessage("from ". $size_download);
        $this->progressBar2->setProgress($percentage);

    }
}