<?php

namespace GraphQL\SchemaObject;

class RootScrapeSceneArgumentsObject extends ArgumentsObject
{
    protected $scraper_id;
    protected $scene;

    public function setScraperId($scraperId)
    {
        $this->scraper_id = $scraperId;

        return $this;
    }

    public function setScene(SceneUpdateInputInputObject $sceneUpdateInputInputObject)
    {
        $this->scene = $sceneUpdateInputInputObject;

        return $this;
    }
}
