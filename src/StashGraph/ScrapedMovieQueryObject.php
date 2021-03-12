<?php

namespace GraphQL\SchemaObject;

class ScrapedMovieQueryObject extends QueryObject
{
    const OBJECT_NAME = "ScrapedMovie";

    public function selectName()
    {
        $this->selectField("name");

        return $this;
    }

    public function selectAliases()
    {
        $this->selectField("aliases");

        return $this;
    }

    public function selectDuration()
    {
        $this->selectField("duration");

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

    public function selectDirector()
    {
        $this->selectField("director");

        return $this;
    }

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }

    public function selectSynopsis()
    {
        $this->selectField("synopsis");

        return $this;
    }

    public function selectStudio(ScrapedMovieStudioArgumentsObject $argsObject = null)
    {
        $object = new ScrapedMovieStudioQueryObject("studio");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectFrontImage()
    {
        $this->selectField("front_image");

        return $this;
    }

    public function selectBackImage()
    {
        $this->selectField("back_image");

        return $this;
    }
}
