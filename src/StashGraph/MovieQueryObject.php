<?php

namespace GraphQL\SchemaObject;

class MovieQueryObject extends QueryObject
{
    const OBJECT_NAME = "Movie";

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

    public function selectAliases()
    {
        $this->selectField("aliases");

        return $this;
    }

    public function selectDuration()
    {
        $this->selectField("duration");

        return $this;
    }

    public function selectDate()
    {
        $this->selectField("date");

        return $this;
    }

    public function selectRating()
    {
        $this->selectField("rating");

        return $this;
    }

    public function selectStudio(MovieStudioArgumentsObject $argsObject = null)
    {
        $object = new StudioQueryObject("studio");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectDirector()
    {
        $this->selectField("director");

        return $this;
    }

    public function selectSynopsis()
    {
        $this->selectField("synopsis");

        return $this;
    }

    public function selectUrl()
    {
        $this->selectField("url");

        return $this;
    }

    public function selectFrontImagePath()
    {
        $this->selectField("front_image_path");

        return $this;
    }

    public function selectBackImagePath()
    {
        $this->selectField("back_image_path");

        return $this;
    }

    public function selectSceneCount()
    {
        $this->selectField("scene_count");

        return $this;
    }
}
