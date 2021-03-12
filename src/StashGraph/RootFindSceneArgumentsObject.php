<?php

namespace GraphQL\SchemaObject;

class RootFindSceneArgumentsObject extends ArgumentsObject
{
    protected $id;
    protected $checksum;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setChecksum($checksum)
    {
        $this->checksum = $checksum;

        return $this;
    }
}
