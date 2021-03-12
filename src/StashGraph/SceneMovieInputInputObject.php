<?php

namespace GraphQL\SchemaObject;

class SceneMovieInputInputObject extends InputObject
{
    protected $movie_id;
    protected $scene_index;

    public function setMovieId($movieId)
    {
        $this->movie_id = $movieId;

        return $this;
    }

    public function setSceneIndex($sceneIndex)
    {
        $this->scene_index = $sceneIndex;

        return $this;
    }
}
