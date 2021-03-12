<?php

namespace GraphQL\SchemaObject;

class RootFindMovieArgumentsObject extends ArgumentsObject
{
    protected $id;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
