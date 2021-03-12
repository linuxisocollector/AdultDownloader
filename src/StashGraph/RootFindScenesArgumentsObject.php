<?php

namespace GraphQL\SchemaObject;

class RootFindScenesArgumentsObject extends ArgumentsObject
{
    protected $scene_filter;
    protected $scene_ids;
    protected $filter;

    public function setSceneFilter(SceneFilterTypeInputObject $sceneFilterTypeInputObject)
    {
        $this->scene_filter = $sceneFilterTypeInputObject;

        return $this;
    }

    public function setSceneIds(array $sceneIds)
    {
        $this->scene_ids = $sceneIds;

        return $this;
    }

    public function setFilter(FindFilterTypeInputObject $findFilterTypeInputObject)
    {
        $this->filter = $findFilterTypeInputObject;

        return $this;
    }
}
