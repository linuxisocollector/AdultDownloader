<?php

namespace GraphQL\SchemaObject;

class RootScrapePerformerArgumentsObject extends ArgumentsObject
{
    protected $scraper_id;
    protected $scraped_performer;

    public function setScraperId($scraperId)
    {
        $this->scraper_id = $scraperId;

        return $this;
    }

    public function setScrapedPerformer(ScrapedPerformerInputInputObject $scrapedPerformerInputInputObject)
    {
        $this->scraped_performer = $scrapedPerformerInputInputObject;

        return $this;
    }
}
