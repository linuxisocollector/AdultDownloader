<?php

namespace GraphQL\SchemaObject;

class StashConfigQueryObject extends QueryObject
{
    const OBJECT_NAME = "StashConfig";

    public function selectPath()
    {
        $this->selectField("path");

        return $this;
    }

    public function selectExcludeVideo()
    {
        $this->selectField("excludeVideo");

        return $this;
    }

    public function selectExcludeImage()
    {
        $this->selectField("excludeImage");

        return $this;
    }
}
