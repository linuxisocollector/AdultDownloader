<?php

namespace App\Command\Downloaders;

use App\Command\Options\SkipHandlers\ISkipHandler;
use App\Command\Options\SkipHandlers\ISkipHandlerInProgress;
use App\Downloaders\IBasicAuth;
use App\Downloaders\ICookie;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Helper\DirectoryHelper;
use App\Helper\ProgressHelper;
use App\Entity\Page;
use App\Entity\Video;
use App\Helper\CookieHelper;
use App\Helper\EntityManager;
use DateTime;
use App\Helper\DownloadHelper;
use Exception;
use GuzzleHttp\Psr7\Response;
use App\Helper\LoggerHelper;
use Doctrine\Common\Collections\Expr\Value;
use HaydenPierce\ClassFinder\ClassFinder;
use App\Command\Options\SkipHandlers\SkipException;
use App\Helper\VideoQualityHelper;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Throwable;

abstract class AbstractDownloadCommand extends Command
{
    /** Dont forgett to overwritte this aswell, this is the command name */
    protected static $defaultName = '';

    /** @var App\Entity\Page */
    protected $page;
    
    /** @var App\Helper\DownloadHelper */
    private $downloadHelper;
    protected $basic_auth = false;
    protected $cookie_auth = false;
    /** @var CookieHelper */
    protected $CookieHelper;

    protected $basic_username;
    protected $basic_password;
    
    protected $downloadVideosSetup;
    protected $saveEntities;
    protected $skipOverviewDownload;
    protected $publicMetadata;
    private $in_progress_skipers = [];
    protected $options;

    protected function configure()
    {
        $this
            ->setDescription('Downloader for '.$this->getBaseUrl())
            ->addArgument('path', InputArgument::REQUIRED, 'Path')
        ;
        $this->addOption('skip-list',null,InputOption::VALUE_REQUIRED,'A File with a list of URLs that should be skipped');
        $this->addOption('skip-until',null,InputOption::VALUE_REQUIRED,'Skip all videos till the passed url occures');
        $this->addOption('skip-behind-the-scences','-b',InputOption::VALUE_NONE,'Skip all behind the scenes videos');
        $this->addOption('ignore-download-status',null,InputOption::VALUE_NONE,'Ignore the downloaded status and redownload every video');
        $this->addOption('del-cache',null,InputOption::VALUE_NONE,'Deletes the whole Overview.html cache before fetching');
        $this->addOption('limit-page',null,InputArgument::REQUIRED,'Limits the overview pages to grab ex 1-3');
        $this->addOption('single-url',null,InputOption::VALUE_REQUIRED,'Url of a single Scene to download');
        $this->addOption('max-bts-quality',null,InputOption::VALUE_REQUIRED,'A Numerice maximal Height of a BTS Scene to Download (Default: 720)');
        $this->addOption('max-scene-quality',null,InputOption::VALUE_REQUIRED,'A Numerice maximal Height for a Scene to Download (Default: 1080)');
        $this->addOption('no-download','-d',InputOption::VALUE_NONE,'Dry Run without Downloading any files (Metadata Only)');
        $this->addOption('no-save',null,InputOption::VALUE_NONE,"Don't save fetched Metadata to Database");
        $this->addOption('no-fetch-overview',null,InputOption::VALUE_NONE,"Don't Fetch Overview Pages (assume no new Videos)");

        $this->addOption('public','-p',InputOption::VALUE_NONE,'Use Public Url to get Metadata when "no-download" is active');
        $this->addAdditonalArguments();
    }

    protected function requireCookieFile() {
        $this->cookie_auth = true;
        $this->addArgument('cookie', InputArgument::REQUIRED, 'Path to Netscape Cookie File (Firefox)');
    }

    protected function requireBasicAuth() {
        $this->basic_auth = true;
        $this->addArgument('username',InputArgument::REQUIRED,'Username for Basic Auth');
        $this->addArgument('password',InputArgument::REQUIRED,'Password for Basic Auth');        
    }
    /**
     * Add additonal Console arguments through this function 
     * @see https://symfony.com/doc/current/console/input.html#using-command-arguments
     * @return void
     */
    protected abstract function addAdditonalArguments();

