<?php

namespace GraphQL\SchemaObject;

class GalleryFilterTypeInputObject extends InputObject
{
    protected $path;
    protected $is_missing;
    protected $is_zip;
    protected $rating;
    protected $organized;
    protected $average_resolution;
    protected $studios;
    protected $tags;
    protected $performers;
    protected $image_count;

    public function setPath(StringCriterionInputInputObject $stringCriterionInputInputObject)
    {
        $this->path = $stringCriterionInputInputObject;

        return $this;
    }

    public function setIsMissing($isMissing)
    {
        $this->is_missing = $isMissing;

        return $this;
    }

    public function setIsZip($isZip)
    {
        $this->is_zip = $isZip;

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

    public function setAverageResolution($averageResolution)
    {
        $this->average_resolution = $averageResolution;

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

    public function setImageCount(IntCriterionInputInputObject $intCriterionInputInputObject)
    {
        $this->image_count = $intCriterionInputInputObject;

        return $this;
    }
}
