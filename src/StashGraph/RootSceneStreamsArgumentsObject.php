<?php

namespace GraphQL\SchemaObject;

class RootSceneStreamsArgumentsObject extends ArgumentsObject
{
    protected $id;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
