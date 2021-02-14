<?php

namespace App\Command;

use App\Downloaders\Aria2;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Exceptions\InvalidChannelsException;
use App\Exceptions\VideoExceptionInterface;
use App\Helper\DirectoryHelper;
use App\Helper\ProgressHelper;
use App\Entity\Page;
use App\Entity\Video;
use App\Helper\EntityManager;
use DateTime;
use App\Helper\DownloadHelper;
use App\Parser\HookupHotshot;
use Exception;
use Psr\Log\LoggerInterface;

class DownloadHookupHotShotCommand extends Command
{
    protected static $defaultName = 'download:hookuphotshot';

    protected $page_id = 1;
    protected $first_page = 0;
    protected $base_url = 'https://hookuphotshot.com/';
    protected $video_path = '/the-dates/page/{num}/';
    /** @var App\Helper\DirectoryHelper; */
    protected $directoryHelper;
    /** @var \Symfony\Component\Console\Style\SymfonyStyle */
    protected $io;
    /** @var App\Helper\DownloadHelper */
    private $downloadHelper;
    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('path', InputArgument::REQUIRED, 'Path')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
        
    }


    private function lastPageReached($res) {
        if(str_contains($res->getBody(),'Sorry... there are no more dates. Click ')) {
            throw new Exception('Reached end');
        }
    }

    private function getCached($url) {
        $filepath  = $this->directoryHelper->getRealPath('cache').md5($url);
        if(is_file($filepath)) {
            return file_get_contents($filepath);
        }
        return false;
    }

    private function getOverviewParser() {
        return new HookupHotshot();
    }

    /**
     * Undocumented function
     *
     * @return Video[]
     */
    private function getVideos() {
        $client = $this->downloadHelper->getClient();
        $page_num = $this->first_page;
        $video_num = 0;
        $bodies = [];
        while(true) {
            $url = str_replace('{num}',$page_num,$this->video_path);
            $page_num++;
            $body = $this->getCached($url);
            if($body === false) {
                try {
                    $res = $client->request('GET',$url);
                    $this->lastPageReached($res);
                    $body = $res->getBody();
                    //save to cache
                    file_put_contents($this->directoryHelper->getRealPath('cache').md5($url),$body);
                    $this->io->note("Downloaded Overview Page: $page_num");
                } catch(Exception $ex) {
                    $this->io->note("Possibly reached last page Pages: $page_num");
                    break;
                }
                sleep(2);
            }
            $bodies[$url] = $body;
        }
        $this->io->note("Finished Downloading Overview Pages, Parsing Metadata now");
        $metadata_parser = $this->getOverviewParser();
        $videos = [];
        foreach ($bodies as $key => $html) {
            $videos  = array_merge($videos, $metadata_parser->ParsePage($html,$key));
        }
        $em = EntityManager::get();
        $video_repository = $em->getRepository('App\Entity\Video');
        /** @var Video[] */
        $existing_vids = $video_repository->findBy([
            'page' => $this->page->getId(),
        ]);
        //remove objects allready in db
        $new_vids = 0;
        foreach ($videos as $key => $video) {
            $videoUrl = $video->getUrl();
            foreach ($existing_vids as $key => $existing_vid) {
                if($existing_vid->getUrl() == $videoUrl) {
                    continue 2;
                }
            }
            $new_vids++;
            //persists to db
            $video->setPage($this->page);
            $em->persist($video);
            $em->flush($video);
        }
        $videos_saved = $video_repository->findBy([
            'page' => $this->page->getId(),
        ]);
        $video_count = count($videos_saved);
        $this->io->note("Found $video_count from which $new_vids are new");
        return $videos_saved;
    }


    protected function getVideoDownloadClient(ProgressHelper $progressHelper) {
        $download = new Aria2($progressHelper);
        return $download;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int {
        $this->io = new SymfonyStyle($input, $output->section());
        $path = $input->getArgument('path');
        $this->directoryHelper = new DirectoryHelper($path);
        $this->directoryHelper->setup_folder();
        $em = EntityManager::get();

        $this->page = $em->find('App\Entity\Page',$this->page_id);
        if($this->page == null) {
            $this->page = new Page();
            $this->page->setId($this->page_id);
            $this->page->setName('HookupHotshot');
            $this->page->setUpdated(new DateTime());
            $em->persist($this->page);
            $em->flush($this->page);
        }
        $this->downloadHelper  = new DownloadHelper($this->base_url);
        $videos = $this->getVideos();
        $progresshelper = new ProgressHelper($videos,$output,$this->io);
        $parser = $this->getOverviewParser(); 
        $downloader = $this->getVideoDownloadClient($progresshelper);
        foreach ($videos as $key => $video) {
            if($video->getDownloadedVideo() === true) {
                $progresshelper->AdvancePrimary($video);
                continue;
            }
            try {
                $video = $parser->parseScenePage($video,$this->downloadHelper);
                $client = $this->downloadHelper->getClient();
                $client->request('GET',$video->getMetadata()->getThumbnailUrl(),[
                    'sink' => $this->directoryHelper->getRealPath('metadata').$video->getId().".jpg"
                ]);
                $this->io->info('Fetched Scene Metadata');
                $downloader->downloadFile(
                    $video->getDownloadUrl(),
                    $this->directoryHelper->getRealPath('videos'),
                    $video->getFilename()
                );
                $this->io->info('Download of Scene'.$video->getFilename()."Finished");
                $video->setDownloadedVideo(true);
                $em = EntityManager::get();
                $em->persist($video);
                $em->flush($video);
            } catch(Exception $ex) {
                $this->io->error($ex->getMessage(). "VKey: ".$key. " ".$video->getMetadata()->getSceneName());
            }
       
            $progresshelper->AdvancePrimary($video);

            sleep(2);
        }

        return Command::SUCCESS;
    }
}


