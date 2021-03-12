<?php

namespace GraphQL\SchemaObject;

class RootQueryObject extends QueryObject
{
    const OBJECT_NAME = "";

    public function selectFindScene(RootFindSceneArgumentsObject $argsObject = null)
    {
        $object = new SceneQueryObject("findScene");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindSceneByHash(RootFindSceneByHashArgumentsObject $argsObject = null)
    {
        $object = new SceneQueryObject("findSceneByHash");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindScenes(RootFindScenesArgumentsObject $argsObject = null)
    {
        $object = new FindScenesResultTypeQueryObject("findScenes");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindScenesByPathRegex(RootFindScenesByPathRegexArgumentsObject $argsObject = null)
    {
        $object = new FindScenesResultTypeQueryObject("findScenesByPathRegex");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectSceneStreams(RootSceneStreamsArgumentsObject $argsObject = null)
    {
        $object = new SceneStreamEndpointQueryObject("sceneStreams");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectParseSceneFilenames(RootParseSceneFilenamesArgumentsObject $argsObject = null)
    {
        $object = new SceneParserResultTypeQueryObject("parseSceneFilenames");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindSceneMarkers(RootFindSceneMarkersArgumentsObject $argsObject = null)
    {
        $object = new FindSceneMarkersResultTypeQueryObject("findSceneMarkers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindImage(RootFindImageArgumentsObject $argsObject = null)
    {
        $object = new ImageQueryObject("findImage");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindImages(RootFindImagesArgumentsObject $argsObject = null)
    {
        $object = new FindImagesResultTypeQueryObject("findImages");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindPerformer(RootFindPerformerArgumentsObject $argsObject = null)
    {
        $object = new PerformerQueryObject("findPerformer");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindPerformers(RootFindPerformersArgumentsObject $argsObject = null)
    {
        $object = new FindPerformersResultTypeQueryObject("findPerformers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindStudio(RootFindStudioArgumentsObject $argsObject = null)
    {
        $object = new StudioQueryObject("findStudio");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindStudios(RootFindStudiosArgumentsObject $argsObject = null)
    {
        $object = new FindStudiosResultTypeQueryObject("findStudios");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindMovie(RootFindMovieArgumentsObject $argsObject = null)
    {
        $object = new MovieQueryObject("findMovie");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindMovies(RootFindMoviesArgumentsObject $argsObject = null)
    {
        $object = new FindMoviesResultTypeQueryObject("findMovies");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindGallery(RootFindGalleryArgumentsObject $argsObject = null)
    {
        $object = new GalleryQueryObject("findGallery");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindGalleries(RootFindGalleriesArgumentsObject $argsObject = null)
    {
        $object = new FindGalleriesResultTypeQueryObject("findGalleries");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindTag(RootFindTagArgumentsObject $argsObject = null)
    {
        $object = new TagQueryObject("findTag");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFindTags(RootFindTagsArgumentsObject $argsObject = null)
    {
        $object = new FindTagsResultTypeQueryObject("findTags");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectMarkerWall(RootMarkerWallArgumentsObject $argsObject = null)
    {
        $object = new SceneMarkerQueryObject("markerWall");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectSceneWall(RootSceneWallArgumentsObject $argsObject = null)
    {
        $object = new SceneQueryObject("sceneWall");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectMarkerStrings(RootMarkerStringsArgumentsObject $argsObject = null)
    {
        $object = new MarkerStringsResultTypeQueryObject("markerStrings");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectStats(RootStatsArgumentsObject $argsObject = null)
    {
        $object = new StatsResultTypeQueryObject("stats");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectSceneMarkerTags(RootSceneMarkerTagsArgumentsObject $argsObject = null)
    {
        $object = new SceneMarkerTagQueryObject("sceneMarkerTags");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectLogs(RootLogsArgumentsObject $argsObject = null)
    {
        $object = new LogEntryQueryObject("logs");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectListPerformerScrapers(RootListPerformerScrapersArgumentsObject $argsObject = null)
    {
        $object = new ScraperQueryObject("listPerformerScrapers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectListSceneScrapers(RootListSceneScrapersArgumentsObject $argsObject = null)
    {
        $object = new ScraperQueryObject("listSceneScrapers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectListGalleryScrapers(RootListGalleryScrapersArgumentsObject $argsObject = null)
    {
        $object = new ScraperQueryObject("listGalleryScrapers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectListMovieScrapers(RootListMovieScrapersArgumentsObject $argsObject = null)
    {
        $object = new ScraperQueryObject("listMovieScrapers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScrapePerformerList(RootScrapePerformerListArgumentsObject $argsObject = null)
    {
        $object = new ScrapedPerformerQueryObject("scrapePerformerList");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScrapePerformer(RootScrapePerformerArgumentsObject $argsObject = null)
    {
        $object = new ScrapedPerformerQueryObject("scrapePerformer");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScrapePerformerURL(RootScrapePerformerURLArgumentsObject $argsObject = null)
    {
        $object = new ScrapedPerformerQueryObject("scrapePerformerURL");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScrapeScene(RootScrapeSceneArgumentsObject $argsObject = null)
    {
        $object = new ScrapedSceneQueryObject("scrapeScene");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScrapeSceneURL(RootScrapeSceneURLArgumentsObject $argsObject = null)
    {
        $object = new ScrapedSceneQueryObject("scrapeSceneURL");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScrapeGallery(RootScrapeGalleryArgumentsObject $argsObject = null)
    {
        $object = new ScrapedGalleryQueryObject("scrapeGallery");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScrapeGalleryURL(RootScrapeGalleryURLArgumentsObject $argsObject = null)
    {
        $object = new ScrapedGalleryQueryObject("scrapeGalleryURL");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScrapeMovieURL(RootScrapeMovieURLArgumentsObject $argsObject = null)
    {
        $object = new ScrapedMovieQueryObject("scrapeMovieURL");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScrapeFreeones(RootScrapeFreeonesArgumentsObject $argsObject = null)
    {
        $object = new ScrapedPerformerQueryObject("scrapeFreeones");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectScrapeFreeonesPerformerList()
    {
        $this->selectField("scrapeFreeonesPerformerList");

        return $this;
    }

    public function selectQueryStashBoxScene(RootQueryStashBoxSceneArgumentsObject $argsObject = null)
    {
        $object = new ScrapedSceneQueryObject("queryStashBoxScene");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectPlugins(RootPluginsArgumentsObject $argsObject = null)
    {
        $object = new PluginQueryObject("plugins");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectPluginTasks(RootPluginTasksArgumentsObject $argsObject = null)
    {
        $object = new PluginTaskQueryObject("pluginTasks");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectConfiguration(RootConfigurationArgumentsObject $argsObject = null)
    {
        $object = new ConfigResultQueryObject("configuration");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectDirectory(RootDirectoryArgumentsObject $argsObject = null)
    {
        $object = new DirectoryQueryObject("directory");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectJobStatus(RootJobStatusArgumentsObject $argsObject = null)
    {
        $object = new MetadataUpdateStatusQueryObject("jobStatus");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectAllPerformers(RootAllPerformersArgumentsObject $argsObject = null)
    {
        $object = new PerformerQueryObject("allPerformers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectAllStudios(RootAllStudiosArgumentsObject $argsObject = null)
    {
        $object = new StudioQueryObject("allStudios");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectAllMovies(RootAllMoviesArgumentsObject $argsObject = null)
    {
        $object = new MovieQueryObject("allMovies");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectAllTags(RootAllTagsArgumentsObject $argsObject = null)
    {
        $object = new TagQueryObject("allTags");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectAllPerformersSlim(RootAllPerformersSlimArgumentsObject $argsObject = null)
    {
        $object = new PerformerQueryObject("allPerformersSlim");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectAllStudiosSlim(RootAllStudiosSlimArgumentsObject $argsObject = null)
    {
        $object = new StudioQueryObject("allStudiosSlim");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectAllMoviesSlim(RootAllMoviesSlimArgumentsObject $argsObject = null)
    {
        $object = new MovieQueryObject("allMoviesSlim");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectAllTagsSlim(RootAllTagsSlimArgumentsObject $argsObject = null)
    {
        $object = new TagQueryObject("allTagsSlim");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectVersion(RootVersionArgumentsObject $argsObject = null)
    {
        $object = new VersionQueryObject("version");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectLatestversion(RootLatestversionArgumentsObject $argsObject = null)
    {
        $object = new ShortVersionQueryObject("latestversion");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
