<?php

namespace GraphQL\SchemaObject;

class RootDirectoryArgumentsObject extends ArgumentsObject
{
    protected $path;

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}
