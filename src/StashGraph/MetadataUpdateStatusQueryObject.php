<?php

namespace GraphQL\SchemaObject;

class MetadataUpdateStatusQueryObject extends QueryObject
{
    const OBJECT_NAME = "MetadataUpdateStatus";

    public function selectProgress()
    {
        $this->selectField("progress");

        return $this;
    }

    public function selectStatus()
    {
        $this->selectField("status");

        return $this;
    }

    public function selectMessage()
    {
        $this->selectField("message");

        return $this;
    }
}
