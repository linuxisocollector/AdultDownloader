<?php

namespace GraphQL\SchemaObject;

class SceneMarkerTagQueryObject extends QueryObject
{
    const OBJECT_NAME = "SceneMarkerTag";

    public function selectTag(SceneMarkerTagTagArgumentsObject $argsObject = null)
    {
        $object = new TagQueryObject("tag");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectSceneMarkers(SceneMarkerTagSceneMarkersArgumentsObject $argsObject = null)
    {
        $object = new SceneMarkerQueryObject("scene_markers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
