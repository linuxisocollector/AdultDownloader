<?php

namespace GraphQL\SchemaObject;

class PerformerFilterTypeInputObject extends InputObject
{
    protected $filter_favorites;
    protected $birth_year;
    protected $age;
    protected $ethnicity;
    protected $country;
    protected $eye_color;
    protected $height;
    protected $measurements;
    protected $fake_tits;
    protected $career_length;
    protected $tattoos;
    protected $piercings;
    protected $aliases;
    protected $gender;
    protected $is_missing;
    protected $stash_id;

    public function setFilterFavorites($filterFavorites)
    {
        $this->filter_favorites = $filterFavorites;

        return $this;
    }

    public function setBirthYear(IntCriterionInputInputObject $intCriterionInputInputObject)
    {
        $this->birth_year = $intCriterionInputInputObject;

        return $this;
    }

    public function setAge(IntCriterionInputInputObject $intCriterionInputInputObject)
    {
        $this->age = $intCriterionInputInputObject;

        return $this;
    }

    public function setEthnicity(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->ethnicity = $stringCriterionInputInputObject;

        return $this;
    }

    public function setCountry(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->country = $stringCriterionInputInputObject;

        return $this;
    }

    public function setEyeColor(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->eye_color = $stringCriterionInputInputObject;

        return $this;
    }

    public function setHeight(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->height = $stringCriterionInputInputObject;

        return $this;
    }

    public function setMeasurements(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->measurements = $stringCriterionInputInputObject;

        return $this;
    }

    public function setFakeTits(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->fake_tits = $stringCriterionInputInputObject;

        return $this;
    }

    public function setCareerLength(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->career_length = $stringCriterionInputInputObject;

        return $this;
    }

    public function setTattoos(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->tattoos = $stringCriterionInputInputObject;

        return $this;
    }

    public function setPiercings(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->piercings = $stringCriterionInputInputObject;

        return $this;
    }

    public function setAliases(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->aliases = $stringCriterionInputInputObject;

        return $this;
    }

    public function setGender(GenderCriterionInputInputObject $genderCriterionInputInputObject)
    {
        $this->gender = $genderCriterionInputInputObject;

        return $this;
    }

    public function setIsMissing($isMissing)
    {
        $this->is_missing = $isMissing;

        return $this;
    }

    public function setStashId($stashId)
    {
        $this->stash_id = $stashId;

        return $this;
    }
}
