<?php

namespace GraphQL\SchemaObject;

class FindPerformersResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "FindPerformersResultType";

    public function selectCount()
    {
        $this->selectField("count");

        return $this;
    }

    public function selectPerformers(FindPerformersResultTypePerformersArgumentsObject $argsObject = null)
    {
        $object = new PerformerQueryObject("performers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
