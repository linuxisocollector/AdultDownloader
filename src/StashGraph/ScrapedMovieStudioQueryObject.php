<?php

namespace GraphQL\SchemaObject;

class ScrapedMovieStudioQueryObject extends QueryObject
{
    const OBJECT_NAME = "ScrapedMovieStudio";

    public function selectId()
    {
        $this->selectField("id");

        return $this;
    }

    public function selectName()
    {
        $this->selectField("name");

        return $this;
    }

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }
}
