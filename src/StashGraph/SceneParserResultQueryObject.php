<?php

namespace GraphQL\SchemaObject;

class SceneParserResultQueryObject extends QueryObject
{
    const OBJECT_NAME = "SceneParserResult";

    public function selectScene(SceneParserResultSceneArgumentsObject $argsObject = null)
    {
        $object = new SceneQueryObject("scene");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
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

    public function selectStudioId()
    {
        $this->selectField("studio_id");

        return $this;
    }

    public function selectGalleryIds()
    {
        $this->selectField("gallery_ids");

        return $this;
    }

    public function selectPerformerIds()
    {
        $this->selectField("performer_ids");

        return $this;
    }

    public function selectMovies(SceneParserResultMoviesArgumentsObject $argsObject = null)
    {
        $object = new SceneMovieIDQueryObject("movies");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectTagIds()
    {
        $this->selectField("tag_ids");

        return $this;
    }
}
