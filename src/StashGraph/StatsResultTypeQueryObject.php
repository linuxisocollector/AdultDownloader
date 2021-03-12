<?php

namespace GraphQL\SchemaObject;

class StatsResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "StatsResultType";

    public function selectSceneCount()
    {
        $this->selectField("scene_count");

        return $this;
    }

    public function selectScenesSize()
    {
        $this->selectField("scenes_size");

        return $this;
    }

    public function selectImageCount()
    {
        $this->selectField("image_count");

        return $this;
    }

    public function selectImagesSize()
    {
        $this->selectField("images_size");

        return $this;
    }

    public function selectGalleryCount()
    {
        $this->selectField("gallery_count");

        return $this;
    }

    public function selectPerformerCount()
    {
        $this->selectField("performer_count");

        return $this;
    }

    public function selectStudioCount()
    {
        $this->selectField("studio_count");

        return $this;
    }

    public function selectMovieCount()
    {
        $this->selectField("movie_count");

        return $this;
    }

    public function selectTagCount()
    {
        $this->selectField("tag_count");

        return $this;
    }
}
