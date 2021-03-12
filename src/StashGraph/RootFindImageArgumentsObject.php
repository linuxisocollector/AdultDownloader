<?php

namespace GraphQL\SchemaObject;

class RootFindImageArgumentsObject extends ArgumentsObject
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
