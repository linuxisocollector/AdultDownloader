<?php

namespace GraphQL\SchemaObject;

class RootMarkerStringsArgumentsObject extends ArgumentsObject
{
    protected $q;
    protected $sort;

    public function setQ($q)
    {
        $this->q = $q;

        return $this;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }
}
