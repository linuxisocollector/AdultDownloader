<?php

namespace GraphQL\SchemaObject;

class StashBoxQueryObject extends QueryObject
{
    const OBJECT_NAME = "StashBox";

    public function selectEndpoint()
    {
        $this->selectField("endpoint");

        return $this;
    }

    public function selectApiKey()
    {
        $this->selectField("api_key");

        return $this;
    }

    public function selectName()
    {
        $this->selectField("name");

        return $this;
    }
}
