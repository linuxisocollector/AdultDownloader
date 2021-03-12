<?php

namespace GraphQL\SchemaObject;

class ImageFilterTypeInputObject extends InputObject
{
    protected $path;
    protected $rating;
    protected $organized;
    protected $o_counter;
    protected $resolution;
    protected $is_missing;
    protected $studios;
    protected $tags;
    protected $performers;
    protected $galleries;

    public function setPath(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->path = $stringCriterionInputInputObject;

        return $this;
    }

    public function setRating(IntCriterionInputInputObject $intCriterionInputInputObject)
    {
        $this->rating = $intCriterionInputInputObject;

        return $this;
    }

    public function setOrganized($organized)
    {
        $this->organized = $organized;

        return $this;
    }

    public function setOCounter(IntCriterionInputInputObject $intCriterionInputInputObject)
    {
        $this->o_counter = $intCriterionInputInputObject;

        return $this;
    }

    public function setResolution($resolution)
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function setIsMissing($isMissing)
    {
        $this->is_missing = $isMissing;

        return $this;
    }

    public function setStudios(MultiCriterionInputInputObject $multiCriterionInputInputObject)
    {
        $this->studios = $multiCriterionInputInputObject;

        return $this;
    }

    public function setTags(MultiCriterionInputInputObject $multiCriterionInputInputObject)
    {
        $this->tags = $multiCriterionInputInputObject;

        return $this;
    }

    public function setPerformers(MultiCriterionInputInputObject $multiCriterionInputInputObject)
    {
        $this->performers = $multiCriterionInputInputObject;

        return $this;
    }

    public function setGalleries(MultiCriterionInputInputObject $multiCriterionInputInputObject)
    {
        $this->galleries = $multiCriterionInputInputObject;

        return $this;
    }
}
