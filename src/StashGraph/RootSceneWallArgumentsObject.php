<?php

namespace GraphQL\SchemaObject;

class RootSceneWallArgumentsObject extends ArgumentsObject
{
    protected $q;

    public function setQ($q)
    {
        $this->q = $q;

        return $this;
    }
}
