<?php
namespace App\Command\Operations;

use App\Entity\Page;
use App\Helper\DirectoryHelper;
use App\Helper\EntityManager;
use App\Helper\LoggerHelper;
use App\Helper\StashHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class SyncStashMetadataCommand extends Command {
    protected static $defaultName = 'operations:syncstash';
    protected function configure()
    {
        $this
            ->setDescription('Sync Metadata from this Tool to Stasher ')
            ->addUsage('console ../stasher/metadata 1 test/')
            ->addArgument('StashUrl', InputArgument::REQUIRED, 'Url to the Stash Instance e.x http://localhost:9999/')
            ->addArgument('DownloaderName', InputArgument::REQUIRED, 'Id of the downloader 1 for Hookup 2 for Pervcity')
            ->addArgument('DownloadPath', InputArgument::REQUIRED, 'Path to the root of your downloaded files')

        ;
        
    }
    protected function execute(InputInterface $input, OutputInterface $output): int {
        /** @var \Symfony\Component\Console\Output\ConsoleOutput $output */
        LoggerHelper::setIO(new SymfonyStyle($input, $output->section()));
        $StashUrl = $input->getArgument('StashUrl');

        $download_path = $input->getArgument('DownloadPath');
        new DirectoryHelper($download_path);
        $downloadername = $input->getArgument('DownloaderName');
        $downloadClass = EntityManager::getDownloadClassByName($downloadername);
        if($downloadClass === false) {
            return Command::FAILURE;
        }
        $downloadClass->loadOrCreatePage();
        $page = $downloadClass->getPage();
        $em = EntityManager::get();
        $video_repository = $em->getRepository('App\Entity\Video');
        /** @var Video[] */
        $videos_saved = $video_repository->findBy([
            'page' => $page->getId(),
        ]);
        
        $stash = new StashHelper($StashUrl,$videos_saved);
        $stash->calculateOhash();
        $stash->updateMetadata();
        return Command::SUCCESS;
    }



}