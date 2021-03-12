<?php

namespace GraphQL\SchemaObject;

class ScrapedSceneStudioQueryObject extends QueryObject
{
    const OBJECT_NAME = "ScrapedSceneStudio";

    public function selectStoredId()
    {
        $this->selectField("stored_id");

        return $this;
    }

    public function selectName()
    {
        $this->selectField("name");

        return $this;
    }

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }

    public function selectRemoteSiteId()
    {
        $this->selectField("remote_site_id");

        return $this;
    }
}
