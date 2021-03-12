<?php

namespace GraphQL\SchemaObject;

class TagQueryObject extends QueryObject
{
    const OBJECT_NAME = "Tag";

    public function selectId()
    {
        $this->selectField("id");

        return $this;
    }

    public function selectName()
    {
        $this->selectField("name");

        return $this;
    }

    public function selectImagePath()
    {
        $this->selectField("image_path");

        return $this;
    }

    public function selectSceneCount()
    {
        $this->selectField("scene_count");

        return $this;
    }

    public function selectSceneMarkerCount()
    {
        $this->selectField("scene_marker_count");

        return $this;
    }
}
