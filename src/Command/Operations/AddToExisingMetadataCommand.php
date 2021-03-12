<?php
namespace App\Command\Operations;

use App\Downloaders\Aria2;
use App\Entity\Video;
use App\Helper\DirectoryHelper;
use App\Helper\DownloadHelper;
use App\Helper\EntityManager;
use App\Helper\LoggerHelper;
use App\Helper\ProgressHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class AddToExisingMetadataCommand extends Command {
    protected static $defaultName = 'operations:downloadedtovideos';
    protected function configure()
    {
        $this
            ->setDescription('Add existing File to correct location (inclusive Metadata)')
            ->addUsage('console ../stasher/metadata 1 test/')
            ->addArgument('DownloaderName', InputArgument::REQUIRED, 'Name of the Downloader')
            ->addArgument('VideoPath', InputArgument::REQUIRED, 'Path to the video that you want to add')
            ->addArgument('SceneUrl', InputArgument::REQUIRED, 'Path to the Original Video Url')
            ->addArgument('ExistingDownloadPath', InputArgument::REQUIRED, 'Path to the root of your downloaded files')

        ;
        
    }


    protected function execute(InputInterface $input, OutputInterface $output): int {
        /** @var \Symfony\Component\Console\Output\ConsoleOutput $output */
        LoggerHelper::setIO(new SymfonyStyle($input, $output->section()));
        $downloadername = $input->getArgument('DownloaderName');
        $downloadClass = EntityManager::getDownloadClassByName($downloadername);
        if($downloadClass === false) {
            return Command::FAILURE;
        }
        $downloadClass->loadOrCreatePage();
        $page = $downloadClass->getPage();
        $page_id = $page->getId();
        $VideoPath = $input->getArgument('VideoPath');
        $sceneUrl =  $input->getArgument('SceneUrl');
        if(!file_exists($VideoPath)) {
            LoggerHelper::writeToConsole("The file $VideoPath does not exist",'error');
            return Command::INVALID;
        }
        $extension = explode('.',$VideoPath);
        $extension = end($extension);
      
        $em = EntityManager::get();
        new DirectoryHelper($input->getArgument('ExistingDownloadPath'));
        $video_repository = $em->getRepository('App\Entity\Video');
        $videos = $video_repository->findBy([
            'url' => $sceneUrl,
            ]);
        /** @var Video */
        $video = reset($videos);
        if($video == false) {
            LoggerHelper::writeToConsole('Invalid url','error');
            return Command::FAILURE;
        }
        $metadata = $video->getMetadata();
        $downloadHelper  = $downloadClass->getDownloadImplementation(new DownloadHelper($downloadClass->getBaseUrl()));
        $fileDownloader  = new Aria2(new ProgressHelper([$video],$output));
        $parser = $downloadClass->getMetadataParser();
        $parser->setSave(false);
        $parser->setDownload(false);
        $parser->setPublic(true);
        /** @var Video */
        $video = $parser->parseScenePage($video,$downloadHelper,$fileDownloader);
        
        $video->setFetchedTime(new \DateTime());
        if($video === null) {
            LoggerHelper::writeToConsole("The Scene Url was not found you have to fetch the metadata first",'error');
            return Command::FAILURE;
        }
        //move video
        $video->setDownloadedQualtity(1080);
        $video->setDownloadedVideo(true);
        $video->setDownloadUrl('.'.$extension);
        $filename = $video->getFilename();
        $video->setFileNameSaved($filename);
        $em = EntityManager::get();
        $em->persist($video);
        $em->flush($video);
        if(file_exists($video->getFilePath())) {
            LoggerHelper::writeToConsole('File already Exists '.$video->getFilePath(),'info');
            return Command::FAILURE;
        }
        rename($VideoPath,$video->getFilePath());
        LoggerHelper::writeToConsole('File correctly integrated','success');
        return Command::SUCCESS;
    }

}