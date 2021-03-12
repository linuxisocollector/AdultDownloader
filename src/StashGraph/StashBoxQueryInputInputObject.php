<?php

namespace GraphQL\SchemaObject;

class StashBoxQueryInputInputObject extends InputObject
{
    protected $stash_box_index;
    protected $scene_ids;
    protected $q;

    public function setStashBoxIndex($stashBoxIndex)
    {
        $this->stash_box_index = $stashBoxIndex;

        return $this;
    }

    public function setSceneIds(array $sceneIds)
    {
        $this->scene_ids = $sceneIds;

        return $this;
    }

    public function setQ($q)
    {
        $this->q = $q;

        return $this;
    }
}
