<?php

namespace GraphQL\SchemaObject;

class RootFindTagArgumentsObject extends ArgumentsObject
{
    protected $id;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
