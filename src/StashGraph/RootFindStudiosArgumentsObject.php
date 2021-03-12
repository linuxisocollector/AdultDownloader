<?php

namespace GraphQL\SchemaObject;

class RootFindStudiosArgumentsObject extends ArgumentsObject
{
    protected $studio_filter;
    protected $filter;

    public function setStudioFilter(StudioFilterTypeInputObject $studioFilterTypeInputObject)
    {
        $this->studio_filter = $studioFilterTypeInputObject;

        return $this;
    }

    public function setFilter(FindFilterTypeInputObject $findFilterTypeInputObject)
    {
        $this->filter = $findFilterTypeInputObject;

        return $this;
    }
}
