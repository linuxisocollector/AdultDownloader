<?php

namespace GraphQL\SchemaObject;

class FindImagesResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "FindImagesResultType";

    public function selectCount()
    {
        $this->selectField("count");

        return $this;
    }

    public function selectImages(FindImagesResultTypeImagesArgumentsObject $argsObject = null)
    {
        $object = new ImageQueryObject("images");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
