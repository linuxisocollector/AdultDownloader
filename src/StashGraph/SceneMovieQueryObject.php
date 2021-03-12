<?php

namespace GraphQL\SchemaObject;

class SceneMovieQueryObject extends QueryObject
{
    const OBJECT_NAME = "SceneMovie";

    public function selectMovie(SceneMovieMovieArgumentsObject $argsObject = null)
    {
        $object = new MovieQueryObject("movie");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }

    public function selectSceneIndex()
    {
        $this->selectField("scene_index");

        return $this;
    }
}
