<?php

namespace GraphQL\SchemaObject;

class FindTagsResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "FindTagsResultType";

    public function selectCount()
    {
        $this->selectField("count");

        return $this;
    }

    public function selectTags(FindTagsResultTypeTagsArgumentsObject $argsObject = null)
    {
        $object = new TagQueryObject("tags");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
