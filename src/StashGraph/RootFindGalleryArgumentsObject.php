<?php

namespace GraphQL\SchemaObject;

class RootFindGalleryArgumentsObject extends ArgumentsObject
{
    protected $id;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
