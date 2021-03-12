<?php

namespace GraphQL\SchemaObject;

class StudioQueryObject extends QueryObject
{
    const OBJECT_NAME = "Studio";

    public function selectId()
    {
        $this->selectField("id");

        return $this;
    }

    public function selectChecksum()
    {
        $this->selectField("checksum");

        return $this;
    }

    public function selectName()
    {
        $this->selectField("name");

        return $this;
    }

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }

    public function selectParentStudio(StudioParentStudioArgumentsObject $argsObject = null)
    {
        $object = new StudioQueryObject("parent_studio");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectChildStudios(StudioChildStudiosArgumentsObject $argsObject = null)
    {
        $object = new StudioQueryObject("child_studios");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectImagePath()
    {
        $this->selectField("image_path");

        return $this;
    }

    public function selectSceneCount()
    {
        $this->selectField("scene_count");

        return $this;
    }

    public function selectStashIds(StudioStashIdsArgumentsObject $argsObject = null)
    {
        $object = new StashIDQueryObject("stash_ids");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