    public static abstract function getPageName();
    /**
     * Used as PK for Database stuff just enter a id that is not used
     *
     * @return int
     */
    public abstract function getPageId();

    /**
     * Returns the Base Url for the page you want to grab "https://example.com"
     *
     * @return string
     */
    public abstract function getBaseUrl();

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
     * @return array
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
    protected abstract function lastPageReached(Response $html,$page_num);



    /**
     * Get the constructed download Client at the Moment only Aria2 is implemented.
     * HLS Streams and similar ar not yet implemented
     * @param ProgressHelper $progressHelper
     * @return AbstractDownloader
     */
    protected abstract function loadFileDownloader(ProgressHelper $progressHelper);

    /**
     * Return your customer scraper through this function. Instance of AbstractHTMLParser class
     *
     * @return AbstractHTMLParser
     */
    public abstract function getMetadataParser();


    public abstract function setPublicMetadata(bool $status);
    /**
     * REST SHOULD NOT BE CHANGED WHEN IMPLEMENTING A NEW PAGE
     */
    
     /**
     * Undocumented function
     *
     * @param Video[] $videos
     * @return Video[]
     */
     protected function deduplicate($videos) {
      $compArr = [];
      $videosOut = [];
      foreach ($videos as $key => $video) {
          $videosOut[$video->getUrl()] = $video;
      }
      return array_values($videosOut);
     }


