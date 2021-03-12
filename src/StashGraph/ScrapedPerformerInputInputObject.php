<?php

namespace GraphQL\SchemaObject;

class ScrapedPerformerInputInputObject extends InputObject
{
    protected $name;
    protected $gender;
    protected $url;
    protected $twitter;
    protected $instagram;
    protected $birthdate;
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

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function setEthnicity($ethnicity)
    {
        $this->ethnicity = $ethnicity;

        return $this;
    }

    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    public function setEyeColor($eyeColor)
    {
        $this->eye_color = $eyeColor;

        return $this;
    }

    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    public function setMeasurements($measurements)
    {
        $this->measurements = $measurements;

        return $this;
    }

    public function setFakeTits($fakeTits)
    {
        $this->fake_tits = $fakeTits;

        return $this;
    }

    public function setCareerLength($careerLength)
    {
        $this->career_length = $careerLength;

        return $this;
    }

    public function setTattoos($tattoos)
    {
        $this->tattoos = $tattoos;

        return $this;
    }

    public function setPiercings($piercings)
    {
        $this->piercings = $piercings;

        return $this;
    }

    public function setAliases($aliases)
    {
        $this->aliases = $aliases;

        return $this;
    }
}
