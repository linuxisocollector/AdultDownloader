<?php

namespace GraphQL\SchemaObject;

class RootScrapeMovieURLArgumentsObject extends ArgumentsObject
{
    protected $url;

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
