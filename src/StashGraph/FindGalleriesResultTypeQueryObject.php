<?php

namespace GraphQL\SchemaObject;

class FindGalleriesResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "FindGalleriesResultType";

    public function selectCount()
    {
        $this->selectField("count");

        return $this;
    }

    public function selectGalleries(FindGalleriesResultTypeGalleriesArgumentsObject $argsObject = null)
    {
        $object = new GalleryQueryObject("galleries");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
