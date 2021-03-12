<?php

namespace GraphQL\SchemaObject;

class StringCriterionInputInputObject extends InputObject
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
