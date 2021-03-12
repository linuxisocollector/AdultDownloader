<?php

namespace GraphQL\SchemaObject;

class MovieFilterTypeInputObject extends InputObject
{
    protected $studios;
    protected $is_missing;

    public function setStudios(MultiCriterionInputInputObject $multiCriterionInputInputObject)
    {
        $this->studios = $multiCriterionInputInputObject;

        return $this;
    }

    public function setIsMissing($isMissing)
    {
        $this->is_missing = $isMissing;

        return $this;
    }
}
