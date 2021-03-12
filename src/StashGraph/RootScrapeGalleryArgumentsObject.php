<?php

namespace GraphQL\SchemaObject;

class RootScrapeGalleryArgumentsObject extends ArgumentsObject
{
    protected $scraper_id;
    protected $gallery;

    public function setScraperId($scraperId)
    {
        $this->scraper_id = $scraperId;

        return $this;
    }

    public function setGallery(GalleryUpdateInputInputObject $galleryUpdateInputInputObject)
    {
        $this->gallery = $galleryUpdateInputInputObject;

        return $this;
    }
}
