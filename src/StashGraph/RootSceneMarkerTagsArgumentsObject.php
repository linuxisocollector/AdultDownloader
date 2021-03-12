<?php

namespace GraphQL\SchemaObject;

class RootSceneMarkerTagsArgumentsObject extends ArgumentsObject
{
    protected $scene_id;

    public function setSceneId($sceneId)
    {
        $this->scene_id = $sceneId;

        return $this;
    }
}
