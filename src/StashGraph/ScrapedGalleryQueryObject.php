<?php

namespace GraphQL\SchemaObject;

class ScrapedGalleryQueryObject extends QueryObject
{
    const OBJECT_NAME = "ScrapedGallery";

    public function selectTitle()
    {
        $this->selectField("title");

        return $this;
    }

    public function selectDetails()
    {
        $this->selectField("details");

        return $this;
    }

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }

    public function selectDate()
    {
        $this->selectField("date");

        return $this;
    }

    public function selectStudio(ScrapedGalleryStudioArgumentsObject $argsObject = null)
    {
        $object = new ScrapedSceneStudioQueryObject("studio");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectTags(ScrapedGalleryTagsArgumentsObject $argsObject = null)
    {
        $object = new ScrapedSceneTagQueryObject("tags");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectPerformers(ScrapedGalleryPerformersArgumentsObject $argsObject = null)
    {
        $object = new ScrapedScenePerformerQueryObject("performers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
