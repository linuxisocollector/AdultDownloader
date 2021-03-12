<?php

namespace GraphQL\SchemaObject;

class DirectoryQueryObject extends QueryObject
{
    const OBJECT_NAME = "Directory";

    public function selectPath()
    {
        $this->selectField("path");

        return $this;
    }

    public function selectParent()
    {
        $this->selectField("parent");

        return $this;
    }

    public function selectDirectories()
    {
        $this->selectField("directories");

        return $this;
    }
}
