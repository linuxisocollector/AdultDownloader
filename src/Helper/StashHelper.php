<?php
namespace App\Helper;

use App\Entity\MetadataObject;
use Exception;
use App\Entity\Video;
use GraphQL\Client;
use GraphQL\Mutation;
use GraphQL\RawObject;
use GraphQL\SchemaObject\RootAllTagsSlimArgumentsObject;
use GraphQL\SchemaObject\RootFindSceneByHashArgumentsObject;
use GraphQL\SchemaObject\RootQueryObject;
use GraphQL\SchemaObject\RootScrapePerformerArgumentsObject;
use GraphQL\SchemaObject\SceneHashInputInputObject;
use GraphQL\SchemaObject\ScrapedPerformerInputInputObject;
use GraphQL\SchemaObject\ScrapedPerformerQueryObject;
use GraphQL\SchemaObject\ScraperPerformerArgumentsObject;
use GraphQL\SchemaObject\ScraperSpecQueryObject;
use GraphQL\Variable;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Finder\Finder;

class StashHelper {
    /** @var Client */
    private $client;
    /** @var Video[] */
    private $videos;
    private $tags = [];
    private $performers = [];
    /** @var \Symfony\Component\Console\Helper\ProgressBar */
    private $progressBar1;

    private $performerScrapers = [];
    /**
     * Undocumented function
     *
     * @param String $stashUrl
     * @param Video[] $videos
     * @param [type] $output
     */
    public function __construct($stashUrl,$videos,$output)
    {
        $this->initializeGraphQL($stashUrl);
        foreach ($videos as $key => $video) {
            
            if($video->getDownloadedVideo()) {
                if($video->getOpenSubtitlesHash() === null) {
                    throw new Exception('Not all Videos have a hash run operations:calculateOhash first');
                }
                $this->videos[$video->getOpenSubtitlesHash()] = $video;
            }
        }
        $this->initProgressBar($output,count($videos));
        LoggerHelper::writeToConsole('Loading Values from StashDB','info');
        $this->loadStashTags();
        $this->loadStashPerformers();
        $this->loadPerformerScrapers();
    }

    private function initProgressBar($output,$countVideos) {
        $section1 = $output->section();
        $this->progressBar1 = new ProgressBar($section1, $countVideos);
        $format_videos = "%current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %message%";
        $this->progressBar1->setFormat($format_videos);
        $this->progressBar1->start();
    }


