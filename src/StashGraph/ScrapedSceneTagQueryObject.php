<?php

namespace GraphQL\SchemaObject;

class ScrapedSceneTagQueryObject extends QueryObject
{
    const OBJECT_NAME = "ScrapedSceneTag";

    public function selectStoredId()
    {
        $this->selectField("stored_id");

        return $this;
    }

    public function selectName()
    {
        $this->selectField("name");

        return $this;
    }
}
