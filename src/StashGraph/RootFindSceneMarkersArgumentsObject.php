<?php

namespace GraphQL\SchemaObject;

class RootFindSceneMarkersArgumentsObject extends ArgumentsObject
{
    protected $scene_marker_filter;
    protected $filter;

    public function setSceneMarkerFilter(SceneMarkerFilterTypeInputObject $sceneMarkerFilterTypeInputObject)
    {
        $this->scene_marker_filter = $sceneMarkerFilterTypeInputObject;

        return $this;
    }

    public function setFilter(FindFilterTypeInputObject $findFilterTypeInputObject)
    {
        $this->filter = $findFilterTypeInputObject;

        return $this;
    }
}
