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
use GuzzleHttp\Psr7\Response;
use LoggerHelper;
use Psr\Log\LoggerInterface;

abstract class AbstractDownloadCommand extends Command
{
    /** Dont forgett to overwritte this aswell, this is the command name */
    protected static $defaultName = '';

    /** @var App\Entity\Page */
    protected $page;
    /** @var App\Helper\DirectoryHelper; */
    protected $directoryHelper;
    /** @var App\Helper\DownloadHelper */
    private $downloadHelper;
    
    protected function configure()
    {
        $this
            ->setDescription('Downloader for '.$this->getBaseUrl())
            ->addArgument('path', InputArgument::REQUIRED, 'Path')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
        
    }

    /**
     * Used as PK for Database stuff just enter a id that is not used
     *
     * @return int
     */
    protected abstract function getPageId();

    /**
     * Returns the Base Url for the page you want to grab "https://example.com"
     *
     * @return string
     */
    protected abstract function getBaseUrl();

    /**
     * Which is the first page does the scene page start with 0 or 1?
     *
     * @return int
     */
    protected abstract function getFirstPage();

    /**
     * Should return a string with the variable num in it e.x "/scenes/page/{num}/"
     * Num will be repalced with current page
     *
     * @return string
     */
    protected abstract function getVideoPath();


    /**
     * A logic that determines if a return page has videos on it or is a 404
     * This is only needed if the page to scrub doesn't return 404 on pages that it doesnt find
     * Throw an exception if we reached the last page
     * @param String $html
     * @return void
     * @throws Exception
     */
    protected abstract function lastPageReached(Response $html);



    /**
     * Get the constructed download Client at the Moment only Aria2 is implemented.
     * HLS Streams and similar ar not yet implemented
     * @param ProgressHelper $progressHelper
     * @return AbstractDownloader
     */
    protected abstract function getVideoDownloadClient(ProgressHelper $progressHelper);

    /**
     * Return your customer scraper through this function. Instance of AbstractHTMLParser class
     *
     * @return AbstractHTMLParser
     */
    protected abstract function getOverviewParser();

    /**
     * REST SHOULD NOT BE CHANGED WHEN IMPLEMENTING A NEW PAGE
     */
    
    /**
     * Returns html from cache
     *
     * @param [type] $url
     * @return void
     */
    protected function getCached($url) {
        $filepath  = $this->directoryHelper->getRealPath('cache').md5($url);
        if(is_file($filepath)) {
            return file_get_contents($filepath);
        }
        return false;
    }



    /**
     * Fetches all the Videos from the Overview page. (Or loads the entries from the db)
     *
     * @return Video[]
     */
    protected function getVideos() {
        $client = $this->downloadHelper->getClient();
        $page_num = $this->getFirstPage();
        $video_num = 0;
        $bodies = [];
        while(true) {
            $url = str_replace('{num}',$page_num,$this->getVideoPath());
            $page_num++;
            $body = $this->getCached($url);
            if($body === false) {
                try {
                    $res = $client->request('GET',$url);
                    $this->lastPageReached($res);
                    $body = $res->getBody();
                    //save to cache
                    file_put_contents($this->directoryHelper->getRealPath('cache').md5($url),$body);
                    LoggerHelper::writeToConsole("Downloaded Overview Page: $page_num",'info');
                    
                    //echo "Downloaded Overview Page: $page_num\n";
                } catch(Exception $ex) {
                    LoggerHelper::writeToConsole("Possibly reached last page Pages: $page_num",'info');
                    break;
                }
                sleep(2);
            }
            $bodies[$url] = $body;
        }
        LoggerHelper::writeToConsole("Finished Downloading Overview Pages, Parsing Metadata now",'info');
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
        LoggerHelper::writeToConsole("Found $video_count from which $new_vids are new",'info');
        return $videos_saved;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int {
        LoggerHelper::setIO(new SymfonyStyle($input, $output));
        $path = $input->getArgument('path');
        $this->directoryHelper = new DirectoryHelper($path);
        $this->directoryHelper->setup_folder();
        $em = EntityManager::get();

        $this->page = $em->find('App\Entity\Page',$this->getPageId());
        if($this->page == null) {
            $this->page = new Page();
            $this->page->setId($this->getPageId());
            $this->page->setName('HookupHotshot');
            $this->page->setUpdated(new DateTime());
            $em->persist($this->page);
            $em->flush($this->page);
        }
        $this->downloadHelper  = new DownloadHelper($this->getBaseUrl());
        $videos = $this->getVideos();
        $progresshelper = new ProgressHelper($videos,$output);
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
                LoggerHelper::writeToConsole('Fetched Scene Metadata','info');
                $downloader->downloadFile(
                    $video->getDownloadUrl(),
                    $this->directoryHelper->getRealPath('videos'),
                    $video->getFilename()
                );
                LoggerHelper::writeToConsole('Download of Scene'.$video->getFilename()."Finished",'info');
                $video->setDownloadedVideo(true);
                $em = EntityManager::get();
                $em->persist($video);
                $em->flush($video);
            } catch(Exception $ex) {
                LoggerHelper::writeToConsole('Download of Scene'.$video->getFilename()."Finished",'error');
            }
       
            $progresshelper->AdvancePrimary($video);

            sleep(2);
        }

        return Command::SUCCESS;
    }
}