    /**
     * Fetches all the Videos from the Overview page. (Or loads the entries from the db)
     *
     * @return Video[]
     */
    protected function getVideos() {
        LoggerHelper::writeToConsole("Starting to fetch overview Pages",'info');
        $client = $this->downloadHelper->getClient();
        $bodies = [];
        foreach ($this->getVideoPath() as $studio => $videoPath) {
            $page_num = $this->getFirstPage();
            while(true) {
                $url = str_replace('{num}',$page_num,$videoPath);
                $body = DirectoryHelper::getCached($url);
                if($body === false) {
                    if($this->skipOverviewDownload) {
                        LoggerHelper::writeToConsole("Didn't download Overview Page",'info');
                        break;
                    }
                    try {
                        $res = $client->request('GET',$url,[]);
                        $body = $res->getBody();
                        
                    
                        //save to cache
                        file_put_contents(DirectoryHelper::getRealPath('cache').md5($url),$body);
                        $this->lastPageReached($res,$page_num);
    
                        LoggerHelper::writeToConsole("Downloaded Overview Page: $studio $page_num",'info');
                        
                        //echo "Downloaded Overview Page: $page_num\n";
                    } catch(Exception $ex) {
                        LoggerHelper::writeToConsole("Possibly reached last page Pages: $studio $page_num",'info');
                        break;
                    }
                    sleep(2);
                }
                $page_num++;
                $bodies[$url] = [
                    'body' => $body,
                    'studio' => $studio
                ];
            }

        }
        LoggerHelper::writeToConsole("Finished Downloading Overview Pages, Parsing Metadata now",'info');
        $metadata_parser = $this->getMetadataParser();
        $videos = [];
        foreach ($bodies as $url => $response) {
            $videos  = array_merge($videos, $metadata_parser->ParsePage($response['body'],$url,$response['studio']));
        }
        $videos = $this->deduplicate($videos);

        $em = EntityManager::get();
        $video_repository = $em->getRepository('App\Entity\Video');
        /** @var Video[] */
        $existing_vids = $video_repository->findBy([
            'page' => $this->page->getId(),
        ]);
        //remove objects allready in db
        $new_vids = 0;
        foreach ($videos as $url => $video) {
            $videoUrl = $video->getUrl();
            foreach ($existing_vids as $url => $existing_vid) {
                if($existing_vid->getUrl() == $videoUrl) {
                    //to prevent overwritte from detail
                    $existing_vid->setMetadata($existing_vid->getMetadata()->combineMetadata($video->getMetadata()));
                    $em->persist($existing_vid);
                    $em->flush($existing_vid);
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
        $videos_saved = $this->filterVideos($videos_saved,$this->options);
        $video_count = count($videos_saved);
        LoggerHelper::writeToConsole("Found $video_count from which $new_vids are new",'info');
        return $videos_saved;
    }

    public function getDownloadImplementation($class) {
        if($this->cookie_auth === true) {
            if(!($class instanceof ICookie)) {
                LoggerHelper::writeToConsole('The Class  does not implement the Cookie interface','error');
            }
            $class->setCookies($this->CookieHelper);
        }
        if($this->basic_auth === true) {
            if(!($class instanceof IBasicAuth)) {
                LoggerHelper::writeToConsole('The Class  does not support BasicAuth','error');
            }
            $class->setBasicAuth($this->basic_username,$this->basic_password);
        } 

        return $class;
    }
    public function loadOrCreatePage() {
        $em = EntityManager::get();
        $this->page = $em->find('App\Entity\Page',$this->getPageId());
        if($this->page == null) {
            $this->page = new Page();
            $this->page->setId($this->getPageId());
            $this->page->setName(static::getPageName());
            $this->page->setUpdated(new DateTime());
            $em->persist($this->page);
            $em->flush($this->page);
        }
    } 

    protected function setUpAdditionaParameters($input) {
        if($this->basic_auth === true) {
            $this->basic_username = $input->getArgument('username');
            $this->basic_password = $input->getArgument('password');    
        }

        if($this->cookie_auth === true) {
            $cookie_file_path = $input->getArgument('cookie');
            $this->CookieHelper = new CookieHelper($cookie_file_path,$this->getBaseUrl());
        }
        
        
    }

    protected function downloadVideos($output,$videos) {
        $progresshelper = new ProgressHelper($videos,$output);
        $parser = $this->getMetadataParser();
        /** @var \App\Downloaders\AbstractDownloader */
        $downloader = $this->getDownloadImplementation($this->loadFileDownloader($progresshelper));
        foreach ($videos as $key => $video) {
            $next_video = null;
            if(array_key_exists($key+1,$videos)) {
                $next_video = $videos[$key+1];
            }
            try {
                /** @var \App\Entity\Video */
                $video = $parser->parseScenePage($video,$this->downloadHelper,$downloader);

                foreach ($this->in_progress_skipers as $key => $handler) {
                    if($handler->doesHandle()) {
                        $handler->handle_in_progress($video);
                    }
                }
                $client = $this->downloadHelper->getClient();
                $client->request('GET',$video->getMetadata()->getThumbnailUrl(),[
                    'sink' => DirectoryHelper::getRealPath('metadata').$video->getId().".jpg",
                ]);
                LoggerHelper::writeToConsole('Fetched Scene Metadata','info');
                $dl_url = $video->getDownloadUrl();
                if($this->downloadVideosSetup) {
                    if(!(str_starts_with($dl_url,'http://') || str_starts_with($dl_url,'https://'))) {
                        $dl_url = $this->getBaseUrl()  .$dl_url;
                        $video->setDownloadUrl($dl_url);
                    }
                    $downloader->downloadFile(
                        $dl_url,
                        DirectoryHelper::getRealPath('videos'),
                        $video->getFilename()
                    );
                    LoggerHelper::writeToConsole('Download of Scene '.$video->getFilename()." Finished",'info');
                    $video->setFileNameSaved($video->getFilename());
                    $video->setDownloadedVideo(true);  
                }
                if($this->saveEntities) {
                    $em = EntityManager::get();
                    $em->persist($video);
                    $em->flush($video);
                }

            } catch(SkipException $ex) {
                if($this->saveEntities) {
                    $em = EntityManager::get();
                    $em->persist($video);
                    $em->flush($video);
                }
                LoggerHelper::writeToConsole('Download of Scene '.$video->getFilename()." was skipped because of ".$ex->getMessage(),'info');

            } catch(Exception $ex) {
                LoggerHelper::writeToConsole('Download of Scene '.$video->getFilename()." failed ".$ex->getMessage(),'error');
            }
            if($next_video !== null) {
                $progresshelper->AdvancePrimary($next_video);
                sleep(2);
            } else {
                LoggerHelper::writeToConsole('Fetched all Scenes','info');
                $progresshelper->AdvancePrimary($video);
            }
        }
    }
    /**
     * Filters videos through the command options
     * @param Video[] $videos
     * @param InputInterface $input
     * @return Video[]
     */
    private function filterVideos($videos,$options) {
        /** @var ISkipHandler[] */
        $classes = ClassFinder::getClassesInNamespace('App\Command\Options\SkipHandlers');
        $commandClasses = [];
        $original_count = count($videos);
        foreach ($classes as $key => $class) {
            $interfaces = class_implements($class);
            if(array_key_exists('App\Command\Options\SkipHandlers\ISkipHandler',$interfaces)) {
                $commandClasses[$class::getCommandName()] = $class;
            }
        }
        foreach ($options as $key => $option) {
            if($option === null) {
                continue;
            }

            if(array_key_exists($key,$commandClasses)) {
                /** @var ISkipHandler */
                $handler = new $commandClasses[$key]($videos,$option);
                if($handler->doesHandle()) {
                    $preCount = count($videos);
                    $videos = $handler->action();
                    $diffCount = $preCount - count($videos);
                    LoggerHelper::writeToConsole("$key skipped $diffCount Videos",'info');
                }
                if($handler instanceof ISkipHandlerInProgress) {
                    $this->in_progress_skipers[] = $handler;
                }
            }
        }
        return $videos;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        /** @var \Symfony\Component\Console\Output\ConsoleOutput $output */
        
        LoggerHelper::setIO(new SymfonyStyle($input, $output->section()));
        $path = $input->getArgument('path');
        $this->options = $input->getOptions();
        $this->loadOrCreatePage();
        $this->saveEntities = !$input->getOption('no-save');
        $this->downloadVideosSetup = !$input->getOption('no-download');
        $this->skipOverviewDownload = $input->getOption('no-fetch-overview');
        if($input->getOption('public')) {
            if($this->downloadVideosSetup) {
                LoggerHelper::writeToConsole("You can't fetch Public metadata and download try the option --no-download",'error');
                return Command::INVALID;
            }
            $this->cookie_auth = false;
            $this->basic_auth = false;
            $this->publicMetadata = true;
            $this->setPublicMetadata(true);
        }
        $this->setUpAdditionaParameters($input);
        $directoryHelper = new DirectoryHelper($path);
        try {
            if($input->getOption('max-bts-quality')) {
                VideoQualityHelper::setBehindeTheScenesQuality($input->getOption('max-bts-quality'));
            }
            if($input->getOption('max-scene-quality')) {
                VideoQualityHelper::setBehindeTheScenesQuality($input->getOption('max-bts-quality'));
            }
        } catch(Throwable $ex) {
            LoggerHelper::writeToConsole($ex->getMessage(),'error');
            return Command::INVALID;
        }

        if($input->getOption('del-cache')) {
            $questionHelper = $this->getHelper('question');
            $question = new ConfirmationQuestion('All files in the path '.DirectoryHelper::getRealPath('cache').". Continue?",true);
            if(!$questionHelper->ask($input,$output,$question)) {
                return Command::FAILURE;
            }
            $directoryHelper->deleteFromPath(DirectoryHelper::getRealPath('cache'));
        }

        $directoryHelper->setupFolder();

        /** @var DownloadHelper */
        $this->downloadHelper  = $this->getDownloadImplementation(new DownloadHelper($this->getBaseUrl()));
        
        $videos = $this->getVideos();
        if(count($videos) == 0) {
            LoggerHelper::writeToConsole('Nothing to download','info');
            return Command::SUCCESS;
        }
        $this->downloadVideos($output,$videos);
        return Command::SUCCESS;
    }

    /**
     * Get the value of page
     */
    public function getPage()
    {
        return $this->page;
    }

}


