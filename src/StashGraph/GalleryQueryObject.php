<?php

namespace GraphQL\SchemaObject;

class GalleryQueryObject extends QueryObject
{
    const OBJECT_NAME = "Gallery";

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

    public function selectPath()
    {
        $this->selectField("path");

        return $this;
    }

    public function selectTitle()
    {
        $this->selectField("title");

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

    public function selectDetails()
    {
        $this->selectField("details");

        return $this;
    }

    public function selectRating()
    {
        $this->selectField("rating");

        return $this;
    }

    public function selectOrganized()
    {
        $this->selectField("organized");

        return $this;
    }

    public function selectScenes(GalleryScenesArgumentsObject $argsObject = null)
    {
        $object = new SceneQueryObject("scenes");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectStudio(GalleryStudioArgumentsObject $argsObject = null)
    {
        $object = new StudioQueryObject("studio");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectImageCount()
    {
        $this->selectField("image_count");

        return $this;
    }

    public function selectTags(GalleryTagsArgumentsObject $argsObject = null)
    {
        $object = new TagQueryObject("tags");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectPerformers(GalleryPerformersArgumentsObject $argsObject = null)
    {
        $object = new PerformerQueryObject("performers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectImages(GalleryImagesArgumentsObject $argsObject = null)
    {
        $object = new ImageQueryObject("images");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectCover(GalleryCoverArgumentsObject $argsObject = null)
    {
        $object = new ImageQueryObject("cover");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
