<?php

namespace GraphQL\SchemaObject;

class RootScrapeFreeonesArgumentsObject extends ArgumentsObject
{
    protected $performer_name;

    public function setPerformerName($performerName)
    {
        $this->performer_name = $performerName;

        return $this;
    }
}
