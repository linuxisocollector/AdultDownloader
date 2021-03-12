<?php

namespace GraphQL\SchemaObject;

class ShortVersionQueryObject extends QueryObject
{
    const OBJECT_NAME = "ShortVersion";

    public function selectShorthash()
    {
        $this->selectField("shorthash");

        return $this;
    }

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }
}
