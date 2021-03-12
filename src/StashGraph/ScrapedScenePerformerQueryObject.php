<?php

namespace GraphQL\SchemaObject;

class ScrapedScenePerformerQueryObject extends QueryObject
{
    const OBJECT_NAME = "ScrapedScenePerformer";

    public function selectStoredId()
    {
        $this->selectField("stored_id");

        return $this;
    }

    public function selectName()
    {
        $this->selectField("name");

        return $this;
    }

    public function selectGender()
    {
        $this->selectField("gender");

        return $this;
    }

    public function selectUrl()
    {
        $this->selectField("url");

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

    public function selectRemoteSiteId()
    {
        $this->selectField("remote_site_id");

        return $this;
    }

    public function selectImages()
    {
        $this->selectField("images");

        return $this;
    }
}
