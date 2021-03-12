<?php

namespace GraphQL\SchemaObject;

class SceneMarkerQueryObject extends QueryObject
{
    const OBJECT_NAME = "SceneMarker";

    public function selectId()
    {
        $this->selectField("id");

        return $this;
    }

    public function selectScene(SceneMarkerSceneArgumentsObject $argsObject = null)
    {
        $object = new SceneQueryObject("scene");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectTitle()
    {
        $this->selectField("title");

        return $this;
    }

    public function selectSeconds()
    {
        $this->selectField("seconds");

        return $this;
    }

    public function selectPrimaryTag(SceneMarkerPrimaryTagArgumentsObject $argsObject = null)
    {
        $object = new TagQueryObject("primary_tag");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectTags(SceneMarkerTagsArgumentsObject $argsObject = null)
    {
        $object = new TagQueryObject("tags");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectStream()
    {
        $this->selectField("stream");

        return $this;
    }

    public function selectPreview()
    {
        $this->selectField("preview");

        return $this;
    }
}
