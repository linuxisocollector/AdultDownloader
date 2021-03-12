<?php

namespace GraphQL\SchemaObject;

class ImageFileTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "ImageFileType";

    public function selectSize()
    {
        $this->selectField("size");

        return $this;
    }

    public function selectWidth()
    {
        $this->selectField("width");

        return $this;
    }

    public function selectHeight()
    {
        $this->selectField("height");

        return $this;
    }
}
