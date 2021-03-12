<?php

namespace GraphQL\SchemaObject;

class RootFindPerformersArgumentsObject extends ArgumentsObject
{
    protected $performer_filter;
    protected $filter;

    public function setPerformerFilter(PerformerFilterTypeInputObject $performerFilterTypeInputObject)
    {
        $this->performer_filter = $performerFilterTypeInputObject;

        return $this;
    }

    public function setFilter(FindFilterTypeInputObject $findFilterTypeInputObject)
    {
        $this->filter = $findFilterTypeInputObject;

        return $this;
    }
}
