<?php

namespace GraphQL\SchemaObject;

class RootQueryStashBoxSceneArgumentsObject extends ArgumentsObject
{
    protected $input;

    public function setInput(StashBoxQueryInputInputObject $stashBoxQueryInputInputObject)
    {
        $this->input = $stashBoxQueryInputInputObject;

        return $this;
    }
}
