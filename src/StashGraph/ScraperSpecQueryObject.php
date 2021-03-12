<?php

namespace GraphQL\SchemaObject;

class ScraperSpecQueryObject extends QueryObject
{
    const OBJECT_NAME = "ScraperSpec";

    public function selectUrls()
    {
        $this->selectField("urls");

        return $this;
    }

    public function selectSupportedScrapes()
    {
        $this->selectField("supported_scrapes");

        return $this;
    }
}
