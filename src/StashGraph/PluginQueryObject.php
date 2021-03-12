<?php

namespace GraphQL\SchemaObject;

class PluginQueryObject extends QueryObject
{
    const OBJECT_NAME = "Plugin";

    public function selectId()
    {
        $this->selectField("id");

        return $this;
    }

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

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }

    public function selectVersion()
    {
        $this->selectField("version");

        return $this;
    }

    public function selectTasks(PluginTasksArgumentsObject $argsObject = null)
    {
        $object = new PluginTaskQueryObject("tasks");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
