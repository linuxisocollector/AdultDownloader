<?php

namespace GraphQL\SchemaObject;

class StashIDQueryObject extends QueryObject
{
    const OBJECT_NAME = "StashID";

    public function selectEndpoint()
    {
        $this->selectField("endpoint");

        return $this;
    }

    public function selectStashId()
    {
        $this->selectField("stash_id");

        return $this;
    }
}
