<?php

namespace GraphQL\SchemaObject;

class RootFindStudioArgumentsObject extends ArgumentsObject
{
    protected $id;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
