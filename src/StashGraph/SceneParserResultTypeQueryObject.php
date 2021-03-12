<?php

namespace GraphQL\SchemaObject;

class SceneParserResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "SceneParserResultType";

    public function selectCount()
    {
        $this->selectField("count");

        return $this;
    }

    public function selectResults(SceneParserResultTypeResultsArgumentsObject $argsObject = null)
    {
        $object = new SceneParserResultQueryObject("results");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
