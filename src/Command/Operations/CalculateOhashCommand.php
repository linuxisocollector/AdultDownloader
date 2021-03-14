<?php
namespace App\Command\Operations;

use App\Entity\Page;
use App\Entity\Video;
use App\Helper\DirectoryHelper;
use App\Helper\EntityManager;
use App\Helper\LoggerHelper;
use App\Helper\Ohash;
use App\Helper\StashHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class CalculateOhashCommand extends Command {
    protected static $defaultName = 'operations:calculateOhash';
    /** @var \Symfony\Component\Console\Helper\ProgressBar */
    private $progressBar1;
    protected function configure()
    {
        $this
            ->setDescription('Sync Metadata from this Tool to Stasher ')
            ->addUsage('console ../stasher/metadata 1 test/')
            ->addArgument('DownloaderName', InputArgument::REQUIRED, 'Id of the downloader 1 for Hookup 2 for Pervcity')
            ->addArgument('DownloadPath', InputArgument::REQUIRED, 'Path to the root of your downloaded files')

        ;
        
    }

    
    private function initProgressBar($output,$countVideos) {
        $section1 = $output->section();
        $this->progressBar1 = new ProgressBar($section1, $countVideos);
        $format_videos = "%current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %message%";
        $this->progressBar1->setFormat($format_videos);
        $this->progressBar1->start();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        /** @var \Symfony\Component\Console\Output\ConsoleOutput $output */
        LoggerHelper::setIO(new SymfonyStyle($input, $output->section()));

        $download_path = $input->getArgument('DownloadPath');
        new DirectoryHelper($download_path);
        $downloadername = $input->getArgument('DownloaderName');
        $downloadClass = EntityManager::getDownloadClassByName($downloadername);
        if($downloadClass === false) {
            return Command::FAILURE;
        }
        $page = $downloadClass->getPage();
        $em = EntityManager::get();
        $video_repository = $em->getRepository('App\Entity\Video');
        /** @var Video[] */
        $videos_saved = $video_repository->findBy([
            'page' => $page->getId(),
        ]);
        $this->initProgressBar($output,count($videos_saved));
        $this->calculateOhash($videos_saved);
        return Command::SUCCESS;
    }

    /**
     * Undocumented function
     *
     * @param  Video[] $videos
     * @return void
     */
    private function calculateOhash($videos) {
        LoggerHelper::writeToConsole('Calculating OHash for the Videos','info');
        $em = EntityManager::get();
        foreach ($videos as $key => $video) {
            $path = $video->getSavedFilePath();
            if($video->getOpenSubtitlesHash() !== '0000000000000000') {
                continue;
            }
            if(!file_exists($path) && !is_dir($path)) {
                LoggerHelper::writeToConsole("File $path was not found",'warn');
                continue;
            }
            $hash = Ohash::OpenSubtitlesHash($path);
            dump($hash);
            $video->setOpenSubtitlesHash($hash);
            $em->persist($video);
            $this->progressBar1->advance();
        }
        $em->flush();

        LoggerHelper::writeToConsole('Calculated Ohash for all scenes','info');
        $this->progressBar1->finish();
    }




}