<?php

namespace GraphQL\SchemaObject;

class RootMarkerWallArgumentsObject extends ArgumentsObject
{
    protected $q;

    public function setQ($q)
    {
        $this->q = $q;

        return $this;
    }
}
