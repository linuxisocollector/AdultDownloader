<?php

namespace GraphQL\SchemaObject;

class RootParseSceneFilenamesArgumentsObject extends ArgumentsObject
{
    protected $filter;
    protected $config;

    public function setFilter(FindFilterTypeInputObject $findFilterTypeInputObject)
    {
        $this->filter = $findFilterTypeInputObject;

        return $this;
    }

    public function setConfig(SceneParserInputInputObject $sceneParserInputInputObject)
    {
        $this->config = $sceneParserInputInputObject;

        return $this;
    }
}
