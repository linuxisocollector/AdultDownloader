<?php

namespace GraphQL\SchemaObject;

class ImagePathsTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "ImagePathsType";

    public function selectThumbnail()
    {
        $this->selectField("thumbnail");

        return $this;
    }

    public function selectImage()
    {
        $this->selectField("image");

        return $this;
    }
}
