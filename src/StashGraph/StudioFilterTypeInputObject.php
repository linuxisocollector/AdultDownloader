<?php

namespace GraphQL\SchemaObject;

class StudioFilterTypeInputObject extends InputObject
{
    protected $parents;
    protected $stash_id;
    protected $is_missing;

    public function setParents(MultiCriterionInputInputObject $multiCriterionInputInputObject)
    {
        $this->parents = $multiCriterionInputInputObject;

        return $this;
    }

    public function setStashId($stashId)
    {
        $this->stash_id = $stashId;

        return $this;
    }

    public function setIsMissing($isMissing)
    {
        $this->is_missing = $isMissing;

        return $this;
    }
}
