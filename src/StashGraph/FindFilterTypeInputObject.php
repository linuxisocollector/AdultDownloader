<?php

namespace GraphQL\SchemaObject;

class FindFilterTypeInputObject extends InputObject
{
    protected $q;
    protected $page;
    protected $per_page;
    protected $sort;
    protected $direction;

    public function setQ($q)
    {
        $this->q = $q;

        return $this;
    }

    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    public function setPerPage($perPage)
    {
        $this->per_page = $perPage;

        return $this;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }
}
