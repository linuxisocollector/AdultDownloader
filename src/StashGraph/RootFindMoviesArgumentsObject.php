<?php

namespace GraphQL\SchemaObject;

class RootFindMoviesArgumentsObject extends ArgumentsObject
{
    protected $movie_filter;
    protected $filter;

    public function setMovieFilter(MovieFilterTypeInputObject $movieFilterTypeInputObject)
    {
        $this->movie_filter = $movieFilterTypeInputObject;

        return $this;
    }

    public function setFilter(FindFilterTypeInputObject $findFilterTypeInputObject)
    {
        $this->filter = $findFilterTypeInputObject;

        return $this;
    }
}
