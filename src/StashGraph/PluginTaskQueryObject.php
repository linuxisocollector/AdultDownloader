<?php

namespace GraphQL\SchemaObject;

class PluginTaskQueryObject extends QueryObject
{
    const OBJECT_NAME = "PluginTask";

    public function selectName()
    {
        $this->selectField("name");

        return $this;
    }

    public function selectDescription()
    {
        $this->selectField("description");

        return $this;
    }

    public function selectPlugin(PluginTaskPluginArgumentsObject $argsObject = null)
    {
        $object = new PluginQueryObject("plugin");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
