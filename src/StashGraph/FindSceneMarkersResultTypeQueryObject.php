<?php

namespace GraphQL\SchemaObject;

class FindSceneMarkersResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "FindSceneMarkersResultType";

    public function selectCount()
    {
        $this->selectField("count");

        return $this;
    }

    public function selectSceneMarkers(FindSceneMarkersResultTypeSceneMarkersArgumentsObject $argsObject = null)
    {
        $object = new SceneMarkerQueryObject("scene_markers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
