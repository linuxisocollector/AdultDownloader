<?php
namespace App\Command;

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
    protected static $defaultName = 'sync:stash';
    protected function configure()
    {
        $this
            ->setDescription('Sync Metadata from this Tool to Stasher ')
            ->addUsage('console ../stasher/metadata 1 test/')
            ->addArgument('MetaPath', InputArgument::REQUIRED, 'Path to the exproted metadata')
            ->addArgument('DownloaderID', InputArgument::REQUIRED, 'Id of the downloader 1 for Hookup 2 for Pervcity')
            ->addArgument('DownloadPath', InputArgument::REQUIRED, 'Path to the root of your downloaded files')

        ;
        
    }


    protected function execute(InputInterface $input, OutputInterface $output): int {
        /** @var \Symfony\Component\Console\Output\ConsoleOutput $output */
        LoggerHelper::setIO(new SymfonyStyle($input, $output->section()));
        
        $MetaPath = $input->getArgument('MetaPath');
        $download_path = $input->getArgument('DownloadPath');
        $directoryHelper = new DirectoryHelper($download_path);
        $downloader_id = $input->getArgument('DownloaderID');
        $em = EntityManager::get();
        $video_repository = $em->getRepository('App\Entity\Video');
        /** @var Video[] */
        $videos_saved = $video_repository->findBy([
            'page' => $downloader_id,
        ]);
        
        $stash = new StashHelper($MetaPath,DirectoryHelper::getRealPath('metadata'),$videos_saved);
      
        return Command::SUCCESS;
    }

}