<?php

namespace GraphQL\SchemaObject;

class MarkerStringsResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "MarkerStringsResultType";

    public function selectCount()
    {
        $this->selectField("count");

        return $this;
    }

    public function selectId()
    {
        $this->selectField("id");

        return $this;
    }

    public function selectTitle()
    {
        $this->selectField("title");

        return $this;
    }
}
