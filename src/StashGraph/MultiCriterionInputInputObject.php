<?php

namespace GraphQL\SchemaObject;

class MultiCriterionInputInputObject extends InputObject
{
    protected $value;
    protected $modifier;

    public function setValue(array $value)
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
