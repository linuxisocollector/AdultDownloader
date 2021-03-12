<?php

namespace GraphQL\SchemaObject;

class PerformerQueryObject extends QueryObject
{
    const OBJECT_NAME = "Performer";

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

    public function selectGender()
    {
        $this->selectField("gender");

        return $this;
    }

    public function selectTwitter()
    {
        $this->selectField("twitter");

        return $this;
    }

    public function selectInstagram()
    {
        $this->selectField("instagram");

        return $this;
    }

    public function selectBirthdate()
    {
        $this->selectField("birthdate");

        return $this;
    }

    public function selectEthnicity()
    {
        $this->selectField("ethnicity");

        return $this;
    }

    public function selectCountry()
    {
        $this->selectField("country");

        return $this;
    }

    public function selectEyeColor()
    {
        $this->selectField("eye_color");

        return $this;
    }

    public function selectHeight()
    {
        $this->selectField("height");

        return $this;
    }

    public function selectMeasurements()
    {
        $this->selectField("measurements");

        return $this;
    }

    public function selectFakeTits()
    {
        $this->selectField("fake_tits");

        return $this;
    }

    public function selectCareerLength()
    {
        $this->selectField("career_length");

        return $this;
    }

    public function selectTattoos()
    {
        $this->selectField("tattoos");

        return $this;
    }

    public function selectPiercings()
    {
        $this->selectField("piercings");

        return $this;
    }

    public function selectAliases()
    {
        $this->selectField("aliases");

        return $this;
    }

    public function selectFavorite()
    {
        $this->selectField("favorite");

        return $this;
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

    public function selectScenes(PerformerScenesArgumentsObject $argsObject = null)
    {
        $object = new SceneQueryObject("scenes");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectStashIds(PerformerStashIdsArgumentsObject $argsObject = null)
    {
        $object = new StashIDQueryObject("stash_ids");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
