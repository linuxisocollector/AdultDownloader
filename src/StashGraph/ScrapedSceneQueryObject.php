<?php

namespace GraphQL\SchemaObject;

class ScrapedSceneQueryObject extends QueryObject
{
    const OBJECT_NAME = "ScrapedScene";

    public function selectTitle()
    {
        $this->selectField("title");

        return $this;
    }

    public function selectDetails()
    {
        $this->selectField("details");

        return $this;
    }

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }

    public function selectDate()
    {
        $this->selectField("date");

        return $this;
    }

    public function selectImage()
    {
        $this->selectField("image");

        return $this;
    }

    public function selectFile(ScrapedSceneFileArgumentsObject $argsObject = null)
    {
        $object = new SceneFileTypeQueryObject("file");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectStudio(ScrapedSceneStudioArgumentsObject $argsObject = null)
    {
        $object = new ScrapedSceneStudioQueryObject("studio");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectTags(ScrapedSceneTagsArgumentsObject $argsObject = null)
    {
        $object = new ScrapedSceneTagQueryObject("tags");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectPerformers(ScrapedScenePerformersArgumentsObject $argsObject = null)
    {
        $object = new ScrapedScenePerformerQueryObject("performers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectMovies(ScrapedSceneMoviesArgumentsObject $argsObject = null)
    {
        $object = new ScrapedSceneMovieQueryObject("movies");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectRemoteSiteId()
    {
        $this->selectField("remote_site_id");

        return $this;
    }

    public function selectDuration()
    {
        $this->selectField("duration");

        return $this;
    }

    public function selectFingerprints(ScrapedSceneFingerprintsArgumentsObject $argsObject = null)
    {
        $object = new StashBoxFingerprintQueryObject("fingerprints");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
