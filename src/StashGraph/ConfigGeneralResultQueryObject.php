<?php

namespace GraphQL\SchemaObject;

class ConfigGeneralResultQueryObject extends QueryObject
{
    const OBJECT_NAME = "ConfigGeneralResult";

    public function selectStashes(ConfigGeneralResultStashesArgumentsObject $argsObject = null)
    {
        $object = new StashConfigQueryObject("stashes");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectDatabasePath()
    {
        $this->selectField("databasePath");

        return $this;
    }

    public function selectGeneratedPath()
    {
        $this->selectField("generatedPath");

        return $this;
    }

    public function selectCachePath()
    {
        $this->selectField("cachePath");

        return $this;
    }

    public function selectCalculateMD5()
    {
        $this->selectField("calculateMD5");

        return $this;
    }

    public function selectVideoFileNamingAlgorithm()
    {
        $this->selectField("videoFileNamingAlgorithm");

        return $this;
    }

    public function selectParallelTasks()
    {
        $this->selectField("parallelTasks");

        return $this;
    }

    public function selectPreviewSegments()
    {
        $this->selectField("previewSegments");

        return $this;
    }

    public function selectPreviewSegmentDuration()
    {
        $this->selectField("previewSegmentDuration");

        return $this;
    }

    public function selectPreviewExcludeStart()
    {
        $this->selectField("previewExcludeStart");

        return $this;
    }

    public function selectPreviewExcludeEnd()
    {
        $this->selectField("previewExcludeEnd");

        return $this;
    }

    public function selectPreviewPreset()
    {
        $this->selectField("previewPreset");

        return $this;
    }

    public function selectMaxTranscodeSize()
    {
        $this->selectField("maxTranscodeSize");

        return $this;
    }

    public function selectMaxStreamingTranscodeSize()
    {
        $this->selectField("maxStreamingTranscodeSize");

        return $this;
    }

    public function selectUsername()
    {
        $this->selectField("username");

        return $this;
    }

    public function selectPassword()
    {
        $this->selectField("password");

        return $this;
    }

    public function selectMaxSessionAge()
    {
        $this->selectField("maxSessionAge");

        return $this;
    }

    public function selectLogFile()
    {
        $this->selectField("logFile");

        return $this;
    }

    public function selectLogOut()
    {
        $this->selectField("logOut");

        return $this;
    }

    public function selectLogLevel()
    {
        $this->selectField("logLevel");

        return $this;
    }

    public function selectLogAccess()
    {
        $this->selectField("logAccess");

        return $this;
    }

    public function selectVideoExtensions()
    {
        $this->selectField("videoExtensions");

        return $this;
    }

    public function selectImageExtensions()
    {
        $this->selectField("imageExtensions");

        return $this;
    }

    public function selectGalleryExtensions()
    {
        $this->selectField("galleryExtensions");

        return $this;
    }

    public function selectCreateGalleriesFromFolders()
    {
        $this->selectField("createGalleriesFromFolders");

        return $this;
    }

    public function selectExcludes()
    {
        $this->selectField("excludes");

        return $this;
    }

    public function selectImageExcludes()
    {
        $this->selectField("imageExcludes");

        return $this;
    }

    public function selectScraperUserAgent()
    {
        $this->selectField("scraperUserAgent");

        return $this;
    }

    public function selectScraperCDPPath()
    {
        $this->selectField("scraperCDPPath");

        return $this;
    }

    public function selectStashBoxes(ConfigGeneralResultStashBoxesArgumentsObject $argsObject = null)
    {
        $object = new StashBoxQueryObject("stashBoxes");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
