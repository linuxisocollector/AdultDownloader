<?php

namespace GraphQL\SchemaObject;

class GenderCriterionInputInputObject extends InputObject
{
    protected $value;
    protected $modifier;

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function setModifier($modifier)
    {
        $this->modifier = $modifier;

        return $this;
    }
}
