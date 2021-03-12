<?php

namespace GraphQL\SchemaObject;

class RootScrapeSceneURLArgumentsObject extends ArgumentsObject
{
    protected $url;

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
