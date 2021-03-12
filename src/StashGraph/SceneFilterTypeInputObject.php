<?php

namespace GraphQL\SchemaObject;

class SceneFilterTypeInputObject extends InputObject
{
    protected $path;
    protected $rating;
    protected $organized;
    protected $o_counter;
    protected $resolution;
    protected $duration;
    protected $has_markers;
    protected $is_missing;
    protected $studios;
    protected $movies;
    protected $tags;
    protected $performers;
    protected $stash_id;

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

    public function setDuration(IntCriterionInputInputObject $intCriterionInputInputObject)
    {
        $this->duration = $intCriterionInputInputObject;

        return $this;
    }

    public function setHasMarkers($hasMarkers)
    {
        $this->has_markers = $hasMarkers;

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

    public function setMovies(MultiCriterionInputInputObject $multiCriterionInputInputObject)
    {
        $this->movies = $multiCriterionInputInputObject;

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

    public function setStashId($stashId)
    {
        $this->stash_id = $stashId;

        return $this;
    }
}
