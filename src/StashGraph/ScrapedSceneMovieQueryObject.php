<?php

namespace GraphQL\SchemaObject;

class ScrapedSceneMovieQueryObject extends QueryObject
{
    const OBJECT_NAME = "ScrapedSceneMovie";

    public function selectStoredId()
    {
        $this->selectField("stored_id");

        return $this;
    }

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

    public function selectSynopsis()
    {
        $this->selectField("synopsis");

        return $this;
    }

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }
}
