<?php

namespace GraphQL\SchemaObject;

class SceneStreamEndpointQueryObject extends QueryObject
{
    const OBJECT_NAME = "SceneStreamEndpoint";

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }

    public function selectMimeType()
    {
        $this->selectField("mime_type");

        return $this;
    }

    public function selectLabel()
    {
        $this->selectField("label");

        return $this;
    }
}
