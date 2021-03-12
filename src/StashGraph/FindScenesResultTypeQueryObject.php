<?php

namespace GraphQL\SchemaObject;

class FindScenesResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "FindScenesResultType";

    public function selectCount()
    {
        $this->selectField("count");

        return $this;
    }

    public function selectScenes(FindScenesResultTypeScenesArgumentsObject $argsObject = null)
    {
        $object = new SceneQueryObject("scenes");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
