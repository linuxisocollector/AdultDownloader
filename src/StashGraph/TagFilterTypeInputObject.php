<?php

namespace GraphQL\SchemaObject;

class TagFilterTypeInputObject extends InputObject
{
    protected $is_missing;
    protected $scene_count;
    protected $marker_count;

    public function setIsMissing($isMissing)
    {
        $this->is_missing = $isMissing;

        return $this;
    }

    public function setSceneCount(IntCriterionInputInputObject $intCriterionInputInputObject)
    {
        $this->scene_count = $intCriterionInputInputObject;

        return $this;
    }

    public function setMarkerCount(IntCriterionInputInputObject $intCriterionInputInputObject)
    {
        $this->marker_count = $intCriterionInputInputObject;

        return $this;
    }
}
