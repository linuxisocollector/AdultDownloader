<?php

namespace GraphQL\SchemaObject;

class VersionQueryObject extends QueryObject
{
    const OBJECT_NAME = "Version";

    public function selectVersion()
    {
        $this->selectField("version");

        return $this;
    }

    public function selectHash()
    {
        $this->selectField("hash");

        return $this;
    }

    public function selectBuildTime()
    {
        $this->selectField("build_time");

        return $this;
    }
}
