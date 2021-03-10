<?php
namespace App\Command;

use App\Downloaders\AbstractDownloader;
use App\Downloaders\Aria2;
use App\Entity\Page;
use App\Entity\Video;
use App\Helper\DirectoryHelper;
use App\Helper\DownloadHelper;
use App\Helper\EntityManager;
use App\Helper\LoggerHelper;
use App\Helper\ProgressHelper;
use App\Helper\StashHelper;
use App\Parser\HookupHotshot;
use Exception;
use HaydenPierce\ClassFinder\ClassFinder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class RenameBySchemaCommand extends Command {
    protected static $defaultName = 'operations:rename';
    protected function configure()
    {
        $this
            ->setDescription('Rename Library after a new Schema')
            ->addUsage('console ../stasher/metadata 1 test/')
            ->addArgument('DownloaderName', InputArgument::REQUIRED, 'Name of the Downloader')
            ->addArgument('ExistingDownloadPath', InputArgument::REQUIRED, 'Path to the root of your downloaded files')

        ;
        
    }


    protected function execute(InputInterface $input, OutputInterface $output): int {
        /** @var \Symfony\Component\Console\Output\ConsoleOutput $output */
        LoggerHelper::setIO(new SymfonyStyle($input, $output->section()));
        $classes = ClassFinder::getClassesInNamespace('App\Command');
        $download_classes = [];
        foreach ($classes as $key => $class) {
            //for some resason class_implements doesnt work here
            try { 
                $download_classes[$class::getPageName()] = $class;
            } catch(\Throwable $ex) {

            }
        }
        $downloadername = $input->getArgument('DownloaderName');
        if(!array_key_exists($downloadername,$download_classes)) {
            $sites = implode(', ',array_keys($download_classes));
            LoggerHelper::writeToConsole("$downloadername is not a valid page name use one of this options: $sites",'error');
            return Command::INVALID;
        }
        
        /** @var AbstractDownloadCommand */
        $download_class = new $download_classes[$downloadername]();
        $download_class->loadOrCreatePage();
        $page = $download_class->getPage();
        $page_id = $page->getId();

        $em = EntityManager::get();
        new DirectoryHelper($input->getArgument('ExistingDownloadPath'));
        $video_repository = $em->getRepository('App\Entity\Video');
        /** @var Video[] */
        $videos = $video_repository->findBy([
            'page' => $page->getId(),
            'downloaded_video' => 1
            ]);
        
        //move video
        $em = EntityManager::get();
        foreach ($videos as $key => $video) {
            $filenameOld = $video->getFileNameSaved();
            $extension = explode('.',$filenameOld);
            $extension = end($extension);
            $video->setDownloadUrl('.'.$extension);
            if(!file_exists($video->getSavedFilePath())) {
                LoggerHelper::writeToConsole("The file $filenameOld was not found, aborting",'error');
                return Command::FAILURE;
            }
            $filenameNew = $video->getFilename();
            if($filenameNew === $filenameOld) {
                LoggerHelper::writeToConsole('Skipped, new name is the same '.$video->getFilename(),'info');

                continue;
            }
            if(rename($video->getSavedFilePath(),$video->getFilePath())) {
                LoggerHelper::writeToConsole('Renamed: '.$video->getFileNameSaved()." => ".$video->getFilename(),'info');
                $video->setFileNameSaved($filenameNew);
                $em->persist($video);
            } else {
                LoggerHelper::writeToConsole('Error while renaming '.$video->getFilename(),'error');
            }


        }

        $em->flush();
        LoggerHelper::writeToConsole('File correctly integrated','success');
        return Command::SUCCESS;
    }

}