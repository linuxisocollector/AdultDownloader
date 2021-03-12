<?php

namespace GraphQL\SchemaObject;

class StashIDInputInputObject extends InputObject
{
    protected $endpoint;
    protected $stash_id;

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function setStashId($stashId)
    {
        $this->stash_id = $stashId;

        return $this;
    }
}
