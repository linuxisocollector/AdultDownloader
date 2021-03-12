<?php

namespace GraphQL\SchemaObject;

class SceneMarkerFilterTypeInputObject extends InputObject
{
    protected $tag_id;
    protected $tags;
    protected $scene_tags;
    protected $performers;

    public function setTagId($tagId)
    {
        $this->tag_id = $tagId;

        return $this;
    }

    public function setTags(MultiCriterionInputInputObject $multiCriterionInputInputObject)
    {
        $this->tags = $multiCriterionInputInputObject;

        return $this;
    }

    public function setSceneTags(MultiCriterionInputInputObject $multiCriterionInputInputObject)
    {
        $this->scene_tags = $multiCriterionInputInputObject;

        return $this;
    }

    public function setPerformers(MultiCriterionInputInputObject $multiCriterionInputInputObject)
    {
        $this->performers = $multiCriterionInputInputObject;

        return $this;
    }
}
