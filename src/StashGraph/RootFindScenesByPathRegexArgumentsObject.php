<?php

namespace GraphQL\SchemaObject;

class RootFindScenesByPathRegexArgumentsObject extends ArgumentsObject
{
    protected $filter;

    public function setFilter(FindFilterTypeInputObject $findFilterTypeInputObject)
    {
        $this->filter = $findFilterTypeInputObject;

        return $this;
    }
}
