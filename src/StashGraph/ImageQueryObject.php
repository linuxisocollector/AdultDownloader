<?php

namespace GraphQL\SchemaObject;

class ImageQueryObject extends QueryObject
{
    const OBJECT_NAME = "Image";

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

    public function selectTitle()
    {
        $this->selectField("title");

        return $this;
    }

    public function selectRating()
    {
        $this->selectField("rating");

        return $this;
    }

    public function selectOCounter()
    {
        $this->selectField("o_counter");

        return $this;
    }

    public function selectOrganized()
    {
        $this->selectField("organized");

        return $this;
    }

    public function selectPath()
    {
        $this->selectField("path");

        return $this;
    }

    public function selectFile(ImageFileArgumentsObject $argsObject = null)
    {
        $object = new ImageFileTypeQueryObject("file");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectPaths(ImagePathsArgumentsObject $argsObject = null)
    {
        $object = new ImagePathsTypeQueryObject("paths");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectGalleries(ImageGalleriesArgumentsObject $argsObject = null)
    {
        $object = new GalleryQueryObject("galleries");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectStudio(ImageStudioArgumentsObject $argsObject = null)
    {
        $object = new StudioQueryObject("studio");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectTags(ImageTagsArgumentsObject $argsObject = null)
    {
        $object = new TagQueryObject("tags");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectPerformers(ImagePerformersArgumentsObject $argsObject = null)
    {
        $object = new PerformerQueryObject("performers");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