    private function loadPerformerScrapers() {
        $rootObject  = new RootQueryObject();
        $rootObject
            ->selectListPerformerScrapers()
            ->selectId()
            ->selectName()
            ->selectPerformer();
        $results = $this->client->runQuery($rootObject->getQuery(),true)->getResults();
        $preferd = [
            "Babepedia",
            "FreeonesCommunity",
            "ThePornDB",
            "Iafd",
            // "Brazzers", 
            // "ManyVids",
            "TheNude",
            //"Xslist", deactivated till i got to implement jav
        ];
        foreach ($results['data']['listPerformerScrapers'] as $key => $value) {
            //doesn't support images skip
            if($value['id'] == 'builtin_freeones') {
                continue;
            }
            if(!in_array('NAME',$value['performer']['supported_scrapes'])) {
                continue;
            }
            $key = array_search($value['id'],$preferd);
            if($key === false) {
                continue;
            }
            $this->performerScrapers[$key] = $value;
        }
        ksort($this->performerScrapers);
    }
    private function createPerformer($performer) {
        $query = '
            mutation performerCreate($input:PerformerCreateInput!) {
              performerCreate(input: $input){
                id 
              }
            }';
        //remove empty fields from variable from Performer Array
        foreach ($performer as $key => &$value) {
            if($value === null) {
                unset($performer[$key]);
            }
            if($key === 'gender') {
                $value =strtoupper($value);
                if(!in_array($value,[
                    'MALE',
                    'FEMALE',
                    'TRANSGENDER_MALE',
                    'TRANSGENDER_FEMALE',
                    'INTERSEX',
                    'NON_BINARY'
                ])) {
                    LoggerHelper::writeToConsole('Invalid Gender "'.$value.'"for Performer '.$performer['name']."",'error');
                    unset($performer[$key]);
                }
            }
        }
        $result = $this->client->runRawQuery(
            $query,
            true,
            ['input' => $performer]
        )->getResults();

        $performerNames = [$performer['name']];
        if(array_key_exists('aliases',$performer)) {
            $performerNames = array_merge($performerNames,explode(' / ',$performer['aliases']));
        }
        LoggerHelper::writeToConsole("New Performer Created: ".$performer['name'],'info');
        $this->performers[$result['data']['performerCreate']['id']] = $performerNames;
        return $result['data']['performerCreate']['id'];
    }
    private function scrapePerformer($performerName) {
        $performerListResult = null;
        $foundOnScraper = null;
        foreach ($this->performerScrapers as $key => $performerScraper) {
            $query = 'query scrapePerformerList($scraper_id: ID!, $performer: String!) {
                scrapePerformerList(scraper_id: $scraper_id, query: $performer) {
                  name
                  url
                  gender
                  twitter
                  instagram
                  birthdate
                  ethnicity
                  country
                  eye_color
                  height
                  measurements
                  fake_tits
                  career_length
                  tattoos
                  piercings
                  aliases
                  image
                  }
              }';
              $result = $this->client->runRawQuery($query,true,[
                  'scraper_id' => $performerScraper['id'],
                  'performer' => $performerName
              ])->getResults();
              foreach ($result['data']['scrapePerformerList'] as $key => $scrapedPerformer) {
                if(strtolower($scrapedPerformer['name']) === strtolower($performerName)) {
                    $performerListResult = $scrapedPerformer;
                    $foundOnScraper = $performerScraper['id'];
                    break 2;
                }
              }
        }
        if($performerListResult == null) {
            LoggerHelper::writeToConsole("Coudln't Scrap Performer $performerName, because it wasn't found",'error');
            return false;
        }

