<?php

namespace GraphQL\SchemaObject;

class RootScrapePerformerURLArgumentsObject extends ArgumentsObject
{
    protected $url;

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
