<?php

namespace GraphQL\SchemaObject;

class SceneMovieIDQueryObject extends QueryObject
{
    const OBJECT_NAME = "SceneMovieID";

    public function selectMovieId()
    {
        $this->selectField("movie_id");

        return $this;
    }

    public function selectSceneIndex()
    {
        $this->selectField("scene_index");

        return $this;
    }
}
