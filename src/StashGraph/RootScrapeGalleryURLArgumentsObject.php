<?php

namespace GraphQL\SchemaObject;

class RootScrapeGalleryURLArgumentsObject extends ArgumentsObject
{
    protected $url;

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
