<?php

namespace GraphQL\SchemaObject;

class SceneUpdateInputInputObject extends InputObject
{
    protected $clientMutationId;
    protected $id;
    protected $title;
    protected $details;
    protected $url;
    protected $date;
    protected $rating;
    protected $organized;
    protected $studio_id;
    protected $gallery_ids;
    protected $performer_ids;
    protected $movies;
    protected $tag_ids;
    protected $cover_image;
    protected $stash_ids;

    public function setClientMutationId($clientMutationId)
    {
        $this->clientMutationId = $clientMutationId;

        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    public function setOrganized($organized)
    {
        $this->organized = $organized;

        return $this;
    }

    public function setStudioId($studioId)
    {
        $this->studio_id = $studioId;

        return $this;
    }

    public function setGalleryIds(array $galleryIds)
    {
        $this->gallery_ids = $galleryIds;

        return $this;
    }

    public function setPerformerIds(array $performerIds)
    {
        $this->performer_ids = $performerIds;

        return $this;
    }

    public function setMovies(array $movies)
    {
        $this->movies = $movies;

        return $this;
    }

    public function setTagIds(array $tagIds)
    {
        $this->tag_ids = $tagIds;

        return $this;
    }

    public function setCoverImage($coverImage)
    {
        $this->cover_image = $coverImage;

        return $this;
    }

    public function setStashIds(array $stashIds)
    {
        $this->stash_ids = $stashIds;

        return $this;
    }
}
