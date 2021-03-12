<?php

namespace GraphQL\SchemaObject;

class SceneQueryObject extends QueryObject
{
    const OBJECT_NAME = "Scene";

    public function selectId()
    {
        $this->selectField("id");

        return $this;
    }

    public function selectChecksum()
    {
        $this->selectField("checksum");

        return $this;
    }

    public function selectOshash()
    {
        $this->selectField("oshash");

        return $this;
    }

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

    public function selectRating()
    {
        $this->selectField("rating");

        return $this;
    }

    public function selectOrganized()
    {
        $this->selectField("organized");

        return $this;
    }

    public function selectOCounter()
    {
        $this->selectField("o_counter");

        return $this;
    }

    public function selectPath()
    {
        $this->selectField("path");

        return $this;
    }

    public function selectFile(SceneFileArgumentsObject $argsObject = null)
    {
        $object = new SceneFileTypeQueryObject("file");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectPaths(ScenePathsArgumentsObject $argsObject = null)
    {
        $object = new ScenePathsTypeQueryObject("paths");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectSceneMarkers(SceneSceneMarkersArgumentsObject $argsObject = null)
    {
        $object = new SceneMarkerQueryObject("scene_markers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectGalleries(SceneGalleriesArgumentsObject $argsObject = null)
    {
        $object = new GalleryQueryObject("galleries");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectStudio(SceneStudioArgumentsObject $argsObject = null)
    {
        $object = new StudioQueryObject("studio");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectMovies(SceneMoviesArgumentsObject $argsObject = null)
    {
        $object = new SceneMovieQueryObject("movies");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectTags(SceneTagsArgumentsObject $argsObject = null)
    {
        $object = new TagQueryObject("tags");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectPerformers(ScenePerformersArgumentsObject $argsObject = null)
    {
        $object = new PerformerQueryObject("performers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectStashIds(SceneStashIdsArgumentsObject $argsObject = null)
    {
        $object = new StashIDQueryObject("stash_ids");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
