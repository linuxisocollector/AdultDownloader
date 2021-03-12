<?php

namespace GraphQL\SchemaObject;

class ConfigResultQueryObject extends QueryObject
{
    const OBJECT_NAME = "ConfigResult";

    public function selectGeneral(ConfigResultGeneralArgumentsObject $argsObject = null)
    {
        $object = new ConfigGeneralResultQueryObject("general");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectInterface(ConfigResultInterfaceArgumentsObject $argsObject = null)
    {
        $object = new ConfigInterfaceResultQueryObject("interface");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
