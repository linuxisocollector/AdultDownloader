<?php

namespace GraphQL\SchemaObject;

class GalleryUpdateInputInputObject extends InputObject
{
    protected $clientMutationId;
    protected $id;
    protected $title;
    protected $url;
    protected $date;
    protected $details;
    protected $rating;
    protected $organized;
    protected $scene_ids;
    protected $studio_id;
    protected $tag_ids;
    protected $performer_ids;

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

    public function setDetails($details)
    {
        $this->details = $details;

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

    public function setSceneIds(array $sceneIds)
    {
        $this->scene_ids = $sceneIds;

        return $this;
    }

    public function setStudioId($studioId)
    {
        $this->studio_id = $studioId;

        return $this;
    }

    public function setTagIds(array $tagIds)
    {
        $this->tag_ids = $tagIds;

        return $this;
    }

    public function setPerformerIds(array $performerIds)
    {
        $this->performer_ids = $performerIds;

        return $this;
    }
}
