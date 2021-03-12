<?php

namespace GraphQL\SchemaObject;

class FindStudiosResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "FindStudiosResultType";

    public function selectCount()
    {
        $this->selectField("count");

        return $this;
    }

    public function selectStudios(FindStudiosResultTypeStudiosArgumentsObject $argsObject = null)
    {
        $object = new StudioQueryObject("studios");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
