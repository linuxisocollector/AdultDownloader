<?php

namespace GraphQL\SchemaObject;

class RootFindPerformerArgumentsObject extends ArgumentsObject
{
    protected $id;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
