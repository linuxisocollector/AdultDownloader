<?php

namespace GraphQL\SchemaObject;

class RootScrapePerformerListArgumentsObject extends ArgumentsObject
{
    protected $scraper_id;
    protected $query;

    public function setScraperId($scraperId)
    {
        $this->scraper_id = $scraperId;

        return $this;
    }

    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }
}