        //scrape from Detail Search
        $performerDetailQuery = 'query scrapePerformer($scraper_id: ID!, $performer: ScrapedPerformerInput!) {
            scrapePerformer(scraper_id: $scraper_id, scraped_performer: $performer) {
              name
              url
              gender
              twitter
              instagram
              birthdate
              ethnicity
              country
              eye_color
              height
              measurements
              fake_tits
              career_length
              tattoos
              piercings
              aliases
              image
              }
          }';
        //no clue why?? probably to remove thubnail
        unset($scrapedPerformer['image']);
        $resultDetail = $this->client->runRawQuery($performerDetailQuery,true,[
            'scraper_id' => $foundOnScraper,
            'performer' => $scrapedPerformer
        ])->getResults();
        $scrapedPerformer = $resultDetail['data']['scrapePerformer'];
        return $scrapedPerformer;
    }

    /**
     * Loads all the Tags that are already existing in stash
     *
     * @return void
     */
    private function loadStashTags() {
        $rootObject  = new RootQueryObject();
        $rootObject
            ->selectAllTagsSlim()
            ->selectId()
            ->selectName();
        $results = $this->client->runQuery($rootObject->getQuery(),true)->getResults();
        foreach ($results['data']['allTagsSlim'] as $key => $value) {
            $this->tags[strtolower($value['name'])] = $value['id'];
        }
    }

    private function loadStashPerformers() {
        $rootObject = new RootQueryObject();
        $rootObject
            ->selectAllPerformers()
            ->selectId()
            ->selectAliases()
            ->selectName();
        $results = $this->client->runQuery($rootObject->getQuery(),true)->getResults();
        foreach ($results['data']['allPerformers'] as $key => $value) {
            $name = [
                $value['name'],
            ];
            if($value['aliases'] !== null) {
                $name = array_merge($name, explode(' / ',$value['aliases']));
            }
            $this->performers[$value['id']] = $name;
        }
    }
    private function initializeGraphQL($stashUrl) {
        $this->client = new Client(
            $stashUrl."graphql",
            [],
            [ 
                'connect_timeout' => 30,
                'timeout' => 30,
            ]
        );
    }
    /**
     * Undocumented function
     *
     * @param MetadataObject $metadata
     * @return void
     */
    private function getOrCreatePerformers($metadata) {
        $performerIds = [];
        foreach ($metadata->getPerformers() as $key => $performer) {
            if($performer === 'Kyaa') {
                $performer = 'Kyaa Chimera';
            }
            if($performer === 'Lilly Rader') {
                $performer = 'Lily Rader';
            }
            if($performer === 'Stevie Fox') {
                $performer = 'Stevie Foxx';
            }
            if($performer === 'Maya Mays') {
                $performer = 'Mya Mays';
            }

            foreach ($this->performers as $performerId => $stashPerformer) {
                foreach ($stashPerformer as $key => $stashPerformerAlias) {
                    if(strtolower($stashPerformerAlias) == strtolower($performer)) {
                        $performerIds[] = $performerId;
                        continue 3;
                    }
                }
            }
            // doesn't already exists :/
            $scrapedPerformer = $this->scrapePerformer($performer);
            if($scrapedPerformer !== false) {
                $performerIds[] = $this->createPerformer($scrapedPerformer);
            } 

        }
        return $performerIds;
    }

    private function getOrCreateTags($tags) {
        $tagIds = [];
        foreach ($tags as $key => $sceneTag) {
            if(array_key_exists(strtolower($sceneTag),$this->tags)) {
                $tagIds[] = $this->tags[strtolower($sceneTag)];
            } else {
                $query = '
                mutation tagCreate($input:TagCreateInput!) {
                  tagCreate(input: $input){
                    id       
                  }
                }';
                $result = $this->client->runRawQuery($query,true,[
                    'input' => [
                        'name' => $sceneTag
                    ]
                ])->getResults();
                $this->tags[strtolower($sceneTag)] = $result['data']['tagCreate']['id'];
                $tagIds[] = $result['data']['tagCreate']['id'];
            }
        }
        return $tagIds;
    }

    private function imageto64($path) {
        if(!file_exists($path) || is_dir($path)) {
            return false;
        }
        $imgData = base64_encode(file_get_contents($path));
        // Format the image SRC:  data:{mime};base64,{data};
        $src = 'data: '.mime_content_type($path).';base64,'.$imgData;

        return $src;
    }
    public function updateMetadata() {
        $graphMutationQueryRaw = file_get_contents(__DIR__."/graphql.query");
        foreach ($this->videos as $ohash => $video) {
            //@todo switch to bulk
            $rootObject  = new RootQueryObject();
            $rootObject
                ->selectFindSceneByHash((new RootFindSceneByHashArgumentsObject())->setInput((new SceneHashInputInputObject())->setOshash($ohash)))
                    ->selectId()
                    ->selectOrganized();
            $results = $this->client->runQuery($rootObject->getQuery());
            $result = $results->getResults()->data->findSceneByHash;
            if($result === null) {
                LoggerHelper::writeToConsole("Scene ".$video->getFilename()." was not found on the stash instance",'error');
                continue;
            }
            if($result->organized == true) {
                LoggerHelper::writeToConsole("Scene ".$video->getFilename()." was skipped because its already marked organized",'info');
                continue;
            }
            $metadata = $video->getMetadata();
            $inputArray = [
                'input' => [
                    "id" => $result->id,
                    "title" => $metadata->getSceneName(),
                    "details" =>  $metadata->getDescription(),
                    "date" => $metadata->getDate()->format('Y-m-d'),
                    "url" => $video->getPublicUrl(),
                    "cover_image" => $this->imageto64(DirectoryHelper::getRealPath('metadata').$video->getId().".jpg"),
                    "performer_ids" => $this->getOrCreatePerformers($metadata),
                    "tag_ids" => $this->getOrCreateTags($metadata->getTags()),
                    // "stash_ids" =>  []
                ]
            ];
            if($inputArray['input']['cover_image'] === false) {
                unset($inputArray['input']['cover_image']);
            }
            $this->client->runRawQuery(
                $graphMutationQueryRaw,
                false,
                $inputArray
            );
            LoggerHelper::writeToConsole("Scene ".$video->getFilename()." was imported into Stash",'info');
            $this->progressBar1->advance();
        }
    }


}
