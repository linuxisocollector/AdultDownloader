<?php

namespace GraphQL\SchemaObject;

class FindMoviesResultTypeQueryObject extends QueryObject
{
    const OBJECT_NAME = "FindMoviesResultType";

    public function selectCount()
    {
        $this->selectField("count");

        return $this;
    }

    public function selectMovies(FindMoviesResultTypeMoviesArgumentsObject $argsObject = null)
    {
        $object = new MovieQueryObject("movies");
        if ($argsObject !== null) {
            $object->appendArguments($argsObject->toArray());
        }
        $this->selectField($object);

        return $object;
    }
}
